@extends('submaster')
@section('content')
@php
    use App\Models\Districts;
    use App\Models\Rejectcomment;
    use App\Models\Verificationcomment;
    $coments = Rejectcomment::where('application_id', '=', $result->id)->first();
    $verificationcoments = Verificationcomment::where('application_id', '=', $result->id)->first();
    $district = Districts::find($result->district_id);
    $category = [
        'जनरल' => 'सामान्य (general)',
        'ओ बी सी' => 'अन्य पिछड़ा वर्ग  (OBC)',
        'एस सी' => 'अनुसूचित जाति (SC)',
        'एस टी' => 'अनुसूचित जनजाति (ST)',
    ];
@endphp

<style>
    .avedan-section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #13509e;
        margin-bottom: 1.5rem;
        border-left: 5px solid #13509e;
        padding-left: 14px;
        background: linear-gradient(90deg, #e3edf8 80%, #fff 100%);
    }
    .avedan-card {
        background: #f8fafc;
        box-shadow: 0 2px 4px rgba(20,20,20,.03);
        border-radius: 10px;
        padding: 2rem;
        margin-bottom: 2rem;
        border: 1px solid #e0e7ef;
    }
    .avedan-table {
        background: #fff;
        border-radius: 6px;
        overflow: hidden;
        box-shadow: 0 1px 2px rgba(20,20,20,.09);
        margin-bottom: 2rem;
    }
    .avedan-table th,
    .avedan-table td {
        text-align: center;
        vertical-align: middle;
    }
    .avedan-label {
        font-weight: 600;
        color: #003366;
        width: 46%;
        display: inline-block;
    }
    .avedan-data {
        color: #111;
        font-size: 1rem;
        display: inline-block;
    }
    .avedan-file-link {
        display: block;
        margin-top: 2px;
        color: #1259a5;
        font-size: 12px;
        text-decoration: underline;
    }
    .avedan-avatar {
        max-width: 80px;
        border-radius: 7px;
        border: 1px solid #e0e7ef;
        margin: 2px 0;
        background: #fff;
    }
    .avedan-status .btn {
        min-width: 80px;
        font-size: 0.92rem;
        margin-top: 8px;
    }
    .avedan-alert {
        border-radius: 7px;
        font-weight: 600;
    }
    @media (max-width: 768px) {
        .avedan-card{padding:1rem;}
        .avedan-section-title{font-size:1.1rem;}
        .avedan-label, .avedan-data{display:block;width:100%;}
    }
</style>

