<?php
session_start();
include 'config.php';

// Jika belum login, arahkan ke halaman login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Query untuk mengambil data mobil
$query = mysqli_query($koneksi, "SELECT * FROM tbl_mobil_eksha");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Rental Mobil Eksha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            color: #333;
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        .navbar {
            background: linear-gradient(90deg, #1c1c1c, #5e60ce);
            padding: 10px 15px;
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: #fff !important;
        }
        .navbar .btn-primary {
            background-color: #28a745;
            border: none;
            transition: background-color 0.3s;
            margin-right: 5px;
            border-radius: 5px;
        }
        .navbar .btn-primary:hover {
            background-color: #218838;
        }
        .navbar .btn-danger {
            margin-left: 95px;
        }
        .navbar .btn-danger:hover {
            background-color: #c82333;
        }
        .navbar-nav {
            display: flex;
            justify-content: flex-end;
            width: 100%;
        }
        .navbar-nav .nav-item {
            margin: 0 5px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(30, 50, 228, 0.1);
            margin-top: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }
        .card img {
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .car-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 20px;
            margin-top: 20px;
        }
        .car-card {
            opacity: 0;
            transform: translateY(50px);
            animation: fadeInUp 1s forwards;
        }
        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(50px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .status-tersedia {
            color: #28a745;
            font-weight: bold;
        }
        .status-tidak-tersedia {
            color: #dc3545;
            font-weight: bold;
        }
        .welcome-text {
            color: #5e60ce;
            font-weight: bold;
        }
        footer {
            background: linear-gradient(90deg, #1c1c1c, #5e60ce);
            color: white;
            text-align: center;
            padding: 10px 0;
            font-size: 1rem;
            border-top: 2px solid #ffffff33;
            box-shadow: 0 -1px 5px rgba(0, 0, 0, 0.2);
        }
        footer p {
            margin: 0;
            line-height: 1.6;
            font-weight: 500;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="#">CV Rental Mobil Eksha</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="btn btn-primary" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="btn btn-primary" href="mobil.php">Data Mobil</a></li>
                <li class="nav-item"><a class="btn btn-primary" href="pelanggan.php">Data Pelanggan</a></li>
                <li class="nav-item"><a class="btn btn-primary" href="rental.php">Reservasi</a></li>
                <li class="nav-item"><a class="btn btn-danger" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<br>
<br>
<!-- Ucapan Selamat Datang -->
<div class="container text-center">
    <div class="card">
        <div class="card-body">
            <h3 class="welcome-text">Selamat Datang, <?= isset($_SESSION['username']) ? $_SESSION['username'] : 'User'; ?>!</h3>
            <p>Anda berhasil login ke Dashboard CV Rental Mobil Eksha. Gunakan menu di atas untuk navigasi lebih lanjut.</p>
        </div>
    </div>
</div>

<!-- Data Mobil -->
<div class="container car-container">
    <?php 
    while ($data = mysqli_fetch_array($query)) { 
        $query_status = mysqli_query($koneksi, "SELECT status_eksha FROM tbl_rental_eksha WHERE no_plat_eksha = '{$data['no_plat_eksha']}' ORDER BY tgl_rental_eksha DESC LIMIT 1");
        if (mysqli_num_rows($query_status) > 0) {
            $status_data = mysqli_fetch_array($query_status);
            $status = ($status_data['status_eksha'] == 'Aktif') ? 'Tidak Tersedia' : 'Tersedia';
            $status_class = ($status_data['status_eksha'] == 'Aktif') ? 'status-tidak-tersedia' : 'status-tersedia';
        } else {
            $status = 'Tersedia';
            $status_class = 'status-tersedia';
        }
    ?>
        <div class="card car-card" style="width: 18rem;">
            <img src="<?= "Foto Mobil Rental/" . $data['foto_mobil_eksha']; ?>" alt="<?= $data['nama_mobil_eksha']; ?>">
            <div class="card-body">
                <h5 class="card-title"><?= $data['nama_mobil_eksha']; ?></h5>
                <p class="card-text">
                    Brand: <?= $data['brand_mobil_eksha']; ?><br>
                    Transmisi: <?= $data['tipe_transmisi_eksha']; ?>
                </p>
                <p class="card-price">Rp. <?= number_format($data['harga_sewa_eksha'], 0, ',', '.'); ?>/hari</p>
                <p class="<?= $status_class; ?>"><?= $status; ?></p>
            </div>
        </div>
    <?php } ?>
</div>
<br>
<br>
<footer>
    <p>2024@ Eksha Oktavian Perdana</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
