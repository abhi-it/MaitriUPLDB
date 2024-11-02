@extends('master')
@section('content')
<style>
  .page-loader{
	width: 100%;
	height: 100vh;
	position: absolute;
	background: #2727275e;
	z-index: 1000;
	.txt{
		color: #666;
		text-align: center;
		top: 40%;
		position: relative;
		text-transform: uppercase;
		letter-spacing: 0.3rem;
		font-weight: bold;
		line-height: 1.5;
	}
}

/* SPINNER ANIMATION */
.spinner {
	position: relative;
	top: 35%;
  width: 80px;
  height: 80px;
  margin: 0 auto;
  background-color: #ea7f40;

  border-radius: 100%;  
  -webkit-animation: sk-scaleout 1.0s infinite ease-in-out;
  animation: sk-scaleout 1.0s infinite ease-in-out;
}
</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<div class="container main-div" style="background-color:white; height: 100%; min-height:380px;">
    <!--First row Start -->
    <h3 class="text-center fw-bold m-4">Map</h3>
@if (session('error'))
<div class="alert alert-danger">
	{{ session('error') }}
</div>
@endif
@if (session('success'))
<div class="alert alert-success">
	{{ session('success') }}
</div>
@endif
@if($errors)
	@foreach ($errors->all() as $error)
	<div class="alert alert-danger">{{ $error }}</div>
	@endforeach
@endif    
<div class="container main-div" style="margin-top:25px">

<div class="page-loader">
	<div class="spinner"></div>
</div>
      <div class="row">
        <div class="col-md-2 mb-4">
          <select name="type" id="type" class="form-control">
            <option value="0">कोई भी चुनें</option>
            <option value="pd_lab">गर्भावस्था निदान प्रयोगशाला (Pregnancy Diagnosis Laboratory) ({{count($pdlab)}})</option>
            <option value="cryo_vessel_blocks">क्रायो-वेसल ब्लॉक (Cryo-Vessel Blocks) ({{count($cvblocks)}})</option>
            <option value="1">मैत्री (पशु मित्र)  ({{count($maitricount)}})</option>
            <option value="2">एआई सेंटर/एलईओ सेंटर/पशु चिकित्सा अस्पताल  ({{count($aicount)}})</option>
            <option value="3">जिलों  ({{count($disticcount)}})</option>
            <option value="lc_agency">सीमेन बैंक / क्षेत्रीय केंद्र (Semen Bank / Zonal Centers) ( {{$agency}} )</option>
            <option value="semen_station">सीमेन डी.एफ.एस. स्टेशन (Semen D F S Station ) ({{$station}})</option>
            <option value="ett_ivf">ईटीटी / आईवीएफ सुविधा केंद्र (ETT /  IVF Facility Center) ({{$ivf}})</option>
            <option value="bull_mother">बुल मदर फार्म्स (बीएमएफ) (Bull Mother Farms ) ({{$bull}})</option>
          </select>
        </div>
      </div>

      <div class="export_aiCenter" style="display: none;">
        <form method="get" action="{{ route('exportAllAIcenters') }}"> 
            <div class="col-md-4 mb-4">
              <button class="btn btn-primary" type="submit" id="ExportAllAiCenter" >Export All</button>
            </div>
        </form>
      </div>

      <div id="maitri" class="row">
          <div class="col-md-4 mb-4">
          <select class="form-control" name="district" id="district" >
              <option>-Select any-</option>
              @foreach($data as $val)
                @if($val!='' ||$val != null)
                    @php
                        $distcount   = App\Models\Maitri::where(['mandal_name'=>$val['mandal_name']])->count();
                    @endphp

                  <option value="{{$val['mandal_name']}}">{{$val['mandal_name']}}  ({{$distcount }})</option>
                @endif
              @endforeach
            </select>
          </div>
          <div class="col-md-4 mb-4">
          <select class="form-control" name="janpad" id="janpad" >
            <option>-Select janpad-</option>
            </select>
          </div>
          <form method="get" action="{{ route('exportselectedmaitries') }}"> 
              <div class="col-md-4 mb-4">
                <input type="hidden" id="id" name="id">
                <button class="btn btn-primary" type="submit" id="maitriExport" >Export</button>
              </div>
          </form>
          <div class="col-md-2 mb-4" id="janpad_count">
            
          </div>
      </div>

      <div id="aicenter" class="row"> 
          <div class="col-md-4 mb-4">
            <select class="form-control" name="address" id="address" >
                <option>-कोई भी चुनें-</option>
                @foreach($aicenter as $val)
                @if($val!='' ||$val != null)
                  @php
                    $distcount   = App\Models\Cliniclocation::where(['mandal_name'=>$val['mandal_name']])->count();
                  @endphp
                  <option value="{{$val['mandal_name']}}">{{$val['mandal_name']}}   ({{$distcount }})</option>
                @endif
                @endforeach
              </select>
          </div>
          <div class="col-md-4 mb-4">
            <select class="form-control" name="get_district" id="get_district" style="display:none;">
            <option value="">Select District</option>
            </select>
          </div>
          <form method="get" action="{{ route('exportselectedAIcenters') }}"> 
              <div class="col-md-4 mb-4">
                <input type="hidden" id="ai_id" name="ai_id">
                <button class="btn btn-primary" type="submit" id="AIExport" >Export</button>
              </div>
          </form>
      </div>

      <div id="location" class="row">
          <div class="col-md-4 mb-4">
            <select class="form-control" name="division" id="division" >
                <option>-कोई भी चुनें-</option>
                @foreach($division as $val)
                @if($val!='' ||$val != null)
                  @php
                    $distcount   = App\Models\Districts::where(['division_id'=>$val['id']])->count();
                  @endphp
                  
                  <option value="{{$val['name_hindi']}}">{{$val['name_hindi']}}  ({{$distcount }})</option>
                @endif
                @endforeach
              </select>
          </div>
          <form method="get" action="{{ route('exportselectedLocation') }}"> 
              <div class="col-md-4 mb-4">
                <input type="hidden" id="lo_id" name="lo_id">
                <button class="btn btn-primary" type="submit" id="locationExport" >Export</button>
              </div>
          </form>
      </div>

      <div class="row mb-5">
        <div id="map"></div>

        <div id="map-up"></div>
      </div>
    </div>
