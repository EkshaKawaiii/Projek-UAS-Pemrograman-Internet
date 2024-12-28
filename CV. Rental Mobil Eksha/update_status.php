<?php
session_start();
if (!isset($_SESSION['username'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

include 'config.php';

// Cek apakah ada parameter 'no_trx' dan 'status' yang dikirim melalui URL
if (isset($_POST['no_trx']) && isset($_POST['status'])) {
    // Ambil data dari POST dan sanitasi input
    $no_trx = mysqli_real_escape_string($koneksi, $_POST['no_trx']);
    $status = mysqli_real_escape_string($koneksi, $_POST['status']);

    // Validasi status, pastikan hanya "Active" atau "Completed"
    if ($status === 'Active' || $status === 'Completed') {
        // Update status rental berdasarkan nomor transaksi
        $query = "UPDATE tbl_rental_eksha SET status_eksha = '$status' WHERE no_trx_eksha = '$no_trx'";

        // Eksekusi query
        if (mysqli_query($koneksi, $query)) {
            // Jika berhasil, arahkan kembali ke halaman rental.php
            header("Location: rental.php");
            exit;
        } else {
            // Jika terjadi error, tampilkan pesan error
            echo "Error: " . mysqli_error($koneksi);
        }
    } else {
        // Jika status tidak valid, tampilkan pesan error
        echo "Invalid status value.";
    }
} else {
    // Jika tidak ada parameter, arahkan kembali ke halaman rental
    header("Location: rental.php");
    exit;
}
?>
