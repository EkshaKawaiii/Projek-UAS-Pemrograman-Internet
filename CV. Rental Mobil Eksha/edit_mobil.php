<?php
include 'config.php';

$no_plat = $_GET['no_plat'];
$query = mysqli_query($koneksi, "SELECT * FROM tbl_mobil_eksha WHERE no_plat_eksha='$no_plat'");
$data = mysqli_fetch_array($query);

if (isset($_POST['submit'])) {
    $nama_mobil = $_POST['nama_mobil'];
    $brand = $_POST['brand'];
    $transmisi = $_POST['transmisi'];

    // Cek apakah foto baru diunggah
    if ($_FILES['foto']['name']) {
        $target_dir = "Pemrograman Internet/CV. Rental Mobil Eksha/Foto Mobil Rental/";
        $foto_name = basename($_FILES["foto"]["name"]);
        $target_file = $target_dir . $foto_name;

        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            // Hapus foto lama jika ada
            if (file_exists($target_dir . $data['foto_mobil_eksha'])) {
                unlink($target_dir . $data['foto_mobil_eksha']);
            }
        } else {
            echo "Gagal mengunggah foto.";
        }
    } else {
        // Jika tidak ada foto baru, gunakan foto lama
        $foto_name = $data['foto_mobil_eksha'];
    }

    // Update data mobil
    mysqli_query($koneksi, "UPDATE tbl_mobil_eksha SET 
        nama_mobil_eksha='$nama_mobil', 
        brand_mobil_eksha='$brand', 
        tipe_transmisi_eksha='$transmisi', 
        foto_mobil_eksha='$foto_name' 
        WHERE no_plat_eksha='$no_plat'");
    header("Location: mobil.php");
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
            <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
            <a href="mobil.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