</div>
<style>
#map, #map-up {
    width: 1000%;
    height: 600px;
}
.leaflet-touch .leaflet-control-attribution, .leaflet-touch .leaflet-control-layers, .leaflet-touch .leaflet-bar {
    box-shadow: none;
    display: none;
}
</style>

<script src="https://unpkg.com/@googlemaps/markerclusterer/dist/index.min.js"></script>
<scrpt src="https://cdnjs.cloudflare.com/ajax/libs/js-marker-clusterer/1.0.0/markerclusterer_compiled.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBgqN0p57wDl0yxjmUHftcU0QM5h3MGAwM&callback=myMap"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
   var totalmaitri  =  <?php echo json_encode($maitricount); ?>;
   var aicount      =  <?php echo json_encode($aicount); ?>; 
   var division      =  <?php echo json_encode($disticcount); ?>; 
   var pdlab        =  <?php echo json_encode($pdlab);?>;
   var cvblocks     =   <?php echo json_encode($cvblocks);?>; 

  $('#map').hide();
  $('#maitri').hide();
  $('#aicenter').hide();
  $('#location').hide();
  $('#janpad_count').hide()
  let featureLayer;
  const featureStyleOptions = {
        strokeColor: "#EA7324",
        strokeOpacity: 1.0,
        strokeWeight: 3.0,
        fillColor: "#EA7324",
        fillOpacity: 0.5,
    };
  var locations =[];
  var currWindow =false; 
  var code ={
    latt: 27.886641697838808,
    long:79.87913668769336
  };
  var place_id='ChIJa7EyH5n9mzkR54uXCYm6zJM';
  var icon = {
      url: "{{ asset('') }}mapicon/icon-1.png",
      size: new google.maps.Size(50, 50),
      origin: new google.maps.Point(0, 0),
  };
  var icon4 = {
      url: "{{ asset('') }}mapicon/icon-4.png",
      size: new google.maps.Size(50, 50),
      origin: new google.maps.Point(0, 0),
  };
  var icon5  ={
      url: "{{ asset('') }}mapicon/icon-5.png",
      size: new google.maps.Size(50, 50),
      origin: new google.maps.Point(0, 0),
  };
  var icon2  ={
      url: "{{ asset('') }}mapicon/icon-2.png",
      size: new google.maps.Size(50, 50),
      origin: new google.maps.Point(0, 0),
  };
  var icon3  ={
      url: "{{ asset('') }}mapicon/icon-3.png",
      size: new google.maps.Size(50, 50),
      origin: new google.maps.Point(0, 0),
  };
  var icon7  ={
      url: "{{ asset('') }}mapicon/icon-7.png",
      size: new google.maps.Size(50, 50),
      origin: new google.maps.Point(0, 0),
  };
  var icon8  ={
      url: "{{ asset('') }}mapicon/icon-8.png",
      size: new google.maps.Size(50, 50),
      origin: new google.maps.Point(0, 0),
  };
  var icon9  ={
      url: "{{ asset('') }}mapicon/icon-9.png",
      size: new google.maps.Size(50, 50),
      origin: new google.maps.Point(0, 0),
  };
  // console.log('url',icon)
  var aiimg = {
      url: "{{ asset('') }}images/i1.svg",
      size: new google.maps.Size(50, 50),
      origin: new google.maps.Point(0, 0),
  }
  var vhimg ={
      url: "{{ asset('') }}images/h1.svg",
      size: new google.maps.Size(50, 50),
      origin: new google.maps.Point(0, 0),
  }
  var img =  {
      url: "{{ asset('') }}images/ai.png",
      size: new google.maps.Size(50, 50),
      origin: new google.maps.Point(0, 0),
  };
  // var lc_img =  {
  //     url: "{{ asset('') }}images/l1.svg",
  //     size: new google.maps.Size(50, 50),
  //     origin: new google.maps.Point(0, 0),
  // };

  var lc_img = {
    url: "{{ asset('') }}images/l1.svg",
    size: new google.maps.Size(100, 100),  // Original size
    scaledSize: new google.maps.Size(50, 50),  // New larger size
    origin: new google.maps.Point(0, 0),
  };

