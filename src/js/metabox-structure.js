! ( function ( $ ) {
    $( function () {
        const get_box = function () {
            let box = $( '#tour-operator-plugin .inside' );
            if ( ! box.length ) {
                box = $( '#lsx-tour-operators .inside' );
            }
            return box;
        };

        // Handle 'tour-operator-plugin' metabox.
        let tour_operators = get_box(),
            tab_wrapper = $(
                '<ul class="lsx_tabs"><li class="lsx_tab active" data-tab="general"><a>General</a></li></ul>'
            ),
            current_tab = 'general';

        tour_operators.find( '.cmb-row' ).each( function () {
            const row = $( this ),
                title = row.find( '.CMB_Title' );

            if ( title.length ) {
                const label = title.find( '.field-title > h3' ).html();
                current_tab = label
                    .split( ' ' )
                    .join( '_' )
                    .split( '-' )
                    .join( '_' )
                    .replace( /[^a-z0-9_]/gi, '' )
                    .toLowerCase();
                tab_wrapper.append(
                    $(
                        '<li class="lsx_tab" data-tab="' +
                            current_tab +
                            '"><a>' +
                            label +
                            '</a></li>'
                    )
                );
            }
            row.addClass( 'lsx_tab_' + current_tab );
        } );

        // add tabs.
        tour_operators
            .prepend( tab_wrapper )
            .append( '<div class="lsx_tabs_clear"></div>' );

        // Handle Clicks.
        $( document ).on( 'click', '.lsx_tab', function () {
            const clicked = $( this );

            $( '.lsx_tab.active' ).removeClass( 'active' ).data( 'tab' );
            clicked.addClass( 'active' );
            $( '.cmb-row' ).hide();
            $( '.cmb-row.lsx_tab_' + clicked.data( 'tab' ) ).show();
        } );

        // trigger the init.
        $( '.lsx_tab' ).first().trigger( 'click' );
    } );
} )( jQuery );
