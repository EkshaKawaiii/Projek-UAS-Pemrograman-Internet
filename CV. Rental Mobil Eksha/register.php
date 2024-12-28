<?php
session_start();
include 'config.php';

$message = ""; // Variabel untuk pesan notifikasi

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $nama_lengkap = $_POST['nama_lengkap'];
    $level = "user"; // Default level untuk user baru

    $query = mysqli_query($koneksi, "INSERT INTO tbl_user_eksha (username_eksha, password_eksha, nama_lengkap_eksha, level_eksha) VALUES ('$username', '$password', '$nama_lengkap', '$level')");
    if ($query) {
        $message = "Berhasil mendaftar! Silakan login sekarang.";
    } else {
        $error = "Registrasi gagal! Silakan coba lagi.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Rental Mobil Eksha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Full background image */
        body {
            background-image: url('Background/background_register.jpg'); /* Path to background image */
            background-size: 100% 100%; /* Menjamin gambar latar belakang menutupi seluruh halaman */
            background-position: center;
            background-attachment: fixed; /* Mengunci gambar latar belakang */
            color: #fff; /* Teks berwarna putih */
            height: 100vh; /* Menjamin halaman mengisi seluruh layar */
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .navbar {
            background: linear-gradient(90deg, #007bff, #5e60ce);
            padding: 10px 30px;
            padding: 10px 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: absolute;
            top: 0;
            width: 100%;
            z-index: 1000;
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
        }

        .navbar .btn-primary:hover {
            background-color: #218838;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: rgba(255, 255, 255, 0.8); /* Transparent background */
            color: #000;
        }

        .text-link {
            color: #007bff;
            text-decoration: none;
        }

        .text-link:hover {
            text-decoration: underline;
        }

        .popup {
            position: fixed;
            top: 10%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1050;
            display: none;
            background: #28a745;
            color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translate(-50%, -60%);
            }

            to {
                opacity: 1;
                transform: translate(-50%, -50%);
            }
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
                        <a class="btn btn-primary" href="index.php">Home</a> <!-- Button Home -->
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Popup untuk pesan sukses -->
    <div class="popup" id="popupMessage"><?= $message; ?></div>

    <!-- Content -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card p-4">
                    <h3 class="text-center mb-3">Register</h3>
                    <form method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" id="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required>
                        </div>
                        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                        <button type="submit" name="register" class="btn btn-primary w-100">Daftar</button>
                        <p class="text-center mt-3">
                            Sudah punya akun? <a href="login.php" class="text-link">Login di sini</a>
                        </p>
                    </form>
                    <?php if ($message) { ?>
                        <div class="text-center mt-3">
                            <a href="login.php" class="btn btn-success w-100">Login Sekarang</a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Menampilkan pop-up jika ada pesan
        const popupMessage = document.getElementById("popupMessage");
        if (popupMessage.textContent.trim() !== "") {
            popupMessage.style.display = "block";
            setTimeout(() => {
                popupMessage.style.display = "none";
            }, 5000); // Pop-up akan hilang setelah 5 detik
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
