<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="csrf-token">
    <title> राष्ट्रीय गोकुल मिशन</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="shortcut icon" href="{{ asset('assets') }}/favicon.ico">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css" />
    <!-- <link href="{{ asset('') }}css/custom.css" rel="stylesheet" type="text/css"> -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/navbar.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="{{ asset('js/jquery-3.6.min.js') }}"></script>
    <script src="{{ asset('js/font-size.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bgcolor.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/account.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery.validate.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/additional-methods.min.js?ver=1.0') }}" type="text/javascript"></script>
    <script type="text/javascript"
        src="https://maps.google.com/maps/api/js?key={{ env('AIzaSyABHXJPN6L8-6nqf4uUekwdoQBPeHLYe60') }}&callback=initMap">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.5.1/axios.min.js"
        integrity="sha512-emSwuKiMyYedRwflbZB2ghzX8Cw8fmNVgZ6yQNNXXagFzFOaQmbvQ1vmDkddHjm5AITcBIZfC7k4ShQSjgPAmQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <!--Data Table---->

    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />

    <!-- New Export Data CDN Start -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/2.3.3/css/buttons.dataTables.min.css" />
    <!-- New Export Data CDN Start -->

    <link href="{{ asset('') }}css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
    <script src="{{ asset('') }}js/jquery.dataTables.min.js" type="text/javascript"></script>

    <link href="{{ asset('') }}css/jquery-ui.css" rel="stylesheet" type="text/css">
    <script src="{{ asset('') }}js/jquery-ui.js" type="text/javascript"></script>
    <style>
    /* ---f--- */
    .footer_parent {
        background-color: #f93;
        color: #000;
        padding-top: 7rem;
        margin-top: 9rem
    }

    .footer_top_footer__u_0LC {
        background: #a6dafa;
        color: #000;
        width: 80%;
        padding: 1rem 2rem;
        border-radius: 1rem;
        box-shadow: 2px 2px 5px 0 #2b2b2b;
        margin: -220px auto 0;
    }

    @media (max-width: 768px) {
        .footer_top_footer__u_0LC {
            padding: 1rem !important;
            width: 90% !important;
        }

        .footer_top_footer__u_0LC P {
            text-align: left;
        }
    }

    .footer_footer__O h3 {
        border-bottom: 2px solid #e47302;
        padding-bottom: 5px
    }

    .footer_footer__O a {
        text-decoration: none;
        color: #fff !important;
    }

    .footer_footer__O ul li:not(:last-child) {
        border-bottom: 1px solid #ffffff42
    }

    .footer_rightContent {
        background-color: #e47302;
        color: #fff;
    }

    .footer_rightContent span {
        padding: .15rem .5rem;
        font-size: 1.2rem;
        letter-spacing: 3px;
        background: #000;
    }

    .footer_footer__O a:hover {
        text-decoration: none;
        color: #fff !important;
    }

    .footer--list li a {
        color: #fff !important;
    }

    .footer--list li:before {
        border-right: 2px solid #fff !important;
        border-bottom: 2px solid #fff !important;
    }

    .footer--heading {
        color: #fff !important;
    }

    #error_b02bbc85a30c7c9a99711a8a93df17b315b95524 {
        display: none !important;
    }

    .footer-counter a {
        pointer-events: none;
    }

    .dropdown-toggle {
        white-space: normal;
    }

    header .navbar li.nav-item.active a.nav-link {
        color: #292b2c !important
    }


    .glow-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    /* padding: var(--badge-padding); */
    /* border-radius: var(--badge-radius); */
    /* background: linear-gradient(180deg, rgba(255,255,255,0.04), rgba(0,0,0,0.05)); */
    position: relative;
    isolation: isolate; /* keeps glow contained visually */
    cursor: default;
    user-select: none;
  }

  /* The visible pill */
  .glow-badge__pill {
  
  background-color: #18191f;
  color: #fff;
  /* box-shadow: 2px 2px 2px #00000080, 10px 1px 12px #00000080,
    2px 2px 10px #00000080, 2px 2px 3px #00000080, inset 2px 2px 10px #00000080,
    inset 2px 2px 10px #00000080, inset 2px 2px 10px #00000080,
    inset 2px 2px 10px #00000080; */
  border-radius: 29px;
  padding: 1px 8px;
  margin: 0 0px;
  animation: animate 3s linear infinite;
  text-shadow: 0 0 50px #0072ff, 0 0 100px #0072ff, 0 0 150px #0072ff,
    0 0 200px #0072ff;
    font-size: 11px;
  }
.glow_badge__pill{
     animation-delay: 0.1s;
}

