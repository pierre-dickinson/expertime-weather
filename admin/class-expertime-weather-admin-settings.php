<?php

/**
 * The settings of the plugin.
 *
 * @link       https://github.com/pierre-dickinson
 * @since      1.0.0
 *
 * @package    Expertime_Weather
 * @subpackage Expertime_Weather/admin
 */


/**
 * Class WordPress_Plugin_Template_Settings
 *
 */
class Expertime_Weather_Admin_Settings {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * This function introduces the theme options into the 'Appearance' menu and into a top-level
	 * 'WPPB Demo' menu.
	 */
	public function setup_plugin_options_menu() {

        //Add the menu to the main admin nav menu set of menu items
        
		add_menu_page(
			__( 'Weather', 'expertime-weather' ), 					// The title to be displayed in the browser window for this page.
			__( 'Weather', 'expertime-weather' ),					// The text to be displayed for this menu item
			'manage_options',					// Which type of users can see this menu item
			'expertime-weather-settings',			// The unique ID - that is, the slug - for this menu item
            array( $this, 'render_settings_page_content'),		// The name of the function to call when rendering this menu's page
            'dashicons-cloud',
			30
        );
        
        add_submenu_page( 
            'expertime-weather-settings', 
            __( 'Configuration', 'expertime-weather' ),
            __( 'Configuration', 'expertime-weather' ),
            'manage_options', 
            'expertime-weather-settings-config',
            array( $this, 'render_settings_page_content')
        );
        
        // plugin must display a "Weather" menu in the WordPress back office. 
        // It must also have a submenu item/page named "Configuration" pointing to the same
        remove_submenu_page( 'expertime-weather-settings', 'expertime-weather-settings' );
        
	}

	/**
	 * Provides default values for the Display Options.
	 *
	 * @return array
	 */
	public function default_display_options() {

		$defaults = array(
			'input_api_endpoint'		=>	'',
		);

		return $defaults;

	}


	/**
	 * Provides default values for the Input Options.
	 *
	 * @return array
	 */
	public function default_input_options() {

		$defaults = array(
			'input_api_endpoint'		=>	''  // ex. https://www.prevision-meteo.ch/services/json
			//'another_input'	=>	'',
		);

		return $defaults;

	}

	/**
	 * Renders a simple page to display for the theme menu defined above.
	 */
	public function render_settings_page_content() {
		?>
		<!-- Create a header in the default WordPress 'wrap' container -->
		<div class="wrap">

			<h2><?php _e( 'Configuration de l\'api', 'expertime-weather' ); ?></h2>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
				settings_fields( 'expertime_weather_options' );
				do_settings_sections( 'expertime_weather_options' );

                submit_button();
                
				?>
			</form>

		</div><!-- /.wrap -->
	<?php
	}


	/**
	 * This function provides a simple description for the General Configuration page.
	 *
	 * It's called from the 'expertime_weather_initialize_theme_options' function by being passed as a parameter
	 * in the add_settings_section function.
	 */
	public function general_options_callback() {
		$options = get_option('expertime_weather_configuration_options');
		var_dump($options);
		echo '<p>' . __( 'Edit your weather api configuration.', 'expertime-weather' ) . '</p>';
	} // end general_options_callback

	
	/**
	 * This function provides a simple description for the Input Examples page.
	 *
	 * It's called from the 'expertime_weather_theme_initialize_input_api_configuration_options' function by being passed as a parameter
	 * in the add_settings_section function.
	 */
	public function input_configuration_api_callback() {
        
        $options = get_option('expertime_weather_options');
        
        // display options values recorded in db
        //var_dump($options);
        
		echo '<p>' . __( 'For instance: https://www.prevision-meteo.ch/services/json/lat=47.2173lng=-1.5534', 'expertime-weather' ) . '</p>';
	} // end general_options_callback

	/**
	 * This function provides a simple description for the Input Google API Key section.
	 *
	 * It's called from the 'expertime_weather_theme_initialize_input_api_configuration_options' function by being passed as a parameter
	 * in the add_settings_section function.
	 */
	public function input_configuration_google_api_callback() {
        
        $options = get_option('expertime_weather_options');
        
        // display options values recorded in db
        //var_dump($options);
        
		echo '<p>' . __( 'In order to get requests to the Google Maps API, you need to create a new project under the Google API Console.', 'expertime-weather' ) . '</p>';
		echo '<p>' . __( 'For this project, enable the Google Maps Javascript API v3 here : <a target="_blank" href="https://console.cloud.google.com/google/maps-apis/overview">get your Google API key for free here</a>', 'expertime-weather' ) . '</p>';
	} // end general_options_callback


