<?php
session_start();
if (!isset($_SESSION['username'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

include 'config.php';

// Ambil no_plat dari parameter GET
$no_plat = $_GET['no_plat'];

// Pertama, ambil data foto mobil dari database
$query = "SELECT foto_mobil_eksha FROM tbl_mobil_eksha WHERE no_plat_eksha='$no_plat'";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_array($result);

// Jika data ditemukan, lanjutkan menghapus foto
if ($data) {
    // Path direktori tempat foto mobil disimpan
    $target_dir = "Pemrograman Internet\\CV. Rental Mobil Eksha\\Foto Mobil Rental\\";  // Pastikan menggunakan double backslash (\\) di path

    // Ambil nama file foto mobil
    $foto_mobil = $data['foto_mobil_eksha'];

    // Cek apakah file foto ada dan hapus file foto tersebut
    if ($foto_mobil && file_exists($target_dir . $foto_mobil)) {
        unlink($target_dir . $foto_mobil);  // Hapus foto dari direktori
    }

    // Hapus data terkait di tabel tbl_rental_eksha
    mysqli_query($koneksi, "DELETE FROM tbl_rental_eksha WHERE no_plat_eksha='$no_plat'");

    // Hapus data mobil dari tabel tbl_mobil_eksha
    $delete_query = "DELETE FROM tbl_mobil_eksha WHERE no_plat_eksha='$no_plat'";

    if (mysqli_query($koneksi, $delete_query)) {
        // Redirect ke halaman mobil.php setelah penghapusan berhasil
        header("Location: mobil.php");
        exit();
    } else {
        echo "Gagal menghapus data mobil.";
    }
} else {
    echo "Mobil tidak ditemukan.";
}
?>
