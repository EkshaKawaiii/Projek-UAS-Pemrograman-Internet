<?php
session_start();  // Ensure session is started at the top of the script
include 'config.php'; // Database connection file

// If not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Get form values
    $no_plat = $_POST['no_plat'];
    $nama_mobil = $_POST['nama_mobil'];
    $brand = $_POST['brand'];
    $transmisi = $_POST['transmisi'];
    $harga_sewa_eksha = str_replace(['Rp.', ','], '', $_POST['harga_sewa_eksha']); // Sanitize the price input

    // Check if the 'no_plat' already exists
    $check_query = "SELECT * FROM tbl_mobil_eksha WHERE no_plat_eksha = '$no_plat'";
    $check_result = mysqli_query($koneksi, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // If data exists, show a notification and retain the form data
        $duplicate_error = true;
    } else {
        // Path absolute for storing the photo
        $target_dir = __DIR__ . "/Foto Mobil Rental/";
        $foto_name = basename($_FILES["foto"]["name"]);
        $target_file = $target_dir . $foto_name;

        // Ensure the folder exists
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            // Insert data into the database if the file is successfully uploaded
            $insert_query = "INSERT INTO tbl_mobil_eksha (no_plat_eksha, nama_mobil_eksha, brand_mobil_eksha, tipe_transmisi_eksha, foto_mobil_eksha, harga_sewa_eksha) 
            VALUES ('$no_plat', '$nama_mobil', '$brand', '$transmisi', '$foto_name', '$harga_sewa_eksha')";

            if (mysqli_query($koneksi, $insert_query)) {
                // Redirect to 'mobil.php' after successful insertion
                header("Location: mobil.php");
                exit();
            } else {
                echo "Gagal menambahkan data mobil.";
            }
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
    <script>
        // JavaScript function to automatically add 'Rp' in the input field
        function formatHarga(input) {
            let value = input.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
            input.value = value ? 'Rp ' + value.replace(/\B(?=(\d{3})+(?!\d))/g, ",") : ''; // Format with commas and add 'Rp'
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Tambah Data Mobil</h1>
        
        <!-- Display Duplicate Error if exists -->
        <?php if (isset($duplicate_error)) { ?>
            <div class="alert alert-danger" role="alert">
                Data dengan No Plat <?= $no_plat; ?> sudah ada! Silakan periksa kembali.
            </div>
        <?php } ?>

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
            <div class="mb-3">
                <div class="mb-3">
                <label for="harga_sewa_eksha" class="form-label">Harga Sewa (Per Hari)</label>
                <div class="input-group">
                <span class="input-group-text">Rp.</span>
                <input type="number" name="harga_sewa_eksha" id="harga_sewa_eksha" class="form-control" value="<?= $data['harga_sewa_eksha']; ?>" required>
            </div>

            </div>
            <button type="submit" name="submit" class="btn btn-primary">Tambah</button>
            <a href="mobil.php" class="btn btn-warning">Kembali</a>
        </form>
        <br>
        <br>
    </div>
</body>
</html>
