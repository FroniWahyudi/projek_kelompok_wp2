<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Pengelolaan Slip Gaji' }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, sans-serif;
        }
        .main-content {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
            padding: 25px;
            min-height: 90vh;
        }
        .page-title {
            font-size: 24px;
            font-weight: 600;
            color: #212529;
            margin-bottom: 20px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        .card-header {
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            padding: 15px;
            font-weight: 600;
        }
        .table th {
            font-weight: 600;
            color: #495057;
        }
        .btn-action {
            padding: 5px 10px;
            margin-right: 5px;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        .status-published {
            background: #d1e7dd;
            color: #0f5132;
        }
        .form-label {
            font-weight: 500;
            color: #495057;
        }
        .tab-content {
            padding: 20px 0;
        }
        .nav-tabs .nav-link {
            color: #495057;
            border: none;
            padding: 10px 15px;
            font-weight: 500;
        }
        .nav-tabs .nav-link.active {
            color: #3a86ff;
            border-bottom: 2px solid #3a86ff;
        }
        .preview-container {
            max-width: 800px;
            margin: 30px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
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
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 p-0">
                <div class="main-content">
                    <!-- Payslips List View -->
                    <div id="payslips-view">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h1 class="page-title mb-0">{{ $title ?? 'Pengelolaan Slip Gaji' }}</h1>
                            <!-- tombol di list view -->
                            <button id="create-payslip-btn" class="btn btn-primary">
                                <i class="bi bi-plus-lg"></i> Buat Slip Gaji Baru
                            </button>
                        </div>
                        <div class="mb-3">
                            <a href="{{ route('dashboard') }}" class="btn btn-primary">
                                <i class="bi bi-house-door-fill"></i> Home
                            </a>
                        </div>
                        <form method="GET" action="{{ route('slips.index') }}" class="row mb-3">
                            <div class="col-md-3">
                                <label for="filter-month" class="form-label">Pilih Bulan</label>
                                <select name="month" id="filter-month" class="form-select">
                                    <option value=""{{ request('month') == '' ? ' selected' : '' }}>Semua Bulan</option>
                                    @foreach(range(1,12) as $m)
                                        <option value="{{ sprintf('%02d', $m) }}"{{ request('month') == sprintf('%02d', $m) ? ' selected' : '' }}>{{ DateTime::createFromFormat('!m', $m)->format('F') }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="filter-year" class="form-label">Pilih Tahun</label>
                                <select name="year" id="filter-year" class="form-select">
                                    <option value=""{{ request('year') == '' ? ' selected' : '' }}>Semua Tahun</option>
                                    @foreach($years as $year)
                                        <option value="{{ $year }}"{{ request('year') == $year ? ' selected' : '' }}>{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                        <div class="card">
                            <div class="card-header">Daftar Slip Gaji</div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID Slip</th>
                                            <th>Nama Karyawan</th>
                                            <th>Periode</th>
                                            <th>Gaji Bersih</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($slips as $slip)
                                            <tr>
                                                <td>{{ $slip->id }}</td>
                                                {{-- UBAH employee → user jika migrasi sudah di-rename --}}
                                                <td>{{ $slip->user->name }}</td> {{-- ← ganti $slip->employee jadi $slip->user --}}
                                                <td>{{ $slip->period->formatLocalized('%B %Y') }}</td>
                                                <td>{{ 'Rp ' . number_format($slip->net_salary, 0, ',', '.') }}</td>
                                                <td>
                                                    <span class="status-badge status-{{ strtolower($slip->status) }}">
                                                        {{ $slip->status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <button type="button" class="edit-btn btn btn-sm btn-outline-primary btn-action">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <form action="{{ route('slips.destroy', $slip) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger btn-action"><i class="bi bi-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Create/Edit Payslip View -->
                    <div id="edit-payslip-view" style="display: none;">
                        <form method="POST" action="{{ isset($slip) ? route('slips.update', $slip) : route('slips.store') }}">
                            @csrf
                            @if(isset($slip)) @method('PUT') @endif
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h1 class="page-title mb-0" id="form-title">{{ isset($slip) ? 'Edit Slip Gaji' : 'Buat Slip Gaji Baru' }}</h1>
                                <div>
                                    <a href="{{ route('slips.index') }}" class="btn btn-outline-secondary me-2"><i class="bi bi-x-lg"></i> Batal</a>
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <button type="button" class="nav-link active" data-bs-toggle="tab" data-bs-target="#info-content">
                                                Informasi Dasar
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#earnings-content">
                                                Pendapatan
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#deductions-content">
                                                Potongan
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#preview-content">
                                                Pratinjau
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <!-- Basic Info -->
                                        <div class="tab-pane fade show active" id="info-content">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <!-- ID Slip Gaji (readonly) -->
                                                    <div class="mb-3">
                                                        <label class="form-label">ID Slip Gaji</label>
                                                        <input
                                                            type="text"
                                                            name="id"
                                                            class="form-control"
                                                            value="{{ old('id', $slip->id ?? 'SG-'.now()->format('Y').'-'.sprintf('%03d', $nextId)) }}"
                                                            readonly
                                                        >
                                                    </div>
                                                    <!-- Periode -->
                                                    <div class="mb-3">
                                                        <label class="form-label">Periode</label>
                                                        <input
                                                            type="month"
                                                            name="period"
                                                            id="payslip-period"
                                                            class="form-control"
                                                            value="{{ old('period', isset($slip) ? $slip->period->format('Y-m') : '') }}"
                                                        >
                                                    </div>
                                                    <!-- Pilih Karyawan -->
                                                    <div class="mb-3">
                                                        <label class="form-label">Pilih Karyawan</label>
                                                        <select
                                                            name="user_id"
                                                            id="employee-select"
                                                            class="form-select"
                                                        >
                                                            @foreach($users as $user)
                                                                <option
                                                                    value="{{ $user->id }}"
                                                                    {{ old('user_id', $slip->user_id ?? '') == $user->id ? ' selected' : '' }}
                                                                >
                                                                    {{ $user->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Earnings -->
                                        <div class="tab-pane fade" id="earnings-content">
                                            <h5>Komponen Pendapatan</h5>
                                            <table class="table table-bordered" id="earnings-table">
                                                <thead>
                                                    <tr>
                                                        <th>Keterangan</th>
                                                        <th>Jumlah (Rp)</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- ← GANTI DISINI: lindungi akses $slip sebelum dipakai --}}
                                                    @foreach(
                                                        old(
                                                            'earnings',
                                                            isset($slip)
                                                                ? $slip->earnings
                                                                : [['name'=>'Gaji Pokok','amount'=>5000000]]
                                                        ) as $i => $earning
                                                    )
                                                        <tr>
                                                            <td>
                                                                <input type="text"
                                                                       name="earnings[{{ $i }}][name]"
                                                                       class="form-control"
                                                                       value="{{ $earning['name'] }}">
                                                            </td>
                                                            <td>
                                                                <input type="number"
                                                                       name="earnings[{{ $i }}][amount]"
                                                                       class="form-control earning-amount"
                                                                       value="{{ $earning['amount'] }}">
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-sm btn-outline-danger delete-row-btn">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="3">
                                                            <button type="button" class="btn btn-sm btn-outline-primary" id="add-earning-btn">
                                                                <i class="bi bi-plus-lg"></i> Tambah
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    {{-- ← GANTI PERHITUNGAN TOTAL JUGA: proteksi $slip --}}
                                                    @php
                                                        $totalEarnings = collect(
                                                            old(
                                                                'earnings',
                                                                isset($slip)
                                                                    ? $slip->earnings
                                                                    : []
                                                            )
                                                        )->sum('amount');
                                                    @endphp
                                                    <tr class="total-row">
                                                        <td>Total Pendapatan</td>
                                                        <td id="total-earnings">
                                                            Rp {{ number_format($totalEarnings, 0, ',', '.') }}
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <!-- Deductions -->
                                        <div class="tab-pane fade" id="deductions-content">
                                            <h5>Komponen Potongan</h5>
                                            <table class="table table-bordered" id="deductions-table">
                                                <thead>
                                                    <tr>
                                                        <th>Keterangan</th>
                                                        <th>Jumlah (Rp)</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- ← GANTI LOOP INI: old('deductions', isset($slip) ? $slip->deductions->toArray() : [['name'=>'BPJS Kesehatan','amount'=>50000]]) --}}
                                                    @foreach(
                                                        old(
                                                            'deductions',
                                                            isset($slip)
                                                                ? $slip->deductions->toArray()
                                                                : [['name'=>'BPJS Kesehatan','amount'=>50000]]
                                                        ) as $i => $ded
                                                    )
                                                        <tr>
                                                            <td>
                                                                <input type="text"
                                                                       name="deductions[{{ $i }}][name]"
                                                                       class="form-control"
                                                                       value="{{ $ded['name'] }}">
                                                            </td>
                                                            <td>
                                                                <input type="number"
                                                                       name="deductions[{{ $i }}][amount]"
                                                                       class="form-control deduction-amount"
                                                                       value="{{ $ded['amount'] }}">
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-sm btn-outline-danger delete-row-btn">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="3">
                                                            <button type="button" class="btn btn-sm btn-outline-primary" id="add-deduction-btn">
                                                                <i class="bi bi-plus-lg"></i> Tambah
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    {{-- ← GANTI PERHITUNGAN TOTAL JUGA: proteksi $slip --}}
                                                    @php
                                                        $totalDeductions = collect(
                                                            old(
                                                                'deductions',
                                                                isset($slip)
                                                                    ? $slip->deductions
                                                                    : []
                                                            )
                                                        )->sum('amount');
                                                    @endphp
                                                    <tr class="total-row">
                                                        <td>Total Potongan</td>
                                                        <td id="total-deductions">
                                                            Rp {{ number_format($totalDeductions, 0, ',', '.') }}
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            @php
                                                // Jika $slip belum terdefinisi (mis. mode index/create), gunakan array kosong
                                                $earningRowsForPreview   = old('earnings', isset($slip) ? $slip->earnings->toArray() : []);
                                                $deductionRowsForPreview = old('deductions', isset($slip) ? $slip->deductions->toArray() : []);

                                                $previewTotalEarnings   = collect($earningRowsForPreview)->sum('amount');
                                                $previewTotalDeductions = collect($deductionRowsForPreview)->sum('amount');
                                                $previewNetSalary       = $previewTotalEarnings - $previewTotalDeductions;
                                            @endphp
                                            <div class="net-salary d-flex justify-content-between mt-4 p-3 bg-light rounded">
                                                <span class="fw-bold">Gaji Bersih</span>
                                                <span class="fw-bold" id="net-salary-amount">
                                                    Rp {{ number_format($previewNetSalary, 0, ',', '.') }}  <!-- ← PERUBAHAN: pakai $previewNetSalary -->
                                                </span>
                                            </div>
                                        </div>
                                        <!-- Preview -->
                                        <div class="tab-pane fade" id="preview-content">
                                            <div class="preview-container">
                                                <div class="preview-header d-flex justify-content-between align-items-center">
                                                    <div class="company-logo">{{ config('app.name') }}</div>
                                                    <div class="text-end">
                                                        <div class="slip-title mb-2">SLIP GAJI</div>
                                                        <span class="period-badge" id="preview-period">{{ old('period', isset($slip) ? $slip->period->formatLocalized('%B %Y') : '') }}</span>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-md-6">
                                                        <div class="section-title">Informasi Karyawan</div>
                                                        <div class="info-row row">
                                                            <div class="col-5 info-label">Nama</div>
                                                            <div class="col-7 info-value" id="preview-employee-name">
                                                                {{-- Ambil nama langsung dari relasi user --}}
                                                                {{ $slip->user->name ?? '-' }}
                                                            </div>
                                                        </div>
                                                        <div class="info-row row">
                                                            <div class="col-5 info-label">ID</div>
                                                            <div class="col-7 info-value" id="preview-employee-id">
                                                                {{-- Tampilkan ID user --}}
                                                                {{ $slip->user->id ?? '-' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-md-6">
                                                        <div class="section-title">Pendapatan</div>
                                                        <table class="table table-sm table-bordered">
                                                            <tbody id="preview-earnings-body">
                                                                {{-- → GANTI LOOP INI: old('earnings', isset($slip) ? $slip->earnings : []) --}}
                                                                @foreach(old('earnings', isset($slip) ? $slip->earnings : []) as $earning)
                                                                    <tr>
                                                                        <td>{{ $earning['name'] }}</td>
                                                                        <td class="text-end income">
                                                                            {{ number_format($earning['amount'], 0, ',', '.') }}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                @php
                                                                    // → GANTI JUGA HITUNG TOTAL INI:
                                                                    $previewTotalEarnings = collect(
                                                                        old('earnings', isset($slip) ? $slip->earnings : [])
                                                                    )->sum('amount');
                                                                @endphp
                                                                <tr class="total-row">
                                                                    <td>Total</td>
                                                                    <td class="text-end income" id="preview-total-income">
                                                                        {{ number_format($previewTotalEarnings, 0, ',', '.') }}
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="section-title">Potongan</div>
                                                        <table class="table table-sm table-bordered">
                                                            <tbody id="preview-deductions-body">
                                                                {{-- → GANTI LOOP INI: old('deductions', isset($slip) ? $slip->deductions : []) --}}
                                                                @foreach(old('deductions', isset($slip) ? $slip->deductions : []) as $ded)
                                                                    <tr>
                                                                        <td>{{ $ded['name'] }}</td>
                                                                        <td class="text-end deduction">
                                                                            {{ number_format($ded['amount'], 0, ',', '.') }}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                @php
                                                                    // → GANTI JUGA HITUNG TOTAL INI:
                                                                    $previewTotalDeductions = collect(
                                                                        old('deductions', isset($slip) ? $slip->deductions : [])
                                                                    )->sum('amount');
                                                                @endphp
                                                                <tr class="total-row">
                                                                    <td>Total</td>
                                                                    <td class="text-end deduction" id="preview-total-deduction">
                                                                        {{ number_format($previewTotalDeductions, 0, ',', '.') }}
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                @php
                                                    // Hitung total pendapatan dan potongan untuk preview
                                                    $previewTotalEarnings = collect(
                                                        old(
                                                            'earnings',
                                                            isset($slip)
                                                                ? $slip->earnings
                                                                : []
                                                        )
                                                    )->sum('amount');

                                                    $previewTotalDeductions = collect(
                                                        old(
                                                            'deductions',
                                                            isset($slip)
                                                                ? $slip->deductions
                                                                : []
                                                        )
                                                    )->sum('amount');

                                                    $previewNetSalary = $previewTotalEarnings - $previewTotalDeductions;
                                                @endphp
                                                <div class="net-salary d-flex justify-content-between">
                                                    <span>Gaji Bersih</span>
                                                    <span id="preview-net-salary">
                                                        Rp {{ number_format($previewNetSalary, 0, ',', '.') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // format angka jadi ribuan
            function formatCurrency(number) {
                return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            // elemen views
            const payslipsView    = document.getElementById('payslips-view');
            const editPayslipView = document.getElementById('edit-payslip-view');

            // elemen input/tab untuk preview
            const periodInput    = document.getElementById('payslip-period');
            const employeeSelect = document.getElementById('employee-select');
            const preview = {
                period:         document.getElementById('preview-period'),
                name:           document.getElementById('preview-employee-name'),
                id:             document.getElementById('preview-employee-id'),
                earningsBody:   document.getElementById('preview-earnings-body'),
                deductionsBody: document.getElementById('preview-deductions-body'),
                totalIncome:    document.getElementById('preview-total-income'),
                totalDeduction: document.getElementById('preview-total-deduction'),
                netSalary:      document.getElementById('preview-net-salary')
            };

            // --- TOGGLE VIEWS ---
            document.getElementById('create-payslip-btn')?.addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('form-title').textContent = 'Buat Slip Gaji Baru';
                payslipsView.style.display    = 'none';
                editPayslipView.style.display = 'block';
            });

            document.getElementById('cancel-edit-btn')?.addEventListener('click', function(e) {
                e.preventDefault();
                payslipsView.style.display    = 'block';
                editPayslipView.style.display = 'none';
            });

            document.querySelectorAll('.btn-action').forEach(button => {
                if (button.querySelector('.bi-pencil')) {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        document.getElementById('form-title').textContent = 'Edit Slip Gaji';
                        payslipsView.style.display    = 'none';
                        editPayslipView.style.display = 'block';
                    });
                }
            });

            // --- UPDATE PREVIEW ---
            function updatePreview() {
                const [y, m] = (periodInput.value || "").split("-");
                if (y && m) {
                    const date = new Date(`${y}-${m}-01`);
                    preview.period.textContent = date.toLocaleString('id-ID', {
                        month: 'long',
                        year: 'numeric'
                    });
                }
                const sel = employeeSelect.selectedOptions[0];
                preview.name.textContent = sel ? sel.textContent : "-";
                preview.id.textContent   = sel ? sel.value       : "-";

                preview.earningsBody.innerHTML = "";
                document.querySelectorAll('#earnings-table tbody tr').forEach(row => {
                    const [inpName, inpAmt] = row.querySelectorAll('input');
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${inpName.value}</td>
                        <td class="text-end income">${formatCurrency(parseInt(inpAmt.value) || 0)}</td>
                    `;
                    preview.earningsBody.appendChild(tr);
                });

                preview.deductionsBody.innerHTML = "";
                document.querySelectorAll('#deductions-table tbody tr').forEach(row => {
                    const [inpName, inpAmt] = row.querySelectorAll('input');
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${inpName.value}</td>
                        <td class="text-end deduction">${formatCurrency(parseInt(inpAmt.value) || 0)}</td>
                    `;
                    preview.deductionsBody.appendChild(tr);
                });
            }

            // --- KALKULASI TOTAL ---
            function calculateTotals() {
                let totalEarnings   = 0;
                let totalDeductions = 0;
                document.querySelectorAll('.earning-amount').forEach(i => {
                    totalEarnings += parseInt(i.value) || 0;
                });
                document.querySelectorAll('.deduction-amount').forEach(i => {
                    totalDeductions += parseInt(i.value) || 0;
                });
                const netSalary = totalEarnings - totalDeductions;

                document.getElementById('total-earnings').textContent    = 'Rp ' + formatCurrency(totalEarnings);
                document.getElementById('total-deductions').textContent  = 'Rp ' + formatCurrency(totalDeductions);
                document.getElementById('net-salary-amount').textContent = 'Rp ' + formatCurrency(netSalary);

                preview.totalIncome.textContent    = formatCurrency(totalEarnings);
                preview.totalDeduction.textContent = formatCurrency(totalDeductions);
                preview.netSalary.textContent      = 'Rp ' + formatCurrency(netSalary);

                updatePreview();
            }

            // --- AUTO-SUBMIT FILTER ---
            // gunakan selector berdasarkan kelas form agar ketemu setelah blade render
            const filterForm  = document.querySelector('form.row.mb-3');
            const filterMonth = document.getElementById('filter-month');
            const filterYear  = document.getElementById('filter-year');

            filterMonth?.addEventListener('change', () => filterForm.submit());
            filterYear?.addEventListener('change', () => filterForm.submit());

            // event listeners add/tambah + input change
            document.getElementById('add-earning-btn')?.addEventListener('click', e => {
                e.preventDefault();
                calculateTotals();
            });
            document.getElementById('add-deduction-btn')?.addEventListener('click', e => {
                e.preventDefault();
                calculateTotals();
            });
            document.querySelectorAll('.earning-amount, .deduction-amount').forEach(i => {
                i.addEventListener('input', calculateTotals);
            });
            periodInput?.addEventListener('change', updatePreview);
            employeeSelect?.addEventListener('change', updatePreview);

            // update saat tab Pratinjau dibuka
            document.querySelector('button[data-bs-target="#preview-content"]')
                ?.addEventListener('shown.bs.tab', updatePreview);

            // inisialisasi
            calculateTotals();
        });
    </script>
</body>
</html>