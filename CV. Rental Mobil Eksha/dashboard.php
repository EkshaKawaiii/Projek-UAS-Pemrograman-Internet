<?php
session_start();
include 'config.php';

// Jika belum login, arahkan ke halaman login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
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
            height: 100vh;
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
            background-color: #28a745; /* Blue color for buttons */
            border: none;
            transition: background-color 0.3s;
            margin-right: 5px;
        }
        .navbar .btn-primary:hover {
            background-color: #28a745; /* Darker blue on hover */
        }

        .navbar .btn-danger {
            background-color: #dc3545; /* Red color for logout button */
            border: none;
        }
        .navbar .btn-danger:hover {
            background-color: #c82333; /* Darker red on hover */
        }

        .navbar-nav {
            display: flex;
            justify-content: flex-end;
            width: 100%;
        }

        .navbar-nav .nav-item {
            margin: 0 5px;
        }

        .navbar-nav .ml-auto {
            margin-left: 100px;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            width: 100%;
            max-width: 900px;
            padding: 40px;
            text-align: center;
            margin-top: 50px;
        }
        .card h3 {
            font-size: 3rem;
            font-weight: bold;
            color: #5e60ce;
        }
        .card p {
            font-size: 1.4rem;
            margin-top: 20px;
            color: #333;
        }

        .container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0 15px;
        }

        footer {
            background: linear-gradient(90deg, #1c1c1c, #5e60ce);
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: auto;
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
                        <a class="btn btn-primary" href="mobil.php">Data Mobil</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary" href="pelanggan.php">Data Pelanggan</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary" href="rental.php">Reservasi</a>
                    </li>
                    <li class="nav-item ml-auto">
                        <a class="btn btn-danger" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <h3>Selamat Datang, <?= isset($_SESSION['username']) ? $_SESSION['username'] : 'User'; ?>!</h3>
                    <p>Anda berhasil login ke Dashboard CV Rental Mobil Eksha. Gunakan menu di atas untuk navigasi lebih lanjut.</p>
                    <p>Silakan pilih salah satu menu untuk mengelola reservasi, pelanggan, atau melihat data mobil.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        2024@ Eksha Oktavian Perdana
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
