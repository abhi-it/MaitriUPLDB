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
            changeMonth: true,
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

    .footer_parent {
        background-color: #ea7327;
        color: #000;
        /* padding-top: 7rem;
    margin-top: 9rem */
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

    .btn-close {
        box-sizing: content-box;
        width: 1em;
        height: 1em;
        padding: .25em .25em;
        color: #000;
        background: transparent url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e) center / 1em auto no-repeat;
        border: 0;
        border-radius: .25rem;
        opacity: .5;
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


                    </div>

                    <div class="tp-right" style="float: right;">


                        @if (Route::has('login'))
                        <span>
                            @auth
                            Welcome,&nbsp;{{ Auth::user()->name }} |
                            <a href="{{ route('logout') }}" id="logout_btn"
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
                            <a href="{{ url('/') }}"> <img src="{{ asset('') }}images/logo.jpg" height="125"></a>
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
                                @if(Auth::user()->role_id=='3')
                                <li class="nav-item active">
                                    <a class="nav-link" href="{{ url('/maitri-dashboard') }}">डैशबोर्ड </a>
                                </li>
                                <li class="nav-item active">
                                    <a class="nav-link" href="{{ url('/request-list') }}">सेवा अनुरोध सूची </a>
                                </li>
                                <li class="nav-item active">
                                    <a class="nav-link" href="{{ url('/monthly-report') }}">मासिक प्रगति रिपोर्ट
                                        (एमपीआर) </a>
                                </li>
                                @else
                                <li class="nav-item active">
                                    <a class="nav-link" href="{{ url('/farmer-dashboard') }}">डैशबोर्ड </a>
                                </li>
                                <li class="nav-item active">
                                    <a class="nav-link" href="{{ url('/service-request') }}">सेवा अनुरोध जोड़ें </a>
                                </li>
                                <li class="nav-item active">
                                    <a class="nav-link" href="{{ url('/high-yielding-animal') }}">उच्च उपज वाले पशु </a>
                                </li>
                                @endif
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
    <!-- </footer> -->

    <footer class="position-relative">
        @if (Route::has('login'))
        @auth
        @else
        <div class="footer_parent">
            <div class="row g-3 footer_top_footer__u_0LC">
                <div class="col-lg-4">
                    <h5><i class="fa fa-map-marker"></i> Head Office</h5>
                    <p>Gokaran Nath Road, Badshahbagh, Lucknow 226007</p>
                    <h5><i class="fa fa-envelope"></i> Email Us</h5>
                    <p class="mb-0">MAITRI Cell - upldbte@gmail.com</p>
                    <p class="mb-0">Grievance Cell - upldbmaitri@gmail.com</p>
                    <p class="mb-0">Insurance - pashubeemaupldb@gmail.com</p>
                    <p class="mb-0">Sexed Semen - upldbss@gmail.com</p>
                </div>
                <div class="col-lg-4">
                    <h5><i class="fa fa-phone"></i> Call Us</h5>
                    <p class="mb-0">Landline Number - +91-522-2977709</p>
                    <p class="mb-0">Insurance - +91 - 9335116448</p>
                    <p class="mb-0">MAITRI - +91 - 9125904205</p>
                    <p class="mb-0 mt-2 fw-semibold">Uttar Pradesh Livestock Development Board</p>
                </div>
                <div class="col-lg-4">
                    <div class="d-flex flex-column justiry-content-center align-items-center w-100">
                        <h5>Download App</h5><a href="#"><img
                                src="https://upldb.vercel.app/assets/images/site/pashudhan_app1.png" width="120px"
                                alt=""></a>
                    </div>
                </div>
            </div>
            <div class="row align-items-top gap-5 px-2 mx-0 pt-4 pb-3 footer_footer__O">
                <div class="col-lg-3 align-items-top text-center">
                    <img src="https://maitriupldb.in/assets/images/upldb-logo.png" alt="" width="150">
                    <span style="line-height:25px;display:block" class="mb-0 mt-3 text-white"> उन्नत संतति हेतु
                        संकल्पबद्ध</span>
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
                        <li>
                            <a href="{{ url('lakshya') }}">
                                <span data-hi="स्वरोजगारी मैत्री (पशु मित्र) की संख्या"
                                    data-en="Number of Swarozgari Maitri (Animal Friends)"></span>
                            </a>
                        </li>
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
                        <li>
                            <a href="{{ url('demandRequests') }}">
                                <span data-hi="मांग अनुरोध" data-en="Demand Requests"></span>
                            </a>
                        </li>
                    </ul>



                </div>
                <div class="col-lg-2">
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
                <div class="col-lg-2">
                    <h5 class="footer--heading">
                        <span data-hi="संपर्क करें" data-en="Contact Us"></span>
                    </h5>
                    <ul class="list-unstyled">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3559.08297384528!2d80.935781475438!3d26.86910477667314!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x399bfd9c9604bea9%3A0x88634ee93200bb69!2sVETERINARY%20POLYCLINIC%20BADSHAH%20BAGH%2C%20LUCKNOW!5e0!3m2!1sen!2sin!4v1705036303907!5m2!1sen!2sin"
                            width="250" height="200"></iframe>
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
                Rashtriya Gokul Mission All rights reserved</p>
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
    <div class="modal fade" id="myModel" tabindex="-1" role="dialog" aria-labelledby="myModel" aria-hidden="true">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script type="text/javascript">
    $('#logout_btn').click(function() {
        localStorage.removeItem('maitri');
        localStorage.removeItem('farmer');
    });
    </script>
</body>

</html>