<?php
include 'config.php';

$no_plat = $_GET['no_plat'];
mysqli_query($koneksi, "DELETE FROM tbl_mobil_eksha WHERE no_plat_eksha='$no_plat'");
header("Location: mobil.php");
?>
