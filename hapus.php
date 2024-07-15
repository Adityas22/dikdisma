<?php
// Koneksi ke database
include('koneksi.php');

// Cek apakah ada parameter 'id' yang dikirimkan melalui URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Buat query untuk menghapus data berdasarkan id
    $query = "DELETE FROM surat WHERE id = '$id'";

    // Jalankan query
    if (mysqli_query($connect, $query)) {
        // Jika berhasil dihapus, redirect ke halaman utama dan tambahkan parameter pesan
        header("Location: data.php?pesan=delete");
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Error: " . $query . "<br>" . mysqli_error($connect);
    }

    // Tutup koneksi database
    mysqli_close($connect);
} else {
    // Jika tidak ada parameter 'id', redirect ke halaman utama
    // header("Location: index.php");
}
?>