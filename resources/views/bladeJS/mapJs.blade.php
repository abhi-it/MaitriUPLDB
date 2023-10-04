@push('body-scripts')
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

    <script type="text/javascript">
        let markers = [];
        var app = {{ Illuminate\Support\Js::from($maitriDistricts) }};
        var appUpldbCenters = {{ Illuminate\Support\Js::from($upldbCenters) }};



        const convertedData = app.map(item => [
            item.district,
            parseFloat(item.latitude),
            parseFloat(item.longitude),
            "/images/logo1.jpg" // Replace with the actual image path
        ]);
        const convertedAppUpldbCentersData = appUpldbCenters.map(item => [
            item.name,
            parseFloat(item.latitude),
            parseFloat(item.longitude),
            item.icon, // Replace with the actual image path
        ]);

        console.log(convertedAppUpldbCentersData, "upldbCenters");
        const UTTAR_PRADESH_BOUNDS = {
            north: 30.4477,
            south: 23.6345,
            west: 77.2761,
            east: 84.9147,
        };
        const uttarPradeshCoordinates = [
            // Define the coordinates that represent the boundaries of UP
            {
                lat: 30.4475,
                lng: 79.6129
            }, // Top-left
            {
                lat: 30.4475,
                lng: 83.6753
            }, // Top-right
            {
                lat: 23.6345,
                lng: 83.6753
            }, // Bottom-right
            {
                lat: 23.6345,
                lng: 79.6129
            }, // Bottom-left
            {
                lat: 30.4475,
                lng: 79.6129
            }, // Closing point (back to top-left)
        ];


        const dashedLineSymbol = {
            path: "M 0,-1 0,1",
            strokeOpacity: 1,
            scale: 4,
        };


        async function initMap() {

            const {
                AdvancedMarkerElement,
                PinElement
            } = await google.maps.importLibrary(
                "marker",
            );



            this.markerInfoWindow = new google.maps.InfoWindow({
                content: ""
            });
            this.markers = [];

            //add map, the type of map
            var mapOptions = {
                zoom: 8,
                // restriction: {
                //     latLngBounds: UTTAR_PRADESH_BOUNDS,
                //     strictBounds: false,
                // },
                mapId: "{{env('GOOGLE_MAP_ID')}}",
                draggable: true,
                animation: google.maps.Animation.DROP,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                center: new google.maps.LatLng(26.8467, 80.9462), // area location

            };
            var mapElement = document.getElementById('map');
            var map = new google.maps.Map(mapElement, mapOptions);

            setTimeout(() => {
                map.setZoom(7);
            }, 1000);

            var locations = convertedData;

            //declare marker call it 'i'
            var marker, i;
            //declare infowindow
            var infowindow = new google.maps.InfoWindow();
            //add marker to each locations
            let no = 1;

            let partalData = '';
            for (i = 0; i < locations.length; i++) {

                partalData = '';
                app[i].maitri_portal.map(data => {


                    if (partalData) {
                        partalData += ` <tr>
                    <td>${no}</td>
                    <td>${data.tehsil}</td>
                    <td>${data.development_area}</td>
                    <td>${data.veterinary_hospital_name}</td>
                    <td>${data.gram_panchayat_name}</td>
                    <td>${data.work_area}</td>
                    <td>${data.private_artificial_insemination_worker}</td>
                    <td>${data.address}</td>
                    
                </tr>`;

                    } else {

                        partalData += ` <tr>
                    <td>${no}</td>
                    <th rowspan="${app[i].maitri_portal.length}">${data.mandal}</th>
                    <th rowspan="${app[i].maitri_portal.length}">${locations[i][0]}</th>
                    <td>${data.tehsil}</td>
                    <td>${data.development_area}</td>
                    <td>${data.veterinary_hospital_name}</td>
                    <td>${data.gram_panchayat_name}</td>
                    <td>${data.work_area}</td>
                    <td>${data.private_artificial_insemination_worker}</td>
                    <td>${data.address}</td>
                    
                </tr>`;
                    }
                    no++;

                });
                no = 1;
                let priceTag = document.createElement("div");
                priceTag.className = "price-tag";
                priceTag.textContent = locations[i][0];
                marker = new google.maps.marker.AdvancedMarkerElement({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: map,
                    content: priceTag,
                });

                this.markers.push(marker);

                let content = `
                        <!DOCTYPE html>
<table border="1" border-collapse="collapse">
            <thead>
                <tr>
                    <th>No</th>
                    <th>mandal</th>
                    <th>Distict</th>
                    <th>तहसील</th>
                    <th>विकास खंड</th>
                    <th>पशुचिकित्सालय का नाम</th>
                    <th>ग्राम पंचायत का नाम <br>
                        (जहां का निवासी हो)
                    </th>
                    <th>कार्यक्षेत्र</th>
                    <th>प्राइवेट कृत्रिम गर्भाधान कार्यकर्ता / पशुमित्र/मैत्री का नाम</th>
                    <th>पता</th>
                    
                </tr>
            </thead>
            <tbody>

                ${partalData}
                
                
            </tbody>
        </table>           
                        `;


                //click function to marker, pops up infowindow
                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        infowindow.setContent(content);
                        infowindow.open(map, marker);
                    }
                })(marker, i));
            }
            for (i = 0; i < convertedAppUpldbCentersData.length; i++) {
                let imgIcon = document.createElement("img");
                imgIcon.className = "image-icon";
                imgIcon.src = window.location.origin + '/' + convertedAppUpldbCentersData[i][3];
                marker = new google.maps.marker.AdvancedMarkerElement({
                    position: new google.maps.LatLng(convertedAppUpldbCentersData[i][1],
                        convertedAppUpldbCentersData[i][2]),
                    map: map,
                    content: imgIcon,
                });
            }
            partalData = '';
            const ctaLayer = new google.maps.KmlLayer({
                url: "https://maitriupldb.in/map-1.kml",
                map: map,
            });

        }
        google.maps.event.addDomListener(window, 'load', initMap);
    </script>

    <script>
        (g => {
            var h, a, k, p = "The Google Maps JavaScript API",
                c = "google",
                l = "importLibrary",
                q = "__ib__",
                m = document,
                b = window;
            b = b[c] || (b[c] = {});
            var d = b.maps || (b.maps = {}),
                r = new Set,
                e = new URLSearchParams,
                u = () => h || (h = new Promise(async (f, n) => {
                    await (a = m.createElement("script"));
                    e.set("libraries", [...r] + "");
                    for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]);
                    e.set("callback", c + ".maps." + q);
                    a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
                    d[q] = f;
                    a.onerror = () => h = n(Error(p + " could not load."));
                    a.nonce = m.querySelector("script[nonce]")?.nonce || "";
                    m.head.append(a)
                }));
            d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() =>
                d[l](f, ...n))
        })
        ({
            key: {{ env('GOOGLE_MAP_KEY') }},
            v: "weekly"
        });
    </script>
    <script src="https://unpkg.com/@googlemaps/markerclusterer/dist/index.min.js"></script>
@endpush
