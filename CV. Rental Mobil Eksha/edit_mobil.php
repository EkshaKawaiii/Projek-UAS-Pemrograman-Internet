<?php
session_start();  // Ensure session is started at the top of the script
include 'config.php'; // Database connection file

// If not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Get 'no_plat' parameter from the URL
$no_plat = $_GET['no_plat'];

// Fetch existing car data from the database
$query = mysqli_query($koneksi, "SELECT * FROM tbl_mobil_eksha WHERE no_plat_eksha='$no_plat'");
$data = mysqli_fetch_array($query);

// If form is submitted, process the data
if (isset($_POST['submit'])) {
    // Get the form input values
    $nama_mobil = $_POST['nama_mobil'];
    $brand = $_POST['brand'];
    $transmisi = $_POST['transmisi'];
    $harga_sewa_eksha = $_POST['harga_sewa_eksha']; // Use 'harga_sewa_eksha' for rental price

    // Check if a new photo is uploaded
    if ($_FILES['foto']['name']) {
        // Define the directory where the photo will be saved
        $target_dir = "Pemrograman Internet/CV. Rental Mobil Eksha/Foto Mobil Rental/";
        $foto_name = basename($_FILES["foto"]["name"]);
        $target_file = $target_dir . $foto_name;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            // If a new photo is uploaded, delete the old one if it exists
            if (file_exists($target_dir . $data['foto_mobil_eksha'])) {
                unlink($target_dir . $data['foto_mobil_eksha']);
            }
        } else {
            echo "Gagal mengunggah foto.";
        }
    } else {
        // If no new photo is uploaded, retain the old one
        $foto_name = $data['foto_mobil_eksha'];
    }

    // Update the car data in the database
    $update_query = "UPDATE tbl_mobil_eksha SET 
        nama_mobil_eksha='$nama_mobil', 
        brand_mobil_eksha='$brand', 
        tipe_transmisi_eksha='$transmisi', 
        foto_mobil_eksha='$foto_name',
        harga_sewa_eksha='$harga_sewa_eksha'  -- Correctly updated the rental price field
        WHERE no_plat_eksha='$no_plat'";

    // Execute the update query
    if (mysqli_query($koneksi, $update_query)) {
        // Redirect to 'mobil.php' after successful update
        header("Location: mobil.php");
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
    <title>Edit Data Mobil - Rental Mobil Eksha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Edit Data Mobil</h1>
        <form method="POST" enctype="multipart/form-data" class="mt-3">
            <div class="mb-3">
                <label for="nama_mobil" class="form-label">Nama Mobil</label>
                <input type="text" name="nama_mobil" id="nama_mobil" class="form-control" value="<?= $data['nama_mobil_eksha']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="brand" class="form-label">Brand</label>
                <input type="text" name="brand" id="brand" class="form-control" value="<?= $data['brand_mobil_eksha']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="transmisi" class="form-label">Tipe Transmisi</label>
                <select name="transmisi" id="transmisi" class="form-select" required>
                    <option value="Manual" <?= $data['tipe_transmisi_eksha'] === 'Manual' ? 'selected' : ''; ?>>Manual</option>
                    <option value="Matic" <?= $data['tipe_transmisi_eksha'] === 'Matic' ? 'selected' : ''; ?>>Matic</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto Mobil</label>
                <input type="file" name="foto" id="foto" class="form-control">
                <small class="text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
                <div class="mt-3">
                    <img src="Pemrograman Internet/CV. Rental Mobil Eksha/Foto Mobil Rental/<?= $data['foto_mobil_eksha']; ?>" alt="<?= $data['nama_mobil_eksha']; ?>" style="width: 200px; border-radius: 10px;">
                </div>
            </div>
            <div class="mb-3">
                <label for="harga_sewa_eksha" class="form-label">Harga Sewa (Per Hari)</label>
                <input type="number" name="harga_sewa_eksha" id="harga_sewa_eksha" class="form-control" value="<?= $data['harga_sewa_eksha']; ?>" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
            <a href="mobil.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
