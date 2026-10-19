@extends('submaster')
@section('content')
<div class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
    <h3 class="text-center fw-bold m-4">सेवा अनुरोध सूची</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>क्र. सं.</th>
                <th>सेवा का नाम</th>
                <th>मैत्री</th>
                <th>संदेश</th>
                <th>स्थिति देखे</th>
            </tr>
        </thead>
        <tbody>
            @if(count($data))
            @foreach($data as $key=> $row)
            <tr>
                <td>{{$key+1}}</td>
                @php
                    $serviceLabels = [
                        'health_medical_checkip' => 'स्वास्थ्य/चिकित्सा जांच',
                        'animal_insurance'       => 'पशु बीमा',
                        'vaccination'            => 'टीकाकरण',
                        'pregnancy_diagnosis'    => 'गर्भावस्था निदान',
                        'artificial_insemination'=> 'कृत्रिम गर्भाधान',
                        'livestock_insurance'    => 'पशुधन बीमा',
                        'calving'                => 'बछड़ा जनन',
                    ];
                @endphp
                <td>{{ $serviceLabels[$row->service_name] ?? '--' }}</td>
                <td>{{ $row->maitri->maitri_name ?? '--' }}</td>
                <td>{{ $row->request_message }}</td>

                @if($row->status == 1)
                    <td><button class="btn btn-primary">नया है</button></td>
                @elseif($row->status == 2)
                    <td><button class="btn btn-warning">इंतज़ार में है</button></td>
                @elseif($row->status == 3)
                    <td><button class="btn btn-danger">अस्वीकार किया गया है</button></td>
                @elseif($row->status == 0)
                    <td>
                        
                        <button class="btn btn-success">स्वीकार कर लिया है</button>
                        @if($row->status == 0)
                            @if($row->feedback()->exists())
                                <button class="btn btn-secondary feedback-done"
                                        data-id="{{ $row->id }}">
                                    प्रतिक्रिया दी गई
                                </button>
                            @else
                                <button class="btn btn-info feedback-btn"
                                        data-id="{{ $row->id }}"
                                        data-service="{{ $row->service_name }}">
                                    प्रतिक्रिया दें
                                </button>
                            @endif
                        @endif
                    
                    </td>
                @else
                    <td>--</td>
                @endif
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="6" style="color:red;">No records..</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>

{{-- ================= Feedback Modal ================= --}}
<div class="modal fade" id="feedbackModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="feedbackForm">
                @csrf
                <input type="hidden" name="service_id" id="feedback_service_id">
                <input type="hidden" name="rating" id="feedback_rating" value="">

                <div class="modal-header">
                    <h5 class="modal-title">प्रतिक्रिया दें</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    {{-- Star Rating --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">रेटिंग दें <span class="text-danger">*</span></label>
                        <div class="star-rating" id="starRating">
                            <i class="fa fa-star star" data-value="1"></i>
                            <i class="fa fa-star star" data-value="2"></i>
                            <i class="fa fa-star star" data-value="3"></i>
                            <i class="fa fa-star star" data-value="4"></i>
                            <i class="fa fa-star star" data-value="5"></i>
                        </div>
                        <small class="text-danger d-none" id="ratingError">कृपया रेटिंग दें।</small>
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">विवरण <span class="text-danger">*</span></label>
                        <textarea name="description" id="feedback_description"
                                  class="form-control" rows="3"
                                  maxlength="1500"
                                  placeholder="अपनी प्रतिक्रिया लिखें..."></textarea>
                        <small class="text-danger d-none" id="descError">कृपया विवरण लिखें।</small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">रद्द करें</button>
                    <button type="submit" class="btn btn-primary" id="submitFeedbackBtn">भेजें</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

{{-- ================= Styles ================= --}}
<style>
.star-rating {
    display: inline-flex;
    gap: 6px;
    font-size: 30px;
    cursor: pointer;
}
.star-rating .star {
    color: #ccc;
    transition: color 0.15s ease-in-out, transform 0.15s;
}
.star-rating .star.hover,
.star-rating .star.selected {
    color: #f5b301; /* yellow */
}
.star-rating .star:hover {
    transform: scale(1.1);
}
</style>

@push('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

{{-- ================= Scripts ================= --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {

    let selectedRating = 0;

    // ---- Star rating interaction ----
    function paintStars(rating) {
        $('#starRating .star').each(function () {
            $(this).toggleClass('selected', $(this).data('value') <= rating);
        });
    }

    $('#starRating .star').on('mouseenter', function () {
        paintStars($(this).data('value'));
    });

    $('#starRating .star').on('mouseleave', function () {
        paintStars(selectedRating);
    });

    $('#starRating .star').on('click', function () {
        selectedRating = $(this).data('value');
        $('#feedback_rating').val(selectedRating);
        paintStars(selectedRating);
        $('#ratingError').addClass('d-none');
    });

    // ---- Open modal ----
    $('.feedback-btn').on('click', function () {
        // reset
        selectedRating = 0;
        $('#feedbackForm')[0].reset();
        $('#feedback_rating').val('');
        $('#feedback_service_id').val($(this).data('id'));
        paintStars(0);
        $('#ratingError, #descError').addClass('d-none');

        $('#feedbackModal').modal('show');
    });

    // ---- Already submitted button ----
    $('.feedback-done').on('click', function () {
        Swal.fire({
            icon: 'info',
            title: 'पहले ही जमा किया जा चुका है',
            text: 'आप इस सेवा अनुरोध के लिए पहले ही प्रतिक्रिया दे चुके हैं।',
        });
    });

    // ---- Submit ----
    $('#feedbackForm').on('submit', function (e) {
        e.preventDefault();

        let isValid = true;

        // Rating required
        if (!selectedRating) {
            $('#ratingError').removeClass('d-none');
            isValid = false;
        } else {
            $('#ratingError').addClass('d-none');
        }

        // Description required
        if ($.trim($('#feedback_description').val()) === '') {
            $('#descError').removeClass('d-none');
            isValid = false;
        } else {
            $('#descError').addClass('d-none');
        }

        if (!isValid) return;

        let $btn = $('#submitFeedbackBtn');
        $btn.prop('disabled', true).text('भेज रहे हैं...');

        $.ajax({
            url: "{{ route('farmer-submit-feedback') }}",
            type: "POST",
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            data: {
                _token: '{{ csrf_token() }}',
                service_id: $('#feedback_service_id').val(),
                rating: $('#feedback_rating').val(),
                description: $('#feedback_description').val(),
            },
            success: function (res) {
                if (res.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'धन्यवाद!',
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false,
                    }).then(() => location.reload());
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: res.message || 'Something went wrong.',
                    });
                }
            },
            error: function (xhr) {
                let msg = 'Something went wrong.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                Swal.fire({ icon: 'error', title: 'Error', text: msg });
            },
            complete: function () {
                $btn.prop('disabled', false).text('भेजें');
            },
        });
    });

});
</script>