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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: #eef2f7;
        }

        .container {
            flex: 1;
        }

        .table {
            margin-top: 20px;
        }

        .table th {
            background-color: #007bff;
            color: white;
            text-align: center;
        }

        .table th, .table td {
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
        }

        .table-striped tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        footer {
            background: linear-gradient(90deg, #1c1c1c, #5e60ce);
            color: white;
            text-align: center;
            padding: 10px 0;
            font-size: 1rem;
            border-top: 2px solid #ffffff33;
            box-shadow: 0 -1px 5px rgba(0, 0, 0, 0.2);
        }

        footer p {
            margin: 0;
            line-height: 1.6;
            font-weight: 500;
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
            margin-left: 95px;
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
            margin-left: 15px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">CV Rental Mobil Eksha</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="btn btn-primary" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="btn btn-primary" href="mobil.php">Data Mobil</a></li>
                    <li class="nav-item"><a class="btn btn-primary" href="pelanggan.php">Data Pelanggan</a></li>
                    <li class="nav-item"><a class="btn btn-primary" href="rental.php">Reservasi</a></li>
                    <li class="nav-item"><a class="btn btn-danger" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container">
        <h1 class="text-center mt-4">Data Rental</h1>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="tambah_rental.php" class="btn btn-success">Tambah Data Rental</a>
            <form method="POST" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Search by No Transaksi, Customer Name or Car Name" value="<?= isset($_POST['search']) ? $_POST['search'] : ''; ?>">
                <button type="submit" class="btn btn-primary">Search</button>
                <a href="rental.php" class="btn btn-secondary ms-2">Kembali</a>
            </form>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No<br>Transaksi</th>
                    <th>Nama<br>Pelanggan</th>
                    <th>Nama<br>Mobil</th>
                    <th>Tanggal<br>Mulai</th>
                    <th>Tanggal<br>Selesai</th>
                    <th>Jam<br>Rental</th>
                    <th>Harga</th>
                    <th>Lama<br>(hari)</th>
                    <th>Total<br>Bayar</th>
                    <th>Status</th>
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
                                <select name="status" class="form-select" onchange="this.form.submit()">
                                    <option value="Aktif" <?= $data['status_eksha'] == 'Aktif' ? 'selected' : ''; ?>>Aktif</option>
                                    <option value="Selesai" <?= $data['status_eksha'] == 'Selesai' ? 'selected' : ''; ?>>Selesai</option>
                                </select>
                                <input type="hidden" name="no_trx" value="<?= $data['no_trx_eksha']; ?>">
                            </form>
                        </td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="edit_rental.php?no_trx=<?= $data['no_trx_eksha']; ?>">Edit</a></li>
                                    <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?= $data['no_trx_eksha']; ?>" data-name="<?= $data['nama_eksha']; ?>">Delete</a></li>
                                </ul>
                            </div>
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
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data rental untuk pelanggan "<span id="nama-pelanggan"></span>"?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="#" id="confirm-delete" class="btn btn-danger">Hapus</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Update modal content dynamically
        const deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');

            document.getElementById('nama-pelanggan').textContent = name;
            document.getElementById('confirm-delete').setAttribute('href', 'hapus_rental.php?no_trx=' + id);
        });
    </script>

    <footer>
        <p>2024@ Eksha Oktavian Perdana</p>
    </footer>
</body>
</html>
