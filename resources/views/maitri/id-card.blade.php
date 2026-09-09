<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maitri ID Card</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background: #e8edf3;
            font-family: Arial, Helvetica, sans-serif;
            padding: 24px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .toolbar {
            width: 320px;
            max-width: 100%;
            display: flex;
            justify-content: flex-end;
            margin-bottom: 12px;
        }
        .toolbar button {
            background: #14213d;
            border: 1px solid #c9a227;
            color: #fff;
            padding: 10px 18px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
        }
        .id-card {
            width: 320px;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            border: 2px solid #c9a227;
        }
        .id-header {
            background: linear-gradient(135deg, #14213d, #1f3b73);
            color: #fff;
            padding: 10px 12px 8px;
            text-align: center;
        }
        .id-header img {
            width: 36px;
            height: 36px;
            object-fit: contain;
            margin-bottom: 4px;
        }
        .id-header h1 {
            font-size: 14px;
            letter-spacing: 1px;
        }
        .id-header p {
            font-size: 10px;
            color: #f0d78c;
            margin-top: 3px;
            line-height: 1.3;
        }
        .id-body {
            padding: 10px 12px 8px;
        }
        .photo-wrap {
            width: 78px;
            height: 92px;
            margin: 0 auto 8px;
            border: 2px solid #c9a227;
            border-radius: 6px;
            overflow: hidden;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .photo-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .name {
            text-align: center;
            font-size: 15px;
            font-weight: 700;
            color: #14213d;
            margin-bottom: 2px;
            line-height: 1.2;
        }
        .role {
            text-align: center;
            font-size: 10px;
            color: #c9a227;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            gap: 8px;
            font-size: 11px;
            padding: 4px 0;
            border-bottom: 1px dashed #ddd;
        }
        .info-row span:first-child {
            color: #666;
            min-width: 80px;
        }
        .info-row span:last-child {
            color: #14213d;
            font-weight: 600;
            text-align: right;
            word-break: break-word;
        }
        .id-footer {
            background: #f8f2df;
            text-align: center;
            padding: 7px 8px;
            font-size: 10px;
            color: #8a6d1f;
            font-weight: 600;
            line-height: 1.3;
        }
        @media print {
            body { background: #fff; padding: 0; }
            .toolbar { display: none !important; }
            .id-card { box-shadow: none; }
        }
    </style>
</head>
<body>
    <div class="toolbar">
        <button id="downloadIdBtn" type="button">
            <i class="fas fa-file-pdf"></i> Download ID Card
        </button>
    </div>

    <div class="id-card" id="idCardContainer">
        <div class="id-header">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo">
            <h1>MAITRI ID CARD</h1>
            <p>{{ $instituteName }}</p>
        </div>
        <div class="id-body">
            <div class="photo-wrap">
                @if(!empty($photo))
                    <img src="{{ $photo }}" alt="Photo">
                @else
                    <span style="color:#999; font-size:11px;">No Photo</span>
                @endif
            </div>
            <div class="name">{{ $maitri->maitri_name }}</div>
            <div class="role">TRAINED MAITRI</div>

            <div class="info-row">
                <span>Certificate No</span>
                <span>{{ $maitri->certificate_no ?: 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span>Mobile</span>
                <span>{{ $maitri->maitri_mobile_no ?: 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span>Father Name</span>
                <span>{{ $maitri->father_name ?: 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span>Janpad</span>
                <span>{{ $maitri->janpad_name ?: 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span>Block</span>
                <span>{{ $maitri->block ?: 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span>Pass Date</span>
                <span>{{ $maitri->pass_date ?: 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span>Valid Till</span>
                <span>{{ $maitri->expiry_date ?: 'N/A' }}</span>
            </div>
        </div>
        <div class="id-footer">
            {{ $instituteName }} · Official Maitri Identity Card
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        document.getElementById('downloadIdBtn').addEventListener('click', function () {
            const btn = this;
            const original = btn.innerHTML;
            const card = document.getElementById('idCardContainer');
            btn.disabled = true;
            btn.innerHTML = 'Generating…';

            // Convert card pixel size to mm so PDF is exactly one page.
            const pxToMm = 0.264583;
            const pageWidth = Math.ceil(card.offsetWidth * pxToMm) + 2;
            const pageHeight = Math.ceil(card.offsetHeight * pxToMm) + 2;

            html2pdf().set({
                margin: 0,
                filename: 'maitri-id-card-{{ preg_replace('/\s+/', '_', $maitri->maitri_name) }}.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: {
                    scale: 2,
                    useCORS: true,
                    logging: false,
                    scrollY: 0,
                    scrollX: 0
                },
                jsPDF: {
                    unit: 'mm',
                    format: [pageWidth, pageHeight],
                    orientation: 'portrait'
                },
                pagebreak: { mode: ['avoid-all'] }
            }).from(card).save().then(function () {
                btn.disabled = false;
                btn.innerHTML = original;
            }).catch(function () {
                alert('Could not generate ID card PDF.');
                btn.disabled = false;
                btn.innerHTML = original;
            });
        });
    </script>
</body>
</html>
