<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($connect, $_GET['id']);
    $query = "SELECT * FROM surat WHERE id='$id'";
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "Data tidak ditemukan.";
        exit();
    }
} else {
    header("Location: data.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Surat</title>
    <link rel="icon" href="img/dikpora.png" type="image/png" />
    <link rel="stylesheet" href="css/style_surat.css" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <style>
    .table td,
    .table th {
        white-space: normal;
        word-wrap: break-word;
    }

    .table th {
        width: 20%;
    }

    .table td {
        width: 80%;
    }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>Detail Surat</h1>
        <table class="table table-bordered">
            <tr>
                <th>Tanggal Surat</th>
                <td><?php echo $row['tanggal']; ?></td>
            </tr>
            <tr>
                <th>Nomor Surat</th>
                <td><?php echo $row['nomor']; ?></td>
            </tr>
            <tr>
                <th>Asal</th>
                <td><?php echo $row['asal']; ?></td>
            </tr>
            <tr>
                <th>Isi</th>
                <td><?php echo nl2br($row['isi']); ?></td>
            </tr>
            <tr>
                <th>Tujuan</th>
                <td><?php echo $row['tujuan']; ?></td>
            </tr>
        </table>
        <a href="data.php" class="btn btn-primary">Kembali</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>