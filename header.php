<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMRS Medika - Portal Rekam Medis</title>
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS & JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --bg-canvas: #edf5fd;
            --sidebar-width: 250px;
            --blue-primary: #0284c7;
            --blue-gradient: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            --text-dark: #1e293b;
            --text-muted: #64748b;
        }

        body {
            background-color: var(--bg-canvas);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* Sidebar Navigation Left */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: #ffffff;
            padding: 20px 16px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.02);
            z-index: 100;
            overflow-y: auto;
        }

        .brand-logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-bottom: 15px;
        }

        .brand-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            box-shadow: 0 8px 20px rgba(14, 165, 233, 0.3);
            margin-bottom: 8px;
        }

        .brand-title {
            font-weight: 800;
            font-size: 1.15rem;
            color: #0284c7;
            letter-spacing: -0.5px;
            line-height: 1.1;
            text-align: center;
        }

        .brand-title span {
            color: #0369a1;
            display: block;
        }

        .nav-menu {
            list-style: none;
            padding: 0;
            margin: 15px 0;
        }

        .nav-item-custom {
            margin-bottom: 6px;
        }

        .nav-link-custom {
            display: flex;
            align-items: center;
            padding: 10px 16px;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        .nav-link-custom i {
            width: 22px;
            font-size: 1rem;
            margin-right: 10px;
        }

        .nav-link-custom:hover {
            color: var(--blue-primary);
            background: #f0f7ff;
        }

        .nav-link-custom.active {
            background: var(--blue-gradient);
            color: #ffffff !important;
            box-shadow: 0 6px 16px rgba(2, 132, 199, 0.3);
        }

        .sidebar-widget {
            background: linear-gradient(180deg, #e0f2fe 0%, #bae6fd 100%);
            border-radius: 16px;
            padding: 14px 12px;
            text-align: center;
            margin-top: 15px;
        }

        .sidebar-widget-icon {
            width: 38px;
            height: 38px;
            background: #0284c7;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 6px auto;
            font-size: 1rem;
            box-shadow: 0 4px 10px rgba(2, 132, 199, 0.3);
        }

        /* Main Wrapper */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            padding: 24px 32px;
            min-height: 100vh;
        }

        /* Topbar Header */
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .search-box {
            position: relative;
            width: 380px;
        }

        .search-box input {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 30px;
            padding: 9px 20px 9px 42px;
            font-size: 0.88rem;
            width: 100%;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
            outline: none;
            transition: all 0.2s ease;
        }

        .search-box input:focus {
            border-color: #0284c7;
            box-shadow: 0 4px 14px rgba(2, 132, 199, 0.15);
        }

        .search-box i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .btn-icon-top {
            width: 40px;
            height: 40px;
            background: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            cursor: pointer;
        }

        .user-card {
            background: #ffffff;
            padding: 5px 14px 5px 6px;
            border-radius: 30px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            cursor: pointer;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            background: #1e3a8a;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
        }

        /* Container Card & Table RS */
        .card-aesthetic {
            background: #ffffff;
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        }

        .table-rs {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        .table-rs thead {
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            color: #ffffff;
        }

        .table-rs th {
            padding: 14px 18px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
            white-space: nowrap;
        }

        .table-rs td {
            padding: 16px 18px;
            background: #ffffff;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            font-size: 0.9rem;
        }

        .table-rs tbody tr:hover td {
            background-color: #f8fafc;
        }

        .action-group {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            white-space: nowrap;
        }

        .btn-action-edit {
            background: #fef3c7;
            color: #d97706;
            border: none;
            border-radius: 10px;
            padding: 7px 12px;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-action-edit:hover {
            background: #fde047;
            color: #b45309;
            transform: translateY(-1px);
        }

        .btn-action-delete {
            background: #ffe4e6;
            color: #e11d48;
            border: none;
            border-radius: 10px;
            padding: 7px 12px;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-action-delete:hover {
            background: #fecdd3;
            color: #be123c;
            transform: translateY(-1px);
        }

        .swal2-popup {
            border-radius: 24px !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            padding: 24px !important;
        }
    </style>
</head>
<body>

<aside class="sidebar">
    <div>
        <div class="brand-logo">
            <div class="brand-icon">
                <i class="fa-solid fa-hospital"></i>
            </div>
            <div class="brand-title">SIMRS<span>MEDIKA</span></div>
        </div>

        <?php $page = basename($_SERVER['PHP_SELF']); ?>
        <ul class="nav-menu">
            <li class="nav-item-custom">
                <a href="index.php" class="nav-link-custom <?= ($page == 'index.php') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-house"></i> Dashboard
                </a>
            </li>
            <li class="nav-item-custom">
                <a href="pasien.php" class="nav-link-custom <?= ($page == 'pasien.php') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-users"></i> Pasien
                </a>
            </li>
            <li class="nav-item-custom">
                <a href="dokter.php" class="nav-link-custom <?= ($page == 'dokter.php') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-user-doctor"></i> Dokter
                </a>
            </li>
            <li class="nav-item-custom">
                <a href="obat.php" class="nav-link-custom <?= ($page == 'obat.php') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-pills"></i> Obat
                </a>
            </li>
            <li class="nav-item-custom">
                <a href="rekam_medis.php" class="nav-link-custom <?= ($page == 'rekam_medis.php') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-file-medical"></i> Rekam Medis
                </a>
            </li>
        </ul>
    </div>

    <div class="sidebar-widget">
        <div class="sidebar-widget-icon">
            <i class="fa-solid fa-heart-pulse"></i>
        </div>
        <div style="font-size: 0.7rem; font-weight: 700; color: #0369a1; line-height: 1.3;">
            Pelayanan Sehat,<br>Untuk Masa Depan<br>Lebih Baik
        </div>
    </div>
</aside>

<div class="main-wrapper">
    <!-- Topbar Header dengan Live Search -->
    <div class="topbar">
        <div class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="globalSearchInput" placeholder="Cari data di tabel halaman ini...">
        </div>
        <div class="user-profile">
            <div class="btn-icon-top">
                <i class="fa-solid fa-bell"></i>
            </div>
            <div class="user-card">
                <div class="user-avatar"><i class="fa-solid fa-user"></i></div>
                <span style="font-size: 0.88rem; font-weight: 700;">Admin</span>
                <i class="fa-solid fa-chevron-down text-muted" style="font-size: 0.7rem;"></i>
            </div>
        </div>
    </div>

    <!-- Live Search JavaScript -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById("globalSearchInput");
        if (searchInput) {
            searchInput.addEventListener("keyup", function() {
                const filter = searchInput.value.toLowerCase();
                const tableRows = document.querySelectorAll("tbody tr");
                
                tableRows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(filter)) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            });
        }
    });
    </script>