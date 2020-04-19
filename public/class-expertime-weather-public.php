<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/pierre-dickinson
 * @since      1.0.0
 *
 * @package    Expertime_Weather
 * @subpackage Expertime_Weather/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Expertime_Weather
 * @subpackage Expertime_Weather/public
 * @author     Pierre Dickinson <pierre.dickinson@gmail.com>
 */
class Expertime_Weather_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}	

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/expertime-weather-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/expertime-weather-public.js', array( 'jquery' ), $this->version, false );
		
	}


	/**
	 * Create the rendering page for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function create_expertime_weather_page() {

		$page_slug = 'my-weather';

		$page = get_page_by_path( $page_slug , OBJECT );

		if ( isset($page) ) {
			return;
		}

		// Gather post data.
		$new_page = array(
			'post_title'    => 'My Weather',
			'post_name'    => $page_slug,
			'post_content'  => '',
			'post_status'   => 'publish',
			'post_type'    => 'page',
			'post_author'   => get_current_user_id()
		);
 
		// Insert the post into the database.
		$page_id = wp_insert_post( $new_page, $wp_error );

		if(empty($page_id)) {
			error_log("Expertime Weather plugin -> error during 'my-weather' page creation.");
		}
		
	}

	/**
	 * Render the right template for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function get_expertime_weather_template($content) {

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
		$plugin_template_loader = new Expertime_Weather_Template_Loader;

		if ( is_page( 'my-weather' ) ) {
        	$content .= $plugin_template_loader->get_template_part( 'my-weather' );
		}
		return $content;
		
	}
	

}
