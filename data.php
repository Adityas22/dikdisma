<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}


$filterQuery = "";
if (isset($_GET['tujuan_staff'])) {
    $tujuan_staff = mysqli_real_escape_string($connect, $_GET['tujuan_staff']);
    $filterQuery = "WHERE tujuan LIKE '%$tujuan_staff%'";
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
$data = mysqli_query($connect, $query);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataTables dengan PHP</title>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <style>
    /* Atur lebar kolom "Isi" */
    .table td:nth-child(5) {
        max-width: 200px;
        white-space: normal;
        word-wrap: break-word;
    }
    </style>
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
                    <a class="nav-link" href="#" id="logoutButton">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Konten Utama -->
    <div class="my-5 pt-5 pr-5 pl-5">
        <h1>Halo! Selamat datang di E-Surat, anda berhasil login sebagai admin dan memiliki akses penuh.
        </h1>

        <!-- Tombol Ekspor -->
        <div class="d-flex justify-content-center align-items-center flex-wrap">
            <button class="btn btn-primary mr-5" data-toggle="modal" data-target="#inputModal">Tambah Data</button>
            <form id="filterForm" method="GET" action="data.php" class="d-flex align-items-between flex-wrap">
                <div class="form-inline mr-5">
                    <input type="month" class="form-control" id="tanggalSurat" name="tanggal">
                    <button type="submit" class="btn btn-success">Filter Bulan-tahun</button>
                </div>
                <div class="form-group mt-3  mr-5">
                    <button type="submit" class="btn btn-primary" name="all_data">Tampilkan Semua Data</button>
                </div>
                <div class="form-inline mr-3">
                    <select class="form-control" id="tujuanSurat" name="tujuan_staff" required>
                        <option value="Dra. Supartini">Dra. Supartini</option>
                        <option value="Widayatun S.Pd">Widayatun S.Pd</option>
                        <option value="Haryoko S.Pd">Haryoko S.Pd</option>
                        <option value="Tri Suryani S.Kom">Tri Suryani S.Kom</option>
                        <option value="Andiyanto Eko Saputro S.Pd">Andiyanto Eko Saputro S.Pd</option>
                        <option value="Ika Indah Yulianingrum S.H">Ika Indah Yulianingrum S.H</option>
                        <option value="Angga Arisdian P">Angga Arisdian P</option>
                        <option value="Dessy Yudhanti S.E">Dessy Yudhanti S.E</option>
                        <option value="Suyatno">Suyatno</option>>
                    </select>
                    <button type="submit" class="btn btn-secondary">Filter Tujuan Staff</button>
                </div>
            </form>
        </div>
    </div>

    <!-- isi datatables -->
    <div class="pr-5 pl-5 ">
        <h2 class="mb-2">Tabel Surat</h2>
        <div class="table-responsive mt-4 data-tables datatable-dark">
            <table id="dataTable" class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Tanggal Surat</th>
                        <th>Nomor Surat</th>
                        <th>Asal</th>
                        <th>Isi</th>
                        <th>Tujuan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($data as $row) {
                        echo "<tr>";
                        echo "<td>{$no}</td>";
                        echo "<td>{$row['tanggal']}</td>";
                        echo "<td>{$row['nomor']}</td>";
                        echo "<td>{$row['asal']}</td>";
                        echo "<td>{$row['isi']}</td>";
                        echo "<td>{$row['tujuan']}</td>";
                        echo "<td class='d-flex justify-content-center align-items-center'>";
                        echo "<button class='btn btn-warning updateButton mr-4' data-id='{$row["id"]}' data-toggle='modal' data-target='#updateModal'>Update</button>";
                        echo "<button class='btn btn-danger deleteButton' data-id='{$row["id"]}' data-toggle='modal' data-target='#deleteModal'>Delete</button>";
                        echo "</td>";
                        echo "</tr>";
                        $no++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
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
                            <input type="text" class="form-control" id="asalSurat" name="asal" placeholder="Asal Surat"
                                required>
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
                            <textarea class="form-control" id="updateIsiSurat" name="isi" rows="3" required></textarea>
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

    <!-- Modal untuk Konfirmasi Delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data ini?</p>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-danger deleteConfirm">Ya</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                </div>
            </div>
        </div>
    </div>


    <!-- jQuery dan DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.colVis.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Custom JS -->
    <!-- <script src="js/surat_masuk.js"></script> -->

    <!-- Inisialisasi DataTables -->
    <script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            dom: 'Bfrtip',
            scrollY: 950,
            buttons: [{
                    extend: 'copy',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                }
            ],
        });
    });

    // Get the delete buttons
    $(".deleteButton").click(function() {
        // Get the data-id attribute
        var id = $(this).data("id");
        // Update the href of the "Ya" button in the modal
        $(".deleteConfirm").attr("href", "hapus.php?id=" + id);
    });

    // update
    $("#updateModal").on("show.bs.modal", function(event) {
        var button = $(event.relatedTarget);
        var id = button.data("id");

        $.ajax({
            url: "get_data_update.php",
            type: "GET",
            data: {
                id: id
            },
            success: function(response) {
                var data = JSON.parse(response);
                $("#updateId").val(data.id);
                $("#updateTanggalSurat").val(data.tanggal);
                $("#updateNomorSurat").val(data.nomor);
                $("#updateAsalSurat").val(data.asal);
                $("#updateIsiSurat").val(data.isi);
                $("#updateTujuanSurat").val(data.tujuan);
            },
        });
    });

    $("#updateDataForm").submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: "update_proses.php",
            type: "POST",
            data: formData,
            success: function(response) {
                $("#updateModal").modal("hide");
                location.reload();
            },
        });
    });

    // Reset form ketika modal ditutup
    $("#inputModal").on("hidden.bs.modal", function() {
        $(this).find("form").trigger("reset");
    });

    // Mengosongkan form ketika data berhasil diinsert
    $("#inputDataForm").on("submit", function(e) {
        e.preventDefault();
        // Ambil data dari form
        var formData = $(this).serialize();

        // Kirim data menggunakan AJAX
        $.ajax({
            type: "POST",
            url: "tambah_proses.php",
            data: formData,
            success: function(response) {
                alert(response);
                $("#inputModal").modal("hide");
                $("#inputDataForm").trigger("reset"); // Reset form setelah submit

                // Tambahkan data baru ke tabel
                var newData = JSON.parse(formData);
                var newRow = [
                    newData.nomor,
                    newData.tanggal,
                    newData.nomor,
                    newData.asal,
                    newData.isi,
                    newData.tujuan,
                    '<button class="btn btn-warning updateButton mr-4" data-id="' + newData.id +
                    '" data-toggle="modal" data-target="#updateModal">Update</button>' +
                    '<button class="btn btn-danger deleteButton" data-id="' + newData.id +
                    '" data-toggle="modal" data-target="#deleteModal">Delete</button>'
                ];

                var table = $('#dataTable').DataTable();
                table.row.add(newRow).draw(false);
            },
            error: function(xhr, status, error) {
                var errorMessage = xhr.status + ": " + xhr.statusText;
                alert("Terjadi kesalahan - " + errorMessage);
            },
        });
    });

    // logout
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('logoutButton').addEventListener('click', function(event) {
            event.preventDefault();
            var confirmation = confirm('Apakah yakin mau logout?');
            if (confirmation) {
                window.location.href = 'logout.php';
            }
        });
    });
    </script>
</body>

</html>