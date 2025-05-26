<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Slip Gaji - {{ $slip->id }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, sans-serif;
            padding-top: 20px;
        }
        .main-content {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            padding: 25px;
            min-height: 90vh;
        }
        .page-title {
            font-size: 24px;
            font-weight: 600;
            color: #212529;
            margin-bottom: 20px;
        }
        .preview-container {
            max-width: 800px;
            margin: 30px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        .preview-header {
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .company-logo {
            font-size: 24px;
            font-weight: bold;
            color: #3a86ff;
        }
        .slip-title {
            font-size: 22px;
            font-weight: 600;
            color: #212529;
        }
        .period-badge {
            background: #e9ecef;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            color: #495057;
        }
        .section-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #495057;
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 5px;
        }
        .info-row {
            margin-bottom: 8px;
        }
        .info-label {
            font-weight: 500;
            color: #6c757d;
        }
        .info-value {
            font-weight: 500;
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
        .net-salary {
            font-size: 18px;
            font-weight: 700;
            background: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .btn-primary {
            background-color: #3a86ff;
            border-color: #3a86ff;
        }
        .btn-primary:hover {
            background-color: #2a6ecc;
            border-color: #2a6ecc;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 p-0">
                <div class="main-content">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="page-title mb-0">Detail Slip Gaji</h1>
                        <a href="{{ route('slips.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                    <div class="preview-container">
                        <div class="preview-header d-flex justify-content-between align-items-center">
                            <div class="company-logo">{{ config('app.name') }}</div>
                            <div class="text-end">
                                <div class="slip-title mb-2">SLIP GAJI</div>
                                <span class="period-badge">{{ $slip->period->formatLocalized('%B %Y') }}</span>
                            </div>
                        </div>

                        <!-- Informasi Karyawan -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="section-title">Informasi Karyawan</div>
                                <div class="info-row row">
                                    <div class="col-5 info-label">Nama</div>
                                    <div class="col-7 info-value">{{ $slip->user->name }}</div>
                                </div>
                                <div class="info-row row">
                                    <div class="col-5 info-label">ID</div>
                                    <div class="col-7 info-value">{{ $slip->user->id }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Tabel Pendapatan & Potongan -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="section-title">Pendapatan</div>
                                <table class="table table-sm table-bordered">
                                    <thead class="table-light">
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
                            <div class="col-md-6">
                                <div class="section-title">Potongan</div>
                                <table class="table table-sm table-bordered">
                                    <thead class="table-light">
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

                        <!-- Gaji Bersih -->
                        <div class="net-salary d-flex justify-content-between">
                            <span>Gaji Bersih</span>
                            <span>{{ number_format($slip->net_salary, 0, ',', '.') }}</span>
                        </div>

                        <!-- Tombol aksi -->
                        <div class="d-flex justify-content-center mt-4">
                            <button class="btn btn-primary me-2">
                                <i class="bi bi-printer"></i> Cetak Slip Gaji
                            </button>
                            <button class="btn btn-secondary me-2">
                                <i class="bi bi-file-earmark-pdf"></i> Unduh PDF
                            </button>
                            <button class="btn btn-outline-secondary">
                                <i class="bi bi-pencil"></i> Edit Data
                            </button>
                        </div>
                        <p class="text-center text-muted mt-3" style="font-size:12px;">
                            Slip gaji ini dihasilkan secara elektronik dan sah tanpa tanda tangan.<br>
                            Jika ada pertanyaan mengenai slip gaji ini, silakan hubungi Departemen SDM.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
