/**
 * Scripts within the customizer controls window.
 *
 * Contextually shows the color hue control and informs the preview
 * when users open or close the front page sections section.
 */

(function( $, api ) {
    wp.customize.bind('ready', function() {
    	// Show message on change.
        var kyamera_settings = ['kyamera_slider_num', 'kyamera_services_num', 'kyamera_projects_num', 'kyamera_testimonial_num', 'kyamera_blog_section_num', 'kyamera_reset_settings', 'kyamera_testimonial_num', 'kyamera_partner_num'];
        _.each( kyamera_settings, function( kyamera_setting ) {
            wp.customize( kyamera_setting, function( setting ) {
                var kyameraNotice = function( value ) {
                    var name = 'needs_refresh';
                    if ( value && kyamera_setting == 'kyamera_reset_settings' ) {
                        setting.notifications.add( 'needs_refresh', new wp.customize.Notification(
                            name,
                            {
                                type: 'warning',
                                message: localized_data.reset_msg,
                            }
                        ) );
                    } else if( value ){
                        setting.notifications.add( 'reset_name', new wp.customize.Notification(
                            name,
                            {
                                type: 'info',
                                message: localized_data.refresh_msg,
                            }
                        ) );
                    } else {
                        setting.notifications.remove( name );
                    }
                };

                setting.bind( kyameraNotice );
            });
        });

        /* === Radio Image Control === */
        api.controlConstructor['radio-color'] = api.Control.extend( {
            ready: function() {
                var control = this;

                $( 'input:radio', control.container ).change(
                    function() {
                        control.setting.set( $( this ).val() );
                    }
                );
            }
        } );

        // Sortable sections
        jQuery( "body" ).on( 'hover', '.kyamera-drag-handle', function() {
            jQuery( 'ul.kyamera-sortable-list' ).sortable({
                handle: '.kyamera-drag-handle',
                axis: 'y',
                update: function( e, ui ){
                    jQuery('input.kyamera-sortable-input').trigger( 'change' );
                }
            });
        });

        /* On changing the value. */
        jQuery( "body" ).on( 'change', 'input.kyamera-sortable-input', function() {
            /* Get the value, and convert to string. */
            this_checkboxes_values = jQuery( this ).parents( 'ul.kyamera-sortable-list' ).find( 'input.kyamera-sortable-input' ).map( function() {
                return this.value;
            }).get().join( ',' );

            /* Add the value to hidden input. */
            jQuery( this ).parents( 'ul.kyamera-sortable-list' ).find( 'input.kyamera-sortable-value' ).val( this_checkboxes_values ).trigger( 'change' );

        });

        // Deep linking for counter section to about section.
        jQuery('.kyamera-edit').click(function(e) {
            e.preventDefault();
            var jump_to = jQuery(this).attr( 'data-jump' );
            wp.customize.section( jump_to ).focus()
        });

    });
})( jQuery, wp.customize );
