<?php

/**
 * Expertime Weather
 *
 * @package    Expertime_Weather
 * @subpackage Expertime_Weather/includes
 * @author     Pierre Dickinson
 */

if ( ! class_exists( 'Gamajo_Template_Loader' ) ) {
    require plugin_dir_path( dirname( __FILE__ ) )  . 'vendor/gamajo/template-loader/class-gamajo-template-loader.php';
  }
  
  /**
   * Template loader for Expertime Weather.
   *
   * Only need to specify class properties here.
   *
   * @package Expertime_Weather
   * @author  Pierre Dickinson
   */
  class Expertime_Weather_Template_Loader extends Gamajo_Template_Loader {
    /**
     * Prefix for filter names.
     *
     * @since 1.0.0
     *
     * @var string
     */
    protected $filter_prefix = 'Expertime_Weather';
  
    /**
     * Directory name where custom templates for this plugin should be found in the theme.
     *
     * @since 1.0.0
     *
     * @var string
     */
    protected $theme_template_directory = 'expertime-weather';
  
    /**
     * Reference to the root directory path of this plugin.
     *
     * Can either be a defined constant, or a relative reference from where the subclass lives.
     *
     * In this case, `EXPERTIME_WEATHER_PLUGIN_DIR` would be defined in the root plugin file as:
     *
     * ~~~
     * define( 'EXPERTIME_WEATHER_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
     * ~~~
     *
     * @since 1.0.0
     *
     * @var string
     */


    protected $plugin_directory = EXPERTIME_WEATHER_PLUGIN_DIR;
  
    /**
     * Directory name where templates are found in this plugin.
     *
     * Can either be a defined constant, or a relative reference from where the subclass lives.
     *
     * e.g. 'templates' or 'includes/templates', etc.
     *
     * @since 1.1.0
     *
     * @var string
     */
    protected $plugin_template_directory = 'templates';
  }