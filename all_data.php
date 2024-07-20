<?php
include 'koneksi.php';

$query = "SELECT * FROM surat";
$data = mysqli_query($connect, $query);

// Redirect back to main page with data
header("Location: data.php?all_data=1");
exit();
?>