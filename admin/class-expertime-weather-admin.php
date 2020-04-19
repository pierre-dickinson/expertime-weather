<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/pierre-dickinson
 * @since      1.0.0
 *
 * @package    Expertime_Weather
 * @subpackage Expertime_Weather/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Expertime_Weather
 * @subpackage Expertime_Weather/admin
 * @author     Pierre Dickinson <pierre.dickinson@gmail.com>
 */
class Expertime_Weather_Admin {

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
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Expertime_Weather_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Expertime_Weather_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/expertime-weather-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Expertime_Weather_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Expertime_Weather_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/expertime-weather-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function register_expertime_weather_menu_page() {

		$expertime_weather_template_loader = new Expertime_Weather_Template_Loader;
		//$expertime_weather_template_loader->get_template_part( 'my-weather' );

		// add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
		add_menu_page( 
			__( 'Weather', 'expertime-weather' ),
			__( 'Weather', 'expertime-weather' ),
			'manage_options', 
			'expertime-weather', 
			get_template_part( 'my-weather' ),
			'dashicons-cloud',
			50
		);

		add_submenu_page( 'expertime-weather', 'Configuration', 'Configuration', 'manage_options', 'expertime-weather');
	}

}
