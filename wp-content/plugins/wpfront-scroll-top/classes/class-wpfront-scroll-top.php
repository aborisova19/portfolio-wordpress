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

require_once("class-wpfront-scroll-top-options.php");

/**
 * Main class of WPFront Scroll Top plugin
 *
 * @author Syam Mohan <syam@wpfront.com>
 * @copyright 2013 WPFront.com
 */
class WPFront_Scroll_Top {
    //Constants
    const VERSION = '2.0.2';
    const OPTIONS_GROUP_NAME = 'wpfront-scroll-top-options-group';
    const OPTION_NAME = 'wpfront-scroll-top-options';
    const PLUGIN_SLUG = 'wpfront-scroll-top';
    const PLUGIN_FILE = 'wpfront-scroll-top/wpfront-scroll-top.php';
    
    //Variables
    protected $iconsDIR = '/tmp/icons/';
    protected $iconsURL = '//tmp/icons/';
    protected $pluginDIRRoot = '/tmp/';
    protected $pluginURLRoot = '//tmp/';
    protected $options;
    protected $markupLoaded;
    protected $scriptLoaded;
    protected $min_file_suffix;
    
    private static $instance = null;
    
    protected function __construct() {
        $this->markupLoaded = FALSE;
        $this->min_file_suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';
    }
    
    public static function Instance() {
        if(empty(self::$instance)) {
            self::$instance = new WPFront_Scroll_Top();
        }
        
        return self::$instance;
    }
    
    public function init($pluginFile = null) {
        //Root variables
        $this->pluginURLRoot = plugins_url() . '/' . self::PLUGIN_SLUG . '/';
        $this->iconsURL = $this->pluginURLRoot . 'images/icons/';
        $this->pluginDIRRoot = plugin_dir_path($pluginFile);
        $this->iconsDIR = $this->pluginDIRRoot . 'images/icons/';
        
        add_action('plugins_loaded', array($this, 'plugins_loaded'));
        
        $this->add_activation_redirect();
        
        if (is_admin()) {
            add_action('admin_init', array($this, 'admin_init'));
            add_action('admin_menu', array($this, 'admin_menu'));
            add_filter('plugin_action_links', array($this, 'action_links'), 10, 2);
            
            add_action('admin_footer', array($this, 'write_markup'));
        } else {
            add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
            add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
            
            add_action('wp_footer', array($this, 'write_markup'));
            add_action('shutdown', array($this, 'shutdown_callback'));
        }
    }
    
    public function action_links($links, $file) {
        if ($file == self::PLUGIN_FILE) {
            $settings_link = '<a href="' . menu_page_url(self::PLUGIN_SLUG, FALSE) . '">' . __('Settings', 'wpfront-scroll-top') . '</a>';
            array_unshift($links, $settings_link);
        }
        return $links;
    }
    
    protected function add_activation_redirect() {
        add_action('activated_plugin', array($this, 'activated_plugin_callback'));
        add_action('admin_init', array($this, 'admin_init_callback'), 999999);
    }
    
    public function activated_plugin_callback($plugin) {
        if ($plugin !== self::PLUGIN_FILE) {
            return;
        }

        if (is_network_admin() || isset($_GET['activate-multi'])) {
            return;
        }
        
        $key = self::PLUGIN_SLUG . '-activation-redirect';
        add_option($key, TRUE);
    }
    
    public function admin_init_callback() {
        $key = self::PLUGIN_SLUG . '-activation-redirect';

        if (get_option($key, FALSE)) {
            delete_option($key);

            if (is_network_admin() || isset($_GET['activate-multi'])) {
                return;
            }

            wp_safe_redirect(menu_page_url(self::PLUGIN_SLUG, FALSE));
        }
    }
    
    //add scripts
    public function enqueue_scripts() {
        if ($this->enabled() == FALSE) {
            return;
        }

        $jsRoot = $this->pluginURLRoot . 'js/';

        wp_enqueue_script('jquery');
        wp_enqueue_script('wpfront-scroll-top', $jsRoot . 'wpfront-scroll-top' . $this->min_file_suffix . '.js', array('jquery'), self::VERSION, TRUE);

        $this->scriptLoaded = TRUE;
    }

    //add styles
    public function enqueue_styles() {
        if ($this->enabled() == FALSE) {
            return;
        }

        $cssRoot = $this->pluginURLRoot . 'css/';

        wp_enqueue_style('wpfront-scroll-top', $cssRoot . 'wpfront-scroll-top' . $this->min_file_suffix . '.css', array(), self::VERSION);            

        if($this->options->button_style() == 'font-awesome') {
            if(!$this->options->fa_button_exclude_URL() || is_admin()) {
                $url = trim($this->options->fa_button_URL());
                $ver = FALSE;
                if(empty($url)) {
                    $url = '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css';
                    $ver = '4.7.0';
                }
                wp_enqueue_style('font-awesome', $url, array(), $ver);
            }
        }
    }

    public function admin_init() {
        register_setting(self::OPTIONS_GROUP_NAME, self::OPTION_NAME);

        $this->enqueue_styles();
        $this->enqueue_scripts();
    }

