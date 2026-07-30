const mouseEvent = ( e ) => {
    const shouldShowExitIntent =
        ! e.toElement && ! e.relatedTarget && e.clientY < 10;

    if ( shouldShowExitIntent ) {
        document.removeEventListener( 'mouseout', mouseEvent );
        document.querySelector( 'html' ).classList.add( 'has-modal-open' );
        const exitModal = document.querySelector(
            '.wp-block-hm-popup[data-trigger="exit"]'
        );
        exitModal.showModal();
        // Focus the modal container instead of the close button
        exitModal.focus();
        window.localStorage.setItem( 'exitIntentShown', Date.now() );
    }
};

// Triggers (e.g. links inside a Slick slider) can be cloned by third-party
// scripts after this file runs, and clones don't inherit listeners bound via
// addEventListener. So click handling for triggers/close links is delegated
// on `document` and resolved at click-time instead of bound per-element -
// that way it keeps working no matter how the trigger element got into the DOM.
const toModalBootstrap = () => {
    let exitIntentSetup = false;

    document.querySelectorAll( '.wp-block-hm-popup' ).forEach( ( popup ) => {
        if ( popup.dataset.lsxToModalBound ) {
            return;
        }
        popup.dataset.lsxToModalBound = '1';

        // On close remove HTML class.
        popup.addEventListener( 'close', () => {
            document
                .querySelector( 'html' )
                .classList.remove( 'has-modal-open' );
        } );

        // On backdrop click, close modal.
        popup.addEventListener( 'mousedown', ( event ) => {
            if ( event.target === event.currentTarget ) {
                event.currentTarget.close();
            }
        } );

        // Handle exit intent trigger.
        if ( popup?.dataset.trigger === 'exit' ) {
            // Get expiry setting on local storage value.
            const expirationDays = parseInt( popup?.dataset.expiry || 7, 10 );

            if (
                parseInt(
                    window.localStorage.getItem( 'exitIntentShown' ) || 0,
                    10
                ) <
                    Date.now() - expirationDays * 24 * 60 * 60 * 1000 &&
                ! exitIntentSetup
            ) {
                exitIntentSetup = true;
                setTimeout( () => {
                    document.addEventListener( 'mouseout', mouseEvent );
                }, 2000 );
            }
        }
    } );
};

// Delegated: handles click-trigger links, including ones cloned into the
// DOM (e.g. by Slick) after toModalBootstrap() has already run.
document.addEventListener( 'click', ( event ) => {
    const trigger = event.target.closest( 'a[href^="#"]' );
    if ( ! trigger ) {
        return;
    }

    const popup = document.getElementById(
        trigger.getAttribute( 'href' ).slice( 1 )
    );
    if (
        ! popup ||
        ! popup.classList.contains( 'wp-block-hm-popup' ) ||
        popup.dataset.trigger !== 'click'
    ) {
        return;
    }

    event.preventDefault();
    document.querySelector( 'html' ).classList.add( 'has-modal-open' );
    popup.showModal();
    // Focus the modal container instead of the close button
    popup.focus();
} );

// Delegated: handles close buttons/links, including clones.
document.addEventListener( 'click', ( event ) => {
    const closeTrigger = event.target.closest(
        '.wp-block-hm-popup__close, .wp-block-hm-popup [href="#close"]'
    );
    if ( ! closeTrigger ) {
        return;
    }

    event.preventDefault();
    closeTrigger.closest( '.wp-block-hm-popup' ).close();
} );

// Handle async scripts.
if ( document.readyState !== 'loading' ) {
    toModalBootstrap();
} else {
    document.addEventListener( 'DOMContentLoaded', toModalBootstrap );
}