$('#type').change(function() {
  $('#maitri').hide();
  $('#aicenter').hide();
  $('#location').hide();
  $('#AIExport').hide();
  $('#locationExport').hide();
  $('#janpad_count').hide()
  var val = $("#type option:selected").val();
  $('#map').hide();
  $('#map-up').hide();
  
  if(val==='1'){
    $('#map').show();
    $('#maitri').show();
    initMap(null, totalmaitri);
  }
  if(val=='2'){
    $('.export_aiCenter').show();
    $('#aicenter').show();
    $('#map').show();
    initAIMap(null,aicount);
  }
  if(val=='3'){
    $('#location').show();
    $('#map').show();
    initLocationMap(null,division);
  }
  if(val=='0'){
    $('#map-up').show();
    initMapDefault();
  }


  if(val=='lc_agency' || val=='semen_station' || val=='ett_ivf' || val=='bull_mother'){
    $.ajax({
        type: "GET",
        url: "getallLiveStockData",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            "_token": "{{ csrf_token() }}",
            "id": val
        },
        cache: false,
        success: function(data) {
          // console.log('data' ,data)
            if(data){
              $('#map').show();
              initLiveStockMap(null, data);
            }
        }
    });

  }

  if(val=='pd_lab'){
    $('#map').show();
    iniPDlabMap(null,pdlab);
  }

  if(val=='cryo_vessel_blocks'){
    $('#map').show();
    iniSryoVesselMap(null,cvblocks);
  }


});
// AIcenter function start here 
$('#address').change(function() {
  $('#ai_id').val();
    var val = $("#address option:selected").val();
    $('#ai_id').val(val);
    if (val) {
        $.ajax({
            type: "GET",
            url: "getallAIcenters",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "_token": "{{ csrf_token() }}",
                "id": val
            },
            cache: false,
            success: function(data) {

              if(data.district){
                $('#get_district').show();
                var district = data.district;
                $.each(district, function(index, item) {
                    const option = $('<option></option>')
                        .attr('value', item.id)
                        .text(item.name_eng + ' (' + item.name_hindi + ')');
                    $('#get_district').append(option);
                });
              }

              console.log("Maitri = "+data.maitri);

              if(data.maitri){
                $('#map').show();
                $('#AIExport').show();
                initAIMap(data.code, data.maitri);
              }
            }
        });
    }
});


