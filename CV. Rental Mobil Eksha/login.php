<?php
session_start();
include 'config.php'; // Pastikan file config.php sudah terhubung dengan benar

// Proses login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Gunakan md5 untuk mengenkripsi password

    // Query untuk mengecek username dan password di database
    $query = mysqli_query($koneksi, "SELECT * FROM tbl_user_eksha WHERE username_eksha='$username' AND password_eksha='$password'");
    $data = mysqli_fetch_array($query);

    if ($data) {
        $_SESSION['username'] = $data['username_eksha'];
        $_SESSION['level'] = $data['level_eksha'];
        header("Location: dashboard.php"); // Arahkan ke halaman dashboard setelah login berhasil
    } else {
        $error = "Login gagal! Username atau password salah."; // Jika login gagal
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Rental Mobil Eksha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('Background/background_login.jpg');
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
            background-color: #28a745;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: rgba(255, 255, 255, 0.7); /* Set background to be transparent with some opacity */
            color: #000;
        }

        .text-link {
            color: #007bff;
            text-decoration: none;
        }

        .text-link:hover {
            text-decoration: underline;
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

    <!-- Content -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card p-4">
                    <h3 class="text-center mb-3">Login</h3>
                    <form method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" id="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                        <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                        <p class="text-center mt-3">
                            Belum punya akun? <a href="register.php" class="text-link">Daftar di sini</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
