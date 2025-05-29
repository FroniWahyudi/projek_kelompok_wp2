<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Slip Gaji Baru</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, sans-serif;
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
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 1px 10px rgba(0, 0, 0, 0.05);
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
            background-color: #f8f9fa;
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
        #employeeTable tbody tr {
            cursor: pointer;
        }
        /* Status Badge Styles */
        .status-badge {
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 700;
            border-radius: 0.25rem;
        }
        .status-checking {
            background-color: #f6c23e;
            color: #000;
        }
        .status-exists {
            background-color: #1cc88a;
            color: white;
        }
        .status-not-exists {
            background-color: #e74a3b;
            color: white;
        }
        .status-error {
            background-color: #36b9cc;
            color: white;
        }
        /* Slide-up Animation Styles */
        .table-container {
            transition: height 0.3s ease-out;
            overflow: hidden;
        }
        .table-row {
            transition: all 0.3s ease-out;
            overflow: hidden;
        }
        .table-row.hidden-row {
            margin-top: -60px; /* Sesuaikan dengan tinggi baris */
            opacity: 0;
            height: 0;
            padding: 0;
            pointer-events: none;
            position: absolute;
        }
        .table-row.active-row {
            background-color: #edf2f7;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 p-0">
                <div class="main-content">
                    <div id="create-payslip-view">
                        <form method="POST" action="{{ route('slips.store') }}" id="payslip-form">
                            @csrf
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h1 class="page-title mb-0">Buat Slip Gaji Baru</h1>
                                <div>
                                    <a href="{{ route('slips.index') }}" class="btn btn-outline-secondary me-2">
                                        <i class="bi bi-x-lg"></i> Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save"></i> Simpan
                                    </button>
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
                                        <!-- Informasi Dasar -->
                                        <div class="tab-pane fade show active" id="info-content">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">ID Slip Gaji</label>
                                                        <input type="text" name="id" class="form-control" value="{{ 'SG-' . now()->format('Y') . '-' . sprintf('%03d', $nextId) }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Periode</label>
                                                        <input type="month" id="payslip-period" name="period" class="form-control" value="{{ old('period', now()->format('Y-m')) }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Pilih Karyawan</label>
                                                        <button id="resetEmployeeTable" class="btn btn-sm btn-outline-secondary ms-2" style="display: none;">Tampilkan Semua</button>
                                                        <!-- Search bar dan filter department -->
                                                        <div class="d-flex mb-3">
                                                            <input type="text" id="search-input" class="form-control me-2" placeholder="Cari nama karyawan...">
                                                            <select id="department-filter" class="form-select">
                                                                <option value="">Semua Department</option>
                                                                @foreach ($departments as $department)
                                                                    <option value="{{ $department }}">{{ $department }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <!-- Hidden input untuk menyimpan user_id -->
                                                        <input type="hidden" name="user_id" id="selected-employee-id">
                                                        <div id="employeeTableContainer" class="table-container">
                                                            <table class="table table-striped align-middle mb-0" id="employeeTable">
                                                                <thead class="table-dark">
                                                                    <tr>
                                                                        <th>Foto</th>
                                                                        <th>Nama</th>
                                                                        <th>Departemen</th>
                                                                        <th>Status</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($users as $user)
                                                                        <tr class="table-row" data-department="{{ $user->department }}" data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                                                                            <td>
                                                                                <img src="{{ $user->photo_url ? asset($user->photo_url) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                                                                                     width="40" height="40" class="rounded-circle"
                                                                                     alt="{{ $user->name }}">
                                                                            </td>
                                                                            <td>{{ $user->name }}</td>
                                                                            <td>{{ $user->department }}</td>
                                                                            <td></td> <!-- Status akan diperbarui via AJAX -->
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
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
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="earnings[0][name]" class="form-control" value="Gaji Pokok" required>
                                                        </td>
                                                        <td>
                                                            <input type="number" name="earnings[0][amount]" class="form-control earning-amount" value="5000000" required>
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-sm btn-outline-danger delete-row-btn">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="earnings[1][name]" class="form-control" value="Tunjangan Transportasi" required>
                                                        </td>
                                                        <td>
                                                            <input type="number" name="earnings[1][amount]" class="form-control earning-amount" value="200000" required>
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-sm btn-outline-danger delete-row-btn">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="earnings[2][name]" class="form-control" value="Tunjangan Makan" required>
                                                        </td>
                                                        <td>
                                                            <input type="number" name="earnings[2][amount]" class="form-control earning-amount" value="300000" required>
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-sm btn-outline-danger delete-row-btn">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="earnings[3][name]" class="form-control" value="Insentif Kinerja" required>
                                                        </td>
                                                        <td>
                                                            <input type="number" name="earnings[3][amount]" class="form-control earning-amount" value="1000000" required>
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-sm btn-outline-danger delete-row-btn">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="earnings[4][name]" class="form-control" value="Tunjangan Jabatan" required>
                                                        </td>
                                                        <td>
                                                            <input type="number" name="earnings[4][amount]" class="form-control earning-amount" value="1000000" required>
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-sm btn-outline-danger delete-row-btn">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
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
                                                        <td id="total-earnings">Rp 5.000.000</td>
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
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="deductions[0][name]" class="form-control" value="BPJS Kesehatan (1%)">
                                                        </td>
                                                        <td>
                                                            <input type="number" name="deductions[0][amount]" class="form-control deduction-amount" value="50000">
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-sm btn-outline-danger delete-row-btn">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="deductions[1][name]" class="form-control" value="BPJS Ketenagakerjaan (2%)">
                                                        </td>
                                                        <td>
                                                            <input type="number" name="deductions[1][amount]" class="form-control deduction-amount" value="100000">
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-sm btn-outline-danger delete-row-btn">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="deductions[2][name]" class="form-control" value="PPh 21">
                                                        </td>
                                                        <td>
                                                            <input type="number" name="deductions[2][amount]" class="form-control deduction-amount" value="125000">
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-sm btn-outline-danger delete-row-btn">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
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
                                                        <td id="total-deductions">Rp 50.000</td>
                                                        <td></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <div class="net-salary d-flex justify-content-between mt-4 p-3 bg-light rounded">
                                                <span class="fw-bold">Gaji Bersih</span>
                                                <span class="fw-bold" id="net-salary-amount">Rp 4.950.000</span>
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
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="section-title">Potongan</div>
                                                        <table class="table table-sm table-bordered">
                                                            <tbody id="preview-deductions-body">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="net-salary d-flex justify-content-between">
                                                    <span>Gaji Bersih</span>
                                                    <span id="preview-net-salary">Rp 0</span>
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
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fungsi untuk memformat angka ke dalam format mata uang
        function formatCurrency(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        // Elemen input/tab untuk preview
        const periodInput = document.getElementById('payslip-period');
        const preview = {
            period: document.getElementById('preview-period'),
            name: document.getElementById('preview-employee-name'),
            id: document.getElementById('preview-employee-id'),
            earningsBody: document.getElementById('preview-earnings-body'),
            deductionsBody: document.getElementById('preview-deductions-body'),
            netSalary: document.getElementById('preview-net-salary')
        };

        // Variabel untuk fitur slide-up
        let isTransitioning = false;
        const employeeTableContainer = document.getElementById('employeeTableContainer');
        const resetEmployeeTableButton = document.getElementById('resetEmployeeTable');
        const tableRows = document.querySelectorAll('#employeeTable .table-row');
        const thead = employeeTableContainer.querySelector('thead');
        let isFocused = false;
        let activeRow = null;

        // Fungsi debounce untuk mengurangi pemanggilan berulang
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Fungsi untuk menghitung total pendapatan, potongan, dan gaji bersih
        const calculateTotals = debounce(function() {
            let totalEarnings = 0;
            let totalDeductions = 0;

            document.querySelectorAll('.earning-amount').forEach(input => {
                const amount = parseInt(input.value) || 0;
                totalEarnings += amount;
            });

            document.querySelectorAll('.deduction-amount').forEach(input => {
                const amount = parseInt(input.value) || 0;
                totalDeductions += amount;
            });

            const netSalary = totalEarnings - totalDeductions;

            document.getElementById('total-earnings').textContent = 'Rp ' + formatCurrency(totalEarnings);
            document.getElementById('total-deductions').textContent = 'Rp ' + formatCurrency(totalDeductions);
            document.getElementById('net-salary-amount').textContent = 'Rp ' + formatCurrency(netSalary);

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

            const selectedRow = document.querySelector('#employeeTable tbody tr.table-active');
            if (selectedRow) {
                preview.name.textContent = selectedRow.getAttribute('data-name');
                preview.id.textContent = selectedRow.getAttribute('data-id');
            } else {
                preview.name.textContent = "-";
                preview.id.textContent = "-";
            }

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
            const earningTotalRow = document.createElement('tr');
            earningTotalRow.className = 'total-row';
            earningTotalRow.innerHTML = `
                <td>Total</td>
                <td class="text-end income">${formatCurrency(totalEarnings)}</td>
            `;
            preview.earningsBody.appendChild(earningTotalRow);

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
            const deductionTotalRow = document.createElement('tr');
            deductionTotalRow.className = 'total-row';
            deductionTotalRow.innerHTML = `
                <td>Total</td>
                <td class="text-end deduction">${formatCurrency(totalDeductions)}</td>
            `;
            preview.deductionsBody.appendChild(deductionTotalRow);

            preview.netSalary.textContent = 'Rp ' + formatCurrency(netSalary);
        }, 300);

        // Fungsi untuk menerapkan filter
        function applyFilters() {
            const searchText = searchInput.value.toLowerCase();
            const selectedDepartment = departmentFilter.value;

            tableRows.forEach(row => {
                const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const department = row.getAttribute('data-department');
                const matchesSearch = name.includes(searchText);
                const matchesDepartment = selectedDepartment === '' || department === selectedDepartment;

                if (matchesSearch && matchesDepartment) {
                    row.classList.remove('hidden-row');
                } else {
                    row.classList.add('hidden-row');
                }
            });
        }

        // Event listener untuk klik pada baris karyawan
        const tbody = document.querySelector('#employeeTable tbody');
        tbody.addEventListener('click', function(e) {
            const tr = e.target.closest('tr');
            if (tr) {
                if (tr.classList.contains('active-row')) {
                    resetEmployeeTableView();
                } else {
                    tbody.querySelectorAll('tr').forEach(row => {
                        row.classList.remove('table-active');
                        row.classList.remove('active-row');
                    });
                    tr.classList.add('table-active');
                    tr.classList.add('active-row');
                    const employeeId = tr.getAttribute('data-id');
                    document.getElementById('selected-employee-id').value = employeeId;
                    focusOnEmployeeRow(tr);
                    calculateTotals();
                }
            }
        });

        // Fungsi fokus pada baris
        function focusOnEmployeeRow(activeRow) {
            if (isTransitioning) return;
            isTransitioning = true;

            const initialHeight = employeeTableContainer.scrollHeight;
            employeeTableContainer.style.height = initialHeight + 'px';

            setTimeout(() => {
                tableRows.forEach(row => {
                    if (row !== activeRow) {
                        row.classList.add('hidden-row');
                    } else {
                        row.classList.remove('hidden-row');
                    }
                });

                const focusedHeight = thead.offsetHeight + activeRow.offsetHeight;
                employeeTableContainer.style.height = focusedHeight + 'px';

                setTimeout(() => {
                    isTransitioning = false;
                }, 300); // Durasi transisi dikurangi menjadi 300ms
            }, 0);

            isFocused = true;
            resetEmployeeTableButton.style.display = 'inline-block';
        }

        // Fungsi reset tampilan
        function resetEmployeeTableView() {
            if (isTransitioning) return;
            isTransitioning = true;

            const initialHeight = employeeTableContainer.scrollHeight;
            employeeTableContainer.style.height = initialHeight + 'px';

            setTimeout(() => {
                tableRows.forEach(row => {
                    row.classList.remove('hidden-row');
                });

                applyFilters();

                const fullHeight = employeeTableContainer.scrollHeight;
                employeeTableContainer.style.height = fullHeight + 'px';

                setTimeout(() => {
                    employeeTableContainer.style.height = 'auto';
                    isTransitioning = false;
                }, 300); // Durasi transisi dikurangi menjadi 300ms
            }, 0);

            isFocused = false;
            resetEmployeeTableButton.style.display = 'none';
            document.getElementById('selected-employee-id').value = '';
            tbody.querySelectorAll('tr').forEach(row => {
                row.classList.remove('active-row');
                row.classList.remove('table-active');
            });
            calculateTotals();
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
                    <td><input type="text" class="form-control" name="earnings[${rowCount}][name]" placeholder="Nama Komponen" required></td>
                    <td><input type="number" class="form-control earning-amount" name="earnings[${rowCount}][amount]" value="0" required></td>
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
        document.querySelector('button[data-bs-target="#preview-content"]')?.addEventListener('shown.bs.tab', calculateTotals);

        // Validasi form submit
        const form = document.getElementById('payslip-form');
        form.addEventListener('submit', function(e) {
            let isValid = true;
            let errorMessage = '';

            if (!periodInput.value) {
                isValid = false;
                errorMessage += 'Periode harus diisi.\n';
            }

            const selectedEmployeeId = document.getElementById('selected-employee-id').value;
            if (!selectedEmployeeId) {
                isValid = false;
                errorMessage += 'Karyawan harus dipilih.\n';
            }

            const earningsRows = document.querySelectorAll('#earnings-table tbody tr');
            if (earningsRows.length === 0) {
                isValid = false;
                errorMessage += 'Harus ada setidaknya satu komponen pendapatan.\n';
            } else {
                earningsRows.forEach((row, index) => {
                    const nameInput = row.querySelector(`input[name="earnings[${index}][name]"]`);
                    const amountInput = row.querySelector(`input[name="earnings[${index}][amount]"]`);
                    if (!nameInput.value.trim()) {
                        isValid = false;
                        errorMessage += 'Nama komponen pendapatan tidak boleh kosong.\n';
                    }
                    if (!amountInput.value || parseInt(amountInput.value) <= 0) {
                        isValid = false;
                        errorMessage += 'Jumlah pendapatan harus lebih dari 0.\n';
                    }
                });
            }

            const deductionsRows = document.querySelectorAll('#deductions-table tbody tr');
            deductionsRows.forEach((row, index) => {
                const nameInput = row.querySelector(`input[name="deductions[${index}][name]"]`);
                const amountInput = row.querySelector(`input[name="deductions[${index}][amount]"]`);
                if (nameInput.value.trim() && (!amountInput.value || parseInt(amountInput.value) < 0)) {
                    isValid = false;
                    errorMessage += 'Jumlah potongan harus 0 atau lebih jika nama diisi.\n';
                }
                if (amountInput.value && !nameInput.value.trim()) {
                    isValid = false;
                    errorMessage += 'Nama komponen potongan tidak boleh kosong jika jumlah diisi.\n';
                }
            });
        });

        // Filter tabel karyawan
        const searchInput = document.getElementById('search-input');
        const departmentFilter = document.getElementById('department-filter');

        // Event listener untuk filter dan reset
        searchInput.addEventListener('input', function() {
            if (!isFocused) {
                applyFilters();
            }
        });
        departmentFilter.addEventListener('change', function() {
            if (!isFocused) {
                applyFilters();
            }
        });
        resetEmployeeTableButton.addEventListener('click', resetEmployeeTableView);

        // Inisialisasi awal
        calculateTotals();

        // Status check functionality dengan delay
        var checkAjaxUrl = "{{ route('slips.check.ajax') }}";
        var csrfToken = '{{ csrf_token() }}';

        function updateStatuses(period) {
            if (period) {
                $('#employeeTable tbody tr').each(function() {
                    var statusCell = $(this).find('td:last');
                    statusCell.html('<span class="status-badge status-checking">Checking</span>');
                });

                var totalRows = $('#employeeTable tbody tr').length;
                var completed = 0;

                $('#employeeTable tbody tr').each(function() {
                    var userId = $(this).data('id');
                    var statusCell = $(this).find('td:last');
                    var row = $(this);

                    setTimeout(function() {
                        $.ajax({
                            url: checkAjaxUrl,
                            method: 'POST',
                            data: {
                                user_id: userId,
                                period: period,
                                _token: csrfToken
                            },
                            success: function(response) {
                                if (response.exists) {
                                    statusCell.html('<span class="status-badge status-exists">Slip sudah dibuat</span>');
                                } else {
                                    statusCell.html('<span class="status-badge status-not-exists">Slip belum dibuat</span>');
                                }
                            },
                            error: function(xhr, status, error) {
                                statusCell.html('<span class="status-badge status-error">Error</span>');
                                console.error(error);
                            },
                            complete: function() {
                                completed++;
                                // When all AJAX calls are done, sort the rows
                                if (completed === totalRows) {
                                    sortEmployeeRowsByStatus();
                                }
                            }
                        });
                    }, 100); // Delay 100ms untuk mengurangi beban
                });
            }
        }

        // Function to sort employee rows by status
        function sortEmployeeRowsByStatus() {
            var rows = $('#employeeTable tbody tr').get();
            rows.sort(function(a, b) {
                var statusA = $(a).find('td:last .status-badge').text().trim();
                var statusB = $(b).find('td:last .status-badge').text().trim();
                // If status is 'Slip sudah dibuat', sort it last
                if (statusA === 'Slip sudah dibuat' && statusB !== 'Slip sudah dibuat') {
                    return 1;
                } else if (statusA !== 'Slip sudah dibuat' && statusB === 'Slip sudah dibuat') {
                    return -1;
                } else {
                    // Otherwise, keep original order
                    return 0;
                }
            });
            $.each(rows, function(idx, row) {
                $('#employeeTable tbody').append(row);
            });
        }

        $('#payslip-period').on('change', function() {
            var period = $(this).val();
            updateStatuses(period);
        });

        var initialPeriod = $('#payslip-period').val();
        if (initialPeriod) {
            updateStatuses(initialPeriod);
        }
    });
    </script>
</body>
</html>