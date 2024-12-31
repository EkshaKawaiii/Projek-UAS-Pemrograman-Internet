<?php
session_start();  // Ensure session is started at the very beginning of the file

// If not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

// Get 'nik_ktp' parameter from the URL
$nik_ktp = $_GET['nik_ktp'];

// Fetch existing data for the given 'nik_ktp' from the database
$query = mysqli_query($koneksi, "SELECT * FROM tbl_pelanggan_eksha WHERE nik_ktp_eksha='$nik_ktp'");
$data = mysqli_fetch_array($query);

// If form is submitted, process the data
if (isset($_POST['submit'])) {
    // Get form input values
    $nama = $_POST['nama'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    // Update the customer data in the database
    $update_query = "UPDATE tbl_pelanggan_eksha SET 
        nama_eksha='$nama', 
        no_hp_eksha='$no_hp', 
        alamat_eksha='$alamat' 
        WHERE nik_ktp_eksha='$nik_ktp'";

    // Execute the update query
    if (mysqli_query($koneksi, $update_query)) {
        // Redirect to 'pelanggan.php' after successful update
        header("Location: pelanggan.php");
        exit();
    } else {
        echo "Gagal mengupdate data.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pelanggan - Rental Mobil Eksha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Edit Data Pelanggan</h1>
        <form method="POST" class="mt-3">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" name="nama" id="nama" class="form-control" value="<?= $data['nama_eksha']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="no_hp" class="form-label">No HP</label>
                <input type="text" name="no_hp" id="no_hp" class="form-control" value="<?= $data['no_hp_eksha']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea name="alamat" id="alamat" class="form-control" required><?= $data['alamat_eksha']; ?></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
            <a href="pelanggan.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
