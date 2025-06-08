<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Slip Gaji - {{ $slip->id }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
      <!-- Css Custom -->
    <link rel="stylesheet" href="{{ asset('css/slip_detail.css') }}">
</head>
<body>
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title">Detail Slip Gaji</h1>
            <a href="{{ route('slips.index') }}" class="btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="preview-container w-100">
            <div class="preview-header">
                <div class="company-logo">
                    <img src="{{ asset('img/logo_brand.png') }}" alt="Logo {{ config('app.name') }}">
                </div>
                <div class="text-end">
                    <div class="slip-title">SLIP GAJI</div>
                    <span class="period-badge">{{ $slip->period->formatLocalized('%B %Y') }}</span>
                </div>
            </div>
            <div class="mb-4" style="display: flex; gap: 32px; margin-bottom: 20px;">
                <!-- Informasi Karyawan (Kiri) -->
                <div style="flex:1; background: linear-gradient(to bottom);">
                    <div class="section-title">Informasi Karyawan</div>
                    <div class="info-row">
                        <div class="info-label">Nama</div>
                        <div class="info-value">{{ $slip->user->name }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">ID</div>
                        <div class="info-value">{{ $slip->user->id_karyawan }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Departemen</div>
                        <div class="info-value">{{ $slip->user->department }}</div>
                    </div>
                </div>
                <!-- Perusahaan (Kanan) -->
                <div style="flex:1;">
                    <div class="section-title">Perusahaan</div>
                    <div class="info-row">
                        <div class="info-label">Nama</div>
                        <div class="info-value">PT Naga Hytam Sejahtera Abadi</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Periode</div>
                        <div class="info-value">{{ $slip->period->formatLocalized('%B %Y') }}</div>
                    </div>
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
                        <td style="border-right:none; background-color:#cce5ff; font-weight:bold; color:#003366;"> Gaji Bersih</td>
                        <td style="border-left:none; text-align:end; background-color:#cce5ff; font-weight:bold; color:#003366;">{{ number_format($slip->net_salary, 0, ',', '.') }}</td>
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

    // Pilih elemen parent yang lebih besar (misalnya .main-content)
    const element = document.querySelector('.main-content');

    if (!element) {
        alert('Elemen .main-content tidak ditemukan. Pastikan elemen tersebut ada di halaman.');
        return;
    }

    // Daftar elemen yang ingin disembunyikan
    const elementsToHide = [
        document.querySelector('.d-flex.justify-content-between.align-items-center.mb-4'), // Tombol "Batal" dan "Simpan"
        document.querySelector('.nav-tabs'), // Tab navigasi
        document.querySelector('#info-content'), // Tab Informasi Dasar
        document.querySelector('#earnings-content'), // Tab Pendapatan
        document.querySelector('#deductions-content'), // Tab Potongan
        document.querySelector('.net-salary.d-flex.justify-content-between.mt-4.p-3.bg-light.rounded'), // Gaji Bersih di tab Potongan
        document.querySelector('.footer-actions')
    ];

    // Simpan status display asli dan sembunyikan elemen
    const originalDisplayStyles = [];
    elementsToHide.forEach((el, index) => {
        if (el) {
            originalDisplayStyles[index] = el.style.display; // Simpan display asli
            el.style.display = 'none'; // Sembunyikan elemen
        } else {
            originalDisplayStyles[index] = null; // Jika elemen tidak ditemukan
        }
    });

    // Konfigurasi html2pdf
    const opt = {
        margin: [-5, 0, 20, 5], // [atas, kanan, bawah, kiri] dalam mm
        filename: `slip-gaji-${slipId}-${slipPeriod}.pdf`,
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2, useCORS: true },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
        pagebreak: { mode: ['avoid-all', 'css', 'legacy'] } // Hindari pemotongan elemen
    };

    // Buat PDF dengan elemen yang telah dimodifikasi
    html2pdf().set(opt).from(element).save().then(() => {
        // Kembalikan tampilan elemen setelah PDF selesai dibuat
        elementsToHide.forEach((el, index) => {
            if (el && originalDisplayStyles[index] !== null) {
                el.style.display = originalDisplayStyles[index] || ''; // Kembalikan display asli
            }
        });
    }).catch(err => {
        console.error('Gagal membuat PDF:', err);
        alert('Terjadi kesalahan saat membuat PDF. Silakan coba lagi.');
        // Kembalikan tampilan elemen meskipun terjadi error
        elementsToHide.forEach((el, index) => {
            if (el && originalDisplayStyles[index] !== null) {
                el.style.display = originalDisplayStyles[index] || '';
            }
        });
    });
}
</script>
</body>
</html>