@keyframes animate {
  0% {
  background-color: #000000;
  }
25% {
     background-color: #ff0000;
  }
  50% {
     background-color: #0400ff;
  }
   75% {
     background-color: #004d11;
  }
  100% {
   background-color: #57009eff;
  }
}

    </style>
    @php
    use App\Models\Setting;
    $settings = Setting::first();
    @endphp
    <script>
    $(document).ready(function() {
        var minDate = "{{ \Carbon\Carbon::parse($settings->start_date)->format('d-m-Y') }}";
        var maxDate = "{{ \Carbon\Carbon::parse($settings->end_date)->format('d-m-Y') }}";

        var currentDate = new Date();
        var currentYear = currentDate.getFullYear();
        var currentMonth = currentDate.getMonth() + 1;
        var previousDate = new Date(currentYear, 8, 30);

        var previousDateFormatted = ("0" + previousDate.getDate()).slice(-2) + "-" + ("0" + (previousDate
            .getMonth() + 1)).slice(-2) + "-" + currentYear;

        $("#dob").datepicker({
            dateFormat: 'dd-mm-yy',
            changeYear: true,
            changeMonth: true,
            minDate: minDate, // Use 'dd-mm-yy' format
            maxDate: maxDate, // Use 'dd-mm-yy' format
            onSelect: function() {
                $(this).valid();
            }
        });


        $("#date").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true
        });

        $("#start_date").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            // yearRange: "-0:+1",
        });

        $("#end_date").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            // yearRange: "+0:+1",
        });

    });
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
        $.validator.addMethod('date', function(value, element, param) {
            return (value != 0) && (value <= 31) && (value == parseInt(value, 10));
        }, 'Please enter a valid date!');
        $.validator.addMethod('month', function(value, element, param) {
            return (value != 0) && (value <= 12) && (value == parseInt(value, 10));
        }, 'Please enter a valid month!');
        $.validator.addMethod('year', function(value, element, param) {
            return (value != 0) && (value >= 1900) && (value == parseInt(value, 10));
        }, 'Please enter a valid year not less than 1900!');
        $.validator.addMethod('username', function(value, element, param) {
            var nameRegex = /^[a-zA-Z0-9]+$/;
            return value.match(nameRegex);
        }, 'Only a-z, A-Z, 0-9 characters are allowed');
        $.validator.addMethod("checkFileSize", function(value, element, param) {
            if (value != '') {

                FileSize = element.files[0].size;

                if (FileSize > param)
                    return false;
                return true;
            } else {
                return true;
            }
        }, "File size must be less than or equal to 100 KB.");

        $.validator.addMethod("checkFileSize20KB", function(value, element, param) {

            if (value != '') {
                FileSize = element.files[0].size;

                if (FileSize > param)
                    return false;
                return true;
            } else {
                return true;
            }
        }, "File size must be less than or equal to 20 KB.");

        $.validator.addMethod("uploadTrainingCertificate", function(value, element) {

            var month = $("#training_certificate_period_in_month")[0].selectedIndex;
            var day = $("#training_certificate_period_in_days")[0].selectedIndex;
            var name = $('#training_certificate').val().split('\\').pop();
            training_certificate_name = name.split('.')[0];


            if (training_certificate_name == '' && (month >= 1 || day >= 1)) {
                return false;
            }

            return true;

        }, "Please upload training certificate");

        $.validator.addMethod("selectMonthORday", function(value, element) {

            var month = $("#training_certificate_period_in_month")[0].selectedIndex;
            var day = $("#training_certificate_period_in_days")[0].selectedIndex;
            var name = $('#training_certificate').val().split('\\').pop();
            training_certificate_name = name.split('.')[0];

            if (training_certificate_name != '' && (month < 1 && day < 1)) {
                return false;
            }

            return true;

        }, "Please select month or day");

        $.validator.addMethod("verifyHighSchoolMarks", function(value, element) {

            var high_marks = $("#high_marks").val();
            var high_total_marks = $("#high_total_marks").val();

            if (high_marks != '' && high_total_marks != '') {
                if (parseInt(high_marks) > parseInt(high_total_marks)) {
                    return false;
                }
            }
            return true;
        }, "Enter valid marks");


        $.validator.addMethod("verifyInterMarks", function(value, element) {

            var inter_marks = $("#inter_marks").val();
            var inter_total_marks = $("#inter_total_marks").val();

            if (inter_marks != '' && inter_total_marks != '') {
                if (parseInt(inter_marks) > parseInt(inter_total_marks)) {
                    return false;
                }
            }

            return true;

        }, "Enter valid marks");


        $.validator.addMethod("checkCategory", function(value, element) {

            var category = $("#category")[0].selectedIndex;
            var day = $("#training_certificate_period_in_days")[0].selectedIndex;
            var name = $('#caste_certificate').val().split('\\').pop();
            caste_certificate_name = name.split('.')[0];
         
            if (caste_certificate_name == '' && (category == 3 || category == 4)) {
                return false;
            } else {
                return true;
            }

        }, "Please upload caste certificate");



        // $.validator.addMethod("checkDOB", function(value, element) {

        //     var userinput = document.getElementById("dob").value;
        //     var dob = new Date(userinput);
        //     var month_diff = new Date('{{ @$ageCalcultedFrom }}') - dob.getTime();
        //     var age_dt = new Date(month_diff);
        //     var year = age_dt.getUTCFullYear();
        //     var age = Math.abs(year - 1970);

        //     if (age < 18) {
        //         return false
        //         ;
        //     }
        //     return true;
        // }, "आप पात्र नहीं हैं! आयु न्यूनतम 18 वर्ष होनी चाहिए");


        // new


        $.validator.addMethod("checkDOB", function (value, element) {
            var userinput = document.getElementById("dob").value;
            var age = moment().diff(moment(userinput, 'DD-MM-YYYY'), 'years');

            // Check if age is between 18 and 40 (inclusive)
            if (age >= 18 && age <= 40) {
                return true;
            }
            return false;

        }, "आप पात्र नहीं हैं! आयु 18 वर्ष से 40 वर्ष के बीच होनी चाहिए");


        // $.validator.addMethod("checkDOB", function(value, element) {
        //     var userinput = $(element).val();
        //     var age = moment().diff(moment(userinput, 'DD-MM-YYYY'), 'years');
        //     return age >= 18;
        // }, "आप पात्र नहीं हैं! आयु न्यूनतम 18 वर्ष होनी चाहिए");

        // $.validator.addMethod("checkDOB", function(value, element) {
        //     var userinput = $(element).val();
        //     var age = moment().diff(moment(userinput, 'DD-MM-YYYY'), 'years');
        //     return age >= 18 || age <= 40;

        // }, "आप पात्र नहीं हैं! आयु 18 वर्ष से 40 वर्ष के बीच होनी चाहिए");



        /*---------Add Avedan From Validations Start-----------------------------*/
        var val = {
            // Specify validation rules
            rules: {
                "training_certificate_period_in_month": {
                    uploadTrainingCertificate: true,
                    selectMonthORday: true,
                },
                "dob": {
                    required: true,
                    checkDOB: true,
                },
                applicant_name: "required",
                yojna_name_for_training: "required",
                AIkit: "required",
                coption: "required",
                tc: "required",
                category: "required",
                fname: "required",
                mother: "required",
                mobile: {
                    required: true,
                    number: true,
                    minlength: 10,
                    maxlength: 10,

                },
                address_number: "required",
                address_type: "required",
                // post_office: "required",
                pincode: "required",
                gender: "required",
                permanent_address: "required",
                // gram_panchayat_name: "required",
                // vikas_khand: "required",
                janpad: "required",
                bank_name: "required",
                account_number: "required",
                ifsc_code: "required",
                // pfms: "required",
                // letter_address: "required",
                high_board_name: "required",
                high_passing_year: "required",
                "high_marks": {
                    required: true,
                    verifyHighSchoolMarks: true,
                },
                high_total_marks: "required",
                high_percentage: "required",

                inter_board_name: "required",
                inter_passing_year: "required",
                "inter_marks": {
                    required: true,
                    verifyInterMarks: true,
                },
                inter_total_marks: "required",
                inter_percentage: "required",


                "permanent_address_proof": {
                    required: true,
                    extension: "pdf|PDF|png|PNG|jpg|JPG|jpeg|JPEG",
                    checkFileSize: 2097152,
                },
                "applicant_photo": {
                    required: true,
                    extension: "pdf|PDF|png|PNG|jpg|JPG|jpeg|JPEG",
                    checkFileSize20KB: 2097152,
                },
                "signature": {
                    required: true,
                    extension: "pdf|PDF|png|PNG|jpg|JPG|jpeg|JPEG",
                    checkFileSize20KB: 2097152,
                },
                "high_marksheet": {
                    required: true,
                    extension: "png|PNG|jpg|JPG|jpeg|JPEG",
                    checkFileSize: 2097152,
                },
                "high_certificate": {
                    required: true,
                    extension: "png|PNG|jpg|JPG|jpeg|JPEG",
                    checkFileSize: 2097152,
                },

                "inter_marksheet": {
                    required: true,
                    extension: "png|PNG|jpg|JPG|jpeg|JPEG",
                    checkFileSize: 2097152, //100000
                },
                "inter_certificate": {
                    required: true,
                    extension: "png|PNG|jpg|JPG|jpeg|JPEG",
                    checkFileSize: 2097152,
                },

                "graduation_marksheet": {
                    extension: "png|PNG|jpg|JPG|jpeg|JPEG",
                    checkFileSize: 2097152,
                },
                "graduation_certificate": {
                    extension: "png|PNG|jpg|JPG|jpeg|JPEG",
                    checkFileSize: 2097152,
                },

                "postgraduation_marksheet": {
                    extension: "png|PNG|jpg|JPG|jpeg|JPEG",
                    checkFileSize: 2097152,
                },
                "postgraduation_certificate": {
                    extension: "png|PNG|jpg|JPG|jpeg|JPEG",
                    checkFileSize: 2097152,
                },

                "training_certificate": {
                    required: true,
                    extension: "png|PNG|jpg|JPG|jpeg|JPEG",
                    checkFileSize: 2097152,
                },
                "id_upload": {
                    required: true,
                    extension: "png|PNG|jpg|JPG|jpeg|JPEG",
                    checkFileSize: 2097152,
                },
                "health_certificate": {
                    // required: true,
                    extension: "png|PNG|jpg|JPG|jpeg|JPEG",
                    checkFileSize: 2097152,
                },
                "caste_certificate": {
                    // required: true,
                    checkCategory: true,
                    extension: "png|PNG|jpg|JPG|jpeg|JPEG",
                    checkFileSize: 2097152,
                },
                nationality: "required",
                declaration: "required",
            },

        }
        $("#myForm").multiStepForm({
            // defaultStep:0,
            beforeSubmit: function(form, submit) {
                console.log("called before submiting the form");
                console.log(form);
                console.log(submit);
            },
            validations: val,
        }).navigateTo(0);
        /*---------Add Avedan From Validations End-------------------------------*/



        /*---------Edit Avedan From Validations Start-----------------------------*/
        var valAvedanEdit = {
            // Specify validation rules
            rules: {
                applicant_name: "required",
                category: "required",
                fname: "required",
                /*email: {
                    required: true,
                    email: true
                },*/
                mobile: {
                    required: true,
                    number: true,
                    minlength: 10,
                    maxlength: 10,

                },
                dob: "required",
                address_type: "required",
                post_office: "required",
                pincode: "required",
                gender: "required",
                permanent_address: "required",
                "permanent_address_proof": {
                    //required:true,
                    //extension: "pdf|PDF|png|PNG|jpg|JPG|jpeg|JPEG",
                    //checkFileSize: 100000,
                },
                gram_panchayat_name: "required",
                vikas_khand: "required",
                janpad: "required",
                letter_address: "required",
                "applicant_photo": {
                    //required:true,
                    extension: "pdf|PDF|png|PNG|jpg|JPG|jpeg|JPEG",
                    checkFileSize20KB: 20000,
                },
                "signature": {
                    //required:true,
                    extension: "pdf|PDF|png|PNG|jpg|JPG|jpeg|JPEG",
                    checkFileSize20KB: 20000,
                },
                high_board_name: "required",
                high_passing_year: "required",
                high_marks: "required",
                high_total_marks: "required",
                high_percentage: "required",
                inter_board_name: "required",
                inter_passing_year: "required",
                inter_marks: "required",
                inter_total_marks: "required",
                inter_percentage: "required",
                "training_certificate": {
                    //required:true,
                    extension: "pdf|PDF|png|PNG|jpg|JPG|jpeg|JPEG",
                    checkFileSize: 2097152,
                },
                "id_upload": {
                    //required:true,
                    extension: "pdf|PDF|png|PNG|jpg|JPG|jpeg|JPEG",
                    checkFileSize: 2097152,
                },
                "health_certificate": {
                    // required: true,
                    extension: "png|PNG|jpg|JPG|jpeg|JPEG",
                    checkFileSize: 2097152,
                },
                "caste_certificate": {
                    // required:true,
                    extension: "pdf|PDF|png|PNG|jpg|JPG|jpeg|JPEG",
                    checkFileSize: 2097152,
                },
                "high_marksheet": {
                    //required:true,
                    extension: "pdf|PDF|png|PNG|jpg|JPG|jpeg|JPEG",
                    checkFileSize: 2097152,
                },
                "high_certificate": {
                    //required:true,
                    extension: "pdf|PDF|png|PNG|jpg|JPG|jpeg|JPEG",
                    checkFileSize: 2097152,
                },
                "inter_marksheet": {
                    //required:true,
                    extension: "pdf|PDF|png|PNG|jpg|JPG|jpeg|JPEG",
                    checkFileSize: 2097152,
                },
                "inter_certificate": {
                    //required:true,
                    extension: "pdf|PDF|png|PNG|jpg|JPG|jpeg|JPEG",
                    checkFileSize: 2097152,
                },
                nationality: "required",
                is_approved: "required",
                //training_certificate_period_in_month: "required",
                //training_certificate_period_in_days: "required",
            },

        }
        $("#avedanEdit").multiStepForm({
            // defaultStep:0,
            beforeSubmit: function(form, submit) {
                console.log("called before submiting the form");
                console.log(form);
                console.log(submit);
            },
            validations: valAvedanEdit,
        }).navigateTo(0);
        /*---------Edit Avedan From Validations End-------------------------------*/



    });

    (function($) {
        $.fn.multiStepForm = function(args) {
            if (args === null || typeof args !== 'object' || $.isArray(args))
                throw " : Called with Invalid argument";
            var form = this;
            var tabs = form.find('.tab');
            var steps = form.find('.step');
            steps.each(function(i, e) {
                $(e).on('click', function(ev) {});
            });
            form.navigateTo = function(i) {
                /*index*/
                /*Mark the current section with the class 'current'*/
                tabs.removeClass('current').eq(i).addClass('current');
                // Show only the navigation buttons that make sense for the current section:
                form.find('.previous').toggle(i > 0);
                atTheEnd = i >= tabs.length - 1;
                form.find('.next').toggle(!atTheEnd);
                // console.log('atTheEnd='+atTheEnd);
                form.find('.submit').toggle(atTheEnd);
                fixStepIndicator(curIndex());
                return form;
            }

            function curIndex() {
                /*Return the current index by looking at which section has the class 'current'*/
                return tabs.index(tabs.filter('.current'));
            }

            function fixStepIndicator(n) {
                steps.each(function(i, e) {
                    i == n ? $(e).addClass('active') : $(e).removeClass('active');
                });
            }
            /* Previous button is easy, just go back */
            form.find('.previous').click(function() {
                form.navigateTo(curIndex() - 1);
            });

            /* Next button goes forward iff current block validates */
            form.find('.next').click(function() {

                if ('validations' in args && typeof args.validations === 'object' && !$.isArray(args
                        .validations)) {
                    if (!('noValidate' in args) || (typeof args.noValidate === 'boolean' && !args
                            .noValidate)) {
                        form.validate(args.validations);
                        if (form.valid() == true) {
                            form.navigateTo(curIndex() + 1);


                            /*-------------------Start Call Ajax Here to Save Data on each next button-------------*/
                            //var form_data = $(this).parents('form').serialize();
                            var form_data = new FormData($(this).closest('#myForm').get(0));
                            //alert(form_data);
                            //var colage = $('[name="colage"]').val();
                            //var spichelest = $('[name="spichelest"]').val();
                            //alert($('[name="yojna_name_for_training"]').val());
                            $.ajax({
                                url: 'getTempData',
                                method: "POST",
                                data: form_data,
                                success: function(data) {
                                    //console.log(data);
                                },
                                cache: false,
                                contentType: false,
                                processData: false
                            });
                            /*-------------------End Call Ajax Here to Save Data on each next button-------------*/
                            /*Start Getting Declaration Data------------------------*/
                            $('#applicant_named').html($('#applicant_name').val());
                            $('#fnamed').html($('#fname').val());
                            $('#janpad_gram').html($('#janpad').find('option:selected').text());
                            $('#gram_panchayat_named').html($('#gram_panchayat_name').val());
                            $('#vikas_khandd').html($('#vikas_khand').val());
                            $('#janpadd').html($('#janpad').find('option:selected').text());
                            $('#janpaddD').html($('#janpad').find('option:selected').text());
                            /*Start Getting Declaration Data------------------------*/

                            return true;
                        }
                        return false;
                    }
                }
                form.navigateTo(curIndex() + 1);
            });
            form.find('.submit').on('click', function(e) {
                if (typeof args.beforeSubmit !== 'undefined' && typeof args.beforeSubmit !== 'function')
                    args.beforeSubmit(form, this);
                /*check if args.submit is set false if not then form.submit is not gonna run, if not set then will run by default*/
                if (typeof args.submit === 'undefined' || (typeof args.submit === 'boolean' && args
                        .submit)) {
                    $('#finalSubmit').hide();
                    $('#loader').show();
                    form.submit();
                }
                return form;
            });
            /*By default navigate to the tab 0, if it is being set using defaultStep property*/
            typeof args.defaultStep === 'number' ? form.navigateTo(args.defaultStep) : null;
            form.noValidate = function() {

            }
            return form;
        };
    }(jQuery));
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#district_id, #caste').change(function() {
            var district_id = $("#district_id").val();
            var category = $("#caste").val();
            var institute_id = $("#instituteID").val();


            if (district_id != '' && category != '') {
                $("#responseID").html('');
                $(".loader").show();

                $.ajax({ //create an ajax request to display.php
                    type: "GET",
                    url: "{{ url('/getAvedanData') }}?district_id=" + district_id +
                        '&category=' + category + '&institute_id=' + institute_id,
                    //dataType: "text",
                    success: function(response) {

                        $("#responseID").html(response);
                        $(".loader").hide();
                        //alert(response);
                    }
                });
            }
        });

        $('#myTable').DataTable({
            "pageLength": 25,
            "ordering": false,
            "oLanguage": {
                "sInfo": "कुल आवेदन मैत्री :  _TOTAL_",
                "sLengthMenu": "देखें  _MENU_ आवेदन",
                "sSearch": "आवेदन को खोजें :",
                "infoEmpty": "कोई आवेदन नहीं है",

            },
            "language": {
                "emptyTable": "कोई आवेदन नहीं है"
            }
        });


        $('#instituteTable').DataTable({
            "pageLength": 25,
            "ordering": false,
            "oLanguage": {
                "sInfo": "कुल संस्थान :  _TOTAL_",
                "sLengthMenu": "देखें  _MENU_ संस्थान",
                "sSearch": "संस्थान को खोजें :",
                "infoEmpty": "कोई संस्थान नहीं है",

            },
            "language": {
                "emptyTable": "कोई संस्थान नहीं है"
            }
        });

    });


    function viewCalculation(id) {
        //$("#responseID").html('');
        //$(".loader").show();
        $('#myModel').modal('show');

        $.ajax({ //create an ajax request to display.php
            type: "GET",
            url: "{{ url('/viewCalculation') }}/" + id,
            //dataType: "text",
            success: function(response) {
                console.log('response', response)

                $("#responseID").html(response);
                //$('#myModel').modal('hide')
                //console.log(response);
            }
        });

    }

    function closemodal() {
        $('#myModel').modal('hide');
    }

    function changeStatus(id, join_status) {
        $("#responseID" + id).html('');
        $(".loader").show();

        $.ajax({
            type: "GET",
            url: "{{ url('/changeStatus') }}/" + id + '/' + join_status,
            success: function(response) {
                $("#responseID" + id).html(response);
                console.log(response);
                $(".loader").hide();
            }
        });
    }
    </script>
