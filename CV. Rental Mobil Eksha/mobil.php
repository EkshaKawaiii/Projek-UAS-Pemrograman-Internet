<?php
session_start();
if (!isset($_SESSION['username'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

include 'config.php';

// Initialize query to select all data initially
$query = "SELECT * FROM tbl_mobil_eksha";

// Check if the search form is submitted
if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $query = "SELECT * FROM tbl_mobil_eksha WHERE 
                no_plat_eksha LIKE '%$search%' OR 
                nama_mobil_eksha LIKE '%$search%' OR 
                brand_mobil_eksha LIKE '%$search%'";
}

$query_result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mobil - Rental Mobil Eksha</title>
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
            word-wrap: break-word; /* Ensure content breaks when needed */
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

        /* Styling for the table */
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
            padding: 10px 0;
            width: 100%;
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
        <h1 class="text-center">Data Mobil</h1>

        <!-- Add Button for Adding Data -->
        <a href="tambah_mobil.php" class="btn btn-success mb-3">Tambah Data Mobil</a>

        <!-- Search Form with Kembali Button -->
        <form method="POST" class="mb-3 search-container">
            <input type="text" name="search" class="form-control" placeholder="Search by No Plat, Name or Brand" value="<?= isset($_POST['search']) ? $_POST['search'] : ''; ?>" style="width: 300px;">
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="mobil.php" class="btn btn-secondary">Kembali</a>
        </form>

        <!-- Table -->
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No Plat</th>
                    <th>Nama Mobil</th>
                    <th>Brand</th>
                    <th>Transmisi</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($data = mysqli_fetch_array($query_result)) { ?>
                    <tr>
                        <td><?= $data['no_plat_eksha']; ?></td>
                        <td><?= $data['nama_mobil_eksha']; ?></td>
                        <td><?= $data['brand_mobil_eksha']; ?></td>
                        <td><?= $data['tipe_transmisi_eksha']; ?></td>
                        <td>
                            <img src="Pemrograman Internet/CV. Rental Mobil Eksha/Foto Mobil Rental/<?= $data['foto_mobil_eksha']; ?>" alt="<?= $data['nama_mobil_eksha']; ?>" width="100px">
                        </td>
                        <td>
                            <a href="edit_mobil.php?no_plat=<?= $data['no_plat_eksha']; ?>" class="btn btn-warning">Edit</a>
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?= $data['no_plat_eksha']; ?>" data-name="<?= $data['nama_mobil_eksha']; ?>">Hapus</button>
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
                    Apakah Anda yakin ingin menghapus data mobil "<span id="mobil-name"></span>"?
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
        var mobilName = document.getElementById('mobil-name');

        // Listen for the modal show event
        deleteModal.addEventListener('show.bs.modal', function (event) {
            // Get data from the button that triggered the modal
            var button = event.relatedTarget;
            var mobilId = button.getAttribute('data-id');
            var mobilNameText = button.getAttribute('data-name');

            // Set the modal's content
            mobilName.textContent = mobilNameText;
            deleteLink.setAttribute('href', 'hapus_mobil.php?no_plat=' + mobilId);
        });
    </script>

    <!-- Footer -->
    <footer>
        2024@ Eksha Oktavian Perdana
    </footer>
</body>
</html>
