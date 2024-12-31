<?php
session_start();
include 'config.php';

// If the user is not logged in, redirect to the login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check if the `no_trx` is set in the URL and sanitize the input to prevent SQL injection
if (isset($_GET['no_trx']) && !empty($_GET['no_trx'])) {
    $no_trx = mysqli_real_escape_string($koneksi, $_GET['no_trx']); // Sanitize input

    // Query to delete the record from the database
    $delete_query = "DELETE FROM tbl_rental_eksha WHERE no_trx_eksha = '$no_trx'";

    // Execute the query
    if (mysqli_query($koneksi, $delete_query)) {
        // If the query is successful, redirect to the rental page
        header("Location: rental.php");
        exit();
    } else {
        // If there was an error in the deletion process
        echo "Error: Could not delete the rental record. Please try again later.";
    }
} else {
    // If the `no_trx` is not set or invalid
    echo "Invalid rental record ID.";
}
?>
