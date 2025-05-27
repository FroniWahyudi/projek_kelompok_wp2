<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Slip Gaji</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input {
            margin-bottom: 10px;
            padding: 5px;
            width: 200px;
        }
        button {
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        p {
            margin-top: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .status-updating {
            color: #888;
        }
        .status-exists {
            color: green;
        }
        .status-not-exists {
            color: red;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Ambil URL dari data attribute
            var checkAjaxUrl = "{{ route('slips.check.ajax') }}";
            var csrfToken = '{{ csrf_token() }}';

            $('#period').on('change', function() {
                var period = $(this).val();
                if (period) {
                    // Ambil semua user_id dari tabel
                    $('table tbody tr').each(function() {
                        var userId = $(this).find('td:first').text();
                        var statusCell = $(this).find('td:last');

                        // Tampilkan indikator updating
                        statusCell.text('Checking...').addClass('status-updating').removeClass('status-exists status-not-exists');

                        // Panggil endpoint untuk cek slip
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
                                    statusCell.text('Slip sudah dibuat').addClass('status-exists').removeClass('status-updating status-not-exists');
                                } else {
                                    statusCell.text('Slip belum dibuat').addClass('status-not-exists').removeClass('status-updating status-exists');
                                }
                            },
                            error: function(xhr, status, error) {
                                statusCell.text('Error checking status').addClass('status-updating').removeClass('status-exists status-not-exists');
                                console.error(error);
                            }
                        });
                    });
                }
            });
        });
    </script>
</head>
<body>
    <h1>Cek Slip Gaji</h1>
    <form action="{{ route('slips.check') }}" method="POST">
        @csrf
        <div>
            <label for="user_id">User ID:</label>
            <input type="text" id="user_id" name="user_id" required>
        </div>
        <div>
            <label for="period">Periode (YYYY-MM):</label>
            <input type="month" id="period" name="period" required>
        </div>
        <button type="submit">Cek</button>
    </form>

    @if (isset($message))
        <p>{{ $message }}</p>
    @endif

    @if (isset($slip))
        <h2>Detail Slip</h2>
        <p>Nomor Slip: {{ $slip->slip_number }}</p>
        <p>Periode: {{ $slip->period }}</p>
        <!-- Tambahkan detail lain jika diperlukan -->
    @endif

    <h2>Daftar User</h2>
    @if (isset($users) && $users->isNotEmpty())
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td></td> <!-- Awalnya kosong, akan diisi oleh JavaScript -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Tidak ada data user.</p>
    @endif
</body>
</html>