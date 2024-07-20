<?php
include 'koneksi.php';

if (isset($_GET['tujuan_staff'])) {
    $tujuan_staff = mysqli_real_escape_string($connect, $_GET['tujuan_staff']);
    $filterQuery = "WHERE tujuan LIKE '%$tujuan_staff%'";
    header("Location: data.php?filter_staff=1&query=" . urlencode($filterQuery));
    exit();
}
?>