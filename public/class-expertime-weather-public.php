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


	// following string must be provided in the plugin option panel
	private $google_api_key = '';


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
		
		 // check if native wp-block-library css grid is loaded
		if ( current_theme_supports( 'wp-block-styles' ) ) {
			wp_enqueue_style( 'wp-block-library' );
			wp_enqueue_style( 'wp-block-library-theme' );
		}
		else {
			/**
			 * we use a lightweight css grid (2Ko)
			 * @link https://simplegrid.io
			 */
			wp_enqueue_style( 'simple-grid', plugin_dir_url( __FILE__ ) . 'css/simple-grid.css', array(), $this->version, 'all' );
		}

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

		$options = get_option( 'expertime_weather_options' );

		// Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
		
		$google_api_key = $this->google_api_key; // default one

		if( isset( $options['google_api_key'] ) ) {
			$google_api_key = $options['google_api_key'];
		} // end if

		wp_enqueue_script('googlemaps', 'https://maps.googleapis.com/maps/api/js?libraries=places&key='.$google_api_key, array(), '', false);
	}



	/**
	 * Create the rendering page for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function etw_create_expertime_weather_page() {

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
	public function etw_get_expertime_weather_template($content) {

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

		if ( is_page( 'my-weather' ) ) {
			$plugin_template_loader = new Expertime_Weather_Template_Loader;
			$plugin_template_loader->get_template_part( 'my-weather' );
		}

		return $content;
	}


	/**
	 * Be sure ‘Access-Control-Allow-Origin’ header is present on front end
	 * for https:// protocol json api access
	 *
	 * @since    1.0.0
	 */
	
	public function etw_add_cors_http_header(){
		header("Access-Control-Allow-Origin: *");
	}
	
	
	/**
	 * Render the right search query for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */

	
	static $search = '';
	
	public static function etw_search_query($search) {

		/**
		 * This function returns the search adress query value in template
		 * tpl: myweather.php
		 */

		if ( is_page( 'my-weather' ) ) {
			// default placeholder
			$search = esc_attr_x( 'Enter an adress...', 'expertime-weather' );
		}

		//return self::$search;
		return $search;
	}


	/**
	 * Render the search results for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */

	
	static $result = '';
	
	public static function etw_search_results($result = array()) {

		/**
		 * This function returns the search adress query value in template
		 * tpl: myweather.php
		 */

		if ( is_page( 'my-weather' ) ) {
			
			$options = get_option( 'expertime_weather_options' );

			// Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
			$end_point_url = ''; 
			if( isset( $options['input_api_endpoint'] ) ) {
				$end_point_url = $options['input_api_endpoint'];
				// remove the slash if available at the end of url and add it again to avoid issue
				$end_point_url = rtrim($end_point_url,"/").'/';
			}
			else {
				error_log('error: no end point url set in plugin settings.');
				return;
			}
			
			if ( isset($_GET['lat']) && isset($_GET['lng']) ) {
				
				if ( empty($_GET['lat']) OR empty($_GET['lng']) ) {
					error_log('error: lat or long values are empty in url GET parameters.');
					return;
				}
			
				// eg. https://www.prevision-meteo.ch/services/json/lat=48.7405305lng=7.3648099
	
				$json_url = $end_point_url . 'lat=' . $_GET["lat"] . 'lng=' . $_GET["lng"]; 

				// first let's check if the json file is not allready in the cache

				// create the unique filename based on coordinates 
				$json_filename = $_GET["lat"] . $_GET["lng"];
				$json_filename = str_replace(".", "", $json_filename);
				$json_filename = str_replace("-", "", $json_filename);

				/**
				 * For better performance with the API (and testing purpose)
				 * We want to use the same weather json data during one hour 
				 * add today's date to keep a daily record for a given lat+lng position
				 * example: 2020041920 for 2020/04/19 at 20h (8pm)
				 *  
				 */ 

				// use WP timestamp date to be sure we don't get the local server time
				//$current_date = get_the_date( 'YmdH' );
				$current_date = date_i18n('YmdH', current_time('timestamp'));
				//error_log($date);

				if (!empty($current_date)) {
					// filename based on current day and hour time combined for caching purpose
					$json_filename = $current_date . '-' . $json_filename;
				}

				$json_cache_dir = plugin_dir_path( dirname( __FILE__ ) ) . 'public/cache';
				$json_cache_file = $json_cache_dir . "/" . $json_filename . ".json";
				
				if (file_exists($json_cache_file)) {
					$file_content = file_get_contents($json_cache_file);
					$api_response = json_decode($file_content, true);
					error_log("Using json cache file");
				}
				else {
					// create a new api query and save the corresponding cache file
					$file_content = file_get_contents($json_url,0,null,null);  
					$api_response = json_decode($file_content, true);
					$json = json_encode($api_response, JSON_PRETTY_PRINT);
					//error_log($json);
					file_put_contents($json_cache_file, $json);
					error_log("new json cache file created for expertime weather.");
				}

				// return results as an array

				$result = $api_response;
				//print_r($result);
				//$city_name =  $result['city_info']['name'];
			}
			
		}

		//return self::$result;
		return $result;
	}
	
}

/**
 * Use static class methods in plugins 
 * to make method from plugin available in theme
 * 
 */

if ( ! function_exists( 'get_expertime_weather_search_query' ) ) {

    function get_expertime_weather_search_query($search = '') {
       return Expertime_Weather_Public::etw_search_query($search);
	}
	
}

if ( ! function_exists( 'get_expertime_weather_search_results' ) ) {

    function get_expertime_weather_search_results($result = array()) {
       return Expertime_Weather_Public::etw_search_results($result);
	}
	
}
