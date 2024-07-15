<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $tanggal = $_POST['tanggal'];
    $nomor = $_POST['nomor'];
    $asal = $_POST['asal'];
    $isi = $_POST['isi'];
    $tujuan = $_POST['tujuan'];

    $tanggal = date("d-m-Y", strtotime($tanggal));

    $query = "UPDATE surat SET tanggal='$tanggal', nomor='$nomor', asal='$asal', isi='$isi', tujuan='$tujuan' WHERE id='$id'";

    if (mysqli_query($connect, $query)) {
        header("Location: data.php?pesan=update");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connect);
    }

    mysqli_close($connect);
}
?>