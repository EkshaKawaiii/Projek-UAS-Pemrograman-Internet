<?php
session_start();
if (!isset($_SESSION['username'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

include 'config.php';

// Initialize query to select all data initially
$query = "SELECT * FROM tbl_pelanggan_eksha";

// Check if the search form is submitted
if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $query = "SELECT * FROM tbl_pelanggan_eksha WHERE 
                nik_ktp_eksha LIKE '%$search%' OR 
                nama_eksha LIKE '%$search%' OR 
                no_hp_eksha LIKE '%$search%'";
}

$query_result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggan - Rental Mobil Eksha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Flexbox layout for body and footer */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: #eef2f7;
        }

        .container {
            flex: 1;
        }

        /* General table styling */
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .table img {
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }
        .navbar {
            background: linear-gradient(90deg, #1c1c1c, #5e60ce);
            padding: 10px 15px;
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: #fff !important;
        }
        .navbar .btn-primary {
            background-color: #28a745;
            border: none;
            transition: background-color 0.3s;
            margin-right: 5px;
            border-radius: 5px;
        }
        .navbar .btn-primary:hover {
            background-color: #218838;
        }
        .navbar .btn-danger {
            background-color: #dc3545;
            border: none;
            border-radius: 5px;
        }
        .navbar .btn-danger:hover {
            background-color: #c82333;
        }
        .navbar-nav {
            display: flex;
            justify-content: flex-end;
            width: 100%;
        }
        .navbar-nav .nav-item {
            margin: 0 5px;
        }
        .navbar-nav .ml-auto {
            margin-left: 100px;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            border: 1px solid #ddd;
        }

        .table th, .table td {
            padding: 15px;
            border: 1px solid #ddd;
            background-color: #fff;
        }

        .table th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        .table-striped tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Align search and back button */
        .search-container {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .search-container .btn {
            margin-left: 10px;
        }

        /* Ensuring proper width for each column */
        .table th, .table td {
            width: auto;
        }

        /* Specifically for the Status column */
        .status-column {
            width: 200px; /* Adjust this to make sure the status content fits properly */
        }

        /* Ensuring dropdown is fully visible */
        .dropdown-menu {
            min-width: 150px;
        }

        /* Footer Style */
        footer {
            background: linear-gradient(90deg, #1c1c1c, #5e60ce);
            color: white;
            text-align: center;
            padding: 10px 0; /* Adjusted to match the 'mobil.php' footer size */
            width: 100%;
            margin-top: auto;  /* Ensure footer stays at the bottom */
        }

    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">CV Rental Mobil Eksha</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="btn btn-primary" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary" href="mobil.php">Data Mobil</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary" href="pelanggan.php">Data Pelanggan</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary" href="rental.php">Reservasi</a>
                    </li>
                    <li class="nav-item ml-auto">
                        <a class="btn btn-danger" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mt-5">
        <h1 class="text-center">Data Pelanggan</h1>

        <!-- Add Button for Adding Data -->
        <a href="tambah_pelanggan.php" class="btn btn-success mb-3">Tambah Data Pelanggan</a>

        <!-- Search Form with Kembali Button -->
        <form method="POST" class="mb-3 search-container">
            <input type="text" name="search" class="form-control" placeholder="Search by NIK, Name or Phone" value="<?= isset($_POST['search']) ? $_POST['search'] : ''; ?>" style="width: 300px;">
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="pelanggan.php" class="btn btn-secondary">Kembali</a>
        </form>

        <!-- Table -->
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>NIK KTP</th>
                    <th>Nama</th>
                    <th>No HP</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($data = mysqli_fetch_array($query_result)) { ?>
                    <tr>
                        <td><?= $data['nik_ktp_eksha']; ?></td>
                        <td><?= $data['nama_eksha']; ?></td>
                        <td><?= $data['no_hp_eksha']; ?></td>
                        <td><?= $data['alamat_eksha']; ?></td>
                        <td>
                            <a href="edit_pelanggan.php?nik_ktp=<?= $data['nik_ktp_eksha']; ?>" class="btn btn-warning">Edit</a>
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?= $data['nik_ktp_eksha']; ?>" data-name="<?= $data['nama_eksha']; ?>">Hapus</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data pelanggan "<span id="pelanggan-name"></span>"?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="#" id="delete-link" class="btn btn-danger">Hapus</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Get modal elements
        var deleteModal = document.getElementById('deleteModal');
        var deleteLink = document.getElementById('delete-link');
        var pelangganName = document.getElementById('pelanggan-name');

        // Listen for the modal show event
        deleteModal.addEventListener('show.bs.modal', function (event) {
            // Get data from the button that triggered the modal
            var button = event.relatedTarget;
            var pelangganId = button.getAttribute('data-id');
            var pelangganNameText = button.getAttribute('data-name');

            // Set the modal's content
            pelangganName.textContent = pelangganNameText;
            deleteLink.setAttribute('href', 'hapus_pelanggan.php?nik_ktp=' + pelangganId);
        });
    </script>

    <!-- Footer -->
    <footer>
        2024@ Eksha Oktavian Perdana
    </footer>
</body>
</html>