<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Slip Gaji</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #f8f9fc;
            --success-color: #1cc88a;
            --danger-color: #e74a3b;
            --warning-color: #f6c23e;
            --info-color: #36b9cc;
        }
        
        body {
            background-color: #f8f9fc;
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
        
        .card {
            border: none;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        .card-header {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
            border-radius: 0.35rem 0.35rem 0 0 !important;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2653d4;
        }
        
        .status-badge {
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 700;
            border-radius: 0.25rem;
        }
        
        .status-checking {
            background-color: var(--warning-color);
            color: #000;
        }
        
        .status-exists {
            background-color: var(--success-color);
            color: white;
        }
        
        .status-not-exists {
            background-color: var(--danger-color);
            color: white;
        }
        
        .status-error {
            background-color: var(--info-color);
            color: white;
        }
        
        .slip-details {
            background-color: white;
            border-left: 0.25rem solid var(--primary-color);
            padding: 1rem;
            margin-bottom: 1rem;
        }
        
        .slip-details h5 {
            color: var(--primary-color);
        }
        
        .table-responsive {
            border-radius: 0.35rem;
            overflow: hidden;
        }
        
        .table thead th {
            background-color: var(--secondary-color);
            font-weight: 600;
        }
        
        .loading-spinner {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            vertical-align: middle;
            border: 0.2em solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            animation: spinner-border 0.75s linear infinite;
        }
        
        @keyframes spinner-border {
            to { transform: rotate(360deg); }
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
        }
    </style>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Ambil URL dari data attribute
            var checkAjaxUrl = "{{ route('slips.check.ajax') }}";
            var csrfToken = '{{ csrf_token() }}';

            // Event listener untuk form submission
            $('#checkSlipForm').on('submit', function(e) {
                e.preventDefault();
                
                var userId = $('#user_id').val();
                var period = $('#period').val();
                
                if (!userId || !period) {
                    alert('Please fill in all fields');
                    return;
                }
                
                // Show loading state
                $('#resultContainer').hide();
                $('button[type="submit"]').html('<span class="loading-spinner"></span> Checking...').prop('disabled', true);
                
                // Simulate API call
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
                            $('#slipNumber').text(response.slip.slip_number || '-');
                            $('#employeeName').text(response.slip.employee_name || '-');
                            $('#slipPeriod').text(response.slip.period || '-');
                            $('#slipStatus').text('Available').addClass('status-exists').removeClass('status-not-exists status-error');
                        } else {
                            $('#slipNumber').text('-');
                            $('#employeeName').text('-');
                            $('#slipPeriod').text(period);
                            $('#slipStatus').text('Not Available').addClass('status-not-exists').removeClass('status-exists status-error');
                        }
                        $('#resultContainer').fadeIn();
                        $('button[type="submit"]').html('<i class="fas fa-search me-1"></i> Check Slip').prop('disabled', false);
                    },
                    error: function(xhr, status, error) {
                        $('#slipStatus').text('Error').addClass('status-error').removeClass('status-exists status-not-exists');
                        console.error(error);
                        $('#resultContainer').fadeIn();
                        $('button[type="submit"]').html('<i class="fas fa-search me-1"></i> Check Slip').prop('disabled', false);
                    }
                });
            });

            // Filter period change handler
            $('#period').on('change', function() {
                var period = $(this).val();
                
                if (period) {
                    // Show loading state for all status cells
                    $('#employeeTableBody tr').each(function() {
                        var statusCell = $(this).find('td:last');
                        statusCell.html('<span class="status-badge status-checking"><span class="loading-spinner"></span> Checking</span>');
                    });
                    
                    // Panggil endpoint untuk cek slip untuk setiap user
                    $('#employeeTableBody tr').each(function() {
                        var userId = $(this).find('td:first').text();
                        var statusCell = $(this).find('td:last');

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
                            }
                        });
                    });
                }
            });

            // Initialize tooltips (jika ada)
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-money-bill-wave me-2"></i>Salary Slip Checker</h6>
                    </div>
                    <div class="card-body">
                        <form id="checkSlipForm" class="row g-3">
                            <div class="col-md-6">
                                <label for="user_id" class="form-label">Employee ID</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    <input type="text" class="form-control" id="user_id" name="user_id" placeholder="Enter employee ID" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="period" class="form-label">Payroll Period</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="month" class="form-control" id="period" name="period" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-1"></i> Check Slip
                                </button>
                            </div>
                        </form>
                        
                        <div id="resultContainer" class="mt-4" style="display: none;">
                            <div class="slip-details">
                                <h5 class="mb-3"><i class="fas fa-file-invoice me-2"></i>Slip Details</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Slip Number:</strong> <span id="slipNumber">-</span></p>
                                        <p><strong>Employee Name:</strong> <span id="employeeName">-</span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Period:</strong> <span id="slipPeriod">-</span></p>
                                        <p><strong>Status:</strong> <span id="slipStatus" class="status-badge">-</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-users me-2"></i>Employee List</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="filterPeriod" class="form-label">Filter by Payroll Period</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-filter"></i></span>
                                <input type="month" class="form-control" id="filterPeriod">
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Employee ID</th>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Slip Status</th>
                                    </tr>
                                </thead>
                                <tbody id="employeeTableBody">
                                    @if (isset($users) && $users->isNotEmpty())
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->department ?? '' }}</td>
                                                <td><span class="status-badge"></span></td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada data user.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        
                        <nav aria-label="Page navigation" class="mt-3">
                            <ul class="pagination justify-content-center">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>