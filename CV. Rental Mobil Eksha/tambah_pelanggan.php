<?php
include 'config.php';

// Check if form is submitted
if (isset($_POST['submit'])) {
    $nik_ktp = $_POST['nik_ktp'];
    $nama = $_POST['nama'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    // Check if the NIK KTP already exists
    $check_query = "SELECT * FROM tbl_pelanggan_eksha WHERE nik_ktp_eksha = '$nik_ktp'";
    $check_result = mysqli_query($koneksi, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // If data exists, show a notification and retain the form data
        $duplicate_error = true;
    } else {
        // Insert the data into the database if it doesn't exist
        mysqli_query($koneksi, "INSERT INTO tbl_pelanggan_eksha (nik_ktp_eksha, nama_eksha, no_hp_eksha, alamat_eksha) 
                                 VALUES ('$nik_ktp', '$nama', '$no_hp', '$alamat')");
        header("Location: pelanggan.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Pelanggan - Rental Mobil Eksha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Add custom styles to center the toast */
        .toast {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1050;
            width: 400px;
            border-radius: 10px;
        }

        .toast-body {
            font-size: 1.2rem;
        }

        .toast-header {
            background-color: #dc3545;
            color: white;
        }

        .toast-body {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Tambah Data Pelanggan</h1>
        <form method="POST" class="mt-3">
            <div class="mb-3">
                <label for="nik_ktp" class="form-label">NIK KTP</label>
                <input type="text" name="nik_ktp" id="nik_ktp" class="form-control" value="<?= isset($_POST['nik_ktp']) ? $_POST['nik_ktp'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" name="nama" id="nama" class="form-control" value="<?= isset($_POST['nama']) ? $_POST['nama'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="no_hp" class="form-label">No HP</label>
                <input type="text" name="no_hp" id="no_hp" class="form-control" value="<?= isset($_POST['no_hp']) ? $_POST['no_hp'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea name="alamat" id="alamat" class="form-control" required><?= isset($_POST['alamat']) ? $_POST['alamat'] : ''; ?></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Tambah</button>
            <a href="pelanggan.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <!-- Toast Notification for Duplicate Data -->
    <?php if (isset($duplicate_error) && $duplicate_error): ?>
        <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
            <div class="d-flex">
                <div class="toast-body">
                    Data pelanggan dengan NIK <strong><?= $nik_ktp; ?></strong> sudah ada! Silakan perbaiki data.
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
