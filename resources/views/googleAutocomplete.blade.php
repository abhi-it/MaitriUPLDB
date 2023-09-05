<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">



<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel Google Maps Multiple Markers Example - ItSolutionStuff.com</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>

    <style type="text/css">
        #map {

            height: 400px;

        }
    </style>

</head>



<body>

    <div class="container mt-5">

        <h2>Gogkul Misson Map</h2>

        <div id="map"></div>

    </div>



    <script type="text/javascript">
        function initMap() {
            //add map, the type of map
            var mapOptions = {
                zoom: 8,
                draggable: true,
                animation: google.maps.Animation.DROP,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                center: new google.maps.LatLng(26.8467, 80.9462), // area location
                styles: [{
                    "stylers": [{
                        "saturation": -100
                    }, {
                        "gamma": 1
                    }]
                }, {
                    "elementType": "labels.text.stroke",
                    "stylers": [{
                        "visibility": "off"
                    }]
                }, {
                    "featureType": "poi.business",
                    "elementType": "labels.text",
                    "stylers": [{
                        "visibility": "off"
                    }]
                }, {
                    "featureType": "poi.business",
                    "elementType": "labels.icon",
                    "stylers": [{
                        "visibility": "off"
                    }]
                }, {
                    "featureType": "poi.place_of_worship",
                    "elementType": "labels.text",
                    "stylers": [{
                        "visibility": "off"
                    }]
                }, {
                    "featureType": "poi.place_of_worship",
                    "elementType": "labels.icon",
                    "stylers": [{
                        "visibility": "off"
                    }]
                }, {
                    "featureType": "road",
                    "elementType": "geometry",
                    "stylers": [{
                        "visibility": "simplified"
                    }]
                }, {
                    "featureType": "water",
                    "stylers": [{
                        "visibility": "on"
                    }, {
                        "saturation": 50
                    }, {
                        "gamma": 0
                    }, {
                        "hue": "#50a5d1"
                    }]
                }, {
                    "featureType": "administrative.neighborhood",
                    "elementType": "labels.text.fill",
                    "stylers": [{
                        "color": "#333333"
                    }]
                }, {
                    "featureType": "road.local",
                    "elementType": "labels.text",
                    "stylers": [{
                        "weight": 0.5
                    }, {
                        "color": "#333333"
                    }]
                }, {
                    "featureType": "transit.station",
                    "elementType": "labels.icon",
                    "stylers": [{
                        "gamma": 1
                    }, {
                        "saturation": 50
                    }]
                }]
            };
            var mapElement = document.getElementById('map');
            var map = new google.maps.Map(mapElement, mapOptions);

            //add locations
            var locations = [
                ['Lakhimpur', 27.9494, 80.7820, '/images/logo1.jpg'],
                ['Kanpur', 26.4499, 80.3319, '/images/logo1.jpg'],
                ['Barabanki', 26.9386, 81.1999, '/images/logo1.jpg'],
                ['Agra', 27.1767, 78.0081, '/images/logo1.jpg'],
                ['Lucknow', 26.8467, 80.9462, '/images/logo1.jpg'],
                ['Sitapur', 27.5610, 80.6826, '/images/logo1.jpg'],
            ];

            //declare marker call it 'i'
            var marker, i;
            //declare infowindow
            var infowindow = new google.maps.InfoWindow();
            //add marker to each locations
            for (i = 0; i < locations.length; i++) {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: map,
                    icon: locations[i][3]
                });
                //click function to marker, pops up infowindow
                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        infowindow.setContent(locations[i][0]);
                        infowindow.open(map, marker);
                    }
                })(marker, i));
            }

            const lucknowLatLng = {
                lat: 26.8467,
                lng: 80.9462
            }; // Lucknow coordinates
        }
        google.maps.event.addDomListener(window, 'load', initMap);
    </script>



    <script type="text/javascript"
        src="https://maps.google.com/maps/api/js?key={{ env('AIzaSyABHXJPN6L8-6nqf4uUekwdoQBPeHLYe60') }}&callback=initMap">
    </script>



</body>

</html>
