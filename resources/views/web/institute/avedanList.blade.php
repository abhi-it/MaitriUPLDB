@extends('submaster')
@section('content')
    <div class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
        <h3 class="text-center fw-bold m-4">आवेदन सूची</h3>

        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-primary">
                    <tr>
                        <th scope="col"><span data-hi="क्र. सं." data-en="S. No."></span></th>
                        <th scope="col"><span data-hi="आवेदन नंबर" data-en="Application Number"></span></th>
                        <th scope="col"><span data-hi="आवेदक का नाम" data-en="Applicant Name"></span></th>
                        <th scope="col"><span data-hi="पिताजी/माताजी का नाम" data-en="Father/Mother Name"></span></th>
                        <th scope="col"><span data-hi="मोबाइल नंबर" data-en="Mobile Number"></span></th>
                        <th scope="col"><span data-hi="स्व मूल्यांकन अंक" data-en="Self-Assessment Marks"></span></th>
                        <th scope="col"><span data-hi="आवेदन दिनांक" data-en="Application Date"></span></th>
                        <th scope="col"><span data-hi="स्थिति" data-en="Status"></span></th>
                        <th scope="col"><span data-hi="क्रिया" data-en="Action"></span></th>
                    </tr>
                </thead>

                <tbody id="applications-table-body">
                    @if ($applications->count())
                        @foreach ($applications as $key => $row)
                            @php
                                $high_percentage = $row->high_percentage;
                                $high_school_calculation = round(($high_percentage * 8) / 10);
                                $inter_percentage = $row->inter_percentage;
                                $inter_calculation = round(($inter_percentage * 2) / 10);
                                $topper_number = $high_school_calculation + $inter_calculation;
                            @endphp
                            <tr id="app-row-{{ $row->id }}">
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $row->applicationNumber }}</td>
                                <td>{{ $row->applicant_name }}</td>
                                <td>{{ $row->fname ?? '--' }}{{ $row->mother ? '/' . $row->mother : '' }}</td>
                                <td>{{ $row->mobile }}</td>
                                <td>
                                    <a href="javascript:void(0)" onclick="viewCalculation({{ $row->id }});"
                                        title="View Calculation">
                                        {{ $topper_number }}
                                    </a>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d/m/Y') }}</td>
                                <td>
                                    @if ($row->is_approved == 1)
                                        <span class="badge bg-success" data-hi="स्वीकृत" data-en="Approved"></span>
                                    @elseif($row->is_approved == 2)
                                        <span class="badge bg-danger" data-hi="अस्वीकृत" data-en="Rejected"></span>
                                    @else
                                        <span class="badge bg-warning text-dark" data-hi="लंबित" data-en="Pending"></span>
                                    @endif
                                </td>
                                <td id="action-column-{{ $row->id }}">
                                    <a href="{{ url('avedan-details') }}/{{ $row->id }}"
                                        class="btn btn-sm btn-primary" title="View Details">
                                        <span data-hi="देखें" data-en="View"></span>
                                    </a>

                                    @if(!$row->maitri_id)
                                        <button class="btn btn-sm btn-primary generate-certificate-btn"
                                            data-id="{{ $row->id }}">Generate Certificate</button>
                                    @else
                                        <a target="_blank" href="{{ route('certificate-preview', $row->maitri_id) }}"
                                            class="btn btn-sm btn-success mb-1" title="View Certificate">
                                            Certificate
                                        </a>
                                        <a target="_blank" href="{{ route('id-card-preview', $row->maitri_id) }}"
                                            class="btn btn-sm btn-info mb-1" title="View ID Card">
                                            ID Card
                                        </a>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9" style="color:red;">कोई रिकॉर्ड नहीं मिला..</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Modal Pop-up Start -->
    <div class="modal fade" id="generateCertificateModal" tabindex="-1" role="dialog"
        aria-labelledby="generateCertificateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="generateCertificateModalLabel">Generate Certificate</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="generateCertificateForm">
                    @csrf
                    <div class="modal-body">
                        <div id="certificateErrorAlert" class="alert alert-danger d-none"></div>
                        <input type="hidden" name="id" id="generateCertificateId">
                        <span class="text-danger fw-bold text-start small">Important: </span>
                        <span class="text-start small">During certificate generation, a Maitri account is created and both Digital Certificate and ID Card are generated automatically. Institute only fills certificate details.</span>

                        <div class="row mt-2">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="certificate_no">Certificate No
                                        <button type="button" class="btn btn-sm btn-primary" id="generateCertificateBtn">Generate</button>
                                    </label>
                                    <input type="text" class="form-control" name="certificate_no" id="certificate_no"
                                        placeholder="Enter Certificate Number">
                                    <div class="invalid-feedback text-danger" id="error-certificate_no"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="pass_date">Pass Date</label>
                                    <input type="date" class="form-control" name="pass_date" id="pass_date">
                                    <div class="invalid-feedback text-danger" id="error-pass_date"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" id="password"
                                        placeholder="Enter Password">
                                    <div class="invalid-feedback text-danger" id="error-password"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="expiry_date">Expiry Date</label>
                                    <input type="date" class="form-control" name="expiry_date" id="expiry_date">
                                    <div class="invalid-feedback text-danger" id="error-expiry_date"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="any_bharat_id">Any Bharat ID</label>
                                    <input type="text" class="form-control" name="any_bharat_id" id="any_bharat_id"
                                        placeholder="Enter Any Bharat ID">
                                    <div class="invalid-feedback text-danger" id="error-any_bharat_id"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Generate Certificate</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Edit Modal Pop-up End -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            // Helper: clear individual field errors
            function clearFieldErrors() {
                $("#generateCertificateForm .form-control").removeClass("is-invalid");
                $("#generateCertificateForm .invalid-feedback").empty();
            }

            // Open modal and load data
            $('.generate-certificate-btn').click(function () {
                $('#certificateErrorAlert').addClass('d-none').empty();
                $('#generateCertificateForm')[0].reset();
                clearFieldErrors();
                const recordId = $(this).data('id');
                $('#generateCertificateId').val(recordId);
                $('#generateCertificateModal').modal('show');
            });

            // Generate certificate number button
            $('#generateCertificateBtn').on('click', function (e) {
                e.preventDefault();

                // More robust, unique certificate number based on timestamp and random 4-digit number
                const now = new Date();
                const y = now.getFullYear();
                const m = ('0' + (now.getMonth() + 1)).slice(-2);
                const d = ('0' + now.getDate()).slice(-2);
                const h = ('0' + now.getHours()).slice(-2);
                const min = ('0' + now.getMinutes()).slice(-2);
                const s = ('0' + now.getSeconds()).slice(-2);
                const rand = Math.floor(1000 + Math.random() * 9000);
                // Example: CERT-20240504-153021-4829
                const certificateNumber = `CERT-${y}${m}${d}-${h}${min}${s}-${rand}`;
                $('#certificate_no').val(certificateNumber);
            });

            // Submit form via AJAX handling validation and updating view button
            $('#generateCertificateForm').submit(function (e) {
                e.preventDefault();

                $('#certificateErrorAlert').addClass('d-none').empty();
                clearFieldErrors();

                $.ajax({
                    type: 'POST',
                    url: '/generate-maitri-certificate',
                    data: $(this).serialize(),
                    success: function (response) {
                        // Hide modal
                        $('#generateCertificateModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Certificate and ID Card generated successfully.',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            if (response.maitri_id && response.certificate_url && response.avedan_id) {
                                const btnHtml = `
                                    <a target="_blank" href="${response.certificate_url}"
                                        class="btn btn-sm btn-success mb-1" title="View Certificate">
                                        Certificate
                                    </a>
                                    <a target="_blank" href="${response.id_card_url}"
                                        class="btn btn-sm btn-info mb-1" title="View ID Card">
                                        ID Card
                                    </a>
                                `;
                                var actionCol = $('#action-column-' + response.avedan_id);
                                if (actionCol.length) {
                                    var existingBtns = actionCol.children();
                                    if (existingBtns.length > 1) {
                                        $(existingBtns[1]).remove();
                                    }
                                    actionCol.append(btnHtml);
                                }
                            }

                            window.open(response.certificate_url, '_blank');
                            if (response.id_card_url) {
                                window.open(response.id_card_url, '_blank');
                            }
                        });
                    },
                    error: function (xhr) {
                        clearFieldErrors();
                        let message = '';

                        // Check for 'Certificate number already exists' in JSON error
                        if (
                            xhr.status === 422 &&
                            xhr.responseJSON && (
                                (xhr.responseJSON.error && xhr.responseJSON.error === "Certificate number already exists") ||
                                (xhr.responseJSON.errors && (
                                    (Array.isArray(xhr.responseJSON.errors.certificate_no) && xhr.responseJSON.errors.certificate_no.includes("Certificate number already exists")) ||
                                    (typeof xhr.responseJSON.errors.certificate_no === 'string' && xhr.responseJSON.errors.certificate_no === "Certificate number already exists")
                                ))
                            )
                        ) {
                            message = "Certificate number already exists";
                            $('#certificateErrorAlert').removeClass('d-none').html(message);
                            // Also set red validation under the certificate_no field
                            $('#certificate_no').addClass('is-invalid');
                            $('#error-certificate_no').html('Certificate number already exists');
                        } else if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;
                            // Display each error next to field
                            for (const field in errors) {
                                if (errors.hasOwnProperty(field)) {
                                    const errorDiv = $(`#error-${field}`);
                                    if (errorDiv.length) {
                                        $(`[name="${field}"]`).addClass("is-invalid");
                                        errorDiv.html(errors[field].join('<br>'));
                                    }
                                }
                            }
                            // General message (optional: could comment out next line if not needed)
                            message = 'Please fix the errors below.';
                            $('#certificateErrorAlert').removeClass('d-none').html(message);
                        } else if (xhr.responseJSON && (xhr.responseJSON.message || xhr.responseJSON.error)) {
                            message = xhr.responseJSON.message ? xhr.responseJSON.message : xhr.responseJSON.error;
                            $('#certificateErrorAlert').removeClass('d-none').html(message);
                        } else {
                            message = 'An error occurred. Please try again.';
                            $('#certificateErrorAlert').removeClass('d-none').html(message);
                        }
                    }
                });
            });
        });
    </script>
@endsection
