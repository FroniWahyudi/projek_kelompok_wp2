<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji - {{ $slip->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .slip-gaji {
            width: 539px; /* Lebar efektif A4 (595px - 2 x 28px margin) */
            margin: 0 auto;
            padding: 25px;
            box-sizing: border-box;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .logo img {
            width: 40px;
            height: auto;
        }
        .title {
            text-align: right;
        }
        .title h2 {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
            color: #212529;
            text-transform: uppercase;
        }
        .bulan {
            display: inline-block;
            background: #e0e0e0;
            padding: 2px 10px;
            border-radius: 10px;
            font-size: 14px;
            color: #495057;
        }
        hr {
            margin: 20px 0;
            border: 1px solid #ddd;
        }
        .informasi-karyawan h3 {
            font-size: 15px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 10px;
        }
        .informasi-karyawan p {
            margin: 0;
            font-size: 14px;
        }
        .informasi-karyawan p strong {
            color: #6c757d;
            font-weight: 500;
        }
        .pendapatan-potongan {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .kolom {
            width: 48%;
        }
        .bordered-table {
            width: 100%;
            border-collapse: collapse;
            border-left: 1px solid #ccc;
            border-right: 1px solid #ccc;
            border-top: 1px solid #ccc;
            margin-top: 10px;
        }
        .bordered-table th,
        .bordered-table td {
            text-align: left;
            padding: 8px 6px;
            border-bottom: 1px solid #ccc;
        }
        .bordered-table th {
            font-weight: 600;
            font-size: 14px;
            background-color: #f8f9fa;
        }
        .bordered-table .total-row td {
            font-weight: bold;
        }
        .green {
            color: #198754;
            font-weight: bold;
        }
        .red {
            color: #dc3545;
            font-weight: bold;
        }
        .gaji-bersih {
            background: #f1f1f1;
            padding: 15px;
            margin-top: 25px;
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            font-size: 18px;
        }
        .catatan {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="slip-gaji">
        <div class="header">
            <div class="logo">
                <img src="{{ public_path('img/logo_brand.png') }}" alt="Logo {{ config('app.name') }}" width="40">
                <div>
                    <strong>{{ config('app.name', 'Naga Hytam') }}</strong><br>
                    Sejahtera Abadi
                </div>
            </div>
            <div class="title">
                <h2>SLIP GAJI</h2>
                <div class="bulan">{{ $slip->period->formatLocalized('%B %Y') }}</div>
            </div>
        </div>

        <hr>

        <div class="informasi-karyawan">
            <h3>Informasi Karyawan</h3>
            <p><strong>Nama:</strong> {{ $slip->user->name }}</p>
            <p><strong>ID:</strong> {{ $slip->user->id }}</p>
        </div>

        <div class="pendapatan-potongan">
            <div class="kolom">
                <h4>Pendapatan</h4>
                <table class="bordered-table">
                    <thead>
                        <tr>
                            <th>Keterangan</th>
                            <th>Jumlah (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($slip->earnings as $earning)
                            <tr>
                                <td>{{ $earning->name }}</td>
                                <td class="green">{{ number_format($earning->amount, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        <tr class="total-row">
                            <td>Total Pendapatan</td>
                            <td class="green">{{ number_format($slip->earnings->sum('amount'), 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="kolom">
                <h4>Potongan</h4>
                <table class="bordered-table">
                    <thead>
                        <tr>
                            <th>Keterangan</th>
                            <th>Jumlah (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($slip->deductions as $deduction)
                            <tr>
                                <td>{{ $deduction->name }}</td>
                                <td class="red">{{ number_format($deduction->amount, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        <tr class="total-row">
                            <td>Total Potongan</td>
                            <td class="red">{{ number_format($slip->deductions->sum('amount'), 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="gaji-bersih">
            <span>Gaji Bersih</span>
            <span>{{ number_format($slip->net_salary, 0, ',', '.') }}</span>
        </div>

        <div class="catatan">
            Slip gaji ini dihasilkan secara elektronik dan sah tanpa tanda tangan.<br>
            Jika ada pertanyaan mengenai slip gaji ini, silakan hubungi Departemen SDM.
        </div>
    </div>
</body>
</html>