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
 * ponytail: relies on CMB2's '.cmb-repeatable-grouping.closed' / '.cmbhandle'
 * markup conventions; revisit if the bundled CMB2 group markup changes.
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
			originalInit.call( wysiwyg, item.el, item.data, item.buttonsInit );
		} );
	}

	$( function () {
		// CMB2 toggles a row open/closed when its handle (or title bar) is clicked.
		$( document ).on(
			'click',
			'.cmb-repeatable-grouping .cmbhandle, .cmb-repeatable-grouping .cmb-group-title',
			function () {
				var $row = $( this ).closest( '.cmb-repeatable-grouping' );
				// The class toggle happens on the same click; defer past it.
				window.setTimeout( function () {
					if ( ! $row.hasClass( 'closed' ) ) {
						flushRow( $row );
					}
				}, 0 );
			}
		);
	} );
} )( window, jQuery );
