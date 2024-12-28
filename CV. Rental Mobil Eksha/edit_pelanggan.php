<?php
include 'config.php';

$nik_ktp = $_GET['nik_ktp'];
$query = mysqli_query($koneksi, "SELECT * FROM tbl_pelanggan_eksha WHERE nik_ktp_eksha='$nik_ktp'");
$data = mysqli_fetch_array($query);

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    mysqli_query($koneksi, "UPDATE tbl_pelanggan_eksha SET nama_eksha='$nama', no_hp_eksha='$no_hp', alamat_eksha='$alamat' WHERE nik_ktp_eksha='$nik_ktp'");
    header("Location: pelanggan.php");
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