$('#get_district').change(function() {
  var district_id = $("#get_district option:selected").val();
  if (district_id) {
        $.ajax({
            type: "GET",
            url: "getallAIcenters",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "_token": "{{ csrf_token() }}",
                'district': district_id
            },
            cache: false,
            success: function(data) {

              if(data.aicenter){

                console.log("Aicenter = "+data.aicenter);
                $('#map').show();
                $('#AIExport').show();
                initAIMap(data.code, data.aicenter);
              }
            }
        });
    }
})

async function initAIMap(code,locations) {
    var lat  = (code)?code.latt:27.5706;
    var long  = (code)?code.long:80.0982;
    const zoom = ((locations.length)>20) ? 10 : 7;
    var latlng = new google.maps.LatLng( lat,long);
    var map = new google.maps.Map(document.getElementById('map'), {
          center: latlng,
          zoom,
          // minZoom: zoom - 3,
          // maxZoom: zoom + 3,
          mapId: "a3efe1c035bad51b", 
          zoomControl: false,
    });
    var markers = [];
    if(locations.length>0){
      var marker, i ,labels;
      var markers=[];
      for (let i = 0; i < locations.length; i++) {
        if (locations[i]['longitute'] !== "" && locations[i]['lattitute'] !== "") {
          const contentString =
                    '<div id="content">' +
                    '<div id="siteNotice">' +
                    "</div>" +
                    '<div id="bodyContent">' +
                    "<p> प्रशिक्षण केंद्र का नाम : <b>"+locations[i]['name']+"</b>,</br> " +
                    " पता : <b>"+locations[i]['janpad_name']+","+locations[i]['mandal_name']+"   </b>,</br>"  + 
                    " केंद्र / संस्थान : <b>"+locations[i]['type']+"</b>,</br> " +
                    "</p></div>" +
                    "</div>";
              
          const infowindow = new google.maps.InfoWindow({
            disableAutoPan: false,
            content: contentString,
          });
          var icons =    (locations[i]['type']=='AI') ?aiimg :vhimg;
          marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i]['lattitute'], locations[i]['longitute']),
            map: map, 
            icon:icons,
          });
            var currentInfowindow = null;
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
              return function() {
                if (currentInfowindow) {
                  currentInfowindow.close();
                }
                infowindow.open(map, marker);
                currentInfowindow = infowindow;
              }
            })(marker, i));
            markers.push(marker);
            google.maps.event.addListener(infowindow, 'closeclick', function() {
              currentInfowindow = null;
            });
        }
        // const markerCluster = new markerClusterer.MarkerClusterer({ markers, map });
      }
    }
    var placeId   = (code)?code.place_id: place_id
    featureLayer = map.getFeatureLayer("ADMINISTRATIVE_AREA_LEVEL_2");
    featureLayer.style = (options) => {
      if (options.feature.placeId == placeId) {
        return featureStyleOptions;
      }
    };
   
}
// end AI center function here 

//location function start here
$('#division').change(function() {
    $('#locationExport').hide();
    $('#lo_id').val();
    var val = $("#division option:selected").val();
    $('#lo_id').val(val);
    if (val) {
        $.ajax({
            type: "GET",
            url: "getalldistrictdata",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "_token": "{{ csrf_token() }}",
                "id": val
            },
            cache: false,
            success: function(data) {
                if(data.maitri){
                  $('#map').show();
                  $('#locationExport').show();
                  initLocationMap(data.code, data.maitri);
                }
            }
        });
    }
});

