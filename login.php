<?php
session_start();
if (isset($_SESSION['user'])) {
    session_destroy(); // Destroy session if user tries to access login page after login
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DIKPORA SEKSI-SMA</title>
    <link rel="icon" href="img/dikpora.png" type="image/png" />
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style_surat.css" />
</head>

<body>
    <div class="login">
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
                        <a class="nav-link" href="index.php">Kembali</a>
                    </li>
                </ul>
            </div>
        </nav>


        <div class="background-pattern login"></div>
        <div class="content">
            <div class="info">
                <h1>E-Surat</h1>
                <p>Halaman ini berfungsi untuk mendata surat masuk secara digital di bidang Seksi-SMA Dinas DIKPORA.
                    Masuk sebagai admin</p>
                <div class="form-container">
                    <form action="login_proses.php" method="post">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" placeholder="username"
                                name="username">
                        </div>
                        <div class="form-group">
                            <label for="password">password</label>
                            <input type="password" class="form-control" id="password" placeholder="password"
                                name="password">
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



</body>

</html>