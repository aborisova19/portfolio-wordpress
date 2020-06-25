<?php
/*
  WPFront Scroll Top Plugin
  Copyright (C) 2013, WPFront.com
  Website: wpfront.com
  Contact: syam@wpfront.com

  WPFront Scroll Top Plugin is distributed under the GNU General Public License, Version 3,
  June 2007. Copyright (C) 2007 Free Software Foundation, Inc., 51 Franklin
  St, Fifth Floor, Boston, MA 02110, USA

  THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
  ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
  WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
  DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
  ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
  (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
  LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
  ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
  (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
  SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

namespace WPFront\Scroll_Top;

/**
 * Template for WPFront Scroll Top
 *
 * @author Syam Mohan <syam@wpfront.com>
 * @copyright 2013 WPFront.com
 */
?>

<?php if ($this->options->hide_small_window()) { ?>
    <style type="text/css">

        @media screen and (max-width: <?php echo $this->options->small_window_width() . "px"; ?>) {

            #wpfront-scroll-top-container {
                visibility: hidden;
            }

        }

    </style>
<?php } ?>

<?php if ($this->options->hide_small_device()) { ?>
    <style type="text/css">

        @media screen and (max-device-width: <?php echo $this->options->small_device_width() . "px"; ?>) {

            #wpfront-scroll-top-container {
                visibility: hidden;
            }

        }

    </style>
<?php } ?>

<?php
if ($this->options->button_style() == 'text') {
    ?>
    <div id="wpfront-scroll-top-container">
        <?php
            $html = sprintf('<div class="text-holder">%s</div>', $this->options->text_button_text());
            $html = $this->apply_button_action_html($html);
            echo $html;
        ?>
    </div>

    <style type="text/css">
        #wpfront-scroll-top-container div.text-holder {
            color: <?php echo $this->options->text_button_text_color(); ?>;
            background-color: <?php echo $this->options->text_button_background_color(); ?>;
            width: <?php echo $this->options->button_width() == 0 ? 'auto' : $this->options->button_width() . 'px'; ?>;
            height: <?php echo $this->options->button_height() == 0 ? 'auto' : $this->options->button_height() . 'px'; ?>;
            
            <?php echo $this->options->text_button_css(); ?>
        }
        
        #wpfront-scroll-top-container div.text-holder:hover {
            background-color: <?php echo $this->options->text_button_hover_color(); ?>;
        }
    </style>
    <?php
} elseif($this->options->button_style() == 'font-awesome') {
    ?>
    <div id="wpfront-scroll-top-container">
        <?php
            $html = sprintf('<i class="%s"></i>', $this->options->fa_button_class());
            $html = $this->apply_button_action_html($html);
            echo $html;
        ?>
    </div>
    
    <style type="text/css">
        #wpfront-scroll-top-container i {
            color: <?php echo $this->options->fa_button_text_color(); ?>;
        }
            
        <?php echo $this->options->fa_button_css(); ?>
    </style>
    <?php
} else {
    ?>
    <div id="wpfront-scroll-top-container">
        <?php
            $html = sprintf('<img src="%s" alt="%s" />', $this->image(), $this->options->image_alt());
            $html = $this->apply_button_action_html($html);
            echo $html;
        ?>
    </div>
    <?php
}
?>