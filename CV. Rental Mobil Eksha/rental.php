<?php
session_start();
if (!isset($_SESSION['username'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

include 'config.php';

// Initialize query to select all data initially
$query = "
    SELECT r.no_trx_eksha, p.nama_eksha, m.nama_mobil_eksha, r.tgl_rental_eksha, 
           r.jam_rental_eksha, r.harga_eksha, r.lama_eksha, r.total_bayar_eksha, r.status_eksha
    FROM tbl_rental_eksha r
    INNER JOIN tbl_pelanggan_eksha p ON r.nik_ktp_eksha = p.nik_ktp_eksha
    INNER JOIN tbl_mobil_eksha m ON r.no_plat_eksha = m.no_plat_eksha
";

// Check if the search form is submitted
if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $query = "
        SELECT r.no_trx_eksha, p.nama_eksha, m.nama_mobil_eksha, r.tgl_rental_eksha, 
               r.jam_rental_eksha, r.harga_eksha, r.lama_eksha, r.total_bayar_eksha, r.status_eksha
        FROM tbl_rental_eksha r
        INNER JOIN tbl_pelanggan_eksha p ON r.nik_ktp_eksha = p.nik_ktp_eksha
        INNER JOIN tbl_mobil_eksha m ON r.no_plat_eksha = m.no_plat_eksha
        WHERE r.no_trx_eksha LIKE '%$search%' 
        OR p.nama_eksha LIKE '%$search%' 
        OR m.nama_mobil_eksha LIKE '%$search%'
    ";
}

$query_result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Rental - Rental Mobil Eksha</title>
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
    padding: 10px 0; /* Same padding as 'mobil.php' */
    width: 100%;
    margin-top: auto; /* Ensure footer stays at the bottom */
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
        <h1 class="text-center">Data Rental</h1>

        <a href="tambah_rental.php" class="btn btn-success mb-3">Tambah Data Rental</a>

        <form method="POST" class="mb-3 search-container">
            <input type="text" name="search" class="form-control" placeholder="Search by No Transaksi, Customer Name or Car Name" value="<?= isset($_POST['search']) ? $_POST['search'] : ''; ?>" style="width: 300px;">
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="rental.php" class="btn btn-secondary">Kembali</a>
        </form>

        <!-- Table -->
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No Transaksi</th>
                    <th>Nama Pelanggan</th>
                    <th>Nama Mobil</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Jam Rental</th>
                    <th>Harga</th>
                    <th>Lama (Hari)</th>
                    <th>Total Bayar</th>
                    <th class="status-column">Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($data = mysqli_fetch_array($query_result)) { 
                    $tgl_mulai = new DateTime($data['tgl_rental_eksha']);
                    $tgl_selesai = $tgl_mulai->add(new DateInterval('P' . $data['lama_eksha'] . 'D'))->format('Y-m-d');
                ?>
                    <tr>
                        <td><?= $data['no_trx_eksha']; ?></td>
                        <td><?= $data['nama_eksha']; ?></td>
                        <td><?= $data['nama_mobil_eksha']; ?></td>
                        <td><?= $data['tgl_rental_eksha']; ?></td>
                        <td><?= $tgl_selesai; ?></td>
                        <td><?= $data['jam_rental_eksha']; ?></td>
                        <td><?= "Rp. " . number_format($data['harga_eksha'], 0, ',', '.'); ?></td>
                        <td><?= $data['lama_eksha']; ?></td>
                        <td><?= "Rp. " . number_format($data['total_bayar_eksha'], 0, ',', '.'); ?></td>
                        <td>
                            <form action="update_status.php" method="POST">
                                <select name="status" class="form-control" onchange="this.form.submit()">
                                    <option value="Active" <?= $data['status_eksha'] == 'Active' ? 'selected' : ''; ?>>Active</option>
                                    <option value="Completed" <?= $data['status_eksha'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                                </select>
                                <input type="hidden" name="no_trx" value="<?= $data['no_trx_eksha']; ?>">
                            </form>
                        </td>
                        <td>
                            <!-- Action Dropdown -->
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="edit_rental.php?no_trx=<?= $data['no_trx_eksha']; ?>">Edit</a></li>
                                    <!-- Delete action with modal confirmation -->
                                    <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $data['no_trx_eksha']; ?>">Delete</a></li>
                                </ul>
                            </div>

                            <!-- Delete Confirmation Modal -->
                            <div class="modal fade" id="deleteModal<?= $data['no_trx_eksha']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete this rental record?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <a href="hapus_rental.php?no_trx=<?= $data['no_trx_eksha']; ?>" class="btn btn-danger">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <br>
                        <br>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <!-- Footer -->
    <footer>
        <p>2024@ Eksha Oktavian Perdana</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
