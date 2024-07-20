<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$tujuanCounts = [];

if (isset($_POST['upload'])) {
    $fileName = $_FILES['file']['tmp_name'];

    if ($_FILES['file']['size'] > 0) {
        $file = fopen($fileName, 'r');

        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            $tujuan = $column[5]; // Asumsi kolom tujuan berada di indeks 5
            if (isset($tujuanCounts[$tujuan])) {
                $tujuanCounts[$tujuan]++;
            } else {
                $tujuanCounts[$tujuan] = 1;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload CSV dan Tampilkan Grafik</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Unggah File CSV dan Tampilkan Grafik Tujuan Surat</h2>
        <form action="" method="post" enctype="multipart/form-data" class="mt-4">
            <div class="form-group">
                <label for="file">Pilih File CSV:</label>
                <input type="file" class="form-control" name="file" id="file" accept=".csv" required>
            </div>
            <button type="submit" name="upload" class="btn btn-primary">Unggah dan Proses</button>
        </form>

        <?php if (!empty($tujuanCounts)): ?>
        <h3 class="mt-5">Grafik Tujuan Surat</h3>
        <canvas id="tujuanChart" width="400" height="200"></canvas>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('tujuanChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode(array_keys($tujuanCounts)); ?>,
                    datasets: [{
                        label: 'Jumlah Surat',
                        data: <?php echo json_encode(array_values($tujuanCounts)); ?>,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
        </script>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>