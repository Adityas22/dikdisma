<?php
include 'koneksi.php';

if (isset($_GET['tanggal'])) {
    $tanggal = mysqli_real_escape_string($connect, $_GET['tanggal']);
    $bulan = date('m', strtotime($tanggal));
    $tahun = date('Y', strtotime($tanggal));
    $filterQuery = "WHERE MONTH(STR_TO_DATE(tanggal, '%d-%m-%Y')) = '$bulan' AND YEAR(STR_TO_DATE(tanggal, '%d-%m-%Y')) = '$tahun'";
    header("Location: data.php?filter_month=1&query=" . urlencode($filterQuery));
    exit();
}
?>