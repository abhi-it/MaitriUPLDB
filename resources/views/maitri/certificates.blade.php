<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maitri Certificate · Preview & Download</title>
    <!-- Font Awesome for download icon -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background: #e5e5e5;
            font-family: Arial, Helvetica, sans-serif;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .toolbar {
            width: 210mm;
            max-width: 100%;
            display: flex;
            justify-content: flex-end;
            margin-bottom: 12px;
            gap: 10px;
            flex-wrap: wrap;
        }
        .toolbar button {
            background: #14213d;
            border: none;
            color: white;
            padding: 10px 22px;
            border-radius: 40px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: background 0.2s;
            border: 1px solid #c9a227;
        }
        .toolbar button i {
            font-size: 18px;
        }
        .toolbar button:hover {
            background: #0b1629;
        }
        .toolbar button:disabled {
            opacity: 0.6;
            cursor: default;
        }
        .certificate-wrapper {
            width: 210mm;
            min-height: 297mm;
            background: #ffffff;
            box-sizing: border-box;
            padding: 20mm;
            position: relative;
            text-align: center;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            border-radius: 4px;
            margin-bottom: 20px;
        }
        /* all inner styles are kept exactly as original (inline) */
        /* but we keep the wrapper to preserve layout */
        .certificate-wrapper > div {
            /* the main certificate content is placed inside */
        }
        /* responsive */
        @media print {
            body { background: white; padding: 0; }
            .toolbar { display: none; }
            .certificate-wrapper { box-shadow: none; margin: 0 auto; border-radius: 0; }
        }
        @media (max-width: 700px) {
            .certificate-wrapper {
                width: 100%;
                min-height: auto;
                padding: 15mm 10mm;
            }
            .toolbar { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>

    <!-- Toolbar with Download button (top right) -->
    <div class="toolbar">
        <button id="downloadPdfBtn" title="Download as PDF">
            <i class="fas fa-file-pdf"></i> Download PDF
        </button>
    </div>

    <!-- A4 Certificate – exact original content with dynamic placeholders -->
    <div class="certificate-wrapper" id="certificateContainer">
        <!-- Outer Border -->
        <div style="position:absolute; top:8mm; left:8mm; right:8mm; bottom:8mm; border:5px solid #14213d; pointer-events:none;"></div>
        <!-- Inner Gold Border -->
        <div style="position:absolute; top:12mm; left:12mm; right:12mm; bottom:12mm; border:2px solid #c9a227; pointer-events:none;"></div>
        <!-- Decorative corners -->
        <div style="position:absolute; top:17mm; left:17mm; width:25mm; height:25mm; border-top:3px solid #c9a227; border-left:3px solid #c9a227;"></div>
        <div style="position:absolute; top:17mm; right:17mm; width:25mm; height:25mm; border-top:3px solid #c9a227; border-right:3px solid #c9a227;"></div>
        <div style="position:absolute; bottom:17mm; left:17mm; width:25mm; height:25mm; border-bottom:3px solid #c9a227; border-left:3px solid #c9a227;"></div>
        <div style="position:absolute; bottom:17mm; right:17mm; width:25mm; height:25mm; border-bottom:3px solid #c9a227; border-right:3px solid #c9a227;"></div>

        <!-- Content -->
        <div style="position:relative; z-index:2;">

            <!-- Logo -->
            <div style="width:75px; height:75px; margin:8mm auto 4mm; border-radius:50%; color:#ffffff; display:flex; align-items:center; justify-content:center; font-size:18px; font-weight:bold; box-sizing:border-box;">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" style="width:100%; height:100%; object-fit:contain;">
            </div>

            <!-- Organization Name -->
            <div style="font-size:22px; font-weight:bold; letter-spacing:5px; color:#14213d; margin-top:5px;">MAITRI</div>
            <!-- Subtitle -->
            <div style="margin-top:5px; font-size:12px; letter-spacing:4px; color:#c9a227;">TRAINING PROGRAM</div>
            <div style="margin-top:8px; font-size:15px; font-weight:600; color:#14213d;">
                {{ $instituteName ?? ($maitri->center_name ?? 'Training Institute') }}
            </div>

            <!-- Divider -->
            <div style="width:100px; height:2px; background:#c9a227; margin:15px auto 20px;"></div>

            <!-- Certificate Title -->
            <h1 style="margin:0; font-family: 'Cookie', cursive; font-size:80px; font-weight:normal; letter-spacing:3px; color:#14213d;">Certificate</h1>

            <!-- Certificate Type -->
            <div style="font-family: 'Cookie', cursive; font-size:30px; letter-spacing:6px; color:#c9a227; margin-top:1px;">of completion</div>

            <!-- Presented To -->
            <p style="margin:15px 0 10px; font-size:14px; letter-spacing:2px; color:#555555;">THIS CERTIFICATE IS PROUDLY PRESENTED TO</p>

            <!-- Recipient Name (dynamic) -->
            <div style="width:75%; margin:20px auto 25px; padding-bottom:12px; border-bottom:2px solid #c9a227; font-family:Georgia, 'Times New Roman', serif; font-size:42px; font-style:italic; color:#b8860b;">
                {{ $maitri->maitri_name }}
            </div>

            <!-- Certificate Description -->
            <div style="max-width:150mm; margin:0 auto; font-size:16px; line-height:1.8; color:#444444;">
                <p style="margin:0;">This certificate is proudly awarded in recognition of the successful completion of the</p>
                <div style="margin:10px 0; font-size:20px; font-weight:bold; color:#14213d;">Maitri Training Program</div>
                <p style="margin:0;">conducted at <strong style="color:#14213d;">{{ $instituteName ?? ($maitri->center_name ?? 'Training Institute') }}</strong>.</p>
                <p style="margin:8px 0 0;">The recipient has successfully completed the required training and demonstrated dedication, commitment, and satisfactory performance throughout the program.</p>
            </div>

            <!-- Award Date (dynamic) -->
            <div style="margin-top:5px; font-size:15px; color:#555555;">
                Awarded on:
                <strong style="color:#14213d;">{{ $maitri->pass_date ?? now()->format('d F Y') }}</strong>
            </div>

            <!-- Achievement Seal -->
            <div style="width:100px; height:100px; margin:15px auto; border-radius:50%; border:5px solid #c9a227; background:#f8f2df; display:flex; flex-direction:column; align-items:center; justify-content:center; box-sizing:border-box; color:#8a6d1f; font-size:12px; font-weight:bold; line-height:1.5;">
                MAITRI<br>TRAINING<br>★ ★ ★
            </div>

            <!-- Signature Section -->
            <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-top:5px; padding:0 15px;">
                <!-- Left Signature -->
                <div style="width:32%; text-align:center;">
                    {{-- <div style="height:45px; font-family:cursive; font-size:24px; color:#bcbcbc;">Signature</div> --}}
                    <div style="border-top:1px solid #c9a227; padding-top:8px;">
                        <strong style="color:#14213d; font-size:13px;">{{ $instituteName ?? 'TRAINING INSTITUTE' }}</strong><br>
                        <span style="font-size:11px; color:#666666;">Training Authority</span>
                    </div>
                </div>

                <!-- Certificate ID (dynamic) -->
                <div style="width:28%; text-align:center; padding:0 10px;">
                    <div style="font-size:24px; color:#c9a227; margin-bottom:5px;">★</div>
                    <div style="font-size:10px; letter-spacing:1px; color:#666666;">CERTIFICATE ID</div>
                    <strong style="display:block; margin-top:5px; color:#14213d; font-size:12px;">{{ $certificateId ?? 'MAITRI-2026-0001' }}</strong>
                </div>

                <!-- Right Signature -->
                <div style="width:32%; text-align:center;">
                    {{-- <div style="height:45px; font-family:cursive; font-size:24px; color:#333333;">Signature</div> --}}
                    <div style="border-top:1px solid #c9a227; padding-top:8px;">
                        <strong style="color:#14213d; font-size:13px;">PROGRAM DIRECTOR</strong><br>
                        <span style="font-size:11px; color:#666666;">Authorized Signature</span>
                    </div>
                </div>
            </div>

            <!-- Footer Divider -->
            <div style="width:100px; height:2px; background:#14213d; margin:25px auto 10px;"></div>
            <!-- Footer -->
            <div style="font-size:11px; letter-spacing:1px; color:#666666;">
                {{ $instituteName ?? ($maitri->center_name ?? 'MAITRI TRAINING PROGRAM') }}
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        (function() {
            'use strict';

            const downloadBtn = document.getElementById('downloadPdfBtn');
            const certificateEl = document.getElementById('certificateContainer');

            // ---- simulate dynamic data (like Laravel blade) ----
            // you can change these values to test different names / dates / IDs
            const traineeName = '{{ $maitri->maitri_name }}';
            const completionDate = '{{ $maitri->pass_date }}';
            const certificateId = '{{ $maitri->certificate_no }}';

            // inject dynamic content into the certificate (replace placeholders)
            function injectDynamicData() {
                // recipient name
                const nameEl = certificateEl.querySelector('div[style*="border-bottom:2px solid #c9a227"]');
                if (nameEl) {
                    nameEl.textContent = traineeName;
                }
                // awarded date
                const dateStrong = certificateEl.querySelector('div[style*="margin-top:25px"] strong');
                if (dateStrong) {
                    dateStrong.textContent = completionDate;
                }
                // certificate ID
                const idStrong = certificateEl.querySelector('div[style*="width:28%"] strong');
                if (idStrong) {
                    idStrong.textContent = certificateId;
                }
            }

            // run injection
            injectDynamicData();

            // ---- download PDF using html2pdf ----
            downloadBtn.addEventListener('click', function() {
                const btn = this;
                const originalHtml = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating…';

                // we want a clean A4 PDF, preserve the exact layout
                const opt = {
                    margin:        [0, 0, 0, 0], // no extra margin (we have internal padding)
                    filename:      'maitri-certificate-' + traineeName.replace(/\s+/g, '_') + '.pdf',
                    image:         { type: 'jpeg', quality: 0.98 },
                    html2canvas:   { scale: 2, letterRendering: true, useCORS: true, logging: false },
                    jsPDF:         { unit: 'mm', format: 'a4', orientation: 'portrait' }
                };

                // use html2pdf on the certificate container
                html2pdf()
                    .set(opt)
                    .from(certificateEl)
                    .save()
                    .then(function() {
                        btn.disabled = false;
                        btn.innerHTML = originalHtml;
                    })
                    .catch(function(err) {
                        console.error('PDF generation error:', err);
                        alert('Could not generate PDF. Please try again.');
                        btn.disabled = false;
                        btn.innerHTML = originalHtml;
                    });
            });

        })();
    </script>

    <!-- note: the certificate is fully self-contained, and download button is at top right -->
    <!-- preview is shown directly, with dynamic data already applied -->
</body>
</html>
