<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Slip Gaji - {{ $slip->id }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        body {
            background-color: #f5f7fb;
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
        }
        .main-content {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            padding: 25px;
            min-height: 90vh;
            max-width: 900px;
            margin: 0 auto;
        }
        .page-title {
            font-size: 24px;
            font-weight: 600;
            color: #212529;
            margin-bottom: 20px;
        }
        .preview-container {
            max-width: 1539px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            box-sizing: border-box;
        }
        .preview-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 3px;
            margin-bottom: 15px;
        }
        .company-logo img {
            width: 200px;
            height: auto;
            object-fit: contain;
        }
        .slip-title {
            font-size: 20px;
            font-weight: 600;
            color: #212529;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .period-badge {
            background: #e9ecef;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            color: #495057;
        }
        .section-title {
            font-size: 15px;
            font-weight: 600;
            color: #495057;
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .info-label {
            font-weight: 500;
            color: #6c757d;
            width: 40%;
        }
        .info-value {
            font-weight: 500;
            width: 60%;
            text-align: left;
        }
        .table-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .table-section {
            width: 48%;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        .table th, .table td {
            padding: 6px 8px;
            border: 1px solid #dee2e6;
            text-align: left;
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        .table .text-end {
            text-align: right;
        }
        .total-row {
            font-weight: 700;
            background: #f8f9fa;
        }
        .income {
            color: #198754;
        }
        .deduction {
            color: #dc3545;
        }
        .footer-actions {
            display: flex;
            justify-content: center;
            margin-top: 15px;
            gap: 10px;
        }
        .btn-secondary, .btn-print {
            background-color: #6c757d;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            cursor: pointer;
        }
        .btn-secondary:hover,
        .btn-print:hover {
            background-color: #5a6268;
        }
        .btn-secondary i,
        .btn-print i {
            margin-right: 5px;
        }
        .footer-notes {
            text-align: center;
            color: #6c757d;
            font-size: 11px;
            margin-top: 10px;
        }
        @page {
            size: A4;
            margin: 0;
        }
        @media print {
            body * {
                visibility: hidden;
            }
            .preview-container,
            .preview-container * {
                visibility: visible;
            }
            .preview-container {
                position: absolute;
                top: 0;
                left: 0;
                width: 210mm;
                height: 297mm;
            }
            .btn-print {
                display: none !important;
            }
            .footer-actions .btn-print {
                display: none !important;
            }
        }
        html, body {
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title">Detail Slip Gaji</h1>
            <a href="{{ route('slips.index') }}" class="btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="preview-container">
            <div class="preview-header">
                <div class="company-logo">
                    <img src="{{ asset('img/logo_brand.png') }}" alt="Logo {{ config('app.name') }}">
                </div>
                <div class="text-end">
                    <div class="slip-title">SLIP GAJI</div>
                    <span class="period-badge">{{ $slip->period->formatLocalized('%B %Y') }}</span>
                </div>
            </div>
            <div class="mb-4">
                <div class="section-title">Informasi Karyawan</div>
                <div class="info-row">
                    <div class="info-label">Nama</div>
                    <div class="info-value">{{ $slip->user->name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">ID</div>
                    <div class="info-value">{{ $slip->user->id }}</div>
                </div>
            </div>
            <div class="table-container mb-4">
                <div class="table-section">
                    <div class="section-title">Pendapatan</div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Keterangan</th>
                                <th class="text-end">Jumlah (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($slip->earnings as $earning)
                                <tr>
                                    <td>{{ $earning->name }}</td>
                                    <td class="text-end income">{{ number_format($earning->amount, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                            <tr class="total-row">
                                <td>Total Pendapatan</td>
                                <td class="text-end income">{{ number_format($slip->earnings->sum('amount'), 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="table-section">
                    <div class="section-title">Potongan</div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Keterangan</th>
                                <th class="text-end">Jumlah (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($slip->deductions as $deduction)
                                <tr>
                                    <td>{{ $deduction->name }}</td>
                                    <td class="text-end deduction">{{ number_format($deduction->amount, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                            <tr class="total-row">
                                <td>Total Potongan</td>
                                <td class="text-end deduction">{{ number_format($slip->deductions->sum('amount'), 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div>
                <table class="table">
                    <tr>
                        <td style="border-right:none; background-color:lightgray; font-weight:bold;"> Gaji Bersih</td>
                        <td style="border-left:none; text-align:end; background-color:lightgray; font-weight:bold;">{{ number_format($slip->net_salary, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
           
            <p class="footer-notes">
                Slip gaji ini dihasilkan secara elektronik dan sah tanpa tanda tangan.<br>
                Jika ada pertanyaan mengenai slip gaji ini, silakan hubungi Departemen SDM.
            </p>
        </div>

        <div class="footer-actions">
                <button class="btn-print" onclick="downloadPDF()">
                    <i class="bi bi-printer"></i> Cetak / Save as PDF
                </button>
        </div>
    </div>
    <script>
        const slipId = "{{ $slip->id }}";
        const slipPeriod = "{{ $slip->period->format('Y-m') }}";
        function downloadPDF() {
    if (typeof html2pdf === 'undefined') {
        alert('Pustaka html2pdf gagal dimuat. Pastikan koneksi internet stabil atau coba lagi nanti.');
        return;
    }
    const element = document.querySelector('.preview-container');
    const opt = {
        margin: 0,
        filename: `slip-gaji-${slipId}-${slipPeriod}.pdf`,
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: {
            scale: 2,
            useCORS: true,
            onclone: function(clonedDoc) {
                // Sembunyikan elemen footer-actions di klon dokumen
                const footerActions = clonedDoc.querySelector('.footer-actions button .btn-print');
                if (footerActions) {
                    footerActions.style.display = 'none';
                }
            }
        },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };
    html2pdf().set(opt).from(element).save().catch(err => {
        console.error('Gagal membuat PDF:', err);
        alert('Terjadi kesalahan saat membuat PDF. Silakan coba lagi.');
    });
}
    </script>
</body>
</html>