async function initLocationMap(code,locations) {
    var lat  = (code)?code.latt:27.5706;
    var long  = (code)?code.long:80.0982;
    const zoom = ((locations.length)>20)? 10 : 7;
    var latlng = new google.maps.LatLng( lat,long);
    var map = new google.maps.Map(document.getElementById('map'), {
          center: latlng,
          zoom,
          // minZoom: zoom - 3,
          // maxZoom: zoom + 3,
          mapId: "a3efe1c035bad51b", 
          zoomControl: false,
    });
    var markers = [];
    if(locations.length>0){
      var marker, i ,labels;
      var markers=[];
      for (let i = 0; i < locations.length; i++) {
        if (locations[i]['long'] !== "" && locations[i]['latt'] !== "") {
          const contentString =
                    '<div id="content">' +
                    '<div id="siteNotice">' +
                    "</div>" +
                    '<div id="bodyContent">' +
                    "<p>  नाम : <b>"+locations[i]['name_hindi']+"</b>,</br> " +
                    "</p></div>" +
                    "</div>";
          const infowindow = new google.maps.InfoWindow({
            disableAutoPan: false,
            content: contentString,
          });
          marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i]['latt'], locations[i]['long']),
            map: map, 
            icon: lc_img,
          });
            var currentInfowindow = null;
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
              return function() {
                if (currentInfowindow) {
                  currentInfowindow.close();
                }
                infowindow.open(map, marker);
                currentInfowindow = infowindow;
              }
            })(marker, i));
            markers.push(marker);
            google.maps.event.addListener(infowindow, 'closeclick', function() {
              currentInfowindow = null;
            });
        }
        // const markerCluster = new markerClusterer.MarkerClusterer({ markers, map });
      }
    }
    var placeId   = (code)?code.place_id: place_id
    featureLayer = map.getFeatureLayer("ADMINISTRATIVE_AREA_LEVEL_2");
    featureLayer.style = (options) => {
      if (options.feature.placeId == placeId) {
        return featureStyleOptions;
      }
    };
   
}
//  location function end here

