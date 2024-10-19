@extends('master')
@section('content')

<style>
    .animal-section {
        width: 100%;
    }

    .animal-section img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 10px;
    }

    .animal-section p {
        margin: 8px 0;
        text-align: center;
        font-weight: 600;
    }
</style>

<div class="container main-div py-5" style="background-color:white; height: 100%;">
    <h3 class="text-center fw-bold"><span data-hi="उत्तर प्रदेश की गाय और भैंस की नस्लें" data-en="Cattle & Buffalo Breeds of Uttar Pradesh"></span> </h1>
    <div class="row">
        <section class="py-4">
            <div class="container">
            <div class="card p-4 rounded mb-3">
                    <h4 class="mb-4"><b>Cattle Breeds</b></h4>
                <div class="row g-4">
                    <div class="col-md-4 col-lg-4 col-xl-3">
                        <div class="animal-section">
                            <img src="{{ asset('cattleBuffalo/1.avif')}}" alt="...">
                            <p><span data-hi="सहिवाल" data-en="Sahiwal"></span></p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 col-xl-3">
                        <div class="animal-section">
                            <img src="{{ asset('cattleBuffalo/2.avif')}}" alt="...">
                            <p><span data-hi="गंगातिरी" data-en="Gangatiri"></span></p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 col-xl-3">
                        <div class="animal-section">
                            <img src="{{ asset('cattleBuffalo/3.avif')}}" alt="...">
                            <p><span data-hi="गिर" data-en="Gir"></span></p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 col-xl-3">
                        <div class="animal-section">
                            <img src="{{ asset('cattleBuffalo/4.avif')}}" alt="...">
                            <p><span data-hi="केनकाथा" data-en="Kenkatha"></span></p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 col-xl-3">
                        <div class="animal-section">
                            <img src="{{ asset('cattleBuffalo/5.avif')}}" alt="...">
                            <p><span data-hi="केरीगढ़" data-en="Kerigarh"></span></p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 col-xl-3">
                        <div class="animal-section">
                            <img src="{{ asset('cattleBuffalo/6.avif')}}" alt="...">
                            <p><span data-hi="मेवाती" data-en="Mewati"></span></p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 col-xl-3">
                        <div class="animal-section">
                            <img src="{{ asset('cattleBuffalo/7.avif')}}" alt="...">
                            <p><span data-hi="पोंवार" data-en="Ponwar"></span></p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 col-xl-3">
                        <div class="animal-section">
                            <img src="{{ asset('cattleBuffalo/8.avif')}}" alt="...">
                            <p><span data-hi="मुर्राह" data-en="Murrah"></span></p>
                        </div>
                    </div>
                </div>
                </div>
                <div class="card p-4 rounded  mb-3">
                    <h4 class="mb-4"><b>Buffalo Breeds</b></h4>
                    <div class="row g-4">
                        <div class="col-md-4 col-lg-4 col-xl-3">
                            <div class="animal-section">
                                <img src="{{ asset('cattleBuffalo/b1.avif')}}" alt="...">
                                <p><span data-hi="भदावारी" data-en="Bhadawari"></span></p>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-xl-3">
                            <div class="animal-section">
                                <img src="{{ asset('cattleBuffalo/b2.avif')}}" alt="...">
                                <p><span data-hi="मुर्राह" data-en="Murrah"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection