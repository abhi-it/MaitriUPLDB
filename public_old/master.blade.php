<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="csrf-token">
    <title>राष्ट्रीय गोकुल मिशन</title>
    <!-- Fonts -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('assets') }}/favicon.ico">
    <link href="{{ asset('') }}css/custom.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('') }}css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('') }}css/navbar.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('') }}css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="{{ asset('') }}js/jquery-3.6.min.js"></script>
    <script src="{{ asset('') }}js/font-size.js" type="text/javascript"></script>
    <script src="{{ asset('') }}js/bgcolor.js" type="text/javascript"></script>
    <script src="{{ asset('') }}js/account.js" type="text/javascript"></script>
    <script src="{{ asset('') }}js/jquery.validate.min.js" type="text/javascript"></script>
    <script src="{{ asset('') }}js/additional-methods.min.js?ver=1.0" type="text/javascript"></script>
    <script type="text/javascript"
        src="https://maps.google.com/maps/api/js?key={{ env('AIzaSyABHXJPN6L8-6nqf4uUekwdoQBPeHLYe60') }}&callback=initMap">
    </script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.5.1/axios.min.js"
        integrity="sha512-emSwuKiMyYedRwflbZB2ghzX8Cw8fmNVgZ6yQNNXXagFzFOaQmbvQ1vmDkddHjm5AITcBIZfC7k4ShQSjgPAmQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <!--Data Table---->
    <link href="{{ asset('') }}css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
    <script src="{{ asset('') }}js/jquery.dataTables.min.js" type="text/javascript"></script>

    <link href="{{ asset('') }}css/jquery-ui.css" rel="stylesheet" type="text/css">
    <script src="{{ asset('') }}js/jquery-ui.js" type="text/javascript"></script>
    

    <script>
        $(document).ready(function() {


            var currentDate = new Date();
            var currentYear = currentDate.getFullYear();
            var currentMonth = currentDate.getMonth() + 1; // Note: Months are zero-based

            // Calculate the previous date (September 30 of the current year)
            var previousDate = new Date(currentYear, 8, 30); // Month is zero-based (8 for September)

            // Format the previous date as 'dd-mm-yy'
            var previousDateFormatted = ("0" + previousDate.getDate()).slice(-2) + "-" + ("0" + (previousDate
                .getMonth() + 1)).slice(-2) + "-" + currentYear;

            $("#dob").datepicker({
                dateFormat: 'dd-mm-yy',
                changeYear: true,
                changeMonth : true,
                // minDate: '19-10-2016', // Use 'dd-mm-yy' format
                maxDate: '01-10-2005' // Use 'dd-mm-yy' format
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
                yearRange: "-0:+1",
            });

            $("#end_date").datepicker({
                dateFormat: 'dd-mm-yy',
                changeMonth: true,
                changeYear: true,
                yearRange: "+0:+1",
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

        
            $.validator.addMethod("checkDOB", function(value, element) {
                var userinput = document.getElementById("dob").value;
                var age = moment().diff(moment(userinput, 'DD-MM-YYYY'), 'years');
                if (age >= 18) {
                    return true;
                } else {
                    return false;
                }
                return true;
            }, "आप पात्र नहीं हैं! आयु न्यूनतम 18 वर्ष होनी चाहिए");





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
                    address_type: "required",
                    post_office: "required",
                    pincode: "required",
                    gender: "required",
                    permanent_address: "required",
                    gram_panchayat_name: "required",
                    vikas_khand: "required",
                    janpad: "required",
                    letter_address: "required",
                    high_board_name: "required",
                    high_passing_year: "required",
                    "high_marks": {
                        required: true,
                        verifyHighSchoolMarks: true,
                    },
                    high_total_marks: "required",
                    high_percentage: "required",
                    "permanent_address_proof": {
                        extension: "pdf|PDF|png|PNG|jpg|JPG|jpeg|JPEG",
                        checkFileSize: 100000,
                    },
                    "applicant_photo": {
                        required: true,
                        extension: "pdf|PDF|png|PNG|jpg|JPG|jpeg|JPEG",
                        checkFileSize20KB: 20000,
                    },
                    "signature": {
                        required: true,
                        extension: "pdf|PDF|png|PNG|jpg|JPG|jpeg|JPEG",
                        checkFileSize20KB: 20000,
                    },
                    "high_marksheet": {
                        required: true,
                        extension: "png|PNG|jpg|JPG|jpeg|JPEG",
                        checkFileSize: 100000,
                    },
                    "high_certificate": {
                        required: true,
                        extension: "png|PNG|jpg|JPG|jpeg|JPEG",
                        checkFileSize: 100000,
                    },

                    "inter_marksheet": {
                        extension: "png|PNG|jpg|JPG|jpeg|JPEG",
                        checkFileSize: 100000,
                    },
                    "inter_certificate": {
                        extension: "png|PNG|jpg|JPG|jpeg|JPEG",
                        checkFileSize: 100000,
                    },

                    "graduation_marksheet": {
                        extension: "png|PNG|jpg|JPG|jpeg|JPEG",
                        checkFileSize: 100000,
                    },
                    "graduation_certificate": {
                        extension: "png|PNG|jpg|JPG|jpeg|JPEG",
                        checkFileSize: 100000,
                    },

                    "postgraduation_marksheet": {
                        extension: "png|PNG|jpg|JPG|jpeg|JPEG",
                        checkFileSize: 100000,
                    },
                    "postgraduation_certificate": {
                        extension: "png|PNG|jpg|JPG|jpeg|JPEG",
                        checkFileSize: 100000,
                    },

                    "training_certificate": {
                        extension: "png|PNG|jpg|JPG|jpeg|JPEG",
                        checkFileSize: 100000,
                    },
                    "id_upload": {
                        required: true,
                        extension: "png|PNG|jpg|JPG|jpeg|JPEG",
                        checkFileSize: 100000,
                    },
                    "caste_certificate": {
                        checkCategory: true,
                        extension: "png|PNG|jpg|JPG|jpeg|JPEG",
                        checkFileSize: 100000,
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
                    //inter_board_name: "required",
                    //inter_passing_year: "required",
                    //inter_marks: "required",
                    //inter_total_marks: "required",
                    //inter_percentage: "required",
                    "training_certificate": {
                        //required:true,
                        extension: "pdf|PDF|png|PNG|jpg|JPG|jpeg|JPEG",
                        checkFileSize: 100000,
                    },
                    "id_upload": {
                        //required:true,
                        extension: "pdf|PDF|png|PNG|jpg|JPG|jpeg|JPEG",
                        checkFileSize: 100000,
                    },
                    "caste_certificate": {
                        //required:true,
                        extension: "pdf|PDF|png|PNG|jpg|JPG|jpeg|JPEG",
                        checkFileSize: 100000,
                    },
                    "high_marksheet": {
                        //required:true,
                        extension: "pdf|PDF|png|PNG|jpg|JPG|jpeg|JPEG",
                        checkFileSize: 100000,
                    },
                    "high_certificate": {
                        //required:true,
                        extension: "pdf|PDF|png|PNG|jpg|JPG|jpeg|JPEG",
                        checkFileSize: 100000,
                    },
                    "inter_marksheet": {
                        //required:true,
                        extension: "pdf|PDF|png|PNG|jpg|JPG|jpeg|JPEG",
                        checkFileSize: 100000,
                    },
                    "inter_certificate": {
                        //required:true,
                        //extension: "pdf|PDF|png|PNG|jpg|JPG|jpeg|JPEG",
                        //checkFileSize: 100000,
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
                    "sInfo": "कुल आवेदन :  _TOTAL_",
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

                    $("#responseID").html(response);
                    //$('#myModel').modal('hide')
                    //console.log(response);
                }
            });

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




    <style type="text/css">
        .btn {
            cursor: pointer;
        }

        .error {
            color: #FF0000;
        }

        body {
            font-size: 16px !important;
        }

        a {
            font-size: 16px !important;
        }

        .navbar-inverse .navbar-nav .nav-link {
            font-size: 16px !important;
            color: #FFF;
            display: block;
            font-family: 'Play', Arial, sans-serif;
            font-size: 14px;
            letter-spacing: 0;
            margin: 0;
            padding: 10px 10px 9px;
            text-decoration: none;
            text-transform: none;
        }

        a .dropdown-item {
            font-family: 'Play', Arial, sans-serif;
            font-size: 8px !important;
        }



        .red {
            position: relative;
            float: right;
            margin-right: 10px;
            /* margin-top:10px;*/
            width: 21px;
            height: 19px;
            background-color: red;
            /*  z-index:4;*/
        }

        .pink {
            position: relative;
            float: right;
            margin-right: 10px;
            /* margin-top:10px;*/
            width: 21px;
            height: 19px;
            background-color: #ff336be8;
            /*  z-index:4;*/
        }

        .blue {
            position: relative;
            float: right;
            margin-right: 10px;
            /* margin-top:10px;*/
            width: 21px;
            height: 19px;
            background-color: #02486d;
            /*  z-index:4;*/
        }

        .green {
            position: relative;
            float: right;
            margin-right: 10px;
            /* margin-top:10px;*/
            width: 21px;
            height: 19px;
            background-color: green;
            /*  z-index:4;*/
        }


        .brown {
            position: relative;
            float: right;
            margin-right: 10px;
            /*margin-top:10px;*/
            width: 21px;
            height: 19px;
            background-color: brown;
            /*  z-index:4;*/
        }

        .orange {
            position: relative;
            float: right;
            margin-right: 10px;
            /*margin-top:10px;*/
            width: 21px;
            height: 19px;
            background-color: #ff9933;
            /*  z-index:4;*/
        }

        .basicColor {
            font-size: 16px !important;
            color: white;
            border: none;
            background-image: linear-gradient(to bottom, #FF9933 0, #5f3308 100%);
        }

        img {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        img:hover {
            border-color: brown 1px solid;
        }
    </style>
    <style>
        .content_mb_60 {
            margin-bottom: 60px;
        }

        .content_wrapper {

            overflow: hidden;
            width: 100%;
        }

        .col_4 {
            float: left;
            margin: 0 20px 0 0;
        }

        #templatemo_main {
            clear: both;
            margin: 0;
            /* padding: 30px 40px;*/
            background: #ffffff;
        }

        ul.list_bullet li a {
            color: #fff;
            font-weight: normal;
            text-decoration: none;
            cursor: pointer;

        }

        ul.list_bullet li a:hover {
            color: yellow;
        }
    </style>

    @stack('head-style')


</head>

<body>
    <div class="container">

        <div class="header">
            <div class="row" style="padding-top:0px;">

                <div class="col-md-12 first_strip" style="background-color:#eee;">
                    <div class="time_txt" style="float:left;">

                        <noscript>
                            Javascript Required
                        </noscript>
                        <script type="text/javascript">
                            var d = new Date()
                            var weekday = new Array("Sun", "Mon", "Tue", "Wed", "Thur", "Fri", "Sat")
                            var monthname = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec")
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


                    </div>

                    <div class="tp-right" style="float: right;">


                        @if (Route::has('login'))
                            <span>
                                @auth
                                    Welcome,&nbsp;{{ Auth::user()->name }} |
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout
                                        &nbsp;</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                @else
                                    <a href="{{ route('login') }}">Log in&nbsp;</a>
                                @endauth
                            </span>
                        @endif


                    </div>
                </div>
            </div>

            <div class="row">
                <!-- <div class="col-md-12"> -->

                <div class="col-md-12 col-sm-12">
                    <div class="row" style="padding-top: 20px;background-color: white;">

                        <div class="col-md-2" align="center" style="vertical-align: middle;align-content: center;">
                            <a href="{{ url('/') }}"> <img src="{{ asset('') }}images/logo.jpg"
                                    height="125"></a>
                        </div>
                        <div class="col-md-8 col-sm-12" style="margin-top: 30px;">
                            <center>
                                <h4 class="uttp" key="UTTP" style="color:black;font-weight: bold;"><span
                                        style="color:Blue; font-size:28px; padding:1px;"> राष्ट्रीय गोकुल
                                        मिशन</span><br /><span style="color:Black; font-size:18px; padding:1px;">
                                        स्वरोजगारी मैत्री (मल्टीपरपज ए0आई0 टेक्निशियन इन रूरल इण्डिया) हेतु <br />
                                        ऑनलाइन आवेदन</span></h4>
                            </center>
                        </div>
                        <div class="col-md-2" style="vertical-align: middle;align-content: center; margin-bottom: 7px;"
                            align="center">
                            <a href="{{ url('/') }}"> <img src="{{ asset('') }}images/upldb.jpg"></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container" style="background-color:white;margin-top: -5px;">
        <div class="row">

            <div class="col-md-12 col-sm-12 main_mnu">
                <nav class="navbar navbar-inverse  navbar-toggleable-md"
                    style="background-color:#ea7327; font-color:blue;" id="mainbackground">
                    <div class="container col-sm-12">
                        <button class="navbar-toggler navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarsExampleContainer" aria-controls="navbarsExampleContainer"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>


                        <div class="collapse navbar-collapse" id="navbarsExampleContainer" style="font-color:blue;">
                            <ul class="navbar-nav mr-auto">
                                @if (Route::has('login'))
                                    @auth
                                        <li class="nav-item active">
                                            <a class="nav-link" href="{{ url('/dashboard') }}">डैशबोर्ड</a>
                                        </li>
                                        @if (auth()->user()->user_type == 'User')
                                            <li class="nav-item active">
                                                <a class="nav-link" href="{{ url('/dashboard') }}">संस्थान आवंटन सूची</a>
                                            </li>
                                        @else
                                            @if (auth()->user()->user_type == 'Director')
                                                <li class="nav-item dropdown">
                                                    <a class="nav-link dropdown-toggle" href="#" id="dropdown02"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                        key="SCHEME">नये आवेदन</a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdown02">
                                                        <a class="dropdown-item" href="{{ url('avedan') }}">नये आवेदन</a>
                                                        <a class="dropdown-item"
                                                            href="{{ url('avedan-districtwise') }}">नये आवेदन जनपद वार</a>
                                                    </div>
                                                </li>
                                            @else
                                                <li class="nav-item active">
                                                    <a class="nav-link" href="{{ url('avedan') }}">नये आवेदन</a>
                                                </li>
                                            @endif





                                            @if (auth()->user()->user_type != 'District Officer')
                                                <li class="nav-item active">
                                                    <a class="nav-link" href="{{ url('total-avedan') }}">कुल आवेदन</a>
                                                </li>
                                            @endif

                                            @if (auth()->user()->user_type == 'District Officer')
                                                <li class="nav-item dropdown">
                                                    <a class="nav-link dropdown-toggle" href="#" id="dropdown02"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                        key="SCHEME">मेरिट सूची (स्क्रीनिंग)</a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdown02">
                                                        <a class="dropdown-item" href="{{ url('merit-list') }}/1">सामान्य
                                                            / अन्य पिछड़ा वर्ग</a>
                                                        <a class="dropdown-item"
                                                            href="{{ url('merit-list') }}/2">अनुसूचित जाति</a>
                                                        <a class="dropdown-item"
                                                            href="{{ url('merit-list') }}/3">अनुसूचित जनजाति</a>
                                                    </div>
                                                </li>
                                            @endif


                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="#" id="dropdown02"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                    key="SCHEME">आवेदन</a>
                                                <div class="dropdown-menu" aria-labelledby="dropdown02">
                                                    <a class="dropdown-item" href="{{ url('approved-avedan') }}">स्वीकृत
                                                        आवेदन</a>
                                                    <a class="dropdown-item" href="{{ url('rejected-avedan') }}">अस्वीकृत
                                                        आवेदन</a>
                                                </div>
                                            </li>


                                            @if (auth()->user()->user_type == 'District Officer')
                                                <li class="nav-item active">
                                                    <a class="nav-link" href="{{ url('document-verification') }}">अभिलेख
                                                        सत्यापन</a>
                                                </li>
                                                <li class="nav-item active">
                                                    <a class="nav-link" href="{{ url('upload-documents') }}">डॉक्यूमेंट
                                                        सत्यापन/अपलोड</a>
                                                </li>
                                            @endif
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="#" id="dropdown02"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                    key="SCHEME">चयनित अभ्यर्थियों की सूची</a>
                                                <div class="dropdown-menu" aria-labelledby="dropdown02">
                                                    <a class="dropdown-item" href="{{ url('all-list') }}">सभी</a>
                                                    <a class="dropdown-item" href="{{ url('general-list') }}">सामान्य /
                                                        अन्य पिछड़ा वर्ग</a>
                                                    <a class="dropdown-item" href="{{ url('sc-list') }}">अनुसूचित
                                                        जाति</a>
                                                    <a class="dropdown-item" href="{{ url('st-list') }}">अनुसूचित
                                                        जनजाति</a>
                                                </div>
                                            </li>

                                            @if (auth()->user()->user_type == 'District Officer')
                                                <li class="nav-item dropdown">
                                                    <a class="nav-link dropdown-toggle" href="#" id="dropdown02"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                        key="SCHEME">प्रतीक्षा सूची</a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdown02">
                                                        <a class="dropdown-item"
                                                            href="{{ url('waiting-list') }}/1">सामान्य / अन्य पिछड़ा
                                                            वर्ग</a>
                                                        <a class="dropdown-item"
                                                            href="{{ url('waiting-list') }}/2">अनुसूचित जाति</a>
                                                        <a class="dropdown-item"
                                                            href="{{ url('waiting-list') }}/3">अनुसूचित जनजाति</a>
                                                    </div>
                                                </li>
                                                <li class="nav-item active">
                                                    <a class="nav-link" href="{{ url('maitri-home') }}">मैत्री</a>
                                                </li>
                                            @endif


                                            @if (auth()->user()->user_type == 'Admin')
                                                <li class="nav-item active">
                                                    <a class="nav-link" href="{{ url('institute') }}">संस्थान प्रबंधन</a>
                                                </li>
                                            @endif


                                            @if (auth()->user()->user_type == 'Director')
                                                <li class="nav-item dropdown">
                                                    <a class="nav-link dropdown-toggle" href="#" id="dropdown02"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                        key="SCHEME">संस्थान आवंटन</a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdown02">
                                                        <a class="dropdown-item" href="{{ url('allocation') }}">अभ्यर्थी
                                                            आवंटन </a>
                                                        <a class="dropdown-item"
                                                            href="{{ url('allocation-list') }}">अभ्यर्थी आवंटन सूची</a>
                                                    </div>
                                                </li>
                                            @endif

                                            <li class="nav-item active">
                                                <a class="nav-link" href="{{ url('candidate-not-joined') }}">संस्थान
                                                    ज्वाइन नहीं किया है</a>
                                            </li>

                                            @if (auth()->user()->user_type == 'Admin')
                                                <li class="nav-item active">
                                                    <a class="nav-link" href="{{ url('setting') }}">सेटिंग्स</a>
                                                </li>
                                            @endif

                                            <li class="nav-item active">
                                                <a class="nav-link" href="{{ url('changePassword') }}">चेंज पासवर्ड</a>
                                            </li>
                                            <li class="nav-item active">
                                                <a class="nav-link" href="{{ url('maitri-home') }}">मैत्री</a>
                                            </li>
                                         
                                            <li class="nav-item active">
                                                <a class="nav-link" href="{{ url('cvo-officer') }}">सीवीओ/वीओ अधिकारी</a>
                                            </li>
                                           
                                            <li class="nav-item active">
                                                <a class="nav-link" href="{{ url('demand-requests-list') }}">Demand Requests Listing</a>
                                            </li>
                                        @endif
                                    @else
                                        <li class="nav-item active">
                                            <a class="nav-link" href="{{ url('/') }}" key="HOME">मुख्य
                                                पृष्ठ<span class="sr-only">(current)</span></a>
                                        </li>

                                        <li class="nav-item active">
                                            <a class="nav-link" href="{{ url('avedan-karein') }}">आवेदन</a>
                                        </li>

                                        <li class="nav-item active">
                                            <a class="nav-link" href="{{ url('lakshya') }}">स्वरोजगारी मैत्री की
                                                संख्या</a>
                                        </li>
                                        <li class="nav-item active">
                                            <a class="nav-link" href="{{ url('application-status') }}">आवेदन की स्थिति
                                                जानिए</a>
                                        </li>
                                        <li class="nav-item active">
                                            <a class="nav-link" href="{{ url('downloads') }}">डाउनलोड</a>
                                        </li>
                                        <li class="nav-item active">
                                            <a class="nav-link" href="{{ url('demandRequests') }}">मांग अनुरोध</a>
                                        </li>
                                        <!-- <li class="nav-item active">
                                            <a class="nav-link" href="{{ url('add-seman-form') }}">वीर्य तिनके फार्म</a>
                                        </li> -->
                                        <li class="nav-item active">
                                            <a class="nav-link" href="{{ url('maitri-register') }}">Maitri Register</a>
                                        </li>
                                        <li class="nav-item active">
                                            <a class="nav-link" href="{{ url('farmer-register') }}">Farmer Register</a>
                                        </li>
                                    @endauth
                                @endif
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>

        </div>
    </div>

    @yield('content')
    <div style="margin-top:20px;"></div>
    <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
    <script type="text/javascript" src="{{ asset('') }}js/abootstrap.min.js"></script>
    <div class="container-fluid ftr_div" style="background-color: white;">
        <div id="footer">
            <div class="container-fluid ftr_links" align="center">
                <div class="row" style="font-size: 16px; line-height: 20px;">

                    @if (Route::has('login'))
                        @auth
                        @else
                            <div class="col-lg-12">
                                <div class="col-md-12 englang">
                                    <a href="{{ url('/') }}" key="HOME">मुख्य पृष्ठ <span
                                            class="sr-only">(current)</span></a>
                                    | <a href="{{ url('avedan-karein') }}">आवेदन</a>
                                    | <a href="{{ url('lakshya') }}">स्वरोजगारी मैत्री की संख्या</a>
                                </div>
                            </div>
                        @endauth
                    @endif


                </div>
            </div>

            <!-- slider -->
            <div class="copyright-txt">
                <center><?php echo date('Y'); ?>-<?php echo date('Y', strtotime('+1 year')); ?> © Rashtriya Gokul Mission All rights reserved</center>

            </div>
        </div>
    </div>
    <script>
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

    <style type="text/css">
        .loader {
            /* position: fixed; */
            z-index: 999;
            height: 20px;
            width: 20px;
            top: 0;
            left: 0;
            /* background-color: Black; */
            filter: alpha(opacity=60);
            opacity: 0.6;
            -moz-opacity: 0.8;
        }

        .center {
            z-index: 1000;
            margin: 300px auto;
            padding: 10px 10px 10px 10px;
            width: 60px;
            height: 60px;
            background-color: White;
            border-radius: 10px;
            filter: alpha(opacity=100);
            opacity: 1;
            -moz-opacity: 1;
        }

        .center img {
            height: 50px;
            width: 50px;
        }
    </style>

    <div class="loader" style="display: none">
        <div class="center">
            <span class="fa fa-spinner fa-spin fa-3x" style="margin-top: 10px;"></span>
        </div>
    </div>

    <!-- Modal -->
    <style>
        .modal-dialog {
            max-width: 900px;
        }
    </style>
    <div class="modal fade" id="myModel" tabindex="-1" role="dialog" aria-labelledby="myModel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">अभ्यर्थी का स्वत: मूल्यांकन</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="responseID">
                        <div class="spinner-border"></div>
                    </span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @stack('body-scripts')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>

</html>
