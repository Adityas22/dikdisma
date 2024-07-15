<?php
session_start();
session_unset(); // Hilangkan semua variabel sesi
session_destroy(); // Hancurkan sesi
header("Location: index.php");
exit();
?>