</head>

<body class="pb-0">
    <header>
        <div class="top-bar py-2">
            <div class="container">
                <div class="text-end top-bar-content">
                    <span class="d-flex flex-wrap gap-2 justify-content-end align-items-center">
                        <noscript>
                            Javascript Required
                        </noscript>
                        <script type="text/javascript">
                        var d = new Date()
                        var weekday = new Array("Sun", "Mon", "Tue", "Wed", "Thur", "Fri", "Sat")
                        var monthname = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct",
                            "Nov", "Dec")
                        document.write(weekday[d.getDay()] + ", ")
                        document.write(d.getDate() + " ")
                        document.write(monthname[d.getMonth()] + ", ")
                        document.write(d.getFullYear())
                        </script>
                        <span id="clockDisplay">
                            <script type="text/javascript" language="javascript">
                            function renderTime() {
                                var currentTime = new Date();
                                var diem = "AM";
                                var h = currentTime.getHours();
                                var m = currentTime.getMinutes();
                                var s = currentTime.getSeconds();
                                setTimeout('renderTime()', 1000);
                                if (h == 0) {
                                    h = 12;
                                } else if (h > 12) {
                                    h = h - 12;
                                    diem = "PM";
                                }
                                if (h < 10) {
                                    h = "0" + h;
                                }
                                if (m < 10) {
                                    m = "0" + m;
                                }
                                if (s < 10) {
                                    s = "0" + s;
                                }
                                var myClock = document.getElementById('clockDisplay');
                                myClock.textContent = h + ":" + m + ":" + s + " " + diem;
                                myClock.innerText = h + ":" + m + ":" + s + " " + diem;
                            }
                            renderTime();
                            </script>
                        </span>
                        <span class="middle-line">|</span>
                        <select class="switchlang">
                            <option value="hi"> Hindi </option>
                            <option value="en"> English</option>
                        </select>
                        <span class="middle-line">|</span>
                        <span class="social-icon">
                            <a href="https://x.com/i/flow/login?redirect_after_login=%2Fupldblko" target="_blank">
                                <i class="ri-twitter-x-line ri-lg"></i>
                            </a>
                            <a href="https://www.linkedin.com/company/uttar-pradesh-livestock-development-board"
                                target="_blank">
                                <i class="ri-linkedin-line ri-lg"></i>
                            </a>
                            <!-- <i class="ri-instagram-line ri-lg"></i> -->
                            <a target="_blank"
                                href="https://www.facebook.com/people/Uttar-Pradesh-Livestock-Development-Board/61554910544850/">
                                <i class="ri-facebook-circle-line ri-lg"></i>
                            </a>
                            <a href="https://www.youtube.com/@uplivestockdevelopmentboard" target="_blank">
                                <i class="ri-youtube-line ri-lg"></i>
                            </a>
                             <span class="middle-line">|</span>
                            <a href="{{ route('video-gallery') }}">
                                <i class="ri-question-line ri-lg"></i>
                                <span class="text-black" data-hi="सहायता केंद्र" data-en="Help Center"></span>
                            </a>
                        </span>
                        <span class="middle-line">|</span>
                        @if (Route::has('login'))
                        <span>
                            @auth
                            Welcome,&nbsp;{{ Auth::user()->name }} |
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <span data-hi="लॉग आउट" data-en="Logout"></span>
                                &nbsp;</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            @else
                            <a href="{{ route('login') }}" class="text-black">
                                <span data-hi="लॉग इन करें" data-en="Log In"></span> </a> |
                            <a href="{{ route('farmer-login') }}" class="text-black">
                                <span data-hi="किसान लॉगिन" data-en="Farmer Login"></span> </a>
                            @endauth
                        </span>
                        @endif
                </div>
            </div>
        </div>
        <div class="logo-header">
            <div class="container py-3">
                <div class="row g-3 align-items-center">
                    <div class="col-lg-9 col-md-12 col-12">
                        <div
                            class="d-flex flex-wrap align-items-center gap-2 justify-content-md-between justify-content-center">
                            <div class="d-flex align-items-center gap-2 flex-column flex-md-row">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="text-center">
                                        <a href="{{ url('/') }}"> <img src="{{ asset('assets/images/logo.png') }}"
                                                height="100" /></a>
                                    </div>
                                    <span class="middle-line">|</span>
                                    <div class="text-center">
                                        <a href="{{ url('/') }}">
                                            <img src="{{ asset('assets/images/upldb-logo.png')}}" height="100" />
                                        </a>
                                    </div>
                                </div>
                                <div class="text-md-left text-center">
                                    <h1 class="mb-2 fw-bold">
                                        <span data-hi="राष्ट्रीय गोकुल मिशन" data-en="Rashtriya Gokul Mission"></span>
                                    </h1>
                                    <h6>
                                        <span
                                            data-hi="स्वरोजगारी मैत्री (मल्टीपरपज ए0आई0 टेक्निशियन इन रूरल इण्डिया) हेतु ऑनलाइन आवेदन"
                                            data-en="Online Application for Swarojgari Maitri (Multipurpose AI Technician in Rural India)"></span>
                                    </h6>
                                </div>
                            </div>
                            
                            {{--<div class="kumbhlogo">
                                <img src="{{ asset('assets/images/PK25.png')}}" height="100" />
                            </div>--}}
                           
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="d-flex flex-column ">
                            <span>Helpline - <a href="tel:1800-309-1938">1800-309-1938</a></span>
                            <span>Email ID - <a href="mailto:upldbte@gmail.com">upldbte@gmail.com </a></span>
                        </div>
                        {{--<form class="d-flex mt-3" role="search">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-primary" type="submit">
                                Search</button>
                        </form> --}}

                        <form class="d-flex mt-3" role="search" action="{{ route('search') }}" method="GET">
                            <input class="form-control me-2" type="search" name="q" placeholder="Search" aria-label="Search" value="{{ request('q') }}">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-expand-xl m-0 p-0">
            <div class="container-fluid justify-content-end">
                <button class="navbar-toggler my-1 bg-white py-1 px-2" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar"
                    aria-label="Toggle navigation">
                    <i class="ri-menu-3-line"></i>
                </button>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasDarkNavbar"
                    aria-labelledby="offcanvasDarkNavbarLabel">
                    <div class="offcanvas-header">
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-center flex-grow-1">
                            @if (Route::has('login'))
                            @auth


                            <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('/dashboard') }}">
                                    <span data-hi="डैशबोर्ड" data-en="Dashboard"></span>
                                </a>
                            </li>

                            @if (auth()->user()->user_type == 'User')
                            <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('/dashboard') }}">
                                    <span data-hi="संस्थान आवंटन सूची" data-en="Institute Allotment List"></span>
                                </a>
                            </li>
                            @else
                            @if (auth()->user()->user_type == 'Director')
                            <li
                                class="nav-item dropdown {{ (request()->is('avedan') || request()->is('avedan-districtwise')) ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false" key="SCHEME">
                                    <span data-hi="नये आवेदन मैत्री" data-en="New Applications"></span>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ url('avedan') }}">
                                        <span data-hi="नये आवेदन मैत्री" data-en="New Applications Maitri"></span>
                                    </a>
                                    <a class="dropdown-item" href="{{ url('avedan-districtwise') }}">
                                        <span data-hi="नये आवेदन मैत्री जनपद वार"
                                            data-en="New Applications Maitri District Wise"></span>
                                    </a>
                                </div>
                            </li>
                            @else
                            <li class="nav-item {{ request()->is('avedan') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('avedan') }}">
                                    <span data-hi="नये आवेदन मैत्री" data-en="New Applications Maitri"></span>
                                </a>
                            </li>
                            @endif
                            @if (auth()->user()->user_type != 'District Officer')
                            <li class="nav-item {{ request()->is('total-avedan') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('total-avedan') }}">
                                    <span data-hi="कुल आवेदन मैत्री" data-en="Total Applications Maitri"></span>

                                </a>
                            </li>
                            @endif

                            @if (auth()->user()->user_type == 'District Officer')
                            <li
                                class="nav-item dropdown {{ (request()->is('merit-list') || request()->is('merit-list/*')) ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false" key="SCHEME">
                                    <span data-hi="मेरिट सूची (स्क्रीनिंग)" data-en="Merit List (Screening)"></span>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ url('merit-list') }}/1">
                                        <span data-hi="सामान्य वर्ग" data-en="General"></span>
                                    </a>
                                    <a class="dropdown-item" href="{{ url('merit-list') }}/2">
                                        <span data-hi="अन्य पिछड़ा वर्ग" data-en="OBC"></span>
                                    </a>
                                    <a class="dropdown-item" href="{{ url('merit-list') }}/3">
                                        <span data-hi="अनुसूचित जाति" data-en="Scheduled Caste"></span>
                                    </a>
                                    <a class="dropdown-item" href="{{ url('merit-list') }}/4">
                                        <span data-hi=" अनुसूचित जनजाति" data-en="Scheduled Tribe"></span>
                                    </a>
                                </div>
                            </li>

                            <!-- <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"
                                        key="SCHEME">मेरिट सूची (स्क्रीनिंग)</a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ url('merit-list') }}/1">सामान्य
                                            / अन्य पिछड़ा वर्ग</a>
                                        <a class="dropdown-item"
                                            href="{{ url('merit-list') }}/2">अनुसूचित जाति</a>
                                        <a class="dropdown-item"
                                            href="{{ url('merit-list') }}/3">अनुसूचित जनजाति</a>
                                    </div>
                                </li> -->
                            @endif
                            <li
                                class="nav-item dropdown {{(request()->is('approved-avedan') || request()->is('rejected-avedan')) ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false" key="SCHEME">
                                    <span data-hi="आवेदन मैत्री" data-en="Application Maitri"></span>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ url('approved-avedan') }}">
                                        <span data-hi="स्वीकृत आवेदन मैत्री"
                                            data-en="Accepted Maitri Applications"></span>
                                    </a>
                                    <a class="dropdown-item" href="{{ url('rejected-avedan') }}">
                                        <span data-hi="अस्वीकृत आवेदन मैत्री"
                                            data-en="Rejected Maitri Applications"></span>
                                    </a>
                                </div>
                            </li>



                            @if (auth()->user()->user_type == 'District Officer')
                            <li class="nav-item {{ request()->is('document-verification') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('document-verification') }}">
                                    <span data-hi="अभिलेख  सत्यापन" data-en="Record Verification"></span>
                                </a>
                            </li>
                            <li class="nav-item {{ request()->is('upload-documents') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('upload-documents') }}">
                                    <span data-hi="दस्तावेज़ सत्यापन / अपलोड करें"
                                        data-en="Document Verification/Upload"></span>
                                </a>
                            </li>
                            @endif
                            <li
                                class="nav-item dropdown {{ (request()->is('all-list') || request()->is('general-list') || request()->is('obc-list') || request()->is('sc-list') || request()->is('st-list')) ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false" key="SCHEME">
                                    <span data-hi="चयनित अभ्यर्थियों की सूची"
                                        data-en="List of Selected Candidates"></span>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ url('all-list/' . request()->route('year')) }}">
                                        <span data-hi="सभी" data-en="All"></span>
                                    </a>
                                    <a class="dropdown-item"
                                        href="{{ url('general-list/' . request()->route('year')) }}">
                                        <span data-hi="सामान्य वर्ग" data-en="General"></span>
                                    </a>
                                    <a class="dropdown-item" href="{{ url('obc-list/' . request()->route('year')) }}">
                                        <span data-hi="अन्य पिछड़ा वर्ग" data-en="OBC"></span>
                                    </a>
                                    <a class="dropdown-item" href="{{ url('sc-list/' . request()->route('year')) }}">
                                        <span data-hi="अनुसूचित जाति" data-en="Scheduled Caste"></span>
                                    </a>
                                    <a class="dropdown-item" href="{{ url('st-list/' . request()->route('year')) }}">
                                        <span data-hi="अनुसूचित जनजाति" data-en="Scheduled Tribe"></span>
                                    </a>
                                </div>
                            </li>

                            @if (auth()->user()->user_type == 'District Officer')
                            <li class="nav-item dropdown {{ request()->is('waiting-list') ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false" key="SCHEME">
                                    <span data-hi="प्रतीक्षा सूची" data-en="Waiting List"></span>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ url('waiting-list') }}/1">
                                        <span data-hi="सामान्य वर्ग" data-en="General"></span>
                                    </a>
                                    <a class="dropdown-item" href="{{ url('waiting-list') }}/2">
                                        <span data-hi="अन्य पिछड़ा वर्ग" data-en="OBC"></span>
                                    </a>
                                    <a class="dropdown-item" href="{{ url('waiting-list') }}/3">
                                        <span data-hi="अनुसूचित जाति" data-en="Scheduled Caste"></span>
                                    </a>
                                    <a class="dropdown-item" href="{{ url('waiting-list') }}/4">
                                        <span data-hi="अनुसूचित जनजाति" data-en="Scheduled Tribe"></span>
                                    </a>
                                </div>
                            </li>
                            @endif


                            @if (auth()->user()->user_type == 'Admin')
                            <li class="nav-item {{ request()->is('institute') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('institute') }}">
                                    <span data-hi="संस्थान प्रबंधन" data-en="Institute Management"></span>
                                </a>
                            </li>
                            @endif


                            @if (auth()->user()->user_type == 'Director')
                            <li
                                class="nav-item dropdown {{ (request()->is('allocation') || request()->is('allocation-list') )? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false" key="SCHEME">
                                    <span data-hi="संस्थान प्रबंधन" data-en="Institute Allotment"></span>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ url('allocation') }}">
                                        <span data-hi="अभ्यर्थी आवंटन" data-en="Candidate Allocation"></span>
                                    </a>
                                    <a class="dropdown-item" href="{{ url('allocation-list') }}">
                                        <span data-hi="अभ्यर्थी आवंटन सूची" data-en="Candidate Allotment List"></span>
                                    </a>
                                </div>
                            </li>
                            @endif

                            <li class="nav-item {{ request()->is('candidate-not-joined') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('candidate-not-joined') }}">
                                    <span data-hi="संस्थान ज्वाइन नहीं किया है"
                                        data-en="Have not joined the institute"></span>
                                </a>
                            </li>

                            @if (auth()->user()->user_type == 'Admin')
                            <li class="nav-item {{ request()->is('setting') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('setting') }}">
                                    <span data-hi="सेटिंग्स" data-en="Setting"></span>
                                </a>
                            </li>
                            @endif

                            <li class="nav-item {{ request()->is('changePassword') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('changePassword') }}">
                                    <span data-hi="चेंज पासवर्ड" data-en="Change Password"></span>
                                </a>
                            </li>
                            <li class="nav-item {{ request()->is('maitri-home') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('maitri-home') }}">
                                    <span data-hi="मैत्री(पशु मित्र)" data-en="Maitri (Animal Friend)"></span>
                                </a>
                            </li>
                            <li class="nav-item {{ request()->is('cvo-officer') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('cvo-officer') }}">
                                    <span data-hi="सीवीओ/वीओ अधिकारी" data-en="CVO/VO Officer"></span>
                                </a>
                            </li>
                            <li class="nav-item {{ request()->is('demandRequests') ? 'active' : '' }} ">
                                <a class="nav-link" href="{{ url('demandRequests') }}">
                                    <span data-hi="मांग अनुरोध" data-en="Demand Requests"></span>
                                </a>
                            </li>
                            <li class="nav-item {{ request()->is('demand-requests-list') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('demand-requests-list') }}">
                                    <span data-hi="मांग अनुरोध सूची" data-en="Demand Request List"></span>
                                </a>
                            </li>

                            <li class="nav-item {{ request()->is('latest-updates') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('latest-updates') }}">
                                    <span data-hi="नयी जानकारियाँ" data-en="Latest information"></span>
                                </a>
                            </li>
                            @if (auth()->user()->user_type == 'Admin'|| auth()->user()->user_type == 'Director' ||
                            auth()->user()->user_type == 'District Officer')
                            <li class="nav-item {{ request()->is('shapathPatraList') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('shapathPatraList') }}">
                                    <span data-hi="शपथ - पत्र" data-en="Affidavit"></span></a>
                            </li>
                            <li class="nav-item  {{ request()->is('totalsessionlist') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('totalsessionlist') }}">
                                    <span data-hi="मैत्री का रिकार्ड" data-en="Record Of Maitri"></span></a>
                            </li>
                            @endif

                            @if(auth()->user()->user_type == 'Admin' || auth()->user()->user_type == 'Director')

                            <li
                                class="nav-item dropdown {{ request()->is('farmers-data') || request()->is('all-aicenter-geo-location') || (request()->is('all-maitri-geo-location') || request()->is('placed-candidates') || request()->is('import-aicenter')) ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false" key="SCHEME">
                                    <span data-hi="नियुक्त उम्मीदवार और मैत्री GEO स्थान अपडेट करें"
                                        data-en="Placed Candidates & Update Maitri GEO Location"></span>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ url('all-maitri-geo-location') }}">
                                        <span data-hi="मैत्री GEO स्थान अपडेट करें"
                                            data-en="Update Maitri GEO Location"></span>
                                    </a>
                                    <a class="dropdown-item" href="{{ url('all-aicenter-geo-location') }}">
                                        <span data-hi="एआई सेंटर जीईओ स्थान अपडेट करें"
                                            data-en="Update AI Center GEO Location"></span>
                                    </a>
                                    <a class="dropdown-item" href="{{ url('farmers-data') }}">
                                        <span data-hi="किसान पंजीकरण डेटा" data-en="Farmer Registration Data"></span>
                                    </a>
                                    <a class="dropdown-item" href="{{ url('placed-candidates') }}">
                                        <span data-hi="नियुक्त उम्मीदवार" data-en="Placed Candidates"></span>
                                    </a>
                                    <a class="dropdown-item" href="{{ url('get-farmer-request') }}">
                                        <span data-hi="किसान अनुरोध" data-en="Farmer Request"></span>
                                    </a>
                                    <a class="dropdown-item" href="{{ url('correctdata') }}">
                                        <span data-hi="सही डेटा" data-en="Correct Data"></span>
                                    </a>
                                    <a class="dropdown-item" href="{{ url('download-document') }}">
                                        <span data-hi="दस्तावेज़ डाउनलोड" data-en="Download Document"></span>
                                    </a>

                                    <!-- <a class="dropdown-item" href="{{ url('import-aicenter') }}">
                                        <span data-hi="AI केंद्र आयात करें" data-en="Import AI Center"></span>
                                    </a> -->
                                    <a class="dropdown-item" href="{{ url('view-update-maitri-aicenter') }}">
                                        <span data-hi="मांग अनुरोध और सूची" data-en="Demand Request & Inventory"></span>
                                    </a>
                                </div>
                            </li>

                            <li
                                class="nav-item dropdown {{ (request()->is('event-news') || request()->is('daily-dashboard')) ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false" key="SCHEME">
                                    <span data-hi="समाचार घटना और दैनिक डैशबोर्ड"
                                        data-en="News Event & Daily Dashboard"></span>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ url('daily-dashboard') }}">
                                        <span data-hi="दैनिक डैशबोर्ड" data-en="Daily Dashboard"></span>
                                    </a>
                                    <a class="dropdown-item" href="{{ url('event-news') }}">
                                        <span data-hi="घटना एवं समाचार" data-en="Event & News"></span>
                                    </a>
                                </div>
                            </li>

                            <!-- <li class="nav-item  {{ request()->is('zone-district-mapping') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('zone-district-mapping') }}">
                                    <span data-hi="क्षेत्र जिला" data-en="Zone District"></span></a>
                            </li> -->

                            @endif

                            <!-- Admin Stock Form Menu End -->
                            @if(auth()->user()->user_type == 'Admin' || auth()->user()->user_type == 'Director' ||
                            auth()->user()->user_type == 'DFS')
                            <li
                                class="nav-item dropdown {{ (request()->is('admin-stock-form') || request()->is('admin-inventory-record')) ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false" key="SCHEME">
                                    <span data-hi="प्रशासनिक स्टॉक और रिकॉर्ड" data-en="Admin Stock & Record"></span>
                                </a>
                                <div class="dropdown-menu">

                                    <a class="dropdown-item" href="{{ url('admin-stock-form') }}">
                                        <span data-hi="एडमिन स्टॉक फॉर्म" data-en="Admin Stock Form"></span>
                                    </a>
                                    <a class="dropdown-item" href="{{ url('admin-inventory-record') }}">
                                        <span data-hi="एडमिन इन्वेंटरी रिकॉर्ड" data-en="Admin Inventory Record"></span>
                                    </a>
                                </div>
                            </li>

                            <li
                                class="nav-item dropdown {{ (request()->is('inventory') || request()->is('admin-distributed-record')) ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false" key="SCHEME">
                                    <span data-hi="इभंडारण एवं वितरण" data-en="Inventory & Distribute"></span>
                                </a>
                                <div class="dropdown-menu">

                                    <a class="dropdown-item" href="{{ url('inventory') }}">
                                        <span data-hi="वस्तुसूची" data-en="Inventory"></span>
                                    </a>
                                    <a class="dropdown-item" href="{{ url('admin-distributed-record') }}">
                                        <span data-hi="एडमिन इन्वेंटरी रिकॉर्ड" data-en="Distributed Record"></span>
                                    </a>
                                </div>
                            </li>
                            <!-- Admin Stock Form Menu Start -->
                            @endif

                            @if(auth()->user()->user_type == 'Admin' || auth()->user()->user_type == 'Director')
                            <li class="nav-item  {{ request()->is('view-dfs') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('view-dfs') }}">
                                    <span data-hi="डीएफएस बनाएं" data-en="Create DFS"></span></a>
                            </li>
                            <li class="nav-item  {{ request()->is('operator-id') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('operator-id') }}">
                                    <span data-hi="ऑपरेटर आईडी प्रबंधन" data-en="Operator ID Management"></span></a>
                            </li>
                            @endif

                            @if(auth()->user()->user_type == 'District Officer')
                            <!-- <li class="nav-item ">
                                <a class="nav-link" href="{{ url('upload-shapatpatra') }}">
                                    <span data-hi="शपथ पत्र अपलोड करें" data-en="Upload Affidavit"></span></a>
                            </li> -->
                            <li class="nav-item  {{ request()->is('upload-selectedcandidate') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('upload-selectedcandidate') }}">
                                    <span data-hi="सीवीओ द्वारा चयनित मैत्रियो की सुची अपलोड करे"
                                        data-en="Upload the list of candidates selected by CVO"></span></a>
                            </li>
                            @endif

                            @endif
                            @else
                            <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('/') }}" key="HOME">
                                    <span data-hi="मुख्य पृष्ठ" data-en="Main Page"></span>
                                    <span class="sr-only">(current)</span></a>
                            </li>

                            <li class="nav-item {{ request()->is('avedan-karein') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('avedan-karein') }}">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="glow-badge p-0">
                                            <!-- <span class="glow-dot" aria-hidden="true"></span> -->
                                            <span class="glow-badge__pill glowing" role="status" aria-label="New content" data-hi="अब" data-en="Now"></span>
                                        </span>
                                        <span data-hi="आवेदन" data-en="Applications"></span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item {{ request()->is('application-status') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('application-status') }}">
                                    <span data-hi="आवेदन की स्थिति जानिए"
                                        data-en="Know the status of your application"></span>
                                </a>
                            </li>
                            
                            <li class="nav-item {{ request()->is('downloads') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('downloads') }}">
                                    <span data-hi="डाउनलोड" data-en="Downlaod"></span>
                                </a>
                            </li>
                           
                            <!-- Hide 01 Sep 2025 -->
                            <!-- <li class="nav-item {{ request()->is('lakshya') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('lakshya') }}">
                                    <span data-hi="स्वरोजगारी मैत्री की संख्या"
                                        data-en="Number of self-employed maitri"></span>
                                </a>
                            </li> -->
                            <!-- Hide 01 Sep 2025 -->
                            <!-- Hide 01 Sep 2025 -->
                            <!-- <li class="nav-item {{ request()->is('demandRequests') ? 'active' : '' }} ">
                                <a class="nav-link" href="{{ url('demandRequests') }}">
                                    <span data-hi="मांग अनुरोध" data-en="Demand Requests"></span>
                                </a>
                            </li>
                            <li class="nav-item {{ request()->is('cattle-buffalo') ? 'active' : '' }} ">
                                <a class="nav-link" href="{{ url('cattle-buffalo') }}">
                                    <span data-hi="गाय और भैंस" data-en="Cattle & Buffalo"></span>
                                </a>
                            </li>
                            <li class="nav-item {{ request()->is('hierarchy-chart') ? 'active' : '' }} ">
                                <a class="nav-link" href="{{ url('hierarchy-chart') }}">
                                    <span data-hi="पदानुक्रम चार्ट" data-en="Hierarchy Chart"></span>
                                </a>
                            </li> -->
                            <!-- Hide 01 Sep 2025 -->

                            <!-- <li class="nav-item ">
                            <a class="nav-link" href="{{ url('maitri-register') }}">
                                <span data-hi="मैत्री (पशु मित्र) पंजीकरण" data-en="Maitri (Animal Friend) Registration"></span>
                            </a>
                            </li> -->

                            <!-- Hide 01 Sep 2025 -->
                            <!-- <li class="nav-item {{ request()->is('farmer-register') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('farmer-register') }}">
                                    <span data-hi="पशुपालक पंजीकरण" data-en="Farmer Registration"></span>
                                </a>
                            </li> -->
                            <!-- Hide 01 Sep 2025 -->

                            <!-- <li class="nav-item ">
                            <a class="nav-link" href="{{ url('refresher-training') }}">
                                <span data-hi="रिफ्रेशर प्रशिक्षण फॉर्म" data-en="Refresher Training Form"></span>
                            </a>
                            </li> -->

                            <!-- Hide 01 Sep 2025 -->
                            <!-- <li class="nav-item {{ request()->is('zonestockform') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('zonestockform') }}">
                                    <span data-hi="ज़ोन स्टॉक फॉर्म" data-en="Zone Stock Form"></span>
                                </a>
                            </li> -->
                            <!-- Hide 01 Sep 2025 -->

                            @endauth
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div>
        @yield('content')
    </div>
    <!-- <footer> -->
    @if (Route::has('login'))
    @auth
    @else
    <!-- <div class="pt-5 pb-3">
        <div class="container">
          <div class="row g-3">
            <div class="col-lg-3">
              <div class="text-center">
                <img src="{{ asset('assets/images/logo.png') }}" height="100" class="mb-3" />
                <h4 class="logo-title"><b>
                <span data-hi="राष्ट्रीय गोकुल मिशन" data-en="National Gokul Mission"></span>

                </b></h4>
                <small >
                <span data-hi="स्वरोजगारी मैत्री (पशु मित्र)" data-en="Self-employment friendship (animal friend)"></span>
               <br />
               <span data-hi="(मल्टीपरपज ए0आई0 टेक्निशियन इन रूरल  इण्डिया)" data-en="(Multipurpose AI Technician in Rural India)"></span>
              <br />
              <span data-hi="हेतु ऑनलाइन आवेदन" data-en="Apply online for"></span>
                  </small
                >
              </div>
            </div>
            <div class="col-lg-3">
              <h5 class="footer--heading">
              <span data-hi="महत्वपूर्ण लिंक" data-en="Important Links"></span>
                </h5>
              <ul class="footer--list">
                <li>
                    <a href="{{ url('/') }}" key="HOME">
                        <span data-hi="मुख्य पृष्ठ" data-en="Main Page"></span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('avedan-karein') }}">
                        <span data-hi="आवेदन" data-en="Applications"></span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('lakshya') }}">
                        <span data-hi="स्वरोजगारी मैत्री (पशु मित्र) की संख्या" data-en="Number of Swarozgari Maitri (Animal Friends)"></span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('application-status') }}">
                        <span data-hi="आवेदन की स्थिति जानिए" data-en="Know the status of your application"></span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('downloads') }}">
                        <span data-hi="डाउनलोड" data-en="Download"></span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('demandRequests') }}">
                        <span data-hi="मांग अनुरोध" data-en="Demand Requests"></span>
                    </a>
                </li>

              </ul>
            </div>
            <div class="col-lg-3">
              <h5 class="footer--heading">
                <span data-hi="त्वरित लिंक" data-en="Quick Links"></span>
              </h5>
              <ul class="footer--list">
                <li>
                    <a href="{{ url('maitri-register') }}">
                        <span data-hi="मैत्री (पशु मित्र) पंजीकरण" data-en="Maitri Registration"></span>
                   </a>
                </li>
                <li>
                    <a href="{{ url('farmer-register') }}">
                        <span data-hi="पशुपालक पंजीकरण" data-en="Livestock Registration"></span>
                    </a>
                </li>

              </ul>
            </div>
            <div class="col-lg-3">
              <h5 class="footer--heading">
              <span data-hi="संपर्क करें" data-en="Contact Us"></span>
                </h5>
            </div>
          </div>
        </div>
      </div> -->
    @endauth
    @endif
    <!-- <div class="copy-right py-2 text-center copyright-text">
        <p class="text-center m-0"><?php echo date('Y'); ?>-<?php echo date('Y', strtotime('+1 year')); ?> © Rashtriya Gokul Mission All rights reserved</p>
      </div> -->
    <!-- </footer> -->
    <footer class="position-relative">
        @if (Route::has('login'))
        @auth
        @else
        <div class="footer_parent">
            <div class="row g-3 footer_top_footer__u_0LC">
                <div class="col-lg-4">
                    <h5><i class="fa fa-map-marker"></i>
                        <span data-hi="हेड ऑफिस" data-en="Head Office"></span>
                    </h5>
                    <p>
                        <span data-hi="गोकरन नाथ रोड, बादशाहबाग, लखनऊ 226007"
                            data-en="Gokaran Nath Road, Badshahbagh, Lucknow 226007"></span>
                    </p>
                    <h5><i class="fa fa-envelope"></i>
                        <span data-hi="ईमेल करें" data-en="Email Us"></span>
                    </h5>
                    <p class="mb-0">
                        <span data-hi="मैत्री सेल" data-en=" MAITRI Cell"></span>
                        - upldbte@gmail.com
                    </p>
                    <p class="mb-0">
                        <span data-hi="शिकायत सेल" data-en="Grievance Cell"></span>
                        - upldbmaitri@gmail.com
                    </p>
                    <p class="mb-0">
                        <span data-hi="बीमा" data-en="Insurance"></span>
                        - pashubeemaupldb@gmail.com
                    </p>
                    <p class="mb-0">
                        <span data-hi="सेक्स्ड सीमेन" data-en="Sexed Semen"></span>
                        - upldbss@gmail.com
                    </p>
                </div>
                <div class="col-lg-4">
                    <h5><i class="fa fa-phone"></i>
                        <span data-hi="कॉल करें" data-en="Call Us"></span>
                    </h5>
                    <p class="mb-0">
                        <span data-hi="लैंडलाइन नंबर" data-en="Landline Number"></span>
                        - +91-522-2977709
                    </p>
                    <p class="mb-0">
                        <span data-hi="बीमा" data-en="Insurance"></span>
                        - +91 - 9335116448
                    </p>
                    <p class="mb-0">
                        <span data-hi="मैत्री" data-en="MAITRI"></span>
                        - +91 - 9125904205
                    </p>
                    <p class="mb-0 mt-2 fw-semibold">
                        <span data-hi="उत्तर प्रदेश पशुधन विकास बोर्ड"
                            data-en="Uttar Pradesh Livestock Development Board"></span>
                    </p>
                </div>
                <div class="col-lg-4">
                    <div class="d-flex flex-column justiry-content-center align-items-center w-100">
                        <h5>
                            <span data-hi="ऐप डाउनलोड करें" data-en="Download App"></span>
                        </h5>
                        <a href="https://play.google.com/store/apps/details?id=com.epashu.in"><img src="https://upldb.vercel.app/assets/images/site/pashudhan_app1.png"
                                width="120px" alt=""></a>
                    </div>
                </div>
            </div>
            <div class="row align-items-top gap-5 px-2 mx-0 pt-4 pb-3 footer_footer__O">
                <div class="col-lg-3 align-items-top text-center">
                    <img src="https://maitriupldb.in/assets/images/upldb-logo.png" alt="" width="150">
                    <span style="line-height:25px;display:block" class="mb-0 mt-3 text-white">
                        <span data-hi="उन्नत संतति हेतु संकल्पबद्ध" data-en="Committed to a better future"></span>

                    </span>
                    <div class="social-links d-flex justify-content-center gap-3 mt-lg-3  mt-md-4 mt-3 ">

                        <a href="https://x.com/i/flow/login?redirect_after_login=%2Fupldblko" target="_blank">
                            <span> <i class="ri-twitter-x-line ri-lg"></i></span>
                        </a>
                        <a target="_blank"
                            href="https://www.facebook.com/people/Uttar-Pradesh-Livestock-Development-Board/61554910544850/">
                            <span> <i class="ri-facebook-circle-line ri-lg"></i></span>
                        </a>

                        <a href="https://www.linkedin.com/company/uttar-pradesh-livestock-development-board"
                            target="_blank">
                            <span><i class="ri-linkedin-line ri-lg"></i></span>
                        </a>
                        <a href="https://www.youtube.com/@uplivestockdevelopmentboard" target="_blank">
                            <span><i class="ri-youtube-line ri-lg"></i> </span>
                        </a>

                        </a>
                    </div>
                </div>
                <div class="col-lg-2">
                    <h5 class="footer--heading">
                        <span data-hi="महत्वपूर्ण लिंक" data-en="Important Links"></span>
                    </h5>
                    <ul class="footer--list">
                        <li>
                            <a href="{{ url('/') }}" key="HOME">
                                <span data-hi="मुख्य पृष्ठ" data-en="Main Page"></span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('avedan-karein') }}">
                                <span data-hi="आवेदन" data-en="Applications"></span>
                            </a>
                        </li>
                        <!-- <li>
                            <a href="{{ url('lakshya') }}">
                                <span data-hi="स्वरोजगारी मैत्री (पशु मित्र) की संख्या"
                                    data-en="Number of Swarozgari Maitri (Animal Friends)"></span>
                            </a>
                        </li> -->
                        <li>
                            <a href="{{ url('application-status') }}">
                                <span data-hi="आवेदन की स्थिति जानिए"
                                    data-en="Know the status of your application"></span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('downloads') }}">
                                <span data-hi="डाउनलोड" data-en="Download"></span>
                            </a>
                        </li>
                        <!-- <li>
                            <a href="{{ url('demandRequests') }}">
                                <span data-hi="मांग अनुरोध" data-en="Demand Requests"></span>
                            </a>
                        </li> -->
                    </ul>



                </div>
                <div class="col-lg-2">
                    <h5 class="footer--heading">
                        <span data-hi="त्वरित लिंक" data-en="Quick Links"></span>
                    </h5>
                    <ul class="footer--list">
                        <!-- <li>
                        <a href="{{ url('maitri-register') }}">
                            <span data-hi="मैत्री (पशु मित्र) पंजीकरण" data-en="Maitri Registration"></span>
                    </a>
                    </li> -->
                        <!-- <li>
                            <a href="{{ url('farmer-register') }}">
                                <span data-hi="पशुपालक पंजीकरण" data-en="Livestock Registration"></span>
                            </a>
                        </li> -->

                    </ul>
                </div>
                <div class="col-lg-2">
                    <h5 class="footer--heading">
                        <span data-hi="संपर्क करें" data-en="Contact Us"></span>
                    </h5>
                    <ul class="list-unstyled">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3559.08297384528!2d80.935781475438!3d26.86910477667314!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x399bfd9c9604bea9%3A0x88634ee93200bb69!2sVETERINARY%20POLYCLINIC%20BADSHAH%20BAGH%2C%20LUCKNOW!5e0!3m2!1sen!2sin!4v1705036303907!5m2!1sen!2sin"
                            width="100%" height="200"></iframe>
                    </ul>
                </div>
            </div>
        </div>
        @endauth
        @endif
        <div class="copy-right py-2 text-center copyright-text footer-counter">
            <a href='https://www.free-counters.org/'>www.free-Counter.org</a>
            <script type='text/javascript'
                src='https://www.freevisitorcounters.com/auth.php?id=b02bbc85a30c7c9a99711a8a93df17b315b95524'></script>
            <script type="text/javascript" src="https://www.freevisitorcounters.com/en/home/counter/1223947/t/5">
            </script>

            <p class="text-center m-0"><?php echo date('Y'); ?>-<?php echo date('Y', strtotime('+1 year')); ?> ©
                <span data-hi="राष्ट्रीय गोकुल मिशन सर्वाधिकार सुरक्षित"
                    data-en="Rashtriya Gokul Mission All rights reserved"></span>
            </p>
        </div>
    </footer>
    <button class="common_top_scroll__cuiN4 top-btn">
        <i class="fa fa-arrow-up" aria-hidden="true"></i>
    </button>

    <script>
    let topBtn = document.querySelector(".top-btn");

    topBtn.onclick = () => window.scrollTo({
        top: 0,
        behavior: "smooth"
    });

    window.onscroll = () => topBtn.style.opacity = window.scrollY > 500 ? 1 : 0;

    var defaultlang = "hi";
    var ls = localStorage.getItem("selectedProject");
    if (ls) {
        $(".switchlang").val(ls).change();
        switchLang(ls);
    } else {
        switchLang(defaultlang);
    }

    function switchLang(lang) {
        document.body.classList.remove("trans_english");
        if (lang === 'en') {
            document.body.classList.add("trans_english");
        }
        $("[data-" + lang + "]").text(function(i, e) {
            return $(this).data(lang);
        });

        $("select").each(function() {
            $(this).find("option").each(function() {
                var value = $(this).data(lang);
                if (value !== undefined) {
                    $(this).text(value);
                }
            });
        });
        $("[data-placeholder-" + lang + "]").each(function() {
            var placeholder = $(this).data("placeholder-" + lang);
            if (placeholder !== undefined) {
                $(this).attr("placeholder", placeholder);
            }
        });
    }
    // function switchLang(lang){
    //     document.body.classList.remove("trans_english");
    //     if(lang=='en'){
    //         document.body.classList.add("trans_english");
    //     }
    //     $("[data-" + lang + "]").text(function(i, e) {

    //         return $(this).data(lang);
    //     });
    // }
    $('.switchlang').change(function() {
        var lang = $(".switchlang option:selected").val();
        localStorage.setItem("selectedProject", lang);
        switchLang(lang)
    });

    function loadlang() {
        var lng = document.getElementById("langselector").value;
        var cnt = document.getElementById("contents");
        switch (lng) {
            case "en":
                cnt.src = "https://jsfiddle.net/q2nw8o35/";
                break;
            case "hi":
                cnt.src = "https://jsfiddle.net/jmn8c9tj/";
                break;
        }
    }
    </script>
    <div class="modal fade" id="myModel" tabindex="-1" role="dialog" aria-labelledby="myModel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        <span data-hi="अभ्यर्थी का स्वत: मूल्यांकन" data-en="Self-Evaluation of the Candidate"></span>
                    </h5>
                    <button type="button" class="close " onclick="closemodal()" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="responseID">
                        <div class="spinner-border"></div>
                    </span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closemodal()"
                        data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @stack('body-scripts')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
    var url = "{{ route('changeLang') }}";
    $(".changeLang").change(function() {
        window.location.href = url + "?lang=" + $(this).val();
    });
    </script>
</body>

</html>