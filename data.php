<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// Ambil data surat berdasarkan filter pencarian
$filterQuery = "";
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($connect, $_GET['search']);
    $filterQuery = "WHERE tanggal LIKE '%$search%' OR nomor LIKE '%$search%' OR asal LIKE '%$search%' OR tujuan LIKE '%$search%'";
} else if (isset($_GET['tanggal'])) {
    $tanggal = mysqli_real_escape_string($connect, $_GET['tanggal']);
    $bulan = date('m', strtotime($tanggal));
    $tahun = date('Y', strtotime($tanggal));
    $filterQuery = "WHERE MONTH(STR_TO_DATE(tanggal, '%d-%m-%Y')) = '$bulan' AND YEAR(STR_TO_DATE(tanggal, '%d-%m-%Y')) = '$tahun'";
}

if (isset($_GET['all_data'])) {
    $filterQuery = "";
}

$query = "SELECT * FROM surat $filterQuery";
$result = mysqli_query($connect, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DIKPORA SEKSI-SMA</title>
    <link rel="icon" href="img/dikpora.png" type="image/png" />
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.bootstrap4.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style_surat.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top custom-navbar">
        <a class="navbar-brand" href="#">
            <img src="img/dikpora.png" alt="Logo" style="height: 2em" />
            DIKPORA SEKSI-SMA
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item" style="background-color:#D21F3C; border-radius: 10px;">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Konten Utama -->
    <div class="data">
        <h1>Halo! Selamat datang di E-Surat, anda berhasil login sebagai admin dan memiliki akses penuh.
        </h1>

        <!-- Form Filter Bulan dan Tahun -->
        <div class="mt-4">
            <form id="filterForm" method="GET" action="data.php">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <input type="month" class="form-control" id="tanggalSurat" name="tanggal">
                    </div>
                    <div class="form-group col-md-2">
                        <button type="submit" class="btn btn-success">Filter Bulan-tahun</button>
                    </div>
                    <div class="form-group col-md-2">
                        <button type="submit" class="btn btn-primary" name="all_data">Tampilkan Semua Data</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tombol Ekspor -->
        <div class="d-flex justify-content-between align-items-center">
            <button class="btn btn-primary" data-toggle="modal" data-target="#inputModal">Tambah Data</button>
            <!-- <div>
                <button class="btn btn-secondary" id="exportPdf">Export PDF</button>
                <button class="btn btn-secondary" id="exportCsv">Export CSV</button>
                <button class="btn btn-secondary" id="exportExcel">Export Excel</button>
                <button class="btn btn-secondary" id="printTable">Print</button>
            </div> -->
            <div class="form-inline">
                <input type="text" class="form-control" id="search" name="search" placeholder="Cari">
                <button class="btn btn-primary" id="searchButton">Cari</button>
            </div>
        </div>

        <!-- Tabel -->
        <div class="table-responsive mt-4 data-tables datatable-dark"">
            <table id=" dataTable" class="table table-bordered">
            <thead>
                <tr style="text-align:center;">
                    <th>No</th>
                    <th>Tanggal Surat</th>
                    <th>Nomor Surat</th>
                    <th>Asal</th>
                    <th>Isi</th>
                    <th>Tujuan</th>
                    <th colspan="3">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
            // Periksa apakah ada data provinsi
            if (mysqli_num_rows($result) > 0) {
                $no = 1; // Variabel nomor

                while ($row = mysqli_fetch_assoc($result)) {
                    $tanggal_table = $row['tanggal'];
                    $nomor_table = $row['nomor'];
                    $asal_table = $row['asal'];
                    // Batasi panjang teks pada kolom "Isi"
                    $isiTeks = $row['isi'];
                    if (strlen($isiTeks) > 30) {
                        $isiTeks = substr($isiTeks, 0, 30) . "...";
                    }
                    $isi_table = $isiTeks;
                    $tujuan_table = $row['tujuan'];
            ?>
                <tr>
                    <td><?= $no ?></td>
                    <td><?php echo $tanggal_table ?></td>
                    <td><?php echo $nomor_table ?></td>
                    <td><?php echo $asal_table ?></td>
                    <td><?php echo $isi_table ?></td>
                    <td><?php echo $tujuan_table ?></td>
                    <td>
                        <button class='btn btn-warning updateButton' data-id='<?= $row["id"] ?>' data-toggle='modal'
                            data-target='#updateModal'>Update</button>
                    </td>
                    <td>
                        <button class='btn btn-danger deleteButton' data-id='<?= $row["id"] ?>' data-toggle='modal'
                            data-target='#deleteModal'>Delete</button>
                    </td>
                    <td>
                        <a href='detail.php?id=<?= $row["id"] ?>' class='btn btn-info'>Detail</a>
                    </td>
                </tr>
                <?php
                $no++; // Tambahkan nomor
                }
            } else {
                echo "<tr><td colspan='9' class='text-center'>Belum ada data.</td></tr>";
            }
            // Tutup koneksi ke database
            mysqli_close($connect);
            ?>
            </tbody>
            </table>
        </div>


        <!-- Modal untuk Input Data -->
        <div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="inputModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="inputModalLabel">Input Surat Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="inputDataForm">
                            <div class="form-group">
                                <label for="tanggalSurat">Tanggal Surat</label>
                                <input type="date" class="form-control" id="tanggalSurat" name="tanggal" required>
                            </div>
                            <div class="form-group">
                                <label for="nomorSurat">Nomor Surat</label>
                                <input type="text" class="form-control" id="nomorSurat" name="nomor"
                                    placeholder="Nomor Surat" required>
                            </div>
                            <div class="form-group">
                                <label for="asalSurat">Asal</label>
                                <input type="text" class="form-control" id="asalSurat" name="asal"
                                    placeholder="Asal Surat" required>
                            </div>
                            <div class="form-group">
                                <label for="isiSurat">Isi</label>
                                <textarea class="form-control" id="isiSurat" name="isi" rows="3" placeholder="Isi Surat"
                                    required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="tujuanSurat">Tujuan</label>
                                <select class="form-control" id="tujuanSurat" name="tujuan" required>
                                    <option value="Dra. Supartini">Dra. Supartini</option>
                                    <option value="Widayatun S.Pd">Widayatun S.Pd</option>
                                    <option value="Haryoko S.Pd">Haryoko S.Pd</option>
                                    <option value="Tri Suryani S.Kom">Tri Suryani S.Kom</option>
                                    <option value="Andiyanto Eko Saputro S.Pd">Andiyanto Eko Saputro S.Pd</option>
                                    <option value="Ika Indah Yulianingrum S.H">Ika Indah Yulianingrum S.H</option>
                                    <option value="Angga Arisdian P">Angga Arisdian P</option>
                                    <option value="Dessy Yudhanti S.E">Dessy Yudhanti S.E</option>
                                    <option value="Suyatno">Suyatno</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Insert</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- update form -->
        <!-- Modal untuk Update Data -->
        <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Update Surat</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="updateDataForm">
                            <input type="hidden" id="updateId" name="id">
                            <div class="form-group">
                                <label for="updateTanggalSurat">Tanggal Surat</label>
                                <input type="date" class="form-control" id="updateTanggalSurat" name="tanggal" required>
                            </div>
                            <div class="form-group">
                                <label for="updateNomorSurat">Nomor Surat</label>
                                <input type="text" class="form-control" id="updateNomorSurat" name="nomor" required>
                            </div>
                            <div class="form-group">
                                <label for="updateAsalSurat">Asal</label>
                                <input type="text" class="form-control" id="updateAsalSurat" name="asal" required>
                            </div>
                            <div class="form-group">
                                <label for="updateIsiSurat">Isi</label>
                                <textarea class="form-control" id="updateIsiSurat" name="isi" rows="3"
                                    required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="updateTujuanSurat">Tujuan</label>
                                <select class="form-control" id="updateTujuanSurat" name="tujuan" required>
                                    <option value="Dra. Supartini">Dra. Supartini</option>
                                    <option value="Widayatun S.Pd">Widayatun S.Pd</option>
                                    <option value="Haryoko S.Pd">Haryoko S.Pd</option>
                                    <option value="Tri Suryani S.Kom">Tri Suryani S.Kom</option>
                                    <option value="Andiyanto Eko Saputro S.Pd">Andiyanto Eko Saputro S.Pd</option>
                                    <option value="Ika Indah Yulianingrum S.H">Ika Indah Yulianingrum S.H</option>
                                    <option value="Angga Arisdian P">Angga Arisdian P</option>
                                    <option value="Dessy Yudhanti S.E">Dessy Yudhanti S.E</option>
                                    <option value="Suyatno">Suyatno</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Update</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- delete -->
        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Penghapusan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus data ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                        <a href="#" class="btn btn-danger deleteConfirm">Ya</a>
                    </div>
                </div>
            </div>
        </div>

        <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
        new DataTable('#dataTable', {
            layout: {
                topStart: {
                    buttons: ['copy', 'excel', 'pdf', 'colvis']
                }
            }
        });
        </script>

        <!-- Bootstrap dan jQuery JS -->
        <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Custom JS -->
        <script src="js/surat_masuk.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <!-- DataTables JS -->
        <script src="assets/datatables.js"></script>
        <script src="assets/datatables.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap4.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.bootstrap4.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.colVis.min.js"></script>

</html>