<?php
use App\Models\Districts;

$category = [
    'जनरल' => 'सामान्य (general)',
    'ओ बी सी' => 'अन्य पिछड़ा वर्ग  (OBC)',
    'एस सी' => 'अनुसूचित जाति (SC)',
    'एस टी' => 'अनुसूचित जनजाति (ST)',
];

$statusLabels = [
    0 => 'लंबित',
    1 => 'स्वीकृत',
    2 => 'अस्वीकार',
    3 => 'प्रतीक्षा सूची में है..',
    4 => 'चयनित',
];

$pdfDocPath = function ($fileName) {
    if (empty($fileName)) {
        return null;
    }
    $path = public_path('upload_documents/' . $fileName);
    if (!file_exists($path)) {
        return null;
    }
    return str_replace('\\', '/', $path);
};
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    body {
        font-family: freeserif;
        font-size: 11pt;
        color: #222;
    }
    h1.title {
        text-align: center;
        font-size: 16pt;
        font-weight: bold;
        margin: 0 0 14px 0;
        padding-bottom: 8px;
        border-bottom: 2px solid #333;
    }
    h2.section-title {
        font-size: 13pt;
        font-weight: bold;
        margin: 16px 0 8px 0;
        padding: 4px 8px;
        background-color: #eef2f7;
        border-left: 4px solid #4a6fa5;
    }
    .notice {
        padding: 6px 10px;
        margin-bottom: 10px;
        border: 1px solid #c0392b;
        background-color: #fdecea;
        color: #7a1f14;
        font-size: 10pt;
    }
    .notice.info {
        border: 1px solid #2471a3;
        background-color: #eaf3fb;
        color: #1a4a6e;
    }
    .field-table {
        width: 100%;
        border-collapse: collapse;
    }
    .field-table td {
        width: 50%;
        vertical-align: top;
        padding: 4px 6px;
        font-size: 10.5pt;
    }
    .field-label {
        font-weight: bold;
    }
    .doc-thumb {
        max-width: 90px;
        max-height: 90px;
        border: 1px solid #999;
        padding: 2px;
    }
    .no-doc {
        color: #777;
        font-style: italic;
    }
    table.exam-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 4px;
    }
    table.exam-table th, table.exam-table td {
        border: 1px solid #999;
        padding: 5px;
        font-size: 9.5pt;
        text-align: center;
    }
    table.exam-table th {
        background-color: #eef2f7;
    }
</style>
</head>
<body>

<h1 class="title">आवेदन - पत्र</h1>

@if(!empty($coments))
    <div class="notice">{{ $coments->comments }}</div>
@endif

@if(!empty($verificationcoments))
    <div class="notice info">{{ $verificationcoments->comments }}</div>
@endif

<h2 class="section-title">आवेदक का विवरण</h2>
<table class="field-table">
    <tr>
        <td><span class="field-label">आवेदक का नाम</span> : {{ $result->applicant_name }}</td>
        <td><span class="field-label">पिता / पति का नाम</span> : {{ $result->fname }}</td>
    </tr>
    <tr>
        <td><span class="field-label">माता का नाम</span> : {{ $result->mother }}</td>
        <td><span class="field-label">जन्म तिथि (हाई स्कूल प्रमाण पत्र के अनुसार)</span> : {{ \Carbon\Carbon::parse($result->dob)->format('d-m-Y') }}</td>
    </tr>
    <tr>
        <td><span class="field-label">पिछला आवेदन नंबर</span> : {{ $result->previous_avedan_number }}</td>
        <td><span class="field-label">दूरभाष / मोबाइल नंबर</span> : {{ $result->mobile }}</td>
    </tr>
    <tr>
        <td><span class="field-label">श्रेणी</span> : {{ @$category[$result->category] }}</td>
        <td><span class="field-label">स्थायी पते के प्रमाण का प्रकार</span> : {{ $result->address_type }}</td>
    </tr>
    <tr>
        <td colspan="2"><span class="field-label">स्थायी पता</span> : {{ $result->permanent_address }}</td>
    </tr>
    <tr>
        <td>
            <span class="field-label">स्थायी पता का प्रमाण - पत्र</span> :<br>
            @if ($path = $pdfDocPath($result->permanent_address_proof))
                <img class="doc-thumb" src="{{ $path }}">
            @else
                <span class="no-doc">No documents</span>
            @endif
        </td>
        <td><span class="field-label">पोस्ट ऑफिस</span> : {{ $result->post_office }}</td>
    </tr>
    <tr>
        <td><span class="field-label">पिनकोड</span> : {{ $result->pincode }}</td>
        <td><span class="field-label">ग्राम पंचायत का नाम</span> : {{ $result->gram_panchayat_name }}</td>
    </tr>
    <tr>
        <td><span class="field-label">लिंग</span> : {{ $result->gender }}</td>
        @if($result->gender == 'महिला')
        <td><span class="field-label">पशु सखी/आजीविका सखी (एनआरएलएम)</span> : {{ $result->pashu_sakhi == '1' ? 'हाँ' : 'नहीं' }}</td>
        @else
        <td>&nbsp;</td>
        @endif
    </tr>
    <tr>
        <td><span class="field-label">जनपद</span> : {{ optional($district)->name_hindi }}</td>
        <td><span class="field-label">विकास खण्ड</span> : {{ $result->vikas_khand }}</td>
    </tr>
    <tr>
        <td colspan="2"><span class="field-label">पत्र - व्यवहार का पता</span> : {{ $result->letter_address }}</td>
    </tr>
    <tr>
        <td><span class="field-label">ई - मेल</span> : {{ $result->email }}</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>
            <span class="field-label">आवेदक की फोटो</span> :<br>
            @if ($path = $pdfDocPath($result->applicant_photo))
                <img class="doc-thumb" src="{{ $path }}">
            @else
                <span class="no-doc">No documents</span>
            @endif
        </td>
        <td>
            <span class="field-label">अभ्यर्थी का हस्ताक्षर</span> :<br>
            @if ($path = $pdfDocPath($result->signature))
                <img class="doc-thumb" src="{{ $path }}">
            @else
                <span class="no-doc">No documents</span>
            @endif
        </td>
    </tr>
