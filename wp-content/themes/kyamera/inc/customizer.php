<?php
/**
 * Moral Theme Customizer
 *
 * @package Moral
 */

/**
 * Get all the default values of the theme mods.
 */
function kyamera_get_default_mods() {
	$kyamera_default_mods = array(
		// Introduction

		'kyamera_introduction_btn_txt' => esc_html__( 'Order Online', 'kyamera' ),
		
		// Products
		'kyamera_products_title' => esc_html__( 'Our Products', 'kyamera' ),

		// About
		'kyamera_about_btn_txt' => esc_html__( 'Know More', 'kyamera' ),
		

		// Features
		'kyamera_features_section_title' => esc_html__( 'Our Features', 'kyamera' ),

		// Footer copyright
		'kyamera_copyright_txt' => sprintf( esc_html__( 'Theme: %1$s by %2$s.', 'kyamera' ), 'Kyamera', '<a href="' . esc_url( 'http://moralthemes.com/' ) . '">Moral Themes</a>' ),

	);

	return apply_filters( 'kyamera_default_mods', $kyamera_default_mods );
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function kyamera_customize_register( $wp_customize ) {
	/**
	 * Separator custom control
	 *
	 * @version 1.0.0
	 * @since  1.0.0
	 */
	class Kyamera_Separator_Custom_Control extends WP_Customize_Control {
		/**
		 * Control type
		 *
		 * @var string
		 */
		public $type = 'kyamera-separator';
		/**
		 * Control method
		 *
		 * @since 1.0.0
		 */
		public function render_content() {
			?>
			<p><hr style="border-color: #222; opacity: 0.2;"></p>
			<?php
		}
	}

	/**
	 * The radio image customize control extends the WP_Customize_Control class.  This class allows
	 * developers to create a list of image radio inputs.
	 *
	 * Note, the `$choices` array is slightly different than normal and should be in the form of
	 * `array(
		 *	$value => array( 'color' => $color_value ),
		 *	$value => array( 'color' => $color_value ),
	 * )`
	 *
	 */

	/**
	 * Radio color customize control.
	 *
	 * @since  3.0.0
	 * @access public
	 */
	class Kyamera_Customize_Control_Radio_Color extends WP_Customize_Control {

		/**
		 * The type of customize control being rendered.
		 *
		 * @since  3.0.0
		 * @access public
		 * @var    string
		 */
		public $type = 'radio-color';

		/**
		 * Add custom parameters to pass to the JS via JSON.
		 *
		 * @since  3.0.0
		 * @access public
		 * @return void
		 */
		public function to_json() {
			parent::to_json();

			// We need to make sure we have the correct color URL.
			foreach ( $this->choices as $value => $args )
				$this->choices[ $value ]['color'] = esc_attr( $args['color'] );

			$this->json['choices'] = $this->choices;
			$this->json['link']    = $this->get_link();
			$this->json['value']   = $this->value();
			$this->json['id']      = $this->id;
		}

		/**
		 * Don't render the content via PHP.  This control is handled with a JS template.
		 *
		 * @since  4.0.0
		 * @access public
		 * @return bool
		 */
		protected function render_content() {}

		/**
		 * Underscore JS template to handle the control's output.
		 *
		 * @since  3.0.0
		 * @access public
		 * @return void
		 */
		public function content_template() { ?>

			<# if ( ! data.choices ) {
				return;
			} #>

			<# if ( data.label ) { #>
				<span class="customize-control-title">{{ data.label }}</span>
			<# } #>

			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>

			<# _.each( data.choices, function( args, choice ) { #>
				<label>
					<input type="radio" value="{{ choice }}" name="_customize-{{ data.type }}-{{ data.id }}" {{{ data.link }}} <# if ( choice === data.value ) { #> checked="checked" <# } #> />

					<span class="screen-reader-text">{{ args.label }}</span>
					
					<# if ( 'custom' != choice ) { #>
						<span class="color-value" style="background-color: {{ args.color }}"></span>
					<# } else { #>
						<span class="color-value custom-color-value"></span>
					<# } #>
				</label>
			<# } ) #>
		<?php }
	}

	$wp_customize->register_control_type( 'Kyamera_Customize_Control_Radio_Color'       );

	class Kyamera_Customize_Control_Sort_Sections extends WP_Customize_Control {

	  	/**
	   	* Control Type
	   	*/
	  	public $type = 'sortable';
	  
		/**
		* Add custom parameters to pass to the JS via JSON.
		*
		* @access public
		* @return void
		*/
	  	public function to_json() {
		  	parent::to_json();

	    	$choices = $this->choices;
	      	$choices = array_filter( array_merge( array_flip( $this->value() ), $choices ) );
		  	$this->json['choices'] = $choices;
		  	$this->json['link']    = $this->get_link();
		  	$this->json['value']   = $this->value();
		  	$this->json['id']      = $this->id;
	  	}

	  	/**
	   	* Render Settings
	   	*/
	  	public function content_template() { ?>
		  	<# if ( ! data.choices ) {
		  		return;
		  	} #>

		    <# if ( data.label ) { #>
				<span class="customize-control-title">{{ data.label }}</span>
			<# } #>

		    <# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>

		    <ul class="kyamera-sortable-list">

		      	<# _.each( data.choices, function( args, choice ) { #>

		        <li>
		            <input class="kyamera-sortable-input sortable-hideme" name="{{choice}}" type="hidden"  value="{{ choice }}" />
		            <span class ="menu-item-handle sortable-span">{{args.name}}</span>
		          <i title="<?php esc_html_e( 'Drag and Move', 'kyamera' );?>" class="dashicons dashicons-menu kyamera-drag-handle"></i>
		          <i title="<?php esc_html_e( 'Edit', 'kyamera' );?>" class="dashicons dashicons-edit kyamera-edit" data-jump="{{args.section_id}}"></i>
		        </li>

		        <# } ) #>

		        <li class="sortable-hideme">
		          <input class="kyamera-sortable-value" {{{ data.link }}} value="{{data.value}}" />
		        </li>

		    </ul>
	  	<?php
	  	}
	}

	$wp_customize->register_control_type( 'Kyamera_Customize_Control_Sort_Sections' );

	$default = kyamera_get_default_mods();

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'kyamera_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'kyamera_customize_partial_blogdescription',
		) );
	}

	/**
	 *
	 * 
	 * Header panel
	 *
	 * 
	 */
	// Header panel
	$wp_customize->add_panel(
		'kyamera_header_panel',
		array(
			'title' => esc_html__( 'Header', 'kyamera' ),
			'priority' => 100
		)
	);

	$wp_customize->get_section( 'title_tagline' )->panel         = 'kyamera_header_panel';
	$wp_customize->get_section( 'header_image' )->panel         = 'kyamera_header_panel';
	// Header text display setting
		$wp_customize->add_setting(	
			'kyamera_header_text_display',
			array(
				'sanitize_callback' => 'kyamera_sanitize_checkbox',
				'default' => true,
				'transport'	=> 'postMessage',
			)
		);

		$wp_customize->add_control(
			'kyamera_header_text_display',
			array(
				'section'		=> 'title_tagline',
				'type'			=> 'checkbox',
				'label'			=> esc_html__( 'Display Site Title and Tagline', 'kyamera' ),
			)
		);

	// Header section
	$wp_customize->add_section(
		'kyamera_header_section',
		array(
			'title' => esc_html__( 'Header', 'kyamera' ),
			'panel' => 'kyamera_header_panel',
		)
	);

	// Header menu sticky enable settings
	$wp_customize->add_setting(
		'kyamera_make_menu_sticky',
		array(
			'sanitize_callback' => 'kyamera_sanitize_checkbox',
			'default' => false
		)
	);

	$wp_customize->add_control(
		'kyamera_make_menu_sticky',
		array(
			'section'		=> 'kyamera_header_section',
			'label'			=> esc_html__( 'Make menu sticky.', 'kyamera' ),
			'type'			=> 'checkbox',
		)
	);

	/**
	 *
	 * 
	 * Home sections panel
	 *
	 * 
	 */
	// Home sections panel
	$wp_customize->add_panel(
		'kyamera_home_panel',
		array(
			'title' => esc_html__( 'Homepage', 'kyamera' ),
			'priority' => 105
		)
	);

	$wp_customize->get_section( 'static_front_page' )->panel         = 'kyamera_home_panel';


	// Your latest posts title setting
	$wp_customize->add_setting(	
		'kyamera_your_latest_posts_title',
		array(
			'sanitize_callback' => 'sanitize_text_field',
			'default' => esc_html__( 'Blogs', 'kyamera' ),
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		'kyamera_your_latest_posts_title',
		array(
			'section'		=> 'static_front_page',
			'label'			=> esc_html__( 'Title:', 'kyamera' ),
			'active_callback' => 'kyamera_is_latest_posts'
		)
	);

	$wp_customize->selective_refresh->add_partial( 
		'kyamera_your_latest_posts_title', 
		array(
	        'selector'            => '.home.blog #page-header .page-title',
			'render_callback'     => 'kyamera_your_latest_posts_partial_title',
    	) 
    );

	/**
	 * Introduction section
	 */
	// Introduction section
	$wp_customize->add_section(
		'kyamera_introduction',
		array(
			'title' => esc_html__( 'Introduction', 'kyamera' ),
			'panel' => 'kyamera_home_panel',
		)
	);

	// Introduction enable settings
	$wp_customize->add_setting(
		'kyamera_introduction',
		array(
			'sanitize_callback' => 'kyamera_sanitize_select',
			'default' => 'custom'
		)
	);

	$wp_customize->add_control(
		'kyamera_introduction',
		array(
			'section'		=> 'kyamera_introduction',
			'label'			=> esc_html__( 'Content type:', 'kyamera' ),
			'description'			=> esc_html__( 'Choose where you want to render the content from.', 'kyamera' ),
			'type'			=> 'select',
			'choices'		=> array( 
					'disable' => esc_html__( '--Disable--', 'kyamera' ),
					'page' => esc_html__( 'Page', 'kyamera' ),
			 	)
		)
	);

	// Introduction page setting
	$wp_customize->add_setting(
		'kyamera_introduction_page',
		array(
			'sanitize_callback' => 'kyamera_sanitize_dropdown_pages',
			'default' => 0,
		)
	);

	$wp_customize->add_control(
		'kyamera_introduction_page',
		array(
			'section'		=> 'kyamera_introduction',
			'label'			=> esc_html__( 'Page:', 'kyamera' ),
			'type'			=> 'dropdown-pages',
			'active_callback' => 'kyamera_if_introduction_page'
		)
	);

	// Introduction button text setting
	$wp_customize->add_setting(
		'kyamera_introduction_btn_txt',
		array(
			'sanitize_callback' => 'sanitize_text_field',
			'default' => $default['kyamera_introduction_btn_txt'],
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		'kyamera_introduction_btn_txt',
		array(
			'section'		=> 'kyamera_introduction',
			'label'			=> esc_html__( 'Button Text:', 'kyamera' ),
			'active_callback' => 'kyamera_if_introduction_enabled'
		)
	);

	$wp_customize->selective_refresh->add_partial( 
		'kyamera_introduction_btn_txt', 
		array(
	        'selector'            => '#introduction-section .more-link a',
			'render_callback'     => 'kyamera_introduction_partial_btn_txt',
    	) 
    );

	/**
	 * Products section
	 */
	// Products section
	$wp_customize->add_section(
		'kyamera_products',
		array(
			'title' => esc_html__( 'Products', 'kyamera' ),
			'panel' => 'kyamera_home_panel',
		)
	);

	// Products enable settings
	$wp_customize->add_setting(
		'kyamera_products',
		array(
			'sanitize_callback' => 'kyamera_sanitize_select',
			'default' => 'custom'
		)
	);

	$wp_customize->add_control(
		'kyamera_products',
		array(
			'section'		=> 'kyamera_products',
			'label'			=> esc_html__( 'Content type:', 'kyamera' ),
			'description'			=> esc_html__( 'Choose where you want to render the content from.', 'kyamera' ),
			'type'			=> 'select',
			'choices'		=> array( 
					'disable' => esc_html__( '--Disable--', 'kyamera' ),
					'page' => esc_html__( 'Page', 'kyamera' ),
			 	)
		)
	);

	// Products title setting
	$wp_customize->add_setting(
		'kyamera_products_title',
		array(
			'sanitize_callback' => 'sanitize_text_field',
			'default' => $default['kyamera_products_title'],
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		'kyamera_products_title',
		array(
			'section'		=> 'kyamera_products',
			'label'			=> esc_html__( 'Title:', 'kyamera' ),
			'active_callback' => 'kyamera_if_products_not_disabled'
		)
	);

	$wp_customize->selective_refresh->add_partial( 
		'kyamera_products_title', 
		array(
	        'selector'            => '#products-section .section-title',
			'render_callback'     => 'kyamera_products_partial_title',
    	) 
    );

	for ( $i=1; $i <= 4; $i++ ) { 

		// Products page setting
		$wp_customize->add_setting(
			'kyamera_products_page_' . $i,
			array(
				'sanitize_callback' => 'kyamera_sanitize_dropdown_pages',
				'default' => 0,
			)
		);

		$wp_customize->add_control(
			'kyamera_products_page_' . $i,
			array(
				'section'		=> 'kyamera_products',
				'label'			=> esc_html__( 'Page ', 'kyamera' ) . $i,
				'type'			=> 'dropdown-pages',
				'active_callback' => 'kyamera_if_products_page'
			)
		);

		// Products custom separator setting
		$wp_customize->add_setting(
			'kyamera_products_custom_separator_' . $i,
			array(
				'sanitize_callback' => 'kyamera_sanitize_html',
			)
		);

		$wp_customize->add_control(
			new Kyamera_Separator_Custom_Control( 
			$wp_customize,
			'kyamera_products_custom_separator_' . $i,
				array(
					'section'		=> 'kyamera_products',
					'active_callback' => 'kyamera_if_products_not_cat_disabled',
					'type'			=> 'kyamera-separator',
				)
			)
		);
	}

	/**
	 * About section
	 */
	// About section
	$wp_customize->add_section(
		'kyamera_about',
		array(
			'title' => esc_html__( 'About', 'kyamera' ),
			'panel' => 'kyamera_home_panel',
		)
	);

	// About image setting
	$wp_customize->add_setting(
		'kyamera_about_background',
		array(
			'sanitize_callback' => 'kyamera_sanitize_image',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'kyamera_about_background',
			array(
				'section'		=> 'kyamera_about',
				'label'			=> esc_html__( 'Background Image:', 'kyamera' ),
				'active_callback' => 'kyamera_if_about_enabled',
			)
		)
	);
	// About enable settings
	$wp_customize->add_setting(
		'kyamera_about',
		array(
			'sanitize_callback' => 'kyamera_sanitize_select',
			'default' => 'custom'
		)
	);

	$wp_customize->add_control(
		'kyamera_about',
		array(
			'section'		=> 'kyamera_about',
			'label'			=> esc_html__( 'Content type:', 'kyamera' ),
			'description'			=> esc_html__( 'Choose where you want to render the content from.', 'kyamera' ),
			'type'			=> 'select',
			'choices'		=> array( 
					'disable' => esc_html__( '--Disable--', 'kyamera' ),
					'page' => esc_html__( 'Page', 'kyamera' ),
			 	)
		)
	);

	// About page setting
	$wp_customize->add_setting(
		'kyamera_about_page',
		array(
			'sanitize_callback' => 'kyamera_sanitize_dropdown_pages',
			'default' => 0,
		)
	);

	$wp_customize->add_control(
		'kyamera_about_page',
		array(
			'section'		=> 'kyamera_about',
			'label'			=> esc_html__( 'Page:', 'kyamera' ),
			'type'			=> 'dropdown-pages',
			'active_callback' => 'kyamera_if_about_page'
		)
	);

	// About button text setting
	$wp_customize->add_setting(
		'kyamera_about_btn_txt',
		array(
			'sanitize_callback' => 'sanitize_text_field',
			'default' => $default['kyamera_about_btn_txt'],
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		'kyamera_about_btn_txt',
		array(
			'section'		=> 'kyamera_about',
			'label'			=> esc_html__( 'Button Text:', 'kyamera' ),
			'active_callback' => 'kyamera_if_about_enabled'
		)
	);

	$wp_customize->selective_refresh->add_partial( 
		'kyamera_about_btn_txt', 
		array(
	        'selector'            => '#about-section .more-link a',
			'render_callback'     => 'kyamera_about_partial_btn_txt',
    	) 
    );


	/**
	 * Features section
	 */
	// Features section
	$wp_customize->add_section(
		'kyamera_features',
		array(
			'title' => esc_html__( 'Features', 'kyamera' ),
			'panel' => 'kyamera_home_panel',
		)
	);

	// Features title setting
	$wp_customize->add_setting(
		'kyamera_features_section_title',
		array(
			'sanitize_callback' => 'sanitize_text_field',
			'default' => $default['kyamera_features_section_title'],
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		'kyamera_features_section_title',
		array(
			'section'		=> 'kyamera_features',
			'label'			=> esc_html__( 'Title:', 'kyamera' ),
			'active_callback' => 'kyamera_if_features_not_disabled',
			'type'			=> 'text',
		)
	);

	// Features enable settings
	$wp_customize->add_setting(
		'kyamera_features',
		array(
			'sanitize_callback' => 'kyamera_sanitize_select',
			'default' => 'cat'
		)
	);

	$wp_customize->add_control(
		'kyamera_features',
		array(
			'section'		=> 'kyamera_features',
			'label'			=> esc_html__( 'Content type:', 'kyamera' ),
			'description'			=> esc_html__( 'Choose where you want to render the content from.', 'kyamera' ),
			'type'			=> 'select',
			'choices'		=> array( 
					'disable' => esc_html__( '--Disable--', 'kyamera' ),
					'cat' => esc_html__( 'Category', 'kyamera' ),
			 	)
		)
	);

    // Features number setting
	$wp_customize->add_setting(
		'kyamera_features_num',
		array(
			'sanitize_callback' => 'kyamera_sanitize_number_range',
			'default' => 3,
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		'kyamera_features_num',
		array(
			'section'		=> 'kyamera_features',
			'label'			=> esc_html__( 'Number of features:', 'kyamera' ),
			'description'			=> esc_html__( 'Min: 1 | Max: 6', 'kyamera' ),
			'active_callback' => 'kyamera_if_features_not_disabled',
			'type'			=> 'number',
			'input_attrs'	=> array( 'min' => 1, 'max' => 6 ),
		)
	);

	// Features number separator setting
	$wp_customize->add_setting(
		'kyamera_features_num_separator',
		array(
			'sanitize_callback' => 'kyamera_sanitize_html',
		)
	);

	$wp_customize->add_control(
		new Kyamera_Separator_Custom_Control( 
		$wp_customize,
		'kyamera_features_num_separator',
			array(
				'section'		=> 'kyamera_features',
				'active_callback' => 'kyamera_if_features_not_disabled',
				'type'			=> 'kyamera-separator',
			)
		)
	);

    // Features category setting
	$wp_customize->add_setting(
		'kyamera_features_cat',
		array(
			'sanitize_callback' => 'kyamera_sanitize_select',
		)
	);

	$wp_customize->add_control(
		'kyamera_features_cat',
		array(
			'section'		=> 'kyamera_features',
			'label'			=> esc_html__( 'Category:', 'kyamera' ),
			'active_callback' => 'kyamera_if_features_cat',
			'type'			=> 'select',
			'choices'		=> kyamera_get_post_cat_choices(),
		)
	); 

	$features_num = get_theme_mod( 'kyamera_features_num', 3 );
	for ( $i=1; $i <= $features_num; $i++ ) { 

		//Features Section icon
		$wp_customize->add_setting(
			'kyamera_features_icons_' . $i,
			array(	
			'sanitize_callback' => 'sanitize_text_field'
			)
		);

		$wp_customize->add_control(
			'kyamera_features_icons_' . $i,
			array(
			'label'       => __('Icon', 'kyamera'). $i,
			'description' => sprintf( __('Please input icon as eg: fa-archive. Find Font-awesome icons %1$shere%2$s', 'kyamera'), '<a href="' . esc_url( 'https://fontawesome.com/v4.7.0/cheatsheet/' ) . '" target="_blank">', '</a>' ),
			'section'     => 'kyamera_features',   
			'active_callback' => 'kyamera_if_features_not_disabled',		
			'type'        => 'text'
			)
		);
	}

	/**
	 *
	 * General settings panel
	 * 
	 */
	// General settings panel
	$wp_customize->add_panel(
		'kyamera_general_panel',
		array(
			'title' => esc_html__( 'Advanced Settings', 'kyamera' ),
			'priority' => 107
		)
	);

	$wp_customize->get_section( 'colors' )->panel         = 'kyamera_general_panel';
	
	// Header title color setting
	$wp_customize->add_setting(	
		'kyamera_header_title_color',
		array(
			'sanitize_callback' => 'kyamera_sanitize_hex_color',
			'default' => '#ff8737',
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control( 
		$wp_customize,
			'kyamera_header_title_color',
			array(
				'section'		=> 'colors',
				'label'			=> esc_html__( 'Site title Color:', 'kyamera' ),
			)
		)
	);

	// Header tagline color setting
	$wp_customize->add_setting(	
		'kyamera_header_tagline',
		array(
			'sanitize_callback' => 'kyamera_sanitize_hex_color',
			'default' => '#929292',
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control( 
		$wp_customize,
			'kyamera_header_tagline',
			array(
				'section'		=> 'colors',
				'label'			=> esc_html__( 'Site tagline Color:', 'kyamera' ),
			)
		)
	);

	$wp_customize->get_section( 'background_image' )->panel         = 'kyamera_general_panel';
	$wp_customize->get_section( 'custom_css' )->panel         = 'kyamera_general_panel';

	/**
	 * General settings
	 */
	// General settings
	$wp_customize->add_section(
		'kyamera_general_section',
		array(
			'title' => esc_html__( 'General', 'kyamera' ),
			'panel' => 'kyamera_general_panel',
		)
	);

	

	// Backtop enable setting
	$wp_customize->add_setting(
		'kyamera_back_to_top_enable',
		array(
			'sanitize_callback' => 'kyamera_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'kyamera_back_to_top_enable',
		array(
			'section'		=> 'kyamera_general_section',
			'label'			=> esc_html__( 'Enable Scroll up.', 'kyamera' ),
			'type'			=> 'checkbox',
		)
	);

	/**
	 * Global Layout
	 */
	// Global Layout
	$wp_customize->add_section(
		'kyamera_global_layout',
		array(
			'title' => esc_html__( 'Global Layout', 'kyamera' ),
			'panel' => 'kyamera_general_panel',
		)
	);

	// Global site layout setting
	$wp_customize->add_setting(
		'kyamera_site_layout',
		array(
			'sanitize_callback' => 'kyamera_sanitize_select',
			'default' => 'wide',
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		'kyamera_site_layout',
		array(
			'section'		=> 'kyamera_global_layout',
			'label'			=> esc_html__( 'Site layout', 'kyamera' ),
			'type'			=> 'radio',
			'choices'		=> array( 
				'boxed' => esc_html__( 'Boxed', 'kyamera' ), 
				'wide' => esc_html__( 'Wide', 'kyamera' ), 
			),
		)
	);

	// Global archive layout setting
	$wp_customize->add_setting(
		'kyamera_archive_sidebar',
		array(
			'sanitize_callback' => 'kyamera_sanitize_select',
			'default' => 'right',
		)
	);

	$wp_customize->add_control(
		'kyamera_archive_sidebar',
		array(
			'section'		=> 'kyamera_global_layout',
			'label'			=> esc_html__( 'Archive Sidebar', 'kyamera' ),
			'description'			=> esc_html__( 'This option works on all archive pages like: 404, search, date, category, "Your latest posts" and so on.', 'kyamera' ),
			'type'			=> 'radio',
			'choices'		=> array( 
				'right' => esc_html__( 'Right', 'kyamera' ), 
				'no' => esc_html__( 'No Sidebar', 'kyamera' ), 
			),
		)
	);

	// Global page layout setting
	$wp_customize->add_setting(
		'kyamera_global_page_layout',
		array(
			'sanitize_callback' => 'kyamera_sanitize_select',
			'default' => 'right',
		)
	);

	$wp_customize->add_control(
		'kyamera_global_page_layout',
		array(
			'section'		=> 'kyamera_global_layout',
			'label'			=> esc_html__( 'Global page sidebar', 'kyamera' ),
			'description'			=> esc_html__( 'This option works only on single pages including "Posts page". This setting can be overridden for single page from the metabox too.', 'kyamera' ),
			'type'			=> 'radio',
			'choices'		=> array( 
				'right' => esc_html__( 'Right', 'kyamera' ), 
				'no' => esc_html__( 'No Sidebar', 'kyamera' ), 
			),
		)
	);

	// Global post layout setting
	$wp_customize->add_setting(
		'kyamera_global_post_layout',
		array(
			'sanitize_callback' => 'kyamera_sanitize_select',
			'default' => 'right',
		)
	);

	$wp_customize->add_control(
		'kyamera_global_post_layout',
		array(
			'section'		=> 'kyamera_global_layout',
			'label'			=> esc_html__( 'Global post sidebar', 'kyamera' ),
			'description'			=> esc_html__( 'This option works only on single posts. This setting can be overridden for single post from the metabox too.', 'kyamera' ),
			'type'			=> 'radio',
			'choices'		=> array( 
				'right' => esc_html__( 'Right', 'kyamera' ), 
				'no' => esc_html__( 'No Sidebar', 'kyamera' ), 
			),
		)
	);

	/**
	 * Blog/Archive section 
	 */
	// Blog/Archive section 
	$wp_customize->add_section(
		'kyamera_archive_settings',
		array(
			'title' => esc_html__( 'Archive/Blog', 'kyamera' ),
			'description' => esc_html__( 'Settings for archive pages including blog page too.', 'kyamera' ),
			'panel' => 'kyamera_general_panel',
		)
	);

	// Archive excerpt setting
	$wp_customize->add_setting(
		'kyamera_archive_excerpt',
		array(
			'sanitize_callback' => 'sanitize_text_field',
			'default' => esc_html__( 'View the post', 'kyamera' ),
		)
	);

	$wp_customize->add_control(
		'kyamera_archive_excerpt',
		array(
			'section'		=> 'kyamera_archive_settings',
			'label'			=> esc_html__( 'Excerpt more text:', 'kyamera' ),
		)
	);

	// Archive excerpt length setting
	$wp_customize->add_setting(
		'kyamera_archive_excerpt_length',
		array(
			'sanitize_callback' => 'kyamera_sanitize_number_range',
			'default' => 60,
		)
	);

	$wp_customize->add_control(
		'kyamera_archive_excerpt_length',
		array(
			'section'		=> 'kyamera_archive_settings',
			'label'			=> esc_html__( 'Excerpt more length:', 'kyamera' ),
			'type'			=> 'number',
			'input_attrs'   => array( 'min' => 5 ),
		)
	);

	// Pagination type setting
	$wp_customize->add_setting(
		'kyamera_archive_pagination_type',
		array(
			'sanitize_callback' => 'kyamera_sanitize_select',
			'default' => 'numeric',
		)
	);

	$archive_pagination_description = '';
	$archive_pagination_choices = array( 
				'disable' => esc_html__( '--Disable--', 'kyamera' ),
				'numeric' => esc_html__( 'Numeric', 'kyamera' ),
				'older_newer' => esc_html__( 'Older / Newer', 'kyamera' ),
			);
	if ( ! class_exists( 'JetPack' ) ) {
		$archive_pagination_description = sprintf( esc_html__( 'We recommend to install %1$sJetpack%2$s and enable %3$sInfinite Scroll%4$s feature for automatic loading of posts.', 'kyamera' ), '<a target="_blank" href="http://wordpress.org/plugins/jetpack">', '</a>', '<b>', '</b>' );
	} else {
		$archive_pagination_choices['infinite_scroll'] = esc_html__( 'Infinite Load', 'kyamera' );
	}
	$wp_customize->add_control(
		'kyamera_archive_pagination_type',
		array(
			'section'		=> 'kyamera_archive_settings',
			'label'			=> esc_html__( 'Pagination type:', 'kyamera' ),
			'description'			=>  $archive_pagination_description,
			'type'			=> 'select',
			'choices'		=> $archive_pagination_choices,
		)
	);
	
	/**
	 * Reset all settings
	 */
	// Reset settings section
	$wp_customize->add_section(
		'kyamera_reset_sections',
		array(
			'title' => esc_html__( 'Reset all', 'kyamera' ),
			'description' => esc_html__( 'Reset all settings to default.', 'kyamera' ),
			'panel' => 'kyamera_general_panel',
		)
	);

	// Reset sortable order setting
	$wp_customize->add_setting(
		'kyamera_reset_settings',
		array(
			'sanitize_callback' => 'kyamera_sanitize_checkbox',
			'default' => false,
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		'kyamera_reset_settings',
		array(
			'section'		=> 'kyamera_reset_sections',
			'label'			=> esc_html__( 'Reset all settings?', 'kyamera' ),
			'type'			=> 'checkbox',
		)
	);

	/**
	 *
	 *
	 * Footer copyright
	 *
	 *
	 */
	// Footer copyright
	$wp_customize->add_section(
		'kyamera_footer_section',
		array(
			'title' => esc_html__( 'Footer', 'kyamera' ),
			'priority' => 106,
			// 'panel' => 'kyamera_general_panel',
		)
	);

	// Footer social menu enable setting
	$wp_customize->add_setting(
		'kyamera_enable_footer_social_menu',
		array(
			'sanitize_callback' => 'kyamera_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'kyamera_enable_footer_social_menu',
		array(
			'section'		=> 'kyamera_footer_section',
			'label'			=> esc_html__( 'Enable social menu.', 'kyamera' ),
			'type'			=> 'checkbox',
		)
	);
}
add_action( 'customize_register', 'kyamera_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function kyamera_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function kyamera_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function kyamera_customize_preview_js() {
	wp_enqueue_script( 'kyamera-customizer', get_theme_file_uri( '/assets/js/customizer.js' ), array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'kyamera_customize_preview_js' );

/**
 * Binds JS handlers for Customizer controls.
 */
function kyamera_customize_control_js() {


	wp_enqueue_style( 'kyamera-customize-style', get_theme_file_uri( '/assets/css/customize-controls.css' ), array(), '20151215' );

	wp_enqueue_script( 'kyamera-customize-control', get_theme_file_uri( '/assets/js/customize-control.js' ), array( 'jquery', 'customize-controls' ), '20151215', true );
	$localized_data = array( 
		'refresh_msg' => esc_html__( 'Refresh the page after Save and Publish.', 'kyamera' ),
		'reset_msg' => esc_html__( 'Warning!!! This will reset all the settings. Refresh the page after Save and Publish to reset all.', 'kyamera' ),
	);

	wp_localize_script( 'kyamera-customize-control', 'localized_data', $localized_data );
}
add_action( 'customize_controls_enqueue_scripts', 'kyamera_customize_control_js' );

/**
 *
 * Sanitization callbacks.
 * 
 */

/**
 * Checkbox sanitization callback example.
 * 
 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
 * as a boolean value, either TRUE or FALSE.
 *
 * @param bool $checked Whether the checkbox is checked.
 * @return bool Whether the checkbox is checked.
 */
function kyamera_sanitize_checkbox( $checked ) {
	// Boolean check.
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}


/**
 * HEX Color sanitization callback example.
 *
 * - Sanitization: hex_color
 * - Control: text, WP_Customize_Color_Control
 *
 */
function kyamera_sanitize_hex_color( $hex_color, $setting ) {
	// Sanitize $input as a hex value without the hash prefix.
	$hex_color = sanitize_hex_color( $hex_color );
	
	// If $input is a valid hex value, return it; otherwise, return the default.
	return ( ! is_null( $hex_color ) ? $hex_color : $setting->default );
}

/**
 * Image sanitization callback example.
 *
 * Checks the image's file extension and mime type against a whitelist. If they're allowed,
 * send back the filename, otherwise, return the setting default.
 *
 * - Sanitization: image file extension
 * - Control: text, WP_Customize_Image_Control
 */
function kyamera_sanitize_image( $image, $setting ) {
	/*
	 * Array of valid image file types.
	 *
	 * The array includes image mime types that are included in wp_get_mime_types()
	 */
    $mimes = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif'          => 'image/gif',
        'png'          => 'image/png',
        'bmp'          => 'image/bmp',
        'tif|tiff'     => 'image/tiff',
        'ico'          => 'image/x-icon',
        'svg'          => 'image/svg+xml'
    );
	// Return an array with file extension and mime_type.
    $file = wp_check_filetype( $image, $mimes );
	// If $image has a valid mime_type, return it; otherwise, return the default.
    return ( $file['ext'] ? $image : $setting->default );
}

/**
 * Select sanitization callback example.
 *
 * - Sanitization: select
 * - Control: select, radio
 */
function kyamera_sanitize_select( $input, $setting ) {
	
	// Ensure input is a slug.
	$input = sanitize_key( $input );
	
	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;
	
	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Drop-down Pages sanitization callback example.
 *
 * - Sanitization: dropdown-pages
 * - Control: dropdown-pages
 * 
 */
function kyamera_sanitize_dropdown_pages( $page_id, $setting ) {
	// Ensure $input is an absolute integer.
	$page_id = absint( $page_id );
	
	// If $page_id is an ID of a published page, return it; otherwise, return the default.
	return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
}

/**
 * Number Range sanitization callback example.
 *
 * - Sanitization: number_range
 * - Control: number, tel
 * 
 */
function kyamera_sanitize_number_range( $number, $setting ) {
	
	// Ensure input is an absolute integer.
	$number = absint( $number );
	
	// Get the input attributes associated with the setting.
	$atts = $setting->manager->get_control( $setting->id )->input_attrs;
	
	// Get minimum number in the range.
	$min = ( isset( $atts['min'] ) ? $atts['min'] : $number );
	
	// Get maximum number in the range.
	$max = ( isset( $atts['max'] ) ? $atts['max'] : $number );
	
	// Get step.
	$step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );
	
	// If the number is within the valid range, return it; otherwise, return the default
	return ( $min <= $number && $number <= $max && is_int( $number / $step ) ? $number : $setting->default );
}

/**
 * HTML sanitization callback example.
 *
 * - Sanitization: html
 * - Control: text, textarea
 *
 * @param string $html HTML to sanitize.
 * @return string Sanitized HTML.
 */
function kyamera_sanitize_html( $html ) {
	return wp_filter_post_kses( $html );
}

/**
 * Sortable section sanitization callback example.
 *
 * - Sanitization: sortable section
 * - Control: sortable
 *
 * @param string $input Value to be sanitized.
 * @return array Sanitized values as array.
 */
function kyamera_sanitize_sort( $input ) {
	// Ensure $input is an array.
	if ( ! is_array( $input ) ){
		$input = explode( ',', $input );
	}

	$output = array_map( 'sanitize_text_field', $input );

	return $output;
}

/**
 *
 * Active callbacks.
 * 
 */

/**
 * Check if the introduction is enabled
 */
function kyamera_if_introduction_enabled( $control ) {
	return 'disable' != $control->manager->get_setting( 'kyamera_introduction' )->value();
}

/**
 * Check if the introduction is custom
 */
function kyamera_if_introduction_custom( $control ) {
	return 'custom' === $control->manager->get_setting( 'kyamera_introduction' )->value();
}

/**
 * Check if the introduction is page
 */
function kyamera_if_introduction_page( $control ) {
	return 'page' === $control->manager->get_setting( 'kyamera_introduction' )->value();
}

/**
 * Check if the introduction is post
 */
function kyamera_if_introduction_post( $control ) {
	return 'post' === $control->manager->get_setting( 'kyamera_introduction' )->value();
}

/**
 * Check if the products is not disabled
 */
function kyamera_if_products_not_disabled( $control ) {
	return 'disable' != $control->manager->get_setting( 'kyamera_products' )->value();
}

/**
 * Check if the products is page
 */
function kyamera_if_products_page( $control ) {
	return 'page' === $control->manager->get_setting( 'kyamera_products' )->value();
}

/**
 * Check if the products is post
 */
function kyamera_if_products_post( $control ) {
	return 'post' === $control->manager->get_setting( 'kyamera_products' )->value();
}

/**
 * Check if the products is cat
 */
function kyamera_if_products_cat( $control ) {
	return 'cat' === $control->manager->get_setting( 'kyamera_products' )->value();
}

/**
 * Check if the products is custom
 */
function kyamera_if_products_custom( $control ) {
	return 'custom' === $control->manager->get_setting( 'kyamera_products' )->value();
}

/**
 * Check if the products is not disabled or category.
 */
function kyamera_if_products_not_cat_disabled( $control ) {
	return ( ! kyamera_if_products_cat( $control ) && kyamera_if_products_not_disabled( $control ) );
}

/**
 * Check if the about is enabled
 */
function kyamera_if_about_enabled( $control ) {
	return 'disable' != $control->manager->get_setting( 'kyamera_about' )->value();
}

/**
 * Check if the about is custom
 */
function kyamera_if_about_custom( $control ) {
	return 'custom' === $control->manager->get_setting( 'kyamera_about' )->value();
}

/**
 * Check if the about is page
 */
function kyamera_if_about_page( $control ) {
	return 'page' === $control->manager->get_setting( 'kyamera_about' )->value();
}

/**
 * Check if the about is post
 */
function kyamera_if_about_post( $control ) {
	return 'post' === $control->manager->get_setting( 'kyamera_about' )->value();
}

/**
 * Check if the features is not disabled
 */
function kyamera_if_features_not_disabled( $control ) {
	return 'disable' != $control->manager->get_setting( 'kyamera_features' )->value();
}

/**
 * Check if the features is page
 */
function kyamera_if_features_page( $control ) {
	return 'page' === $control->manager->get_setting( 'kyamera_features' )->value();
}

/**
 * Check if the features is post
 */
function kyamera_if_features_post( $control ) {
	return 'post' === $control->manager->get_setting( 'kyamera_features' )->value();
}

/**
 * Check if the features is cat
 */
function kyamera_if_features_cat( $control ) {
	return 'cat' === $control->manager->get_setting( 'kyamera_features' )->value();
}

/**
 * Check if the features is custom
 */
function kyamera_if_features_custom( $control ) {
	return 'custom' === $control->manager->get_setting( 'kyamera_features' )->value();
}

/**
 * Check if the features is not disabled or category.
 */
function kyamera_if_features_not_cat_disabled( $control ) {
	return ( ! kyamera_if_features_cat( $control ) && kyamera_if_features_not_disabled( $control ) );
}

/**
 * Check if the gallery is not disabled
 */
function kyamera_if_gallery_not_disabled( $control ) {
	return 'disable' != $control->manager->get_setting( 'kyamera_gallery' )->value();
}

/**
 * Check if the gallery is page
 */
function kyamera_if_gallery_page( $control ) {
	return 'page' === $control->manager->get_setting( 'kyamera_gallery' )->value();
}

/**
 * Check if the gallery is post
 */
function kyamera_if_gallery_post( $control ) {
	return 'post' === $control->manager->get_setting( 'kyamera_gallery' )->value();
}

/**
 * Check if the gallery is cat
 */
function kyamera_if_gallery_cat( $control ) {
	return 'cat' === $control->manager->get_setting( 'kyamera_gallery' )->value();
}

/**
 * Check if the gallery is custom
 */
function kyamera_if_gallery_custom( $control ) {
	return 'custom' === $control->manager->get_setting( 'kyamera_gallery' )->value();
}

/**
 * Check if the testimonial is not disabled
 */
function kyamera_if_testimonial_not_disabled( $control ) {
	return 'disable' != $control->manager->get_setting( 'kyamera_testimonial' )->value();
}

/**
 * Check if the testimonial is page
 */
function kyamera_if_testimonial_page( $control ) {
	return 'page' === $control->manager->get_setting( 'kyamera_testimonial' )->value();
}

/**
 * Check if the testimonial is post
 */
function kyamera_if_testimonial_post( $control ) {
	return 'post' === $control->manager->get_setting( 'kyamera_testimonial' )->value();
}

/**
 * Check if the testimonial is cat
 */
function kyamera_if_testimonial_cat( $control ) {
	return 'cat' === $control->manager->get_setting( 'kyamera_testimonial' )->value();
}

/**
 * Check if the testimonial is custom
 */
function kyamera_if_testimonial_custom( $control ) {
	return 'custom' === $control->manager->get_setting( 'kyamera_testimonial' )->value();
}

/**
 * Check if the slider is not disabled
 */
function kyamera_if_slider_not_disabled( $control ) {
	return 'disable' != $control->manager->get_setting( 'kyamera_slider' )->value();
}

/**
 * Check if the slider is page
 */
function kyamera_if_slider_page( $control ) {
	return 'page' === $control->manager->get_setting( 'kyamera_slider' )->value();
}

/**
 * Check if the slider is post
 */
function kyamera_if_slider_post( $control ) {
	return 'post' === $control->manager->get_setting( 'kyamera_slider' )->value();
}

/**
 * Check if the slider is cat
 */
function kyamera_if_slider_cat( $control ) {
	return 'cat' === $control->manager->get_setting( 'kyamera_slider' )->value();
}

/**
 * Check if the slider is custom
 */
function kyamera_if_slider_custom( $control ) {
	return 'custom' === $control->manager->get_setting( 'kyamera_slider' )->value();
}

/**
 * Check if the partner is enabled.
 */
function kyamera_if_partner_enable( $control ) {
	return $control->manager->get_setting( 'kyamera_enable_partner' )->value();
}

/**
 * Check if the blog section is not disabled
 */
function kyamera_if_blog_section_not_disabled( $control ) {
	return 'disable' != $control->manager->get_setting( 'kyamera_blog_section' )->value();
}

/**
 * Check if the blog section is cat
 */
function kyamera_if_blog_section_cat( $control ) {
	return 'cat' === $control->manager->get_setting( 'kyamera_blog_section' )->value();
}

/**
 * Check if the blog section is post
 */
function kyamera_if_blog_section_post( $control ) {
	return 'post' === $control->manager->get_setting( 'kyamera_blog_section' )->value();
}

/**
 * Check if the footer text is enabled
 */
function kyamera_if_footer_text_enable( $control ) {
	return $control->manager->get_setting( 'kyamera_enable_footer_text' )->value();
}



/**
 * Selective refresh.
 */

/**
 * Selective refresh for introduction title.
 */
function kyamera_introduction_partial_title() {
	return esc_html( get_theme_mod( 'kyamera_introduction_title' ) );
}

/**
 * Selective refresh for introduction sub title.
 */
function kyamera_introduction_partial_sub_title() {
	return esc_html( get_theme_mod( 'kyamera_introduction_sub_title' ) );
}

/**
 * Selective refresh for introduction content.
 */
function kyamera_introduction_partial_content() {
	return wp_kses_post( get_theme_mod( 'kyamera_introduction_content' ) );
}

/**
 * Selective refresh for introduction btn text.
 */
function kyamera_introduction_partial_btn_txt() {
	return esc_html( get_theme_mod( 'kyamera_introduction_btn_txt' ) );
}

/**
 * Selective refresh for products title.
 */
function kyamera_products_partial_title() {
	return esc_html( get_theme_mod( 'kyamera_products_title' ) );
}

/**
 * Selective refresh for products btn text.
 */
function kyamera_products_partial_sub_title() {
	return esc_html( get_theme_mod( 'kyamera_products_sub_title' ) );
}

/**
 * Selective refresh for about title.
 */
function kyamera_about_partial_title() {
	return esc_html( get_theme_mod( 'kyamera_about_title' ) );
}

/**
 * Selective refresh for about sub title.
 */
function kyamera_about_partial_sub_title() {
	return esc_html( get_theme_mod( 'kyamera_about_sub_title' ) );
}

/**
 * Selective refresh for about content.
 */
function kyamera_about_partial_content() {
	return wp_kses_post( get_theme_mod( 'kyamera_about_content' ) );
}

/**
 * Selective refresh for about btn text.
 */
function kyamera_about_partial_btn_txt() {
	return esc_html( get_theme_mod( 'kyamera_about_btn_txt' ) );
}

/**
 * Selective refresh for features title.
 */
function kyamera_features_partial_section_title() {
	return esc_html( get_theme_mod( 'kyamera_features_section_title' ) );
}

/**
 * Selective refresh for features btn text.
 */
function kyamera_features_partial_btn_txt() {
	return esc_html( get_theme_mod( 'kyamera_features_btn_txt' ) );
}

/**
 * Selective refresh for gallery title.
 */
function kyamera_gallery_partial_section_title() {
	return esc_html( get_theme_mod( 'kyamera_gallery_section_title' ) );
}

/**
 * Selective refresh for blog section title.
 */
function kyamera_blog_section_partial_title() {
	return esc_html( get_theme_mod( 'kyamera_blog_section_title' ) );
}

/**
 * Selective refresh for blog section text.
 */
function kyamera_blog_section_partial_sub_title() {
	return esc_html( get_theme_mod( 'kyamera_blog_section_sub_title' ) );
}

/**
 * Selective refresh for footer copyright.
 */
function kyamera_copyright_partial() {
	return wp_kses_post( get_theme_mod( 'kyamera_copyright_txt' ) );
}

/**
 * Selective refresh for your latest posts title.
 */
function kyamera_your_latest_posts_partial_title() {
	return esc_html( get_theme_mod( 'kyamera_your_latest_posts_title' ) );
}

/**
 * Selective refresh for partner title.
 */
function kyamera_partner_partial_title() {
	return esc_html( get_theme_mod( 'kyamera_partner_title' ) );
}