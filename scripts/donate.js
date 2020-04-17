var map,geocoder,description = "",i,num,marker,j;

function haversine_distance(mk1, mk2) {
  var R = 3958.8; // Radius of the Earth in miles
  var rlat1 = mk1.geometry.location.lat() * (Math.PI/180); // Convert degrees to radians
  var rlat2 = mk2.lat * (Math.PI/180); // Convert degrees to radians
  var difflat = rlat2-rlat1; // Radian difference (latitudes)
  var difflon = (mk2.lng-mk1.geometry.location.lng()) * (Math.PI/180); // Radian difference (longitudes)

  var d = 2 * R * Math.asin(Math.sqrt(Math.sin(difflat/2)*Math.sin(difflat/2)+Math.cos(rlat1)*Math.cos(rlat2)*Math.sin(difflon/2)*Math.sin(difflon/2)));
  return d;
}

function initMap() {

  geocoder = new google.maps.Geocoder();
  infowindow =  new google.maps.InfoWindow({
  });
  map = new google.maps.Map(document.getElementById('map'), {
    zoom: 2,
    center: {lat: 30, lng: 0},
    mapTypeControl: false,
    streetViewControl: false
  });

  for(j = 0; j < addresses.length; j++) {
    var address = addresses[j];
    var hnamet = hname[j];
    var blooddrivet = blooddrive[j];
    var glovest = gloves[j];
    var maskst = masks[j];
    var ventilatorst = ventilators[j];
    var othert = other[j];
    var nonlatext = nonlatex[j];
    var foodt = food[j];
    var gownst = gowns[j];
    var capst = caps[j];

    (function(hnamet, blooddrivet, glovest, nonlatext, maskst, ventilatorst, foort, gownst, capst, othert, addresst) {
      geocoder.geocode( {address: address}, function(results, status) {
      if(status == 'OK') {
        marker = new google.maps.Marker({
          position: results[0].geometry.location,
          map: map,
          title: hnamet
        });
        google.maps.event.addListener(marker, 'click', (function (marker) {
        return function () {
          description = "<b>" + hnamet + "</b>:<br> Items Needed: <br>";
          if(blooddrivet == 1) {
            description += "Blood(Blood Drive) <br>";
          }
          if(nonlatext == 1) {
            description += "Non-Latex Gloves <br>";
          }
          if(foodt == 1) {
            description += "Food(For Medical Staff) <br>";
          }
          if(gownst == 1) {
            description += "Disposable Surgical Gowns <br>";
          }
          if(capst == 1) {
            description += "Disposable Surgical Caps <br>";
          }
          if(glovest == 1) {
            description += "Gloves <br>";
          }
          if(maskst == 1) {
            description += "Masks <br>";
          }
          if(ventilatorst == 1) {
            description += "Ventilators <br>";
          }
          if(othert != null) {
            description += othert;
          }
          infowindow.setContent(description);
          infowindow.open(map, marker);
      }
    })(marker, j));
      }
    });
    })(hnamet, blooddrivet, glovest, nonlatext, maskst, ventilatorst, foodt, gownst, capst, othert, address);
  }

  	google.maps.event.addDomListener(document.getElementById('closest-location'), 'click', function () {
  		if (navigator.geolocation) {
          	navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            for(j = 0; j < addresses.length; j++) {
              var address = addresses[j];
              var distancetemp = 0;
              var finaldistance = -1;
              var index = j;
              var finalres = 0;
              var length = addresses.length-1;
              (function(address, index, length) {
                geocoder.geocode( {address: address}, function(results, status) {
                  if(status == 'OK') {
                    distancetemp = haversine_distance(results[0], pos);
                    console.log(address + ":");
                    console.log(index);
                    console.log(length);
                    if(finaldistance == -1) {
                      finalres = results[0];
                      finaldistance = distancetemp;
                    }
                    else if(distancetemp < finaldistance) {
                      finalres = results[0];
                      console.log(distancetemp);
                      console.log(finaldistance);
                      finaldistance = distancetemp;
                    }
                    if(index == length) {
                      map.panTo(finalres.geometry.location);
                    }
                  }
                });
              })(address, index, length);
            }

			      smoothZoom(map, 12, map.getZoom());
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
        setTimeout(function(){map.setZoom(cnt)}, 80);
    }
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
                          'Error: The Geolocation service failed.' :
                          'Error: Your browser doesn\'t support geolocation.');
    infoWindow.open(map);
}