</table>

<h2 class="section-title">शैक्षिक योग्यता व अन्य विवरण</h2>
<table class="exam-table">
    <tr>
        <th style="width: 14%;">उत्तीर्ण परीक्षा का नाम</th>
        <th>बोर्ड का नाम</th>
        <th>उत्तीर्ण वर्ष</th>
        <th>प्राप्तांक</th>
        <th>पूर्णांक</th>
        <th>प्रतिशत</th>
        <th>अंकतालिका</th>
    </tr>
    <tr>
        <td>हाई स्कूल (जीव विज्ञान)</td>
        <td>{{ $result->high_board_name }}</td>
        <td>{{ $result->high_passing_year }}</td>
        <td>{{ $result->high_marks }}</td>
        <td>{{ $result->high_total_marks }}</td>
        <td>{{ $result->high_percentage }}</td>
        <td>
            @if ($path = $pdfDocPath($result->high_marksheet))
                <img class="doc-thumb" src="{{ $path }}">
            @else
                <span class="no-doc">No documents</span>
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
            @if ($path = $pdfDocPath($result->inter_marksheet))
                <img class="doc-thumb" src="{{ $path }}">
            @else
                <span class="no-doc">No documents</span>
            @endif
        </td>
    </tr>
</table>

<table class="field-table" style="margin-top: 10px;">
    @if ($result->training_adopted != 'नहीं')
    <tr>
        <td colspan="2">
            <span class="field-label">राज्य / केंद्र सरकार द्वारा मान्यता प्राप्त संस्थान से यदि पूर्व में कृत्रिम गर्भाधान के प्रशिक्षण का प्रमाण पत्र प्राप्त किया हो</span> :<br>
            @if ($path = $pdfDocPath($result->training_certificate))
                <img class="doc-thumb" src="{{ $path }}">
            @else
                <span class="no-doc">No documents</span>
            @endif
        </td>
    </tr>
    <tr>
        <td><span class="field-label">माह</span> : {{ $result->training_certificate_period_in_month }}</td>
        <td><span class="field-label">दिन</span> : {{ $result->training_certificate_period_in_days }}</td>
    </tr>
    <tr>
        <td><span class="field-label">योजना का नाम जिसके अंतर्गत प्रशिक्षण प्राप्त किया गया</span> : {{ $result->yojna_name_for_training }}</td>
        <td><span class="field-label">प्रशिक्षणोपरांत ए. आई. किट तथा बायोलोजिकल कन्टेनर प्राप्त किये गये है</span> : {{ $result->AIkit }}</td>
    </tr>
    @endif
    <tr>
        <td>
            <span class="field-label">वोटर आई डी कार्ड / आधार कार्ड / पैन कार्ड का प्रमाण पत्र</span> :<br>
            @if ($path = $pdfDocPath($result->id_upload))
                <img class="doc-thumb" src="{{ $path }}">
            @else
                <span class="no-doc">No documents</span>
            @endif
        </td>
        <td>
            <span class="field-label">जाति (एस सी / एस टी श्रेणी हेतु न्याय अधिकारी द्वारा जारी प्रमाण पत्र)</span> :<br>
            @if ($path = $pdfDocPath($result->caste_certificate))
                <img class="doc-thumb" src="{{ $path }}">
            @else
                <span class="no-doc">No documents</span>
            @endif
        </td>
    </tr>
    <tr>
        <td>
            <span class="field-label">राजकीय चिकित्साधिकारी द्वारा प्रदत्त स्वास्थ्य प्रमाण - पत्र</span> :<br>
            @if ($path = $pdfDocPath($result->health_certificate))
                <img class="doc-thumb" src="{{ $path }}">
            @else
                <span class="no-doc">No documents</span>
            @endif
        </td>
        <td><span class="field-label">राष्ट्रीयता</span> : {{ $result->nationality }}</td>
    </tr>
    <?php
        $statusColors = [
            0 => '#6c757d',
            1 => '#28a745',
            2 => '#28a745',
            3 => '#17a2b8',
            4 => '#17a2b8',
        ];
        $statusColor = $statusColors[$result->is_approved] ?? '#6c757d';
    ?>
    <tr>
        <td>
            <span class="field-label">स्टेटस</span> :
            <span style="display:inline-block; padding:3px 10px; font-weight:bold; border-radius:3px; background-color: {{ $statusColor }}; color: #ffffff;">{{ $statusLabels[$result->is_approved] ?? '' }}</span>
        </td>
        <td>&nbsp;</td>
    </tr>
</table>

</body>
</html>