    public function admin_menu() {
        $page_hook_suffix = add_options_page(__('WPFront Scroll Top', 'wpfront-scroll-top'), __('Scroll Top', 'wpfront-scroll-top'), 'manage_options', self::PLUGIN_SLUG, array($this, 'options_page'));

        add_action('admin_print_scripts-' . $page_hook_suffix, array($this, 'enqueue_options_scripts'));
        add_action('admin_print_styles-' . $page_hook_suffix, array($this, 'enqueue_options_styles'));
    }

    public function enqueue_options_scripts() {
        wp_enqueue_media();
        
        $this->enqueue_scripts();
        
        $jsRoot = $this->pluginURLRoot . 'jquery-plugins/colorpicker/js/';
        wp_enqueue_script('jquery.eyecon.colorpicker', $jsRoot . 'colorpicker' . $this->min_file_suffix . '.js', array('jquery'), self::VERSION);
        
        $jsRoot = $this->pluginURLRoot . 'js/';
        wp_enqueue_script('wpfront-scroll-top-options', $jsRoot . 'options' . $this->min_file_suffix . '.js', array('jquery'), self::VERSION);
    }

    //options page styles
    public function enqueue_options_styles() {
        $styleRoot = $this->pluginURLRoot . 'jquery-plugins/colorpicker/css/';
        wp_enqueue_style('jquery.eyecon.colorpicker', $styleRoot . 'colorpicker' . $this->min_file_suffix . '.css', array(), self::VERSION);

        $styleRoot = $this->pluginURLRoot . 'css/';
        wp_enqueue_style('wpfront-scroll-top-options', $styleRoot . 'options' . $this->min_file_suffix . '.css', array(), self::VERSION);
    }
    
    public function set_options($options) {
        $this->options = $options;
    }

    public function plugins_loaded() {
        //load plugin options
        $this->set_options(new WPFront_Scroll_Top_Options(self::OPTION_NAME, self::PLUGIN_SLUG));

        if($this->options->javascript_async()) {
            add_filter('script_loader_tag', array($this, 'script_loader_tag'), 999999, 3);
        }
    }

    public function script_loader_tag($tag, $handle, $src) {
        if($handle === 'wpfront-scroll-top') {
            return '<script type="text/javascript" src="' . $src . '" async="async" defer="defer"></script>' . "\n";
        }

        return $tag;
    }

    public function shutdown_callback() {
        if ($this->markupLoaded) {
            return;
        }

        $headers = headers_list();
        $flag = FALSE;
        foreach ($headers as $value) {
            $value = strtolower(str_replace(' ', '', $value));
            if (strpos($value, 'content-type:text/html') === 0) {
                $flag = TRUE;
                break;
            }
        }

        if ($flag) {
            $this->write_markup();
        }
    }

    //writes the html and script for the button
    public function write_markup() {
        if ($this->markupLoaded) {
            return;
        }

        if (!$this->scriptLoaded) {
            return;
        }

        if ($this->doing_ajax()) {
            return;
        }
        
        if ($this->enabled()) {
            if(is_admin()) {
                $this->options->set_button_action('top');
            }
            
            include($this->pluginDIRRoot . 'templates/scroll-top-template.php');

            echo '<script type="text/javascript">';
            echo    'function wpfront_scroll_top_init() {';
            echo        'if(typeof wpfront_scroll_top == "function" && typeof jQuery !== "undefined") {';
            echo            'wpfront_scroll_top(' . json_encode(array(
                                'scroll_offset' => $this->options->scroll_offset(),
                                'button_width' => $this->options->button_width(),
                                'button_height' => $this->options->button_height(),
                                'button_opacity' => $this->options->button_opacity() / 100,
                                'button_fade_duration' => $this->options->button_fade_duration(),
                                'scroll_duration' => $this->options->scroll_duration(),
                                'location' => $this->options->location(),
                                'marginX' => $this->options->marginX(),
                                'marginY' => $this->options->marginY(),
                                'hide_iframe' => $this->options->hide_iframe(),
                                'auto_hide' => $this->options->auto_hide(),
                                'auto_hide_after' => $this->options->auto_hide_after(),
                                'button_action' => $this->options->button_action(),
                                'button_action_element_selector' => $this->options->button_action_element_selector(),
                                'button_action_container_selector' => $this->options->button_action_container_selector(),
                                'button_action_element_offset' => $this->options->button_action_element_offset()
                            )) . ');';
            echo        '} else {';
            echo            'setTimeout(wpfront_scroll_top_init, 100);';
            echo        '}';
            echo    '}';
            echo    'wpfront_scroll_top_init();';
            echo '</script>';
        }

        $this->markupLoaded = TRUE;
    }
    
    protected function doing_ajax() {
        if (defined('DOING_AJAX') && DOING_AJAX) {
            return TRUE;
        }

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return TRUE;
        }

        if (!empty($_SERVER['REQUEST_URI']) && strtolower($_SERVER['REQUEST_URI']) == '/wp-admin/async-upload.php') {
            return TRUE;
        }

