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
    
    // Sanitize and convert harga to an integer
    $harga_sewa_eksha = (int)str_replace(['Rp.', ',', ' '], '', $_POST['harga_sewa_eksha']);
    
    $lama = $_POST['lama'];
    $total_bayar_eksha = $harga_sewa_eksha * $lama;

    // Calculate Tanggal Selesai
    $tgl_rental_obj = new DateTime($tgl_rental);
    $tgl_selesai_obj = $tgl_rental_obj->add(new DateInterval('P' . $lama . 'D'));
    $tgl_selesai = $tgl_selesai_obj->format('Y-m-d');

    // Insert rental data into the database
    $insert_query = "INSERT INTO tbl_rental_eksha 
    (no_trx_eksha, nik_ktp_eksha, no_plat_eksha, tgl_rental_eksha, jam_rental_eksha, harga_eksha, lama_eksha, total_bayar_eksha, tgl_selesai_eksha) 
    VALUES ('$no_trx', '$nik_ktp', '$no_plat', '$tgl_rental', '$jam_rental', '$harga_sewa_eksha', '$lama', '$total_bayar_eksha', '$tgl_selesai')";

    if (mysqli_query($koneksi, $insert_query)) {
        header("Location: rental.php");
    } else {
        echo "Gagal menambahkan data rental.";
    }
}

// Ambil data pelanggan
$pelanggan = mysqli_query($koneksi, "SELECT * FROM tbl_pelanggan_eksha");

// Ambil data mobil yang tidak sedang disewa
$mobil = mysqli_query($koneksi, "
    SELECT m.no_plat_eksha, m.nama_mobil_eksha, m.harga_sewa_eksha 
    FROM tbl_mobil_eksha m
    LEFT JOIN (
        SELECT no_plat_eksha 
        FROM tbl_rental_eksha 
        WHERE status_eksha = 'Aktif'
    ) r ON m.no_plat_eksha = r.no_plat_eksha
    WHERE r.no_plat_eksha IS NULL
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Rental - Rental Mobil Eksha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
                        <option value="<?= $data['no_plat_eksha']; ?>" data-harga_sewa_eksha="<?= $data['harga_sewa_eksha']; ?>"><?= $data['no_plat_eksha']; ?> - <?= $data['nama_mobil_eksha']; ?></option>
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
                <label for="harga_sewa_eksha" class="form-label">Harga Sewa (Per Hari)</label>
                <input type="number" name="harga_sewa_eksha" id="harga_sewa_eksha" class="form-control" readonly required>
            </div>
            <div class="mb-3">
                <label for="lama" class="form-label">Lama (Hari)</label>
                <input type="number" name="lama" id="lama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="total_bayar_eksha" class="form-label">Total Bayar</label>
                <input type="number" name="total_bayar_eksha" id="total_bayar_eksha" class="form-control" readonly required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Tambah</button>
            <a href="rental.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
    <br>
    <br>
    <script>
        document.getElementById('no_plat').addEventListener('change', function() {
            const harga_sewa_eksha = this.options[this.selectedIndex].getAttribute('data-harga_sewa_eksha');
            document.getElementById('harga_sewa_eksha').value = harga_sewa_eksha ? harga_sewa_eksha : '';
            calculateTotal();
        });

        document.getElementById('lama').addEventListener('input', function() {
            calculateTotal();
        });

        function calculateTotal() {
            const harga_sewa_eksha = parseInt(document.getElementById('harga_sewa_eksha').value.replace(/[^0-9]/g, ''));
            const lama = document.getElementById('lama').value;
            if (harga_sewa_eksha && lama) {
                const total = harga_sewa_eksha * lama;
                document.getElementById('total_bayar_eksha').value = total;
            }
        }
    </script>
</body>
</html>
