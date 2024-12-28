<?php
session_start();
if (!isset($_SESSION['username'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

include 'config.php';

if (isset($_POST['submit'])) {
    $no_plat = $_POST['no_plat'];
    $nama_mobil = $_POST['nama_mobil'];
    $brand = $_POST['brand'];
    $transmisi = $_POST['transmisi'];

    // Check if the 'no_plat' already exists
    $check_query = "SELECT * FROM tbl_mobil_eksha WHERE no_plat_eksha = '$no_plat'";
    $check_result = mysqli_query($koneksi, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // If data exists, show a notification and retain the form data
        $duplicate_error = true;
    } else {
        // Path absolut untuk penyimpanan file
        $target_dir = __DIR__ . "/Foto Mobil Rental/";
        $foto_name = basename($_FILES["foto"]["name"]);
        $target_file = $target_dir . $foto_name;

        // Pastikan folder ada
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Pindahkan file ke lokasi
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            // Simpan data ke database jika file berhasil diunggah
            mysqli_query($koneksi, "INSERT INTO tbl_mobil_eksha (no_plat_eksha, nama_mobil_eksha, brand_mobil_eksha, tipe_transmisi_eksha, foto_mobil_eksha) VALUES ('$no_plat', '$nama_mobil', '$brand', '$transmisi', '$foto_name')");
            header("Location: mobil.php");
        } else {
            echo "Gagal mengunggah foto.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Mobil - Rental Mobil Eksha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Add some custom styles to center the toast */
        .toast {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1050; /* Make sure it stays on top */
            width: 400px; /* Control the width of the toast */
            border-radius: 10px;
        }

        .toast-body {
            font-size: 1.2rem; /* Increase the font size for better visibility */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Tambah Data Mobil</h1>
        <form method="POST" enctype="multipart/form-data" class="mt-3">
            <div class="mb-3">
                <label for="no_plat" class="form-label">No Plat</label>
                <input type="text" name="no_plat" id="no_plat" class="form-control" value="<?= isset($_POST['no_plat']) ? $_POST['no_plat'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="nama_mobil" class="form-label">Nama Mobil</label>
                <input type="text" name="nama_mobil" id="nama_mobil" class="form-control" value="<?= isset($_POST['nama_mobil']) ? $_POST['nama_mobil'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="brand" class="form-label">Brand</label>
                <input type="text" name="brand" id="brand" class="form-control" value="<?= isset($_POST['brand']) ? $_POST['brand'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="transmisi" class="form-label">Tipe Transmisi</label>
                <select name="transmisi" id="transmisi" class="form-select" required>
                    <option value="Manual" <?= (isset($_POST['transmisi']) && $_POST['transmisi'] == 'Manual') ? 'selected' : ''; ?>>Manual</option>
                    <option value="Matic" <?= (isset($_POST['transmisi']) && $_POST['transmisi'] == 'Matic') ? 'selected' : ''; ?>>Matic</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto Mobil</label>
                <input type="file" name="foto" id="foto" class="form-control" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Tambah</button>
            <a href="mobil.php" class="btn btn-warning">Kembali</a>
        </form>
    </div>

    <!-- Toast Notification for Duplicate Data -->
    <?php if (isset($duplicate_error) && $duplicate_error): ?>
        <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
            <div class="d-flex">
                <div class="toast-body">
                    Data mobil dengan no plat <strong><?= $no_plat; ?></strong> sudah ada! Silakan perbaiki data.
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Initialize the Toast notification
        var toastEl = document.querySelector('.toast');
        if (toastEl) {
            var toast = new bootstrap.Toast(toastEl);
            toast.show();
        }
    </script>
</body>
</html>
