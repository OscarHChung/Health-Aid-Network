var map;
function initMap() {

	var locations = [
    	['Los Angeles', 34.052235, -118.243683],
    	['Santa Monica', 34.024212, -118.496475],
    	['Redondo Beach', 33.849182, -118.388405],
    	['Newport Beach', 33.628342, -117.927933],
    	['Long Beach', 33.770050, -118.193739]
  	];

	map = new google.maps.Map(document.getElementById('map'), {
		zoom: 2,
		center: new google.maps.LatLng(30, 0)
	});

	infowindow =  new google.maps.InfoWindow({
	});
	var marker, count;
	for (count = 0; count < locations.length; count++) {
    	marker = new google.maps.Marker({
      		position: new google.maps.LatLng(locations[count][1], locations[count][2]),
      		map: map,
      		title: locations[count][0]
    	});
		google.maps.event.addListener(marker, 'click', (function (marker, count) {
      		return function () {
        	infowindow.setContent(locations[count][0]);
        	infowindow.open(map, marker);
    		}
    	})(marker, count));
  	}

  	google.maps.event.addDomListener(document.getElementById('closest-location'), 'click', function () {
  		if (navigator.geolocation) {
          	navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };

            map.panTo(pos);
			smoothZoom(map, 8, map.getZoom());
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          handleLocationError(false, infoWindow, map.getCenter());
        }
	});
}

function smoothZoom (map, max, cnt) {
    if (cnt >= max) {
        return;
    }
    else {
        z = google.maps.event.addListener(map, 'zoom_changed', function(event){
            google.maps.event.removeListener(z);
            smoothZoom(map, max, cnt + 1);
        });
        setTimeout(function(){map.setZoom(cnt)}, 80); // 80ms is what I found to work well on my system -- it might not work well on all systems
    }
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
                          'Error: The Geolocation service failed.' :
                          'Error: Your browser doesn\'t support geolocation.');
    infoWindow.open(map);
}