//  start maitri function from here
  $('#janpad').hide();
  $('#maitriExport').hide();
  $('#janpad_count').hide()
  $('#district').change(function() {
      $('#id').val();
      $('#maitriExport').hide();
      $('#janpad').hide();
      $('#janpad_count').hide();
      var val = $("#district option:selected").val();
      if (val) {
          $.ajax({
              type: "GET",
              url: "getJanpadUnique",
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              data: {
                  "_token": "{{ csrf_token() }}",
                  "id": val
              },
              cache: false,
              success: function(data) {
                  $('#janpad').show();
                  $('#janpad').empty();
                  $('#janpad').append($("<option>-Select one-</option>"));
                  $.each(data.data.results, function(i, index) {
                    // Skip the iteration if the janpad_name is "विन्ध्याचल"
                    if (index.janpad_name === "विन्ध्याचल") {
                        return true; // This will skip the current iteration
                    }

                    // Create the option element with value and display text
                    var option = $("<option></option>")
                        .attr("value", index.janpad_name)
                        .text(index.janpad_name + " (" + index.count + ")");

                    // Append the option to the select element
                    $('#janpad').append(option);
                });

                  var maitricount = data.data.maitri;
                  var janpad       = data.data.janapad;
                  if(maitricount.length>0){
                    initMap(janpad, maitricount);
                  }
              }
          });
      }
  });

  $('#janpad').change(function() {
      $('#maitriExport').hide();
      var val = $("#janpad option:selected").val();
      $('#id').val(val);
      if (val) {
          $.ajax({
              type: "GET",
              url: "allMaitriesData",
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              data: {
                  "_token": "{{ csrf_token() }}",
                  "id": val
              },
              cache: false,
              success: function(data) {
                $('#janpad_count').empty()
                  if(data.code){
                    $('#janpad_count').show()
                    $('#map').show();
                    $('#janpad_count').append($("<label for='count' class='btn btn-primary'>Total Maitri : "+data.maitri.length+"</label>"));
                    $('#maitriExport').show();
                    initMap(data.code, data.maitri);
                  }
              }
          });
      }
  });

  async function initMap(code,locations) {
      var lat  = (code)?code.latt:27.5706;
      var long  = (code)?code.long:80.0982;
      const zoom = ((locations.length)>20)? 10 : 7;
      var latlng = new google.maps.LatLng( lat,long);
      var map = new google.maps.Map(document.getElementById('map'), {
            center: latlng,
            zoom,
            // minZoom: zoom - 3,
            // maxZoom: zoom + 3,
            mapId: "a3efe1c035bad51b", 
            zoomControl: false,
      });
      var markers = [];
      if(locations.length>0){
        var marker, i ,labels;
        var markers=[];
        for (let i = 0; i < locations.length; i++) {
          if (locations[i]['longitude'] !== "" && locations[i]['latitude'] !== "") {
            const contentString =
                      '<div id="content">' +
                      '<div id="siteNotice">' +
                      "</div>" +
                      '<div id="bodyContent">' +
                      "<p> नाम : <strong><b>"+locations[i]['maitri_name']+"</b></strong>,</br>" +
                      " मोबाइल नंबर : <b>"+locations[i]['maitri_mobile_no']+"</b>,</br>" +
                      " मंडल नाम/ज़िला : <b>"+locations[i]['mandal_name']+"</b>,</br> " +
                      " जनपद का नाम : <b>"+locations[i]['janpad_name']+"</b>,</br> " +
                      " ग्राम पंचायत : <b>"+locations[i]['gram_panchayat']+"</b>,</br> " +
                      " पोस्ट ऑफ़िस : <b>"+locations[i]['post_office']+"</b>,</br> " +
                      " तहसील : <b>"+locations[i]['tehsil']+"</b>,</br> " +
                      " प्रशिक्षण केंद्र का नाम : <b>"+locations[i]['center_name']+"</b>,</br> " +
                      " भारत पशुधन एआई आईडी : <b>"+locations[i]['any_bharat_id']+"</b>,</br> " +
                      " प्रशिक्षण का वर्ष : <b>"+locations[i]['pass_date']+"</b>,</br> " +
                      "</p></div>" +
                      "</div>";
            const infowindow = new google.maps.InfoWindow({
              disableAutoPan: false,
              content: contentString,
            });


            if(locations[i]['mandal_name'] == 'मेरठ'){
              marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i]['latitude'], locations[i]['longitude']),
                map: map,
                icon: icon7,
              });
            }else{
              marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i]['latitude'], locations[i]['longitude']),
                map: map,
                icon: icon,
              });
            }
              var currentInfowindow = null;
              google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                  if (currentInfowindow) {
                    currentInfowindow.close();
                  }
                  infowindow.open(map, marker);
                  currentInfowindow = infowindow;
                }
              })(marker, i));
              markers.push(marker);
              google.maps.event.addListener(infowindow, 'closeclick', function() {
                currentInfowindow = null;
              });
          }
          // const markerCluster = new markerClusterer.MarkerClusterer({ markers, map });
        }
      }else{
        var marker = new google.maps.Marker({
              position: latlng,
              map: map,
              draggable: true
        });
        google.maps.event.addListener(marker, 'dragend', function(a) {
            var div = document.createElement('div');
            div.innerHTML = a.latLng.lat().toFixed(4) + ', ' + a.latLng.lng().toFixed(4);
            document.getElementsByTagName('body')[0].appendChild(div);
        });
      }
      var placeId   = (code)?code.place_id: place_id
        featureLayer = map.getFeatureLayer("ADMINISTRATIVE_AREA_LEVEL_2");
        featureLayer.style = (options) => {
          if (options.feature.placeId == placeId) {
            return featureStyleOptions;
          }
        };
  }
// end maitri function from here 