	/**
	 * Initializes the theme's display options page by registering the Sections,
	 * Fields, and Settings.
	 *
	 * This function is registered with the 'admin_init' hook.
	 */
	public function initialize_display_options() {

		// If the theme options don't exist, create them.
		if( false == get_option( 'expertime_weather_configuration_options' ) ) {
			$default_array = $this->default_display_options();
			add_option( 'expertime_weather_configuration_options', $default_array );
		}

		add_settings_section(
			'general_settings_section',			            // ID used to identify this section and with which to register options
			__( 'Configuration', 'expertime-weather' ),		        // Title to be displayed on the administration page
			array( $this, 'general_options_callback'),	    // Callback used to render the description of the section
			'expertime_weather_configuration_options'		                // Page on which to add this section of options
		);

		// Finally, we register the fields with WordPress
		register_setting(
			'expertime_weather_configuration_options',
			'expertime_weather_configuration_options'
		);

	} // end expertime_weather_initialize_theme_options


	/**
	 * Initializes the theme's input example by registering the Sections,
	 * Fields, and Settings. This particular group of options is used to demonstration
	 * validation and sanitization.
	 *
	 * This function is registered with the 'admin_init' hook.
	 */
	public function initialize_input_api_configuration_options() {
		//delete_option('expertime_weather_options');
		if( false == get_option( 'expertime_weather_options' ) ) {
			$default_array = $this->default_input_options();
			update_option( 'expertime_weather_options', $default_array );
		} // end if

		add_settings_section(
			'input_api_configuration_section',
			 __( 'Configurez ici votre accès à l\'api météo', 'expertime-weather' ),
			array( $this, 'input_configuration_api_callback'),
			'expertime_weather_options'
		);

		add_settings_field(
			'Input Element',
			__( 'End point', 'expertime-weather' ),
			array( $this, 'input_element_callback'),
			'expertime_weather_options',
			'input_api_configuration_section'
		);

		add_settings_section(
			'input_google_api_configuration_section',
			 __( 'Configurez ici votre accès à l\'api Google Maps', 'expertime-weather' ),
			array( $this, 'input_configuration_google_api_callback'),
			'expertime_weather_options'
		);

		add_settings_field(
			'Input Element',
			__( 'Google API key', 'expertime-weather' ),
			array( $this, 'google_api_key_callback'),
			'expertime_weather_options',
			'input_google_api_configuration_section'
		);

		register_setting(
			'expertime_weather_options',
			'expertime_weather_options',
			array( $this, 'validate_input_api_configuration_options')
		);

	}

	
	public function input_element_callback() {

        $api_url = '';

		$options = get_option( 'expertime_weather_options' );

        if( isset( $options['input_api_endpoint'] ) ) {
			$api_url = esc_url( $options['input_api_endpoint'] );
		} // end if

		// Render the output
		echo '<input type="text" id="input_api_endpoint" size="70" name="expertime_weather_options[input_api_endpoint]" value="' . $api_url . '" />';

	} // end input_element_callback


	public function google_api_key_callback() {

		// First, we read the social options collection
		$options = get_option( 'expertime_weather_options' );

		// Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
		$google_api_key = '';
		if( isset( $options['google_api_key'] ) ) {
			$google_api_key = $options['google_api_key'];
		} // end if

		// Render the output
		echo '<input type="text" id="google_api_key" size="70" name="expertime_weather_options[google_api_key]" value="' . $google_api_key . '" />';

	} // end google_callback
	

	/**
	 * Sanitization callback for the options. Since each of the options are text inputs,
	 * this function loops through the incoming option and strips all tags and slashes from the value
	 * before serializing it.
	 *
	 * @params	$input	The unsanitized collection of options.
	 *
	 * @returns			The collection of sanitized values.
	 */
	public function sanitize_input_api_endpoint( $input ) {

		// Define the array for the updated options
		$output = array();

		// Loop through each of the options sanitizing the data
		foreach( $input as $key => $val ) {

			if( isset ( $input[$key] ) ) {
				$output[$key] = esc_url_raw( strip_tags( stripslashes( $input[$key] ) ) );
			} // end if

		} // end foreach

		// Return the new collection
		return apply_filters( 'sanitize_input_api_endpoint', $output, $input );

	} // end sanitize_input_api_endpoint

	public function validate_input_api_configuration_options( $input ) {

		// Create our array for storing the validated options
		$output = array();

		// Loop through each of the incoming options
		foreach( $input as $key => $value ) {

			// Check to see if the current option has a value. If so, process it.
			if( isset( $input[$key] ) ) {

				// Strip all HTML and PHP tags and properly handle quoted strings
				$output[$key] = strip_tags( stripslashes( $input[ $key ] ) );

			} // end if

		} // end foreach

		// Return the array processing any additional functions filtered by this action
		return apply_filters( 'validate_input_api_configuration_options', $output, $input );

	} // end validate_input_api_configuration_options


}