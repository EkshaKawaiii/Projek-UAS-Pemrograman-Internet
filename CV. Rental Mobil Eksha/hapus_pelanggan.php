<?php
include 'config.php';

$nik_ktp = $_GET['nik_ktp'];
mysqli_query($koneksi, "DELETE FROM tbl_pelanggan_eksha WHERE nik_ktp_eksha='$nik_ktp'");
header("Location: pelanggan.php");
?>
