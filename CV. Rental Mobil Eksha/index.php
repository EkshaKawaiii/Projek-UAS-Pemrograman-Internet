<?php
include 'config.php';

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
            transition: background-color 0.3s ease;
        }
        .navbar:hover {
            background: linear-gradient(90deg, #5e60ce, #007bff); /* Reverse the gradient on hover */
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.8rem;
            color: #fff !important;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }
        .navbar-brand:hover {
            color: #28a745 !important;
        }
        .navbar .btn-primary {
            background-color: #28a745; /* Bright orange */
            border: none;
            transition: background-color 0.3s;
            border-radius: 5px;
        }
        .navbar .btn-primary:hover {
            background-color: #28a745; /* Darker orange on hover */
        }
        .navbar-nav {
            display: flex;
            justify-content: flex-end;
            width: 100%;
        }
        .navbar-nav .nav-item {
            margin: 0 15px;
        }
        .navbar-nav .nav-link {
            color: white !important;
            font-size: 1.1rem;
            text-transform: capitalize;
            letter-spacing: 0.5px;
        }
        .navbar-nav .nav-link:hover {
            color: #f8f9fa !important;
            text-decoration: underline;
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
        .card .card-title {
            margin: 10px 0 0;
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
        }
        .container {
            margin-top: 100px;
        }
        /* Footer Style */
        footer {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 5px 0; /* Reduced padding for smaller space */
            width: 100%;
        }
        .contact-container {
            background-color: rgba(255, 255, 255, 0.8); /* Light background for the contact container */
            padding: 60px 0;
            margin-top: 20px;
        }
        .contact-container p {
            font-size: 1.5rem;
            color: #000; /* Change contact text color to black */
            font-weight: bold;
        }
        .contact-container a {
            text-decoration: none;
            color: #000; /* Black color for contact text */
            font-size: 2rem; /* Increased font size */
            margin-right: 20px; /* Add space between icons */
        }
        .contact-container a:hover {
            text-decoration: underline;
        }
        .contact-icons i {
            font-size: 4rem; /* Increased icon size */
            margin-right: 20px;
            transition: color 0.3s;
        }
        .contact-icons i:hover {
            color: #28a745; /* Green color on hover */
        }
        .contact-container h3 {
            color: black; /* Black color for 'Kontak Kami' heading */
            font-size: 2.5rem; /* Increased size for title */
            font-weight: bold;
        }
        /* Center the content inside the contact-container */
        .contact-container .contact-icons {
            display: flex;
            justify-content: center;
            align-items: center;
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

    <!-- Content -->
    <div class="container text-center">
        <h1 class="title">Temukan Mobil Untuk di Rental Sesuai Kebutuhan Anda</h1>
        <br><br>

        <!-- Data Mobil -->
        <div class="row mt-5">
            <?php while ($data = mysqli_fetch_array($query)) { ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <?php
                        $absolute_path = "C:/xampp/htdocs/Pemrograman Internet/CV. Rental Mobil Eksha/Foto Mobil Rental/" . $data['foto_mobil_eksha'];
                        $relative_path = str_replace("C:/xampp/htdocs/", "/", $absolute_path);
                        ?>
                        <img src="<?= $relative_path; ?>" alt="<?= $data['nama_mobil_eksha']; ?>">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= $data['nama_mobil_eksha']; ?></h5> <!-- Nama Mobil -->
                            <p class="card-text">
                                Brand: <?= $data['brand_mobil_eksha']; ?><br>
                                Transmisi: <?= $data['tipe_transmisi_eksha']; ?><br>
                                No Plat: <?= $data['no_plat_eksha']; ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="container contact-container">
        <h3>Kontak Kami</h3>
        <div class="contact-icons">
            <a href="https://wa.me/1234567890" target="_blank"><i class="fab fa-whatsapp" style="color: #25D366;"></i>WhatsApp</a>
            <a href="https://instagram.com/eksha_oktavian_69" target="_blank"><i class="fab fa-instagram" style="color: #E4405F;"></i>Instagram</a>
            <a href="https://t.me/eksha_rental" target="_blank"><i class="fab fa-telegram" style="color: #0088CC;"></i>Telegram</a>
            <a href="https://youtube.com/@ekshaoktavian2239?si=pozkGv4VqFy5u8wL" target="_blank"><i class="fab fa-youtube" style="color: #FF0000;"></i>YouTube</a>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>2024@ Eksha Oktavian Perdana</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>
</html>
