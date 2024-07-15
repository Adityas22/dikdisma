<?php
include "koneksi.php";

$tanggal = $_POST["tanggal"];
$nomor = $_POST["nomor"];
$asal = $_POST["asal"];
$isi = $_POST["isi"];
$tujuan = $_POST["tujuan"];

// Format tanggal menjadi tgl-bln-thn
$tanggal = date("d-m-Y", strtotime($tanggal));

$query = "INSERT INTO surat (tanggal, nomor, asal, isi, tujuan) VALUES ('$tanggal', '$nomor', '$asal', '$isi','$tujuan')";
$result = mysqli_query($connect, $query);

if ($result) {
    echo "Data berhasil disimpan";
} else {
    echo "Terjadi kesalahan saat menambahkan data: " . mysqli_error($connect);
}

mysqli_close($connect);
?>