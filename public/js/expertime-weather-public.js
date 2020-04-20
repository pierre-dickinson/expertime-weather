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
	
	 // actual google api key : AIzaSyCBwn0wn6xypgYc5oCGdpq6tSCRToRdIRY

	$(function() {

		function initializeAutocomplete(id) {
			var element = document.getElementById(id);
			if (element) {
			  var autocomplete = new google.maps.places.Autocomplete(element, { types: ['geocode'] });
			  google.maps.event.addListener(autocomplete, 'place_changed', onPlaceChanged);
			}
		  }
		  
		  function onPlaceChanged() {
			var place = this.getPlace();
		  
			console.log(place);  // Uncomment this line to view the full object returned by Google API.
		  
			for (var i in place.address_components) {
			  var component = place.address_components[i];
			  for (var j in component.types) {  // Some types are ["country", "political"]
				var type_element = document.getElementById(component.types[j]);
				if (type_element) {
				  type_element.value = component.long_name;
				}
			  }
			}
		  }
		  
		  google.maps.event.addDomListener(window, 'load', function() {
			initializeAutocomplete('expertime-weather-search-adress');
		  });

	});

	

})( jQuery );