async function initLiveStockMap(code,locations) {
    var lat  = (code)?code.latt:27.5706;
    var long  = (code)?code.long:80.0982;
    const zoom = ((locations.length)>20)? 10 : 7;
    var latlng = new google.maps.LatLng( lat,long);
    var map = new google.maps.Map(document.getElementById('map'), {
          center: latlng,
          zoom,
          mapId: "a3efe1c035bad51b", 
          zoomControl: false,
    });
    var markers = [];
    if(locations.length>0){
      var marker, i ,labels;
      var markers=[];
      for (let i = 0; i < locations.length; i++) {
        if(locations[i]['type']=='ett_ivf'){
          var imgcustom  = icon4;
        }
        if(locations[i]['type']=='semen_station' ){
          var imgcustom  = icon5;
        }
        if(locations[i]['type']=='lc_agency'){
          var imgcustom  = icon2;
        }
        if(locations[i]['type']=='bull_mother' ){
          if(locations[i]['district']=='हापुड़' || locations[i]['district']=='ललितपुर' || locations[i]['district']=='बाराबंकी'){
            var imgcustom  = icon3;
          }
          if(locations[i]['district']=='वाराणसी' || locations[i]['district']=='मेरठ' || locations[i]['district']=='सीतापुर'){
            var imgcustom  = icon8;
          }
          if(locations[i]['district']=='इटावा'){
            var imgcustom  = icon9;
          }
          if(locations[i]['district']=='खेरी'){
            var imgcustom  = icon5;
          }
        }
        // console.log('imgcustom',imgcustom)
        if (locations[i]['longitude'] !== "" && locations[i]['lattitute'] !== "") {
          const contentString =
                    '<div id="content">' +
                    '<div id="siteNotice">' +
                    "</div>" +
                    '<div id="bodyContent">' +
                    "<p>  नाम : <b>"+locations[i]['address']+"</b>,</br> " +
                    "</p></div>" +
                    "</div>";
          const infowindow = new google.maps.InfoWindow({
            disableAutoPan: false,
            content: contentString,
          });
          marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i]['lattitute'], locations[i]['longitude']),
            map: map, 
            icon: imgcustom,
          });
            var currentInfowindow = null;
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
              return function() {
                if (currentInfowindow) {
                  currentInfowindow.close();
                }
                infowindow.open(map, marker);
                currentInfowindow = infowindow;
              }
            })(marker, i));
            markers.push(marker);
            google.maps.event.addListener(infowindow, 'closeclick', function() {
              currentInfowindow = null;
            });
        }
      }
    }
    var placeId   = (code)?code.place_id: place_id
    featureLayer = map.getFeatureLayer("ADMINISTRATIVE_AREA_LEVEL_2");
    featureLayer.style = (options) => {
      if (options.feature.placeId == placeId) {
        return featureStyleOptions;
      }
    };
   
}


async function iniPDlabMap(code,locations) {
    var lat    = (code)?code.latt:27.5706;
    var long   = (code)?code.long:80.0982;
    const zoom = ((locations.length)>20)? 10 : 7;
    var latlng =  new google.maps.LatLng( lat,long);
    var map    =  new google.maps.Map(document.getElementById('map'), {
          center: latlng,
          zoom,
          mapId: "a3efe1c035bad51b", 
          zoomControl: false,
    });
    var markers = [];
    if(locations.length>0){
      var marker, i ,labels;
      var markers=[];
      for (let i = 0; i < locations.length; i++) {
        if (locations[i]['longitutde'] !== "" && locations[i]['lattitude'] !== "") {
          const contentString =
                    '<div id="content">' +
                    '<div id="siteNotice">' +
                    "</div>" +
                    '<div id="bodyContent">' +
                    "<p>  नाम : <b>"+locations[i]['name_hindi']+"</b>,</br> " +
                    "<p>  जोन : <b>"+locations[i]['distric']+"</b>,</br> " +
                    "</p></div>" +
                    "</div>";
          const infowindow = new google.maps.InfoWindow({
            disableAutoPan: false,
            content: contentString,
          });
          marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i]['lattitude'], locations[i]['longitutde']),
            map: map, 
            // icon: icon2,
          });
            var currentInfowindow = null;
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
              return function() {
                if (currentInfowindow) {
                  currentInfowindow.close();
                }
                infowindow.open(map, marker);
                currentInfowindow = infowindow;
              }
            })(marker, i));
            markers.push(marker);
            google.maps.event.addListener(infowindow, 'closeclick', function() {
              currentInfowindow = null;
            });
        }
      }
    }
    var placeId   = (code)?code.place_id: place_id
    featureLayer = map.getFeatureLayer("ADMINISTRATIVE_AREA_LEVEL_2");
    featureLayer.style = (options) => {
      if (options.feature.placeId == placeId) {
        return featureStyleOptions;
      }
    };
   
}


