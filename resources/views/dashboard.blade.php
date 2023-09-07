@extends('master')
@section('content')
    <style>
        .card {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, .125);
            border-radius: 0.25rem;
        }

        .card-body {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            padding: 1.25rem;
        }
    </style>
    <div class="container main-div">

        <div class="row">
            <div class="col-sm-3">
                <div class="card text-center">
                    <div class="card-header">नये आवेदन</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $newApplication }}</h5>
                        <!--p class="card-text">With supporting text below as a natural lead-in to additional content.</p-->
                        @if (auth()->user()->user_type == 'Director')
                            <a href="{{ url('avedan-districtwise') }}" class="btn btn-primary">View</a>
                        @else
                            <a href="{{ url('avedan') }}" class="btn btn-primary">View</a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="card text-center">
                    <div class="card-header">स्वीकृत आवेदन</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $approvedApplication }}</h5>
                        <!--p class="card-text">With supporting text below as a natural lead-in to additional content.</p-->
                        <a href="{{ url('approved-avedan') }}" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="card text-center">
                    <div class="card-header">अस्वीकार आवेदन</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $rejectedApplication }}</h5>
                        <!--p class="card-text">With supporting text below as a natural lead-in to additional content.</p-->
                        <a href="{{ url('rejected-avedan') }}" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="card text-center">
                    <div class="card-header">चयनित सामान्य/अन्य पिछड़ा वर्ग अभ्यर्थी</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $generalList }}</h5>
                        <!--p class="card-text">With supporting text below as a natural lead-in to additional content.</p-->
                        <a href="{{ url('general-list') }}" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="card text-center">
                    <div class="card-header">चयनित अनुसूचित जाति अभ्यर्थी</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $SClist }}</h5>
                        <!--p class="card-text">With supporting text below as a natural lead-in to additional content.</p-->
                        <a href="{{ url('sc-list') }}" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="card text-center">
                    <div class="card-header">चयनित अनुसूचित जनजाति अभ्यर्थी</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $STlist }}</h5>
                        <!--p class="card-text">With supporting text below as a natural lead-in to additional content.</p-->
                        <a href="{{ url('st-list') }}" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>

            @if (auth()->user()->user_type == 'District Officer')
                <div class="col-sm-3">
                    <div class="card text-center">
                        <div class="card-header">प्रतीक्षा सूची</div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $waitingList }}</h5>
                            <!--p class="card-text">With supporting text below as a natural lead-in to additional content.</p-->
                            <a href="{{ url('waiting-list') }}/1" class="btn btn-primary">View</a>
                        </div>
                    </div>
                </div>
            @endif





            <style type="text/css">
                #map {

                    height: 400px;

                }
            </style>

            <div class="container mt-5">

                <h2>Gogkul Misson Map</h2>

                <div id="map"></div>

            </div>



            <script type="text/javascript">
                const UTTAR_PRADESH_BOUNDS = {
                    north: 30.4477,
                    south: 23.6345,
                    west: 77.2761,
                    east: 84.9147,
                };
                const LUCKNOW = {
                    lat: 26.8467,
                    lng: 80.9462
                };


                function initMap() {
                    //add map, the type of map
                    var mapOptions = {
                        zoom: 8,
                        restriction: {
                            latLngBounds: UTTAR_PRADESH_BOUNDS,
                            strictBounds: false,
                        },
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

                    const ctaLayer = new google.maps.KmlLayer({
                        url: "https://special-eureka-vp949v7g9qj2w9v7-4200.app.github.dev/assets/images/kml",
                        map: map,
                    });


                }
                google.maps.event.addDomListener(window, 'load', initMap);
            </script>

            <script defer type="text/javascript"
                src="https://maps.google.com/maps/api/js?key={{ env('AIzaSyABHXJPN6L8-6nqf4uUekwdoQBPeHLYe60') }}&callback=initMap">
            </script>

        </div>
    @endsection
