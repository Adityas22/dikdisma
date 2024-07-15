<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($connect, $_GET['id']);
    $query = "SELECT * FROM surat WHERE id = '$id'";
    $result = mysqli_query($connect, $query);

    if ($result) {
        $data = mysqli_fetch_assoc($result);
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'Data tidak ditemukan']);
    }
}
?>