async function iniSryoVesselMap(code,locations) {
    var lat    = (code)?code.latt:27.5706;
    var long   = (code)?code.long:80.0982;
    const zoom = ((locations.length)>20)? 10 : 7;
    var latlng =  new google.maps.LatLng( lat,long);
    var map    =  new google.maps.Map(document.getElementById('map'), {
          center: latlng,
          zoom,
          mapId: "a3efe1c035bad51b", 
          zoomControl: false,
    });
    var markers = [];
    if(locations.length>0){
      var marker, i ,labels;
      var markers=[];
      for (let i = 0; i < locations.length; i++) {
        if (locations[i]['longitude'] !== "" && locations[i]['lattitude'] !== "") {
          const contentString =
                    '<div id="content">' +
                    '<div id="siteNotice">' +
                    "</div>" +
                    '<div id="bodyContent">' +
                    "<p>  नाम : <b>"+locations[i]['name_hindi']+"</b>,</br> " +
                    "<p>  जनपद : <b>"+locations[i]['janpad']+"</b>,</br> " +
                    "<p>  तहसील : <b>"+locations[i]['tehsil']+"</b>,</br> " +
                    "</p></div>" +
                    "</div>";
          const infowindow = new google.maps.InfoWindow({
            disableAutoPan: false,
            content: contentString,
          });
          marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i]['lattitude'], locations[i]['longitude']),
            map: map, 
            icon: icon2,
          });
            var currentInfowindow = null;
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
              return function() {
                if (currentInfowindow) {
                  currentInfowindow.close();
                }
                infowindow.open(map, marker);
                currentInfowindow = infowindow;
              }
            })(marker, i));
            markers.push(marker);
            google.maps.event.addListener(infowindow, 'closeclick', function() {
              currentInfowindow = null;
            });
        }
      }
    }
    var placeId   = (code)?code.place_id: place_id
    featureLayer = map.getFeatureLayer("ADMINISTRATIVE_AREA_LEVEL_2");
    featureLayer.style = (options) => {
      if (options.feature.placeId == placeId) {
        return featureStyleOptions;
      }
    };
   
}

initMapDefault();
async function initMapDefault() {
  $('.page-loader').fadeOut('slow');
  $.ajax({
        type: "GET",
        url: "https://nominatim.openstreetmap.org/search.php?q=Uttar%20pradesh%20%2C%20India&polygon_geojson=1&format=jsonv2",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            "_token": "{{ csrf_token() }}",
        },
        cache: false,
        success: function(data) {
          var cordinates = [];
          if(data){
            $('.page-loader').hide();
            const map = L.map('map-up').setView([data[0].lat,data[0].lon], 6); 
            cordinates = data[0].geojson?.coordinates[0];
            // L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png?lang=hi',{ //style URL
            L.tileLayer('https://tile.openstreetmap.de/{z}/{x}/{y}.png?lang=hi',{ //style URL
              tileSize: 512,
              zoomOffset: -1,
              minZoom: 4,
              maxZoom: 15,
              attribution: "",
              crossOrigin: true
            }).addTo(map);
              L.geoJSON({
                  'type': 'Feature',
                  'geometry': {
                      'type': 'Polygon',
                      'coordinates': [
                        cordinates[0]
                    ]
                  }
            }, {
            style: {
            color: "#ea7327",
            opacity: 1.0,
            fillColor: "#ea7327",
            fillOpacity: 0.8
            }
            }).addTo(map);
          }
        
        }
    });

}


</script>
 @endsection 