<?php require 'config.php'; ?>
var directionsService = new google.maps.DirectionsService();
var map;
var service;
var markers = [];
var placesMarkers = [];
var currentProperty = null;

function initialize() {
	var mapCenter = new google.maps.LatLng(<?php echo GOOGLE_MAP_CENTER; ?>);
	directionsDisplay = new google.maps.DirectionsRenderer();
	var mapOptions = {
		zoom: 14,
		center: mapCenter,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
	directionsDisplay.setMap(map);
	directionsDisplay.setPanel(document.getElementById('directions-panel'));
	var transitLayer = new google.maps.TransitLayer();
	transitLayer.setMap(map);

	google.maps.event.addListener(map, 'center_changed', function() {
		service = new google.maps.places.PlacesService(map);
		service.nearbySearch({
			location: map.getCenter(),
			radius: 500,
			types: ['grocery_or_supermarket', 'pharmacy', 'bar']
		}, callback);
	});
}

function callback(results, status) {
	for (var i = 0; i < placesMarkers.length; i++) {
		placesMarkers[i].setMap(null);
	}
	if (status == google.maps.places.PlacesServiceStatus.OK) {
		for (var i = 0; i < results.length; i++) {
			createMarker(results[i]);
		}
	}
}

function createMarker(place, type) {
	var markerIcon = null;
	if ($.inArray("grocery_or_supermarket", place.types) >= 0 ||  $.inArray("food", place.types) >= 0) {
		markerIcon = 'icons/supermarket.png';
	} else if ($.inArray("pharmacy", place.types) >= 0) {
		markerIcon = 'icons/drugstore.png';
	} else if ($.inArray("bar", place.types) >= 0) {
		markerIcon = 'icons/bar.png';
	}
	var marker = new google.maps.Marker({
		map: map,
		position: place.geometry.location,
		title: place.name,
		icon: markerIcon
	});
	placesMarkers.push(marker);
}

function setTransitRoute(lat, lng) {
	var d = new Date();
	d.setDate(d.getDate() + (7 + 1 - d.getDay()) % 7);
	var request = {
		origin: lat + "," + lng,
		destination: "<?php echo GOOGLE_MAP_TRANSIT_DEST; ?>",
		travelMode: google.maps.TravelMode.TRANSIT,
		transitOptions: {
			arrivalTime: d
		}
	};
	directionsService.route(request, function(result, status) {
		if (status == google.maps.DirectionsStatus.OK) {
			directionsDisplay.setDirections(result);
		}
	});
}

function toggleCategory(category) {
	for (var i = 0; i < markers.length; ++i) {
		if (markers[i].category == category) {
			if (markers[i].visible == true) {
				markers[i].setVisible(false)
			} else {
				markers[i].setVisible(true);
			}
		}
	}
}

google.maps.event.addDomListener(window, 'load', initialize);



$(document).ready(function() {

	$.get('api.php', function(data) {
		var properties = eval(data);

		$.each(properties, function(i, property) {

			var marker = new google.maps.Marker({
				position: new google.maps.LatLng(property.coordinates[0], property.coordinates[1]),
				map: map,
				title: property.description + '<br /><a target="_blank" href="' + property.url + '">Link</a>',
				icon: property.icon
			});

			if ( property.starred ) {
				marker.category = "starred";
			} else {
				marker.category = property.rent_level;
			}

			marker.hash = property.hash;
			marker.url = property.url;

			markers.push(marker);

			google.maps.event.addListener(marker, 'click', function() {
				setTransitRoute(marker.getPosition().lat(), marker.getPosition().lng());
				$('#information-panel').empty();
				$('#information-panel').append(marker.title);
				currentProperty = marker;
			});
		});

	});

	$.each(["low", "medium", "high", "starred"], function(index, item) {
		$("#btn_" + item).click(function() {
			toggleCategory(item);
		});
	});

	$('#btn_hide').click(function() {
		if (currentProperty != null) {
			currentProperty.setMap(null);
			var request = $.ajax({
				url: "db.php",
				type: "POST",
				data: {
					id: currentProperty.hash,
					url: currentProperty.url,
					reason: $('#hide_reason').val(),
					hide: true
				},
				dataType: "html"
			});
		}
	});
	
	$('#btn_favorite').click(function() {
		if (currentProperty != null) {
			var request = $.ajax({
				url: "db.php",
				type: "POST",
				data: {
					id: currentProperty.hash,
					url: currentProperty.url,
					reason: $('#hide_reason').val(),
					favorite: true
				},
				dataType: "html"
			});
			currentProperty.icon = currentProperty.icon.replace("home", "star");
			currentProperty.setMap(null);
			currentProperty.setMap(map);
			currentProperty.category = "starred";
		}
	});

});
