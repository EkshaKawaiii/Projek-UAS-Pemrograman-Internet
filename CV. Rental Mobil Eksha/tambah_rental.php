<?php
session_start();
if (!isset($_SESSION['username'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

include 'config.php';

if (isset($_POST['submit'])) {
    $no_trx = "TRX-" . date("YmdHis"); // Auto-generate No Transaksi
    $nik_ktp = $_POST['nik_ktp'];
    $no_plat = $_POST['no_plat'];
    $tgl_rental = $_POST['tgl_rental'];
    $jam_rental = $_POST['jam_rental'];
    $harga = str_replace('Rp', '', $_POST['harga']); // Remove 'Rp' from the input field before storing
    $harga = str_replace(',', '', $harga); // Remove any commas if present
    $lama = $_POST['lama'];
    $total_bayar = $harga * $lama;

    // Calculate Tanggal Selesai
    $tgl_rental_obj = new DateTime($tgl_rental);
    $tgl_selesai_obj = $tgl_rental_obj->add(new DateInterval('P' . $lama . 'D'));
    $tgl_selesai = $tgl_selesai_obj->format('Y-m-d'); // Format the Tanggal Selesai

    // Insert rental data into the database
    mysqli_query($koneksi, "INSERT INTO tbl_rental_eksha (no_trx_eksha, nik_ktp_eksha, no_plat_eksha, tgl_rental_eksha, jam_rental_eksha, harga_eksha, lama_eksha, total_bayar_eksha, tgl_selesai_eksha) 
    VALUES ('$no_trx', '$nik_ktp', '$no_plat', '$tgl_rental', '$jam_rental', '$harga', '$lama', '$total_bayar', '$tgl_selesai')");

    header("Location: rental.php");
}

// Ambil data pelanggan dan mobil untuk dropdown
$pelanggan = mysqli_query($koneksi, "SELECT * FROM tbl_pelanggan_eksha");
$mobil = mysqli_query($koneksi, "SELECT * FROM tbl_mobil_eksha");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Rental - Rental Mobil Eksha</title>
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
        <h1 class="text-center">Tambah Data Rental</h1>
        <form method="POST" class="mt-3">
            <div class="mb-3">
                <label for="nik_ktp" class="form-label">Pelanggan</label>
                <select name="nik_ktp" id="nik_ktp" class="form-select" required>
                    <option value="">-- Pilih Pelanggan --</option>
                    <?php while ($data = mysqli_fetch_array($pelanggan)) { ?>
                        <option value="<?= $data['nik_ktp_eksha']; ?>"><?= $data['nik_ktp_eksha']; ?> - <?= $data['nama_eksha']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="no_plat" class="form-label">Mobil</label>
                <select name="no_plat" id="no_plat" class="form-select" required>
                    <option value="">-- Pilih Mobil --</option>
                    <?php while ($data = mysqli_fetch_array($mobil)) { ?>
                        <option value="<?= $data['no_plat_eksha']; ?>"><?= $data['no_plat_eksha']; ?> - <?= $data['nama_mobil_eksha']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="tgl_rental" class="form-label">Tanggal Mulai</label>
                <input type="date" name="tgl_rental" id="tgl_rental" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="jam_rental" class="form-label">Jam Rental</label>
                <input type="time" name="jam_rental" id="jam_rental" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga (Per Hari)</label>
                <input type="text" name="harga" id="harga" class="form-control" oninput="formatHarga(this)" required>
            </div>
            <div class="mb-3">
                <label for="lama" class="form-label">Lama (Hari)</label>
                <input type="number" name="lama" id="lama" class="form-control" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Tambah</button>
            <a href="rental.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
