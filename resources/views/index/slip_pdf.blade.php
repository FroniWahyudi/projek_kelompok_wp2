<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji - {{ $slip->id }}</title>
    <!-- Css Custom -->
    <link rel="stylesheet" href="{{ asset('css/slip_pdf.css') }}">
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