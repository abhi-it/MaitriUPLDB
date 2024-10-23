@extends('master')
@section('content')
    <style>
        .search__button {
            display: flex;
            align-items: flex-end;
            gap: 10px;
        }

        /* label container */
        .radio-button-container {
            color: rgba(0, 0, 0, 0.75);
            display: block;
            position: relative;
            padding-left: 55px !important;
            line-height: 25px;
            margin-bottom: 12px;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            /* margin-left: 30px; */
            cursor: pointer;
            font-size: 18px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* Hide the browser's default radio button */
        .radio-button-container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        /* Create a custom radio button */
        .checkmarkradio {
            position: absolute;
            top: 0;
            left: 15px;
            margin: auto;
            bottom: 0;
            height: 25px;
            width: 25px;
            background-color: #fff;
            border-radius: 50%;
            border: 2px solid #EA7327;
            transition: all 0.3s;
        }

        /* On mouse-over, add a grey background color */
        .radio-button-container:hover input~.checkmarkradio {
            border-color: #EA7327;
        }

        /* When the radio button is checked */
        .radio-button-container input:checked~.checkmarkradio {
            background-color: #EA7327;
            border-color: #EA7327;
        }


        /* Create the indicator (the dot/circle - hidden when not checked) */
        .checkmarkradio:after {
            content: "";
            position: absolute;
            display: none;
        }

        /* Show the indicator (dot/circle) when checked */
        .radio-button-container input:checked~.checkmarkradio:after {
            display: block;
        }

        /* Style the indicator (dot/circle) */
        .radio-button-container .checkmarkradio:after {
            position: absolute;
            top: -4px;
            left: 0;
            width: 6px;
            height: 13px;
            border: solid #ffffff;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
            right: 0;
            bottom: 0;
            margin: auto;
        }

        .custom-radio-container {
            max-width: 1100px;
            margin: auto;
        }
    </style>

    <div x-data="deoUser()" class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
        <h3 class="text-center m-4 fw-bold"> <span data-hi="ज़िला आईडी बनाएं" data-en="Create District ID"></span> </h3>
        <div class="custom-radio-container">
            <div class="row">
                <div class="col-md-12">

                    <h5 class="m-4 fw-bold"> <span data-hi="जोन चुनें" data-en="Select Zone"></span> </h5>

                    <div x-show="errorMessage" class="alert alert-danger" role="alert" style="display: none;">
                        <span x-text="errorMessage"></span>
                    </div>
                    <template x-for="(error, index) in objectErrorMessage" :key="index">
                        <div class="alert alert-danger" role="alert">
                            <span x-text="error"></span>
                        </div>
                    </template>

                    <div class="row">
                        <template x-for="(zone, index) in zones" :key="index">
                            <div class="col-md-4">
                                <div class="custom-radio">
                                    <label class="radio-button-container">
                                        <span :for="'zone' + zone.id" :data-hi="zone.name_hi" :data-en="zone.name_en"
                                            x-text="localStorage.getItem('selectedProject') === 'en' ? zone.name_en : zone.name_hi"></span>
                                        <input type="radio" class="zone_radios" name="zone" :id="'zone' + zone.id"
                                            :value="zone.id" x-on:click="getZoneDistrict(zone.id)">
                                        <span class="checkmarkradio"></span>
                                    </label>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="row mt-5">
                        <div class="col-md-3">
                            <div x-show="selectedDistricts.length > 0">
                                <h5 class="m-4 fw-bold"> <span data-hi="डिस्ट्रिक्ट चुनें" data-en="Select District"></span>
                                </h5>
                                <template x-for="(district, index) in selectedDistricts" :key="index">
                                    <div class="custom-radio">
                                        <label class="radio-button-container">
                                            <span :for="'district' + district.id" :data-hi="district.name_hindi"
                                                :data-en="district.name_eng"
                                                x-text="localStorage.getItem('selectedProject') === 'en' ? district.name_eng : district.name_hindi"></span>
                                            <input type="radio" name="district" :id="'district' + district.id"
                                                :value="district.id">
                                            <span class="checkmarkradio"></span>
                                        </label>
                                    </div>
                                </template>
                            </div>
                            <button class="btn btn-primary mb-4" x-on:click="createDEOUser()">Create</button>
                        </div>
                    </div>


                </div>
            </div>
        </div>



    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>
        function deoUser() {
            return {
                init() {
                    console.log(this.districts, 'this.districts');

                    setInterval(() => {
                        this.errorMessage = '';
                        this.objectErrorMessage = {};
                    }, 5000);
                },
                zones: @json($zones),
                selectedDistricts: [],
                
                errorMessage: '',
                objectErrorMessage: {},
                getZoneDistrict(zoneId) {

                    console.log(zoneId, 'zoneId');

                    axios.get('{{ route('get-all-zone-district') }}', {
                            params: {
                                zone_id: zoneId
                            }
                        })
                        .then(response => {
                            this.selectedDistricts = response.data.district;
                            setTimeout(() => {
                                this.selectedDistricts.forEach(district => {
                                    let radio = document.getElementById('district' + district.id);
                                    if (radio) {
                                        radio.checked = false;
                                    }
                                });
                            }, 100);
                        })
                        .catch(error => {
                            console.error('There was an error fetching the divisions!', error);
                        });
                },
                createDEOUser() {

                    const selectedZoneValue = this.getSelectedValue('zone');
                    if (!selectedZoneValue) {
                        this.errorMessage = 'Please select a zone';
                        return;
                    }

                    const selectedDistrictValue = this.getSelectedValue('district');
                    if (!selectedDistrictValue) {
                        this.errorMessage = 'Please select a district';
                        return;
                    }

                   

                    axios.post('{{ route('district-Operator-store-step1') }}', {
                            zone: selectedZoneValue,
                            district: selectedDistrictValue,
                        })
                        .then(response => {
                            // handle success
                            console.log(response.data);
                            window.location.href = '{{ route('deo-district-user-step2') }}';
                            if (response.status === 200) {
                                window.location.href = '{{ route('deo-district-user-step2') }}';
                            }
                            // You can redirect or show a success message here
                        })
                        .catch(error => {
                            console.log(error.response.data.errors, 'error');
                            this.objectErrorMessage = error.response.data.errors;

                            // handle error
                            // console.error(error);
                            // this.errorMessage = 'An error occurred while creating the DEO user. Please try again.';
                        });

                },
                getSelectedValue(name) {
                    const selectedRadio = document.querySelector(`input[name="${name}"]:checked`);
                    return selectedRadio ? selectedRadio.value : null;
                }

            }
        }
    </script>
@endsection
