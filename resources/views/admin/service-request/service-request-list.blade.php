@extends('master')
@section('content')
<style>
    .tooltip-inner {
        max-width: 400px;
        text-align: left;
        white-space: normal;
        word-break: break-word;
    }

    .msg-cell {
        vertical-align: top;
        word-break: break-word;
        overflow-wrap: anywhere;
    }
</style>
<div class="container main-div">
    <div class="row">
        <div class="col-md-12">
            <h3 class="text-center fw-bold m-4">
                सेवा अनुरोध सूची ( कुल : {{ $results->total() }})
            </h3>
        </div>
    </div>

    {{-- ============ FILTER FORM ============ --}}
    <form method="get" action="{{ Request::url() }}" class="form-comman mb-3">
        @csrf
        <div class="row">

            <div class="form-group col-md-4 col-xl-2">
                <label class="fw-bold">जनपद</label>
                <select class="form-control" name="district_id">
                    <option value="">-- सभी --</option>
                    @foreach($districts as $district)
                        <option value="{{ $district->id }}"
                            {{ request('district_id') == $district->id ? 'selected' : '' }}>
                            {{ $district->name_hindi }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-4 col-xl-2">
                <label class="fw-bold">मैत्री</label>
                <select class="form-control" name="maitri_id">
                    <option value="">-- सभी --</option>
                    @foreach($maitries as $maitri)
                        <option value="{{ $maitri->id }}"
                            {{ request('maitri_id') == $maitri->id ? 'selected' : '' }}>
                            {{ $maitri->maitri_name }} ({{ $maitri->maitri_mobile_no }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-4 col-xl-2">
                <label class="fw-bold">सेवा का नाम</label>
                <select class="form-control" name="service_name">
                    <option value="">-- सभी --</option>
                    @foreach($services as $key => $label)
                        <option value="{{ $key }}"
                            {{ request('service_name') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-4 col-xl-2">
                <label class="fw-bold">स्थिति</label>
                <select class="form-control" name="status">
                    <option value="">-- सभी --</option>
                    @foreach($statuses as $val => $label)
                        <option value="{{ $val }}"
                            {{ request('status') === (string)$val ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-4 col-xl-2">
                <label class="fw-bold">प्रतिक्रिया</label>
                <select class="form-control" name="feedback">
                    <option value="">-- सभी --</option>
                    <option value="yes" {{ request('feedback') == 'yes' ? 'selected' : '' }}>दी गई</option>
                    <option value="no"  {{ request('feedback') == 'no'  ? 'selected' : '' }}>नहीं दी गई</option>
                </select>
            </div>

            <div class="form-group col-md-4 col-xl-2">
                <label class="fw-bold">खोजें (किसान)</label>
                <input type="text" class="form-control" name="search"
                       value="{{ request('search') }}" placeholder="नाम / मोबाइल">
            </div>

            <div class="form-group col-xl-3 mt-4 col-md-12">
                <button type="submit" class="btn btn-primary">सर्च करें</button>
                <a href="{{ Request::url() }}" class="btn btn-secondary">रीसेट करें</a>
            </div>

        </div>
    </form>

    {{-- ============ PAGINATION ============ --}}
    <div class="row">
        <div class="col-md-12">
            <div class="pagnation-scroll">
                {{ $results->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    {{-- ============ TABLE ============ --}}
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>क्र.सं.</th>
                        <th>किसान</th>
                        <th>जनपद</th>
                        <th>सेवा का नाम</th>
                        <th>मैत्री</th>
                        <th>संदेश</th>
                        <th>स्थिति</th>
                        <th>प्रतिक्रिया</th>
                        <th>प्रतिक्रिया विवरण</th>
                        <th>दिनांक</th>
                    </tr>
                </thead>
                <tbody>
                    @if($results->count())
                        @foreach($results as $key => $row)
                            @php
                                $message   = $row->request_message ?? '';
                                $wordCount = str_word_count(strip_tags($message));
                                $isLong    = $wordCount > 10;
                                $shortMsg  = $isLong ? \Illuminate\Support\Str::words($message, 10, '...') : $message;
                            @endphp
                            <tr>
                                <td>{{ $results->firstItem() + $key }}</td>

                                <td>
                                    {{ $row->user->name ?? '--' }}<br>
                                    <small class="text-muted">
                                        {{ $row->user->MobileNumber ?? '' }}
                                    </small>
                                </td>

                                <td>{{ $row->user->district->name_hindi ?? '--' }}</td>

                                <td>{{ $services[$row->service_name] ?? $row->service_name }}</td>

                                <td>
                                    {{ $row->maitri->maitri_name ?? '--' }}<br>
                                    <small class="text-muted">
                                        {{ $row->maitri->maitri_mobile_no ?? '' }}
                                    </small>
                                </td>

                                {{-- <td>{{ Str::limit($row->request_message, 60) }}</td> --}}
                                <td class="msg-cell"
                                    @if($isLong)
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        data-bs-html="true"
                                        title="{{ e($message) }}"
                                        style="cursor:pointer;"
                                    @endif
                                >
                                    {{ $shortMsg ?: '--' }}
                                </td>

                                <td>
                                    @if($row->status == 1)
                                        <span class="badge bg-primary">नया है</span>
                                    @elseif($row->status == 2)
                                        <span class="badge bg-warning text-dark">इंतज़ार में है</span>
                                    @elseif($row->status == 3)
                                        <span class="badge bg-danger">अस्वीकार किया गया है</span>
                                    @elseif($row->status == 0)
                                        <span class="badge bg-success">स्वीकार कर लिया है</span>
                                    @else
                                        <span class="badge bg-secondary">--</span>
                                    @endif
                                </td>

                                <td style="min-width:180px;">
                                    @if($row->feedback)
                                        <div class="text-warning mb-1" style="font-size:16px;">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fa fa-star {{ $i <= $row->feedback->rating ? '' : 'text-secondary' }}"></i>
                                            @endfor
                                        </div>
                                    @else
                                        <span class="badge bg-secondary">नहीं दी गई</span>
                                    @endif
                                </td>

                                <td style="min-width:180px;">
                                    @if($row->feedback)
                                        @if($row->feedback->description)
                                            <small class="text-muted">
                                                {{ Str::limit($row->feedback->description, 80) }}
                                            </small>
                                        @endif
                                    @endif
                                </td>

                                <td>{{ $row->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9" class="text-center text-danger">No records found..</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="pagnation-scroll">
                {{ $results->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('[data-bs-toggle="tooltip"]').tooltip({
            trigger: 'hover focus',
            container: 'body',
            html: true,
        });
    });
</script>
@endsection