        return FALSE;
    }
    
    protected function apply_button_action_html($html) {
        if($this->options->button_action() == "url") {
            return sprintf('<a href="%s">' . $html . '</a>', $this->options->button_action_page_url());
        }
        
        return $html;
    }

    protected function enabled() {
        $enabled = TRUE;
        
        if ($enabled && !$this->options->enabled()) {
            $enabled = FALSE;
        }

        if ($enabled && $this->options->hide_wpadmin() && is_admin()) {
            $enabled = FALSE;
        }

        if ($enabled && !$this->filter_pages()) {
            $enabled = FALSE;
        }

        $enabled = apply_filters('wpfront_scroll_top_enabled', $enabled);
        
        return $enabled;
    }

    protected function filter_pages() {
        if (is_admin()) {
            return TRUE;
        }

        switch ($this->options->display_pages()) {
            case 1:
                return TRUE;
            case 2:
            case 3:
                global $post;
                $ID = FALSE;
                if (is_home()) {
                    $ID = 'home';
                } elseif(!empty($post)) {
                    $ID = $post->ID;
                }
                if ($this->options->display_pages() == 2) {
                    if ($ID !== FALSE) {
                        if ($this->filter_pages_contains($this->options->include_pages(), $ID) === FALSE) {
                            return FALSE;
                        }
                        else {
                            return TRUE;
                        }
                    }
                    return FALSE;
                }
                if ($this->options->display_pages() == 3) {
                    if ($ID !== FALSE) {
                        if ($this->filter_pages_contains($this->options->exclude_pages(), $ID) === FALSE) {
                            return TRUE;
                        }
                        else {
                            return FALSE;
                        }
                    }
                    return TRUE;
                }
        }

        return TRUE;
    }

    protected function filter_pages_contains($list, $key) {
        return strpos(',' . $list . ',', ',' . $key . ',');
    }

    protected function image() {
        if ($this->options->image() == 'custom') {
            return $this->options->custom_url();
        }
        return $this->iconsURL . $this->options->image();
    }

    protected function get_filter_objects() {
        $objects = array();

        $objects['home'] = __('[Page]', 'wpfront-scroll-top') . ' ' . __('Home', 'wpfront-scroll-top');

        $pages = get_pages();
        foreach ($pages as $page) {
            $objects[$page->ID] = __('[Page]', 'wpfront-scroll-top') . ' ' . $page->post_title;
        }

        $posts = get_posts();
        foreach ($posts as $post) {
            $objects[$post->ID] = __('[Post]', 'wpfront-scroll-top') . ' ' . $post->post_title;
        }

//            $categories = get_categories();
//            foreach ($categories as $category) {
//                $objects['3.' . $category->cat_ID] = __('[Category]', 'wpfront-scroll-top') . ' ' . $category->cat_name;
//            }

        return $objects;
    }
    
    public function options_page() {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.', 'wpfront-scroll-top'));
            return;
        }

        include($this->pluginDIRRoot . 'templates/options-template.php');
    }

    protected function options_page_header($title, $optionsGroupName) {
        echo '<div class="wrap">';
        echo '<h2>' . $title . '</h2>';
        echo '<div id="' . self::PLUGIN_SLUG . '-options" class="inside">';
        echo '<form method="post" action="options.php">';
        @settings_fields($optionsGroupName);
        @do_settings_sections(self::PLUGIN_SLUG);

        if ((isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true') || (isset($_GET['updated']) && $_GET['updated'] == 'true')) {
            echo '
            <div class="updated">
                <p>
                    <strong>' . __('If you have a caching plugin, clear the cache for the new settings to take effect.', 'wpfront-scroll-top') . '</strong>
                </p>
            </div>
            ';
        }
    }

    protected function options_page_footer($settingsLink, $FAQLink) {
        @$this->submit_button();

        echo '</form>';
        echo '</div>';
        echo '</div>';

        $this->settingsLink = $settingsLink;
        $this->FAQLink = $FAQLink;

        add_filter('admin_footer_text', array($this, 'admin_footer_text'));
    }

    public function admin_footer_text($text) {
        $settingsLink = sprintf('<a href="%s" target="_blank">%s</a>', 'https://wpfront.com/' . $this->settingsLink, __('Settings Description', 'wpfront-scroll-top'));
        $reviewLink = sprintf('<a href="%s" target="_blank">%s</a>', 'https://wordpress.org/support/plugin/' . self::PLUGIN_SLUG . '/reviews/', __('Write a Review', 'wpfront-scroll-top'));
        $donateLink = sprintf('<a href="%s" target="_blank">%s</a>', 'https://wpfront.com/donate/', __('Buy me a Beer or Coffee', 'wpfront-scroll-top'));

        return sprintf('%s | %s | %s | %s', $settingsLink, $reviewLink, $donateLink, $text);
    }

    //for compatibility
    public function submit_button() {
        if (function_exists('submit_button')) {
            submit_button();
        } else {
            echo '<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="' . __('Save Changes', 'wpfront-scroll-top') . '" /></p>';
        }
    }
}

