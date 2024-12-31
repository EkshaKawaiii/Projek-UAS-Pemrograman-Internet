<?php
session_start(); // Ensure session is started

include 'config.php';

// If the user is not logged in, redirect to the login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check if 'nik_ktp' is passed in the URL and sanitize the input
if (isset($_GET['nik_ktp']) && !empty($_GET['nik_ktp'])) {
    $nik_ktp = mysqli_real_escape_string($koneksi, $_GET['nik_ktp']); // Sanitize user input to prevent SQL injection

    // Query to delete the record from the database
    $delete_query = "DELETE FROM tbl_pelanggan_eksha WHERE nik_ktp_eksha = '$nik_ktp'";

    // Execute the query and check if it was successful
    if (mysqli_query($koneksi, $delete_query)) {
        // If the query is successful, redirect to the 'pelanggan.php' page
        header("Location: pelanggan.php");
        exit();
    } else {
        // If there was an error in the deletion process
        echo "Error: Could not delete the record. Please try again later.";
    }
} else {
    // If 'nik_ktp' parameter is missing or invalid
    echo "Invalid data. The 'nik_ktp' is missing or incorrect.";
}
?>
