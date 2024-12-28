<?php
include 'config.php';

$no_trx = $_GET['no_trx'];
mysqli_query($koneksi, "DELETE FROM tbl_rental_eksha WHERE no_trx_eksha='$no_trx'");
header("Location: rental.php");
?>
