<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://github.com/pierre-dickinson
 * @since      1.0.0
 *
 * @package    Expertime_Weather
 * @subpackage Expertime_Weather/public/partials
 */

 /**
  * Layout Grid system is Gutemberg compatible
 *  if not in use in the active theme, we use a lightweight css grid (2Ko)
 *  You can edit the grid in css/simple-grid.css
 *  @link https://simplegrid.io
 */

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="expertime-weather-container container">
    
    <div class="wp-block-columns alignwide has-2-columns row">
    
        <div class="wp-block-column col-12-sm col-6">
            <figure class="wp-block-image">
                <!--  some responsive image here -->
            </figure>

            <h3>Ma météo</h3>

            <p>
            <a class="btn button" id="expertime-weather-geolocation-btn">Utiliser ma position actuelle</a>
            </p>

        </div>

        <div class="wp-block-column col-12-sm col-6">

        <?php
        /**
         * Check if a Google Maps API key is set in plugins settings
         * we need to make sure the element is defined in the options. 
         * If not, we'll not display the autocomplete search form
         */
        $options = get_option( 'expertime_weather_options' );
        ?>

		<?php if( !isset( $options['google_api_key'] ) ): ?>
            
            <?php if( current_user_can('editor') || current_user_can('administrator') ): ?>
            <p>
                Veuillez renseigner votre clé d'api Google Maps pour activer la recherche d'adresse par saisie.
                <br><a href="<?php echo get_admin_url() . 'admin.php?page=expertime-weather-settings-config'; ?>">Ajouter ma clé d'api Google Maps</a>
            </p>
            <?php endif; ?>
        
        <?php else: ?>

            <h3>Entrer une adresse</h3>

            <form role="search-adress" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                
                <label for="search-adress-form">
                    <span class="screen-reader-text">Entrer une adresse&nbsp;:</span>
                    <input type="search" id="expertime-weather-search-adress" class="search-field" placeholder="<?php echo get_expertime_weather_search_query(); ?>" value="" name="s-adress">
                </label>

                <input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Rechercher', 'expertime-weather' ); ?>">

                <div>
                    <label>
                    <span class="screen-reader-text">street_number&nbsp;:</span>
                    <input type="hidden" id="street_number" name="street_number" class="search-field">
                    </label>
                
                    <label>
                    <span class="screen-reader-text">route&nbsp;:</span>
                    <input type="hidden" id="route" name="route">
                    </label>
                    
                    <label>
                    <span class="screen-reader-text">locality&nbsp;:</span>
                    <input type="hidden" id="locality" name="locality">
                    </label>
                    
                    <label>
                    <span class="screen-reader-text">country&nbsp;:</span>
                    <input type="hidden" id="country" name="country">
                    </label>

                    <label>
                    <span class="screen-reader-text">latitude&nbsp;:</span>
                    <input type="hidden" id="latitude" name="latitude">
                    </label>

                    <label>
                    <span class="screen-reader-text">longitude&nbsp;:</span>
                    <input type="hidden" id="longitude" name="longitude">
                    </label>
                </div>
            </form>

        <?php endif; ?>

        </div>
    </div>

    <div class="wp-block-columns alignwide has-1-columns row">
    
        <div class="wp-block-column col-12">
            
            <?php 
            // get json data as an array
            $weather_data = get_expertime_weather_search_results();
            ?>
           
            <div id="expertime-weather-results">

            <?php if (!empty($weather_data)): ?>
            <!-- start current condition section -->
               
                <div class="wp-block-columns alignwide has-1-columns row" id="current-condition">
                    
                    <div class="wp-block-column col-12 col-6-sm">
                        <h4> <?php _e( "Aujourd'hui", 'expertime-weather' ); ?>, <?php echo $weather_data['current_condition']['date']; ?></h4>
                        <p>
                          Lever du soleil : <?php echo $weather_data['city_info']['sunrise']; ?>
                          - Coucher du soleil : <?php echo $weather_data['city_info']['sunset']; ?>
                        </p>
                    </div>

                    <div class="wp-block-column col-12 col-6-sm">
                        <h5><?php _e( "Conditions à ", 'expertime-weather' ); ?> <?php echo $weather_data['current_condition']['hour']; ?></h5>
                        <p class="weather-current-condition">
                            <img class="weather-condition-pict" src="<?php echo $weather_data['current_condition']['icon_big']; ?>" alt="<?php echo $weather_data['current_condition']['condition_key']; ?>">
                            <strong><?php echo $weather_data['current_condition']['condition']; ?></strong>
                        </p>
                    </div>

                </div>
                <div class="wp-block-columns alignwide has-1-columns row" id="current-condition">

                    <div class="wp-block-column col-12 col-12-sm">
                        <ul>
                            <li><?php _e( "Température actuelle", 'expertime-weather' ); ?> : <?php echo $weather_data['current_condition']['tmp']; ?></li>
                            <li><?php _e( "Vitesse du vent", 'expertime-weather' ); ?> : <?php echo $weather_data['current_condition']['wnd_spd']; ?> k/h</li>
                            <li><?php _e( "Direction du vent", 'expertime-weather' ); ?> : <?php echo $weather_data['current_condition']['wnd_dir']; ?></li>
                            <li><?php _e( "Pression atmosphérique", 'expertime-weather' ); ?> : <?php echo $weather_data['current_condition']['pressure']; ?> k/h</li>
                            <li><?php _e( "Humidité", 'expertime-weather' ); ?> : <?php echo $weather_data['current_condition']['humidity']; ?> &#37;</li>
                        </ul>
                    </div>

                </div>

                <div class="wp-block-columns alignwide has-1-columns row" style="padding-top:30px;">
                    <div class="wp-block-column col-3 col-12-sm">
                        <h5><?php echo $weather_data['fcst_day_0']['day_long']; ?></h5> 
                        <ul class="weather-day-bloc">
                            <li>
                                <img class="weather-condition-pict" src="<?php echo $weather_data['fcst_day_0']['icon_big']; ?>" alt="<?php echo $weather_data['current_condition']['condition_key']; ?>">
                                <small>Min. <?php echo $weather_data['fcst_day_0']['tmin']; ?> &deg;<br>Max.  <?php echo $weather_data['fcst_day_0']['tmax']; ?> &deg;</small>
                            </li>
                            <li><span class="font-heavy"><?php echo $weather_data['fcst_day_0']['condition_key']; ?></span></li>
                        </ul>
                    </div>
                    <div class="wp-block-column col-3 col-12-sm">
                        <h5>Mercerdi</h5>
                    </div>
                    <div class="wp-block-column col-3 col-12-sm">
                        <h5>jeu</h5>
                    </div>
                    <div class="wp-block-column col-3 col-12-sm">
                        <h5>ven</h5>
                    </div>
                </div>

                </div>

            <!-- end section current condition -->
            <?php else: ?>
                <div class="wp-block-columns alignwide has-1-columns row" id="no-weather-data">
                    <div class="wp-block-column col-12">
                    <p><?php _e( "Veuillez indiquer une localité pour afficher la météo correspondante.", 'expertime-weather' ); ?></p>
                    </div>
                </div>
            <?php endif; ?>
            </div>
            
        </div>

    </div>

</div>