<div class="container main-div py-5" style="background-color: #f1f5fa; min-height:90vh;">
    <div class="avedan-section-title d-flex justify-content-between align-items-center flex-wrap">
        <span>आवेदन - पत्र</span>
        <a href="{{ route('avedan-list') }}" class="btn btn-outline-primary btn-sm"> <i class="fa fa-arrow-left"></i> वापस जाएं</a>
    </div>

    @if (session()->get('success'))
        <div class="alert alert-success avedan-alert">
            {{ session()->get('success') }}
        </div>
    @endif

    <div class="avedan-card">
        <div class="avedan-section-title">आवेदक का विवरण</div>
        @if(!empty($coments))
            <div class="alert alert-danger avedan-alert mb-3">{{ $coments->comments }}</div>
        @endif
        <div class="row gy-3">
            <div class="col-md-6">
                <span class="avedan-label">आवेदक का नाम:</span>
                <span class="avedan-data">{{ $result->applicant_name }}</span>
            </div>
            <div class="col-md-6">
                <span class="avedan-label">पिता / पति का नाम:</span>
                <span class="avedan-data">{{ $result->fname }}</span>
            </div>
            <div class="col-md-6">
                <span class="avedan-label">माता का नाम:</span>
                <span class="avedan-data">{{ $result->mother }}</span>
            </div>
            <div class="col-md-6">
                <span class="avedan-label">जन्म तिथि (हाई स्कूल प्रमाण पत्र के अनुसार):</span>
                <span class="avedan-data">{{ \Carbon\Carbon::parse($result->dob)->format('d-m-Y') }}</span>
            </div>
            <div class="col-md-6">
                <span class="avedan-label">पिछला आवेदन नंबर:</span>
                <span class="avedan-data">{{ $result->previous_avedan_number }}</span>
            </div>
            <div class="col-md-6">
                <span class="avedan-label">दूरभाष / मोबाइल नंबर:</span>
                <span class="avedan-data">{{ $result->mobile }}</span>
            </div>
            <div class="col-md-6">
                <span class="avedan-label">श्रेणी:</span>
                <span class="avedan-data">{{ @$category[$result->category] }}</span>
            </div>
            <div class="col-md-6">
                <span class="avedan-label">स्थायी पते के प्रमाण का प्रकार:</span>
                <span class="avedan-data">{{ $result->address_type }}</span>
            </div>
            <div class="col-md-6">
                <span class="avedan-label">स्थायी पता:</span>
                <span class="avedan-data">{{ $result->permanent_address }}</span>
            </div>
            <div class="col-md-6">
                <span class="avedan-label">स्थायी पता का प्रमाण - पत्र:</span>
                @if ($result->permanent_address_proof != '')
                    <img class="avedan-avatar" src="{{ asset('upload_documents/'.$result->permanent_address_proof) }}">
                    <a href="{{ asset('upload_documents/'.$result->permanent_address_proof) }}"
                        target="_blank" class="avedan-file-link">View</a>
                @else
                    <span class="text-muted">No documents</span>
                @endif
            </div>
            <div class="col-md-6">
                <span class="avedan-label">पोस्ट ऑफिस:</span>
                <span class="avedan-data">{{ $result->post_office }}</span>
            </div>
            <div class="col-md-6">
                <span class="avedan-label">पिनकोड:</span>
                <span class="avedan-data">{{ $result->pincode }}</span>
            </div>
            <div class="col-md-6">
                <span class="avedan-label">ग्राम पंचायत का नाम:</span>
                <span class="avedan-data">{{ $result->gram_panchayat_name }}</span>
            </div>
            <div class="col-md-6">
                <span class="avedan-label">लिंग:</span>
                <span class="avedan-data">{{ $result->gender }}</span>
            </div>
            @if($result->gender == 'महिला')
            <div class="col-md-6">
                <span class="avedan-label">पशु सखी/आजीविका सखी (एनआरएलएम):</span>
                <span class="avedan-data">{{ $result->pashu_sakhi == '1' ? 'हाँ' : 'नहीं' }}</span>
            </div>
            @endif
            <div class="col-md-6">
                <span class="avedan-label">जनपद:</span>
                <span class="avedan-data">{{ $district ? $district->name_hindi : '' }}</span>
            </div>
            <div class="col-md-6">
                <span class="avedan-label">विकास खण्ड:</span>
                <span class="avedan-data">{{ $result->vikas_khand }}</span>
            </div>
            <div class="col-md-6">
                <span class="avedan-label">पत्र - व्यवहार का पता:</span>
                <span class="avedan-data">{{ $result->letter_address }}</span>
            </div>
            <div class="col-md-6">
                <span class="avedan-label">ई - मेल:</span>
                <span class="avedan-data">{{ $result->email }}</span>
            </div>
            <div class="col-md-6">
                <span class="avedan-label">आवेदक की फोटो:</span>
                @if ($result->applicant_photo != '')
                    <img class="avedan-avatar" src="{{ asset('upload_documents/'.$result->applicant_photo) }}">
                    <a href="{{ asset('upload_documents/'.$result->applicant_photo) }}"
                        target="_blank" class="avedan-file-link">View</a>
                @else
                    <span class="text-muted">No documents</span>
                @endif
            </div>
            <div class="col-md-6">
                <span class="avedan-label">अभ्यर्थी का हस्ताक्षर:</span>
                @if ($result->signature != '')
                    <img class="avedan-avatar" src="{{ asset('upload_documents/'.$result->signature) }}">
                    <a href="{{ asset('upload_documents/'.$result->signature) }}"
                        target="_blank" class="avedan-file-link">View</a>
                @else
                    <span class="text-muted">No documents</span>
                @endif
            </div>
        </div>
    </div>

    <div class="avedan-card">
        <div class="avedan-section-title">शैक्षिक योग्यता व अन्य विवरण</div>

        <table class="table avedan-table table-bordered mb-4">
            <thead class="table-light">
                <tr>
                    <th width="14%">उत्तीर्ण परीक्षा का नाम</th>
                    <th>बोर्ड का नाम</th>
                    <th>उत्तीर्ण वर्ष</th>
                    <th>प्राप्तांक</th>
                    <th>पूर्णांक</th>
                    <th>प्रतिशत</th>
                    <th>अंकतालिका</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>हाई स्कूल (जीव विज्ञान)</td>
                    <td>{{ $result->high_board_name }}</td>
                    <td>{{ $result->high_passing_year }}</td>
                    <td>{{ $result->high_marks }}</td>
                    <td>{{ $result->high_total_marks }}</td>
                    <td>{{ $result->high_percentage }}</td>
                    <td>
                        @if ($result->high_marksheet != '' && @file_exists(public_path() . '/upload_documents/' . $result->high_marksheet))
                            <img class="avedan-avatar" src="{{ asset('upload_documents/'.$result->high_marksheet) }}">
                            <a href="{{ asset('upload_documents/'.$result->high_marksheet) }}" target="_blank" class="avedan-file-link">View</a>
                        @else
                            <span class="text-muted">No documents</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>इण्टर (जीव विज्ञान)</td>
                    <td>{{ $result->inter_board_name }}</td>
                    <td>{{ $result->inter_passing_year }}</td>
                    <td>{{ $result->inter_marks }}</td>
                    <td>{{ $result->inter_total_marks }}</td>
                    <td>{{ $result->inter_percentage }}</td>
                    <td>
                        @if ($result->inter_marksheet != '' && @file_exists(public_path() . '/upload_documents/' . $result->inter_marksheet))
                            <img class="avedan-avatar" src="{{ asset('upload_documents/'.$result->inter_marksheet) }}">
                            <a href="{{ asset('upload_documents/'.$result->inter_marksheet) }}" target="_blank" class="avedan-file-link">View</a>
                        @else
                            <span class="text-muted">No documents</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="row gy-3">
            @if ($result->training_adopted != 'नहीं')
                <div class="col-md-6">
                    <span class="avedan-label">कृत्रिम गर्भाधान के प्रशिक्षण का प्रमाण पत्र:</span>
                    @if ($result->training_certificate != '')
                        <img class="avedan-avatar" src="{{ asset('upload_documents/'.$result->training_certificate) }}">
                        <a href="{{ asset('upload_documents/'.$result->training_certificate) }}" target="_blank" class="avedan-file-link">View</a>
                    @else
                        <span class="text-muted">No documents</span>
                    @endif
                </div>
                <div class="col-md-3">
                    <span class="avedan-label">माह:</span>
                    <span class="avedan-data">{{ $result->training_certificate_period_in_month }}</span>
                </div>
                <div class="col-md-3">
                    <span class="avedan-label">दिन:</span>
                    <span class="avedan-data">{{ $result->training_certificate_period_in_days }}</span>
                </div>
                <div class="col-md-6">
                    <span class="avedan-label">योजना का नाम (प्रशिक्षण):</span>
                    <span class="avedan-data">{{ $result->yojna_name_for_training }}</span>
                </div>
                <div class="col-md-6">
                    <span class="avedan-label">ए. आई. किट तथा बायोलोजिकल कन्टेनर:</span>
                    <span class="avedan-data">{{ $result->AIkit }}</span>
                </div>
            @endif

            <div class="col-md-6">
                <span class="avedan-label">वोटर आई डी कार्ड / आधार कार्ड / पैन कार्ड का प्रमाण पत्र:</span>
                @if ($result->id_upload != '')
                    <img class="avedan-avatar" src="{{ asset('upload_documents/'.$result->id_upload) }}">
                    <a href="{{ asset('upload_documents/'.$result->id_upload) }}" target="_blank" class="avedan-file-link">View</a>
                @else
                    <span class="text-muted">No documents</span>
                @endif
            </div>
            <div class="col-md-6">
                <span class="avedan-label">जाति प्रमाण पत्र:</span>
                @if ($result->caste_certificate != '')
                    <img class="avedan-avatar" src="{{ asset('upload_documents/'.$result->caste_certificate) }}">
                    <a href="{{ asset('upload_documents/'.$result->caste_certificate) }}" target="_blank" class="avedan-file-link">View</a>
                @else
                    <span class="text-muted">No documents</span>
                @endif
            </div>
            <div class="col-md-6">
                <span class="avedan-label">स्वास्थ्य प्रमाण पत्र:</span>
                @if ($result->health_certificate != '')
                    <img class="avedan-avatar" src="{{ asset('upload_documents/'.$result->health_certificate) }}">
                    <a href="{{ asset('upload_documents/'.$result->health_certificate) }}" target="_blank" class="avedan-file-link">View</a>
                @else
                    <span class="text-muted">No documents</span>
                @endif
            </div>
            <div class="col-md-6">
                <span class="avedan-label">राष्ट्रीयता:</span>
                <span class="avedan-data">{{ $result->nationality }}</span>
            </div>
            <div class="col-md-6 avedan-status">
                <span class="avedan-label">स्टेटस:</span>
                @if ($result->is_approved == 0)
                    <span class="btn btn-sm btn-secondary">लंबित</span>
                @elseif($result->is_approved == 1)
                    <span class="btn btn-sm btn-success">स्वीकृत</span>
                @elseif($result->is_approved == 2)
                    <span class="btn btn-sm btn-danger">अस्वीकार</span>
                @elseif($result->is_approved == 3)
                    <span class="btn btn-sm btn-info active">प्रतीक्षा सूची में है</span>
                @elseif($result->is_approved == 4)
                    <span class="btn btn-sm btn-primary active">चयनित</span>
                @endif
            </div>
        </div>

        @if(!empty($coments))
            <div class="alert alert-danger avedan-alert mt-4">{{ $coments->comments }}</div>
        @endif

        @if(!empty($verificationcoments))
            <div class="alert alert-info avedan-alert mt-3">{{ $verificationcoments->comments }}</div>
        @endif
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form method="post" action="{{ url('rejectApplication') }}" id="myForm"
            enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">अस्वीकार आवेदन</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="avedan-label">आवेदन संख्या:</label>
                        <span class="avedan-data">{{ $result->applicationNumber }}</span>
                        <input type="hidden" value="{{ $result->id }}" name="application_id">
                    </div>
                    <div class="mb-2">
                        <label class="avedan-label">आवेदन अस्वीकार करने का कारण</label>
                        <textarea class="form-control" style="min-height:100px;" name="comments" id="comments"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light communicationAddress1" data-dismiss="modal">बंद करें</button>
                    <button type="submit" class="btn btn-primary communicationAddress2">अस्वीकार करें</button>
                    <span class="spinner-border spinner-border-sm loader saveLoader" role="status"
                        aria-hidden="true" style="display:none;"></span>
                    <span class="saveCommunicationAddress"></span>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#myForm').validate({
            rules: {
                "comments": { required: true }
            },
            submitHandler: function(form) {
                $('.communicationAddress1').hide();
                $('.communicationAddress2').hide();
                $('.saveLoader').show();
                $('.saveCommunicationAddress').html('Please Wait, Saving..');
                form.submit();
            },
        });

        $('.exampleModalCenter').click(function(){
            $('#exampleModalCenter').modal('show');
        });
        $('.close').click(function(){
            $('#exampleModalCenter').modal('hide');
        });
    });
</script>
@endsection
