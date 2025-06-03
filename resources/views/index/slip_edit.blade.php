<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Slip Gaji</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f0f4f8;
            font-family: 'Segoe UI', Tahoma, sans-serif;
            color: #4a4a4a;
        }
        .main-content {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 25px;
            min-height: 90vh;
        }
        .page-title {
            font-size: 26px;
            font-weight: 700;
            color: #003366;
            margin-bottom: 20px;
            letter-spacing: -0.5px;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            margin-bottom: 25px;
            overflow: hidden;
        }
        .card-header {
            background: linear-gradient(120deg, #e3f2fd, #e1f5fe);
            border: none;
            padding: 18px 20px;
            font-weight: 700;
            font-size: 18px;
            color: #003366;
            border-radius: 12px 12px 0 0 !important;
            font-weight: 600;
        }
        .table th {
            font-weight: 700;
            color: #003366;
            background-color: #f8f9fa;
            padding: 12px 15px;
        }
        .form-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
            font-size: 15px;
        }
        .tab-content {
            padding: 25px 0;
        }
        .nav-tabs {
            border: none;
            padding: 0;
        }
        .nav-tabs .nav-link {
            color: #555;
            border: none;
            padding: 12px 20px;
            font-weight: 600;
            font-size: 15px;
            border-radius: 8px 8px 0 0;
            margin-right: 5px;
            background: #f8f9fa;
            transition: all 0.3s;
        }
        .nav-tabs .nav-link:hover {
            background: #e9ecef;
            color: #007bff;
        }
        .nav-tabs .nav-link.active {
            color: #007bff;
            background: #ffffff;
            border-bottom: 3px solid #007bff;
            position: relative;
            z-index: 1;
        }
        .preview-container {
            max-width: 800px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 35px;
            border: 1px solid #e1e8ed;
        }
        .preview-header {
            border-bottom: 2px solid #e1e8ed;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }
        .company-logo {
            font-size: 24px;
            font-weight: bold;
            color: #003366;
        }
        .slip-title {
            font-size: 24px;
            font-weight: 700;
            color: #003366;
            letter-spacing: -0.5px;
        }
        .period-badge {
            background: #e9ecef;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 15px;
            color: #555;
            font-weight: 600;
        }
        .section-title {
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 15px;
            color: #003366;
            border-bottom: 1px solid #e1e8ed;
            padding-bottom: 10px;
        }
        .info-row {
            margin-bottom: 10px;
        }
        .info-label {
            font-weight: 600;
            color: #555;
        }
        .info-value {
            font-weight: 600;
            color: #003366;
        }
        .total-row {
            font-weight: 700;
            background: #f8f9fa;
        }
        .income {
            color: #198754;
            font-weight: 600;
        }
        .deduction {
            color: #dc3545;
            font-weight: 600;
        }
        .net-salary {
            font-size: 20px;
            font-weight: 800;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-top: 25px;
            border-left: 4px solid #007bff;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 123, 255, 0.25);
        }
        .form-control, .form-select {
            border: 1px solid #d1d9e6;
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 15px;
            transition: all 0.3s;
            background-color: #f8fafc;
        }
        .form-control:focus, .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.15);
            background-color: #fff;
        }
        .add-item-btn {
            border-radius: 8px;
            padding: 8px 15px;
            font-size: 14px;
            font-weight: 600;
        }
        .delete-row-btn {
            border-radius: 8px;
            padding: 5px 10px;
            font-size: 14px;
        }
        .table-bordered {
            border: 1px solid #e1e8ed;
            border-radius: 10px;
            overflow: hidden;
        }
        .table-bordered th, .table-bordered td {
            padding: 12px 15px;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 p-0">
                <div class="main-content">
                    <div id="edit-payslip-view">
                        <form method="POST" action="{{ route('slips.update', $slip->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h1 class="page-title mb-0">Edit Slip Gaji</h1>
                                <div>
                                    <a href="{{ route('slips.index') }}" class="btn btn-outline-secondary me-2">
                                        <i class="bi bi-x-lg"></i> Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save"></i> Simpan
                                    </button>
                                </div>
                            </div>
                            @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
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
                                        <!-- Informasi Dasar -->
                                        <div class="tab-pane fade show active" id="info-content">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">ID Slip Gaji</label>
                                                        <p>{{ $slip->slip_number }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Periode</label>
                                                        <input type="month" id="payslip-period" name="period" class="form-control" value="{{ $slip->period }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Pilih Karyawan</label>
                                                        <select name="user_id" id="employee-select" class="form-select" disabled>
                                                            @foreach($users as $user)
                                                                <option value="{{ $user->id }}" {{ $slip->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Pendapatan -->
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
                                                    @foreach($slip->earnings as $index => $earning)
                                                        <tr>
                                                            <td>
                                                                <input type="hidden" name="earnings[{{ $index }}][id]" value="{{ $earning->id }}">
                                                                <input type="text" name="earnings[{{ $index }}][name]" class="form-control" value="{{ $earning->name }}" required>
                                                            </td>
                                                            <td>
                                                                <input type="number" name="earnings[{{ $index }}][amount]" class="form-control earning-amount" value="{{ $earning->amount }}">
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
                                                            <button type="button" class="btn btn-sm btn-outline-primary add-earning-btn">
                                                                <i class="bi bi-plus-lg"></i> Tambah
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <tr class="total-row">
                                                        <td>Total Pendapatan</td>
                                                        <td id="total-earnings">Rp {{ number_format($slip->earnings->sum('amount'), 0, ',', '.') }}</td>
                                                        <td></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <!-- Potongan -->
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
                                                    @foreach($slip->deductions as $index => $deduction)
                                                        <tr>
                                                            <td>
                                                                <input type="hidden" name="deductions[{{ $index }}][id]" value="{{ $deduction->id }}">
                                                                <input type="text" name="deductions[{{ $index }}][name]" class="form-control" value="{{ $deduction->name }}" required>
                                                            </td>
                                                            <td>
                                                                <input type="number" name="deductions[{{ $index }}][amount]" class="form-control deduction-amount" value="{{ $deduction->amount }}">
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
                                                            <button type="button" class="btn btn-sm btn-outline-primary add-deduction-btn">
                                                                <i class="bi bi-plus-lg"></i> Tambah
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <tr class="total-row">
                                                        <td>Total Potongan</td>
                                                        <td id="total-deductions">Rp {{ number_format($slip->deductions->sum('amount'), 0, ',', '.') }}</td>
                                                        <td></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <div class="net-salary d-flex justify-content-between mt-4 p-3 bg-light rounded">
                                                <span class="fw-bold">Gaji Bersih</span>
                                                <span class="fw-bold" id="net-salary-amount">Rp {{ number_format($slip->earnings->sum('amount') - $slip->deductions->sum('amount'), 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                        <!-- Pratinjau -->
                                        <div class="tab-pane fade" id="preview-content">
                                            <div class="preview-container">
                                                <div class="preview-header d-flex justify-content-between align-items-center">
                                                               <div class="company-logo">
    <img src="{{ asset('img/logo_brand.png') }}" 
         alt="Logo {{ config('app.name') }}" 
         style="height: 71px; object-fit: contain;">
</div>
                                                    <div class="text-end">
                                                        <div class="slip-title mb-2">SLIP GAJI</div>
                                                        <span class="period-badge" id="preview-period">-</span>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-md-6">
                                                        <div class="section-title">Informasi Karyawan</div>
                                                        <div class="info-row row">
                                                            <div class="col-5 info-label">Nama</div>
                                                            <div class="col-7 info-value" id="preview-employee-name">-</div>
                                                        </div>
                                                        <div class="info-row row">
                                                            <div class="col-5 info-label">ID</div>
                                                            <div class="col-7 info-value" id="preview-employee-id">-</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-md-6">
                                                        <div class="section-title">Pendapatan</div>
                                                        <table class="table table-sm table-bordered">
                                                            <tbody id="preview-earnings-body">
                                                                <!-- Diperbarui oleh JavaScript -->
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="section-title">Potongan</div>
                                                        <table class="table table-sm table-bordered">
                                                            <tbody id="preview-deductions-body">
                                                                <!-- Diperbarui oleh JavaScript -->
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="net-salary d-flex justify-content-between">
                                                    <span>Gaji Bersih</span>
                                                    <span id="preview-net-salary">Rp {{ number_format($slip->earnings->sum('amount') - $slip->deductions->sum('amount'), 0, ',', '.') }}</span>
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
            // Fungsi untuk memformat angka ke dalam format mata uang
            function formatCurrency(number) {
                return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            // Elemen input/tab untuk preview
            const periodInput = document.getElementById('payslip-period');
            const employeeSelect = document.getElementById('employee-select');
            const preview = {
                period: document.getElementById('preview-period'),
                name: document.getElementById('preview-employee-name'),
                id: document.getElementById('preview-employee-id'),
                earningsBody: document.getElementById('preview-earnings-body'),
                deductionsBody: document.getElementById('preview-deductions-body'),
                totalIncome: document.getElementById('preview-total-income'),
                totalDeduction: document.getElementById('preview-total-deduction'),
                netSalary: document.getElementById('preview-net-salary')
            };

            // Fungsi untuk menghitung total pendapatan, potongan, dan gaji bersih
            function calculateTotals() {
                let totalEarnings = 0;
                let totalDeductions = 0;

                // Hitung total pendapatan
                document.querySelectorAll('.earning-amount').forEach(input => {
                    const amount = parseInt(input.value) || 0;
                    totalEarnings += amount;
                });

                // Hitung total potongan
                document.querySelectorAll('.deduction-amount').forEach(input => {
                    const amount = parseInt(input.value) || 0;
                    totalDeductions += amount;
                });

                const netSalary = totalEarnings - totalDeductions;

                // Perbarui tampilan total di tabel
                document.getElementById('total-earnings').textContent = 'Rp ' + formatCurrency(totalEarnings);
                document.getElementById('total-deductions').textContent = 'Rp ' + formatCurrency(totalDeductions);
                document.getElementById('net-salary-amount').textContent = 'Rp ' + formatCurrency(netSalary);

                // Perbarui pratinjau
                updatePreview(totalEarnings, totalDeductions, netSalary);
            }

            // Fungsi untuk memperbarui pratinjau
            function updatePreview(totalEarnings, totalDeductions, netSalary) {
                const [y, m] = (periodInput.value || "").split("-");
                if (y && m) {
                    const date = new Date(`${y}-${m}-01`);
                    preview.period.textContent = date.toLocaleString('id-ID', {
                        month: 'long',
                        year: 'numeric'
                    });
                } else {
                    preview.period.textContent = '-';
                }

                const sel = employeeSelect.selectedOptions[0];
                preview.name.textContent = sel ? sel.textContent : "-";
                preview.id.textContent = sel ? sel.value : "-";

                // Update tabel pendapatan di pratinjau
                preview.earningsBody.innerHTML = "";
                document.querySelectorAll('#earnings-table tbody tr').forEach(row => {
                    const [inpName, inpAmt] = row.querySelectorAll('input[type="text"], input[type="number"]');
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${inpName.value}</td>
                        <td class="text-end income">${formatCurrency(parseInt(inpAmt.value) || 0)}</td>
                    `;
                    preview.earningsBody.appendChild(tr);
                });
                const earningTotalRow = document.createElement('tr');
                earningTotalRow.className = 'total-row';
                earningTotalRow.innerHTML = `
                    <td>Total</td>
                    <td class="text-end income">${formatCurrency(totalEarnings)}</td>
                `;
                preview.earningsBody.appendChild(earningTotalRow);

                // Update tabel potongan di pratinjau
                preview.deductionsBody.innerHTML = "";
                document.querySelectorAll('#deductions-table tbody tr').forEach(row => {
                    const [inpName, inpAmt] = row.querySelectorAll('input[type="text"], input[type="number"]');
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${inpName.value}</td>
                        <td class="text-end deduction">${formatCurrency(parseInt(inpAmt.value) || 0)}</td>
                    `;
                    preview.deductionsBody.appendChild(tr);
                });
                const deductionTotalRow = document.createElement('tr');
                deductionTotalRow.className = 'total-row';
                deductionTotalRow.innerHTML = `
                    <td>Total</td>
                    <td class="text-end deduction">${formatCurrency(totalDeductions)}</td>
                `;
                preview.deductionsBody.appendChild(deductionTotalRow);

                // Update total di pratinjau
                preview.netSalary.textContent = 'Rp ' + formatCurrency(netSalary);
            }

            // Event listeners untuk input pendapatan dan potongan
            document.querySelectorAll('.earning-amount, .deduction-amount').forEach(input => {
                input.addEventListener('input', calculateTotals);
            });

            // Event listener untuk tombol tambah pendapatan
            document.querySelectorAll('.add-earning-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    new bootstrap.Tab(document.querySelector('#earnings-content')).show();
                    const tbody = document.querySelector('#earnings-table tbody');
                    const rowCount = tbody.querySelectorAll('tr').length;
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td><input type="text" class="form-control" name="earnings[${rowCount}][name]" placeholder="Nama Komponen"></td>
                        <td><input type="number" class="form-control earning-amount" name="earnings[${rowCount}][amount]" value="0"></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-danger delete-row-btn">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    `;
                    tbody.appendChild(row);
                    row.querySelector('.earning-amount').addEventListener('input', calculateTotals);
                    calculateTotals();
                });
            });

            // Event listener untuk tombol tambah potongan
            document.querySelectorAll('.add-deduction-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    new bootstrap.Tab(document.querySelector('#deductions-content')).show();
                    const tbody = document.querySelector('#deductions-table tbody');
                    const rowCount = tbody.querySelectorAll('tr').length;
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td><input type="text" class="form-control" name="deductions[${rowCount}][name]" placeholder="Nama Komponen"></td>
                        <td><input type="number" class="form-control deduction-amount" name="deductions[${rowCount}][amount]" value="0"></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-danger delete-row-btn">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    `;
                    tbody.appendChild(row);
                    row.querySelector('.deduction-amount').addEventListener('input', calculateTotals);
                    calculateTotals();
                });
            });

            // Event listener untuk menghapus baris
            document.querySelectorAll('#earnings-table tbody, #deductions-table tbody').forEach(tbody => {
                tbody.addEventListener('click', function(e) {
                    if (e.target.closest('.delete-row-btn')) {
                        e.target.closest('tr').remove();
                        calculateTotals();
                    }
                });
            });

            // Preview change listeners
            periodInput?.addEventListener('change', calculateTotals);
            employeeSelect?.addEventListener('change', calculateTotals);
            document.querySelector('button[data-bs-target="#preview-content"]')?.addEventListener('shown.bs.tab', calculateTotals);

            // Inisialisasi awal
            calculateTotals();
        });
    </script>
</body>
</html>