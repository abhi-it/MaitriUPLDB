@push('head-style')

<style type="text/css">
    #map {

        height: 700px;

    }

    .price-tag {
        background-color: #ff6300db;
        border-radius: 8px;
        color: #000000;
        font-size: 14px;
        padding: 5px 8px;
        position: relative;
        opacity: 1;
    }

    .price-tag::after {
        content: "";
        position: absolute;
        left: 50%;
        top: 100%;
        transform: translate(-50%, 0);
        width: 0;
        height: 0;
        border-left: 8px solid transparent;
        border-right: 8px solid transparent;
        border-top: 8px solid #db671d87;
        /* Match the background color with transparency */
    }

    [class$=api-load-alpha-banner] {
        display: none;
    }


    .image-icon {
        height: 40px;
        width: 40px;
        object-fit: contain;
    }
</style>

@endpush

<div class="container mt-5">

    <div x-data="init()">
        <span><b x-text="q"></b></span>
    </div>


    <center>
        <h2>गोकुल मिशन मानचित्र</h2>
    </center>

    <div id="map"></div>
    @include('bladeJS.mapJs')
</div>


