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
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="expertime-weather-container">
    
    <div class="wp-block-columns alignwide has-2-columns">
    
        <div class="wp-block-column">
            <figure class="wp-block-image">
                <!--  some responsive image here -->
            </figure>

            <h3>Ma météo</h3>

            <p>
            <a class="btn button" id="expertime-weather-geolocation-btn">Utiliser ma position actuelle</a>
            </p>

        </div>

        <div class="wp-block-column">

            <h3>Entrer une adresse</h3>

            <form role="search-adress" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                
                <label for="search-adress-form">
                    <span class="screen-reader-text">Entrer une adresse&nbsp;:</span>
                    <input type="search" id="expertime-weather-search-adress" class="search-field" placeholder="<?php echo get_expertime_weather_search_query(); ?>" value="" name="s-adress">
                </label>

                <input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'expertime-weather' ); ?>">

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
        </div>

    </div>

    <div class="wp-block-columns alignwide has-1-columns">
    
        <div class="wp-block-column">
            <div id="expertime-weather-results" style="padding:30px 0;">
            
            <?php 
            echo get_expertime_weather_search_results();
            ?>
            
            </div>
        </div>

    </div>

</div>