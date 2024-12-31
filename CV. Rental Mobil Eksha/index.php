<?php
session_start();
include 'config.php'; // Pastikan file config.php terhubung dengan benar

// Query untuk mengambil data mobil
$query = mysqli_query($koneksi, "SELECT * FROM tbl_mobil_eksha");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Rental Mobil Eksha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> <!-- Font Awesome for social media icons -->
    <style>
        body {
            background-image: url('https://source.unsplash.com/1600x900/?car,rent');
            background-size: cover;
            background-position: center;
            color: #fff;
            margin-top: 0;
        }
        .navbar {
            background: linear-gradient(90deg, #007bff, #5e60ce);
            padding: 10px 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.8rem;
            color: #fff !important;
            text-transform: uppercase;
        }
        .navbar .btn-primary {
            background-color: #28a745;
            border: none;
            transition: background-color 0.3s;
            border-radius: 5px;
        }
        .navbar .btn-primary:hover {
            background-color: #218838;
        }
        .title {
            color: #007bff;
            font-weight: bold;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
        }
        .card {
            background-color: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
        .card .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: black;
        }
        .card .card-text {
            font-size: 1.2rem;
            color: black;
        }
        .status-tersedia {
            font-size: 1.2rem;
            color: #28a745; /* Hijau untuk Tersedia */
            font-weight: bold;
        }
        .status-tidak-tersedia {
            font-size: 1.2rem;
            color: #FF0000; /* Merah untuk Tidak Tersedia */
            font-weight: bold;
        }
        footer {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 5px 0;
            width: 100%;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">CV Rental Mobil Eksha</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="btn btn-primary" href="login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <br>
    <br>
    <!-- Content -->
    <div class="container text-center">
        <h1 class="title">Temukan Mobil Untuk di Rental Sesuai Kebutuhan Anda</h1>
        <br><br>

        <!-- Data Mobil -->
        <div class="row mt-5">
            <?php 
            while ($data = mysqli_fetch_array($query)) { 
                // Cek status mobil berdasarkan tabel tbl_rental_eksha
                $query_status = mysqli_query($koneksi, "SELECT status_eksha FROM tbl_rental_eksha WHERE no_plat_eksha = '{$data['no_plat_eksha']}' ORDER BY tgl_rental_eksha DESC LIMIT 1");
                if (mysqli_num_rows($query_status) > 0) {
                    $status_data = mysqli_fetch_array($query_status);
                    $status = ($status_data['status_eksha'] == 'Aktif') ? 'Tidak Tersedia' : 'Tersedia';
                    $status_class = ($status_data['status_eksha'] == 'Aktif') ? 'status-tidak-tersedia' : 'status-tersedia';
                } else {
                    $status = 'Tersedia'; // Default jika tidak ada transaksi rental
                    $status_class = 'status-tersedia';
                }
            ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <?php
                        $absolute_path = "C:/xampp/htdocs/Pemrograman Internet/CV. Rental Mobil Eksha/Foto Mobil Rental/" . $data['foto_mobil_eksha'];
                        $relative_path = str_replace("C:/xampp/htdocs/", "/", $absolute_path);
                        ?>
                        <img src="<?= $relative_path; ?>" alt="<?= $data['nama_mobil_eksha']; ?>">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= $data['nama_mobil_eksha']; ?></h5>
                            <p class="card-text">
                                Brand: <?= $data['brand_mobil_eksha']; ?><br>
                                Transmisi: <?= $data['tipe_transmisi_eksha']; ?>
                            </p>
                            <p class="card-price">Harga Sewa: Rp. <?= number_format($data['harga_sewa_eksha'], 0, ',', '.'); ?>/hari</p>
                            <p class="<?= $status_class; ?>"><?= $status; ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<br>
<br>
    <!-- Footer -->
    <footer>
        <p>2024@ Eksha Oktavian Perdana</p>
    </footer>

    <script src="https
