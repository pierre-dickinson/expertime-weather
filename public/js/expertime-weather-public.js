(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source reside in this file.
	 *
	 * define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 *
	 */
	
	$(function() {

		var loadingModal = $("#loading-modal");
		var modal_bg = $("#loading-modal .modal__bg");
		var modal_close = $("#loading-modal .modal__close");
		
		/**
		 * Google Maps API call for autocomplete adress search form
		 * actual google api key is set in admin setting panel
		 * Input text adress with autocomplete
		*/
		function initializeAutocomplete(id) {
			var element = document.getElementById(id);
			if (element) {
			  var autocomplete = new google.maps.places.Autocomplete(element, { types: ['geocode'] });
			  google.maps.event.addListener(autocomplete, 'place_changed', onPlaceChanged);
			}
		  }
		  
		  function onPlaceChanged() {
			var place = this.getPlace();
		  
			// console.log(place);  // Uncomment this line to view the full object returned by Google API.
		  
			for (var i in place.address_components) {
			  var component = place.address_components[i];
			  for (var j in component.types) {  // Some types are ["country", "political"]
				var type_element = document.getElementById(component.types[j]);
				if (type_element) {
				  type_element.value = component.long_name;
				}
			  }
			}

			var latitude = place.geometry.location.lat();
			var longitude = place.geometry.location.lng();

			var type_element_latitude  = document.getElementById('latitude');
			var type_element_longitude = document.getElementById('longitude');
			
			type_element_latitude.value  = latitude;
			type_element_longitude.value = longitude;

			//console.log(latitude);
			//console.log(longitude);

			loadingModal.addClass( "show" );

			// refresh results section
			$( "#expertime-weather-results" ).empty();
			$( "html, body" ).animate({ scrollTop: $( "#expertime-weather-results" ).scrollTop() }, 1000);
			
			// remove get parameters from url
			var uri = window.location.toString();
			if (uri.indexOf("?") > 0) {
				var clean_uri = uri.substring(0, uri.indexOf("?"));
				window.history.replaceState({}, document.title, clean_uri);
			}

			var url = document.location.href+"?lat="+latitude+"&lng="+longitude;
			// update the url with the new get parameters
			document.location = url;

		  }
		  
		  google.maps.event.addDomListener(window, 'load', function() {
			initializeAutocomplete('expertime-weather-search-adress');
		  });
		  
		  /**
		  *  Geolocation button
		  */

		//var btn_geolocate = document.getElementById('expertime-weather-geolocation-btn');
		var btn_geolocate = $("#expertime-weather-geolocation-btn");
		
		// user geolocation
		btn_geolocate.click(function() {

			// first check for Geolocation support
			if (!navigator.geolocation) {
				console.log('Geolocation is not supported for this Browser/OS.');
			}
			else {

				var startPos;
				var latitude;
				var longitude;

				loadingModal.addClass( "show" );

				var geoSuccess = function(position) {
					
					startPos = position;

					latitude = startPos.coords.latitude;
					longitude = startPos.coords.longitude;

					console.log('Geolocation startLat is: ' + latitude );
					console.log('Geolocation startLng is: ' + longitude );

					// refresh results section
					$( "#expertime-weather-results" ).empty();
					$( "html, body" ).animate({ scrollTop: $( "#expertime-weather-results" ).scrollTop() }, 1000);

					// remove get parameters from url
					var uri = window.location.toString();
					if (uri.indexOf("?") > 0) {
						var clean_uri = uri.substring(0, uri.indexOf("?"));
						window.history.replaceState({}, document.title, clean_uri);
					}

					var url = document.location.href+"?lat="+latitude+"&lng="+longitude;
					// update the url with the new get parameters
					document.location = url;
					
				};

				navigator.geolocation.getCurrentPosition(geoSuccess);
				
			}
			
		});


		/**
		  *  Loading Modal
		  */

		modal_bg.click(function() {
			loadingModal.removeClass( "show" );
		});
		modal_close.click(function() {
			loadingModal.removeClass( "show" );
		});

	});
	

})( jQuery );
