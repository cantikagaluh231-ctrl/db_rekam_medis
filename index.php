<?php 
include 'koneksi.php';
include 'header.php';

// Atur Timezone Indonesia (WIB)
date_default_timezone_set('Asia/Jakarta');

$total_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pasien"))['total'];
$total_dokter = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM dokter"))['total'];
$total_obat   = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM obat"))['total'];
$total_rekam  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM rekam_medis"))['total'];

// Array Nama Bulan Bahasa Indonesia
$bulan = array(
    1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
);
$tgl_indo = date('d') . ' ' . $bulan[(int)date('m')] . ' ' . date('Y');
?>

<!-- Banner Utama -->
<div class="hero-banner-aesthetic mb-4">
    <div class="row align-items-center">
        <div class="col-md-7">
            <span class="badge bg-success bg-opacity-75 text-white rounded-pill px-3 py-2 fw-semibold mb-3">
                <i class="fa-solid fa-circle me-1" style="font-size: 7px;"></i> Sistem Aktif & Terintegrasi
            </span>
            <h1 class="fw-bold text-primary mb-2" style="font-size: 2rem; letter-spacing: -0.5px; color: #1e3a8a !important;">
                Selamat Datang di<br>SIMRS Medika
            </h1>
            <p class="text-secondary fw-medium mb-0" style="max-width: 480px; font-size: 0.9rem;">
                Sistem Informasi Pengelolaan Rekam Medis & Pelayanan Kesehatan Digital.
            </p>
        </div>
        <div class="col-md-5 d-none d-md-flex justify-content-end">
            <div class="date-badge">
                <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2">
                    <i class="fa-solid fa-calendar-days fa-lg"></i>
                </div>
                <div>
                    <span class="text-muted d-block" style="font-size: 0.75rem; font-weight: 600;">Tanggal Sistem</span>
                    <strong style="color: #1e3a8a; font-size: 0.95rem;"><?= $tgl_indo; ?></strong>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Grid Card Stats -->
<div class="row g-4 mb-4">
    <!-- Card Pasien -->
    <div class="col-md-3">
        <div class="card-stat-soft">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon-bg bg-soft-blue shadow-sm">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <span class="text-muted fw-semibold small d-block">Total Pasien</span>
                    <h2 class="fw-bold mb-0" style="color: #1e293b;"><?= $total_pasien; ?></h2>
                    <span class="badge badge-trend bg-primary bg-opacity-10 text-primary mt-1">↑ +0%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Dokter -->
    <div class="col-md-3">
        <div class="card-stat-soft">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon-bg bg-soft-green shadow-sm">
                    <i class="fa-solid fa-user-doctor"></i>
                </div>
                <div>
                    <span class="text-muted fw-semibold small d-block">Total Dokter</span>
                    <h2 class="fw-bold mb-0" style="color: #1e293b;"><?= $total_dokter; ?></h2>
                    <span class="badge badge-trend bg-success bg-opacity-10 text-success mt-1">↑ +0%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Obat -->
    <div class="col-md-3">
        <div class="card-stat-soft">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon-bg bg-soft-purple shadow-sm">
                    <i class="fa-solid fa-bed-pulse"></i>
                </div>
                <div>
                    <span class="text-muted fw-semibold small d-block">Stok Jenis Obat</span>
                    <h2 class="fw-bold mb-0" style="color: #1e293b;"><?= $total_obat; ?></h2>
                    <span class="badge badge-trend bg-purple bg-opacity-10 text-purple mt-1" style="color: #a855f7; background: #f3e8ff;">↑ +0%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Rekam Medis -->
    <div class="col-md-3">
        <div class="card-stat-soft">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon-bg bg-soft-cyan shadow-sm">
                    <i class="fa-solid fa-prescription-bottle-medical"></i>
                </div>
                <div>
                    <span class="text-muted fw-semibold small d-block">Rekam Medis</span>
                    <h2 class="fw-bold mb-0" style="color: #1e293b;"><?= $total_rekam; ?></h2>
                    <span class="badge badge-trend bg-info bg-opacity-10 text-info mt-1">↑ +0%</span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>