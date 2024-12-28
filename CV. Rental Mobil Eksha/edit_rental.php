<?php
include 'config.php';

$no_trx = $_GET['no_trx'];
$query = mysqli_query($koneksi, "SELECT * FROM tbl_rental_eksha WHERE no_trx_eksha='$no_trx'");
$data = mysqli_fetch_array($query);

if (isset($_POST['submit'])) {
    $tgl_rental = $_POST['tgl_rental'];
    $jam_rental = $_POST['jam_rental'];
    $harga = $_POST['harga'];
    $lama = $_POST['lama'];
    $total_bayar = $harga * $lama;

    mysqli_query($koneksi, "UPDATE tbl_rental_eksha SET tgl_rental_eksha='$tgl_rental', jam_rental_eksha='$jam_rental', harga_eksha='$harga', lama_eksha='$lama', total_bayar_eksha='$total_bayar' WHERE no_trx_eksha='$no_trx'");
    header("Location: rental.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Rental - Rental Mobil Eksha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Edit Data Rental</h1>
        <form method="POST" class="mt-3">
            <div class="mb-3">
                <label for="tgl_rental" class="form-label">Tanggal Rental</label>
                <input type="date" name="tgl_rental" id="tgl_rental" class="form-control" value="<?= $data['tgl_rental_eksha']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="jam_rental" class="form-label">Jam Rental</label>
                <input type="time" name="jam_rental" id="jam_rental" class="form-control" value="<?= $data['jam_rental_eksha']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga (Per Hari)</label>
                <div class="input-group">
                    <span class="input-group-text">Rp.</span>
                    <input type="number" name="harga" id="harga" class="form-control" value="<?= $data['harga_eksha']; ?>" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="lama" class="form-label">Lama (Hari)</label>
                <input type="number" name="lama" id="lama" class="form-control" value="<?= $data['lama_eksha']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="total_bayar" class="form-label">Total Bayar</label>
                <input type="text" id="total_bayar" class="form-control" value="Rp. <?= number_format($data['harga_eksha'] * $data['lama_eksha'], 0, ',', '.'); ?>" readonly>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
            <a href="rental.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
