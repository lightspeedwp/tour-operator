/**
 * Lazy-initialise grouped WYSIWYG (TinyMCE) editors inside CMB2 repeatable groups.
 *
 * CMB2's cmb2-wysiwyg.js eagerly runs tinyMCE.init() for every WYSIWYG field of
 * every existing group row on page load. A tour with N itinerary days therefore
 * spawns N * (wysiwyg fields per row) TinyMCE iframes at once, each re-fetching the
 * full editor CSS/JS bundle. On long tours this makes the edit screen take
 * minutes to load.
 *
 * This script defers editor initialisation for collapsed rows (see the
 * 'closed' => true itinerary group option) and only initialises a row's editors
 * the first time that row is expanded. Page-load cost then no longer scales with
 * the number of days.
 *
 * We override window.CMB2.wysiwyg.init at parse time (not on DOM ready) so the
 * override is in place before CMB2 fires cmb_init -> wysiwyg.initAll().
 *
 * ponytail: relies on CMB2's '.cmb-repeatable-grouping' + 'closed' class
 * convention; revisit if the bundled CMB2 group markup changes.
 */
( function ( window, $ ) {
	'use strict';

	var cmb2 = window.CMB2;
	if ( ! cmb2 || ! cmb2.wysiwyg || 'function' !== typeof cmb2.wysiwyg.init ) {
		return;
	}

	var wysiwyg = cmb2.wysiwyg;
	var originalInit = wysiwyg.init;

	// Pending editors keyed nowhere — stored on the row element itself.
	function isCollapsed( $el ) {
		var $row = $el.closest( '.cmb-repeatable-grouping' );
		return $row.length ? $row.hasClass( 'closed' ) : false;
	}

	wysiwyg.init = function ( $toReplace, data, buttonsInit ) {
		// Only defer for grouped, currently-collapsed rows. Everything else
		// (top-level editors, expanded rows, newly added rows) inits immediately.
		if ( data && data.groupid && isCollapsed( $toReplace ) ) {
			var $row = $toReplace.closest( '.cmb-repeatable-grouping' );
			var pending = $row.data( 'lazyWysiwyg' ) || [];
			pending.push( { el: $toReplace, data: data, buttonsInit: buttonsInit } );
			$row.data( 'lazyWysiwyg', pending );
			return;
		}
		return originalInit.call( wysiwyg, $toReplace, data, buttonsInit );
	};

	function flushRow( $row ) {
		var pending = $row.data( 'lazyWysiwyg' );
		if ( ! pending || ! pending.length ) {
			return;
		}
		$row.removeData( 'lazyWysiwyg' );
		pending.forEach( function ( item ) {
			var $el  = item.el;
			var data = item.data;

			// CMB2 renumbers a group row's field id/name/iterator when rows are
			// added, removed, or sorted (resetTitlesAndIterator). The values
			// captured when this row was deferred can therefore be stale, so
			// re-read them from the live placeholder at flush time — otherwise the
			// editor would bind to an old index and edits could save under the
			// wrong itinerary day. groupid/fieldid/hash are index-independent and
			// stay as cached.
			data.id    = $el.attr( 'id' );
			data.name  = $el.attr( 'name' );
			data.value = $el.val();
			var iterator = $row.attr( 'data-iterator' );
			if ( 'undefined' !== typeof iterator && false !== iterator ) {
				data.iterator = iterator;
			}

			originalInit.call( wysiwyg, $el, data, item.buttonsInit );
		} );
	}

	$( function () {
		// Watch for the 'closed' class being removed from a group row and flush that
		// row's deferred editors. A MutationObserver reacts to ANY expansion — click,
		// keyboard, drag-sort, or a programmatic class change — and avoids the race a
		// setTimeout(0) click handler is prone to. flushRow() is a no-op once a row
		// has been flushed, so repeat fires are harmless.
		if ( 'undefined' !== typeof MutationObserver ) {
			var observer = new MutationObserver( function ( mutations ) {
				mutations.forEach( function ( mutation ) {
					var target = mutation.target;
					if (
						target.classList &&
						target.classList.contains( 'cmb-repeatable-grouping' ) &&
						! target.classList.contains( 'closed' )
					) {
						flushRow( $( target ) );
					}
				} );
			} );
			observer.observe( document.body, {
				attributes: true,
				subtree: true,
				attributeFilter: [ 'class' ],
			} );
		} else {
			// Fallback for browsers without MutationObserver.
			$( document ).on(
				'click',
				'.cmb-repeatable-grouping .cmbhandle, .cmb-repeatable-grouping .cmb-group-title',
				function () {
					var $row = $( this ).closest( '.cmb-repeatable-grouping' );
					window.setTimeout( function () {
						if ( ! $row.hasClass( 'closed' ) ) {
							flushRow( $row );
						}
					}, 0 );
				}
			);
		}
	} );
} )( window, jQuery );
