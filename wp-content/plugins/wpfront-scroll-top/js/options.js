/*
 WPFront Scroll Top Plugin
 Copyright (C) 2013, WPFront.com
 Website: wpfront.com
 Contact: syam@wpfront.com
 
 WPFront Scroll Top Plugin is distributed under the GNU General Public License, Version 3,
 June 2007. Copyright (C) 2007 Free Software Foundation, Inc., 51 Franklin
 St, Fifth Floor, Boston, MA 02110, USA
 
 */

(function () {
    window.init_wpfront_scroll_top_options = function (settings) {
        var $ = jQuery;

        function setColorPicker(div) {
            div.ColorPicker({
                color: div.attr('color'),
                onShow: function(colpkr) {
                    $(colpkr).fadeIn(500);
                    return false;
                }, onHide: function(colpkr) {
                    $(colpkr).fadeOut(500);
                    return false;
                },
                onChange: function(hsb, hex, rgb) {
                    div.css('backgroundColor', '#' + hex);
                    div.next().text('#' + hex).next().val('#' + hex);
                }
            }).css('backgroundColor', div.attr('color'));
        }

        $('#wpfront-scroll-top-options').find(".color-selector").each(function(i, e) {
            setColorPicker($(e));
        });

        $('#wpfront-scroll-top-options .pages-selection input[type="checkbox"]').change(function() {
            var $this = $(this);
            var $input = $this.parent().parent().parent().prev();
            var $text = $input.val();

            if($this.prop('checked')) {
                $text += ',' + $this.val();
            } else {
                $text = (',' + $text + ',').replace(',' + $this.val() + ',', ',');
            }

            $text = $text.replace(/(^[,\s]+)|([,\s]+$)/g, '');
            $input.val($text);
        });

        $('#wpfront-scroll-top-options input.button-style').change(function() {
            $('#wpfront-scroll-top-options .button-options').hide().filter('.' + $(this).val()).show();
        });

        $('#wpfront-scroll-top-options .button-options').hide().filter('.' + settings.button_style).show();

        $('#wpfront-scroll-top-options input.button-action').change(function() {
            $('#wpfront-scroll-top-options div.button-action-container div.fields-container').addClass('hidden').filter('.' + $(this).val()).removeClass('hidden');
        });

        $('#wpfront-scroll-top-options div.button-action-container div.fields-container').filter('.' + settings.button_action).removeClass('hidden');

        (function() {
            var mediaLibrary = null;

            $('#media-library-button').click(function(e) {
                e.preventDefault();

                if(mediaLibrary === null) {
                    mediaLibrary = wp.media.frames.file_frame = wp.media({
                        title: settings.label_choose_image,
                        multiple: false,
                        button: {
                          text: settings.label_select_image
                        }
                    }).on('select', function() {
                        var obj = mediaLibrary.state().get('selection').first().toJSON();

                        $('#custom').prop('checked', true);
                        $('#custom-url-textbox').val(obj.url);

                        if(obj.alt !== "")
                            $('#alt-textbox').val(obj.alt);
                    });
                }

                mediaLibrary.open();
                return false;
            });
        })();
    };
})();