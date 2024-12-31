<?php
session_start();
if (!isset($_SESSION['username'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

include 'config.php';

if (isset($_POST['no_trx']) && isset($_POST['status'])) {
    $no_trx = mysqli_real_escape_string($koneksi, $_POST['no_trx']);
    $status = mysqli_real_escape_string($koneksi, $_POST['status']);

    if ($status === 'Aktif' || $status === 'Selesai') {
        $query = "UPDATE tbl_rental_eksha SET status_eksha = '$status' WHERE no_trx_eksha = '$no_trx'";

        if (mysqli_query($koneksi, $query)) {
            $_SESSION['success'] = "Status berhasil diperbarui.";
            header("Location: rental.php");
            exit;
        } else {
            $_SESSION['error'] = "Gagal memperbarui status.";
            header("Location: rental.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "Status tidak valid.";
        header("Location: rental.php");
        exit;
    }
} else {
    header("Location: rental.php");
    exit;
}
?>
