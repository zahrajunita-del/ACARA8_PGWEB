<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "latihan";

$conn = new mysqli(
    $servername,
    $username,
    $password,
    $dbname
);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

$sql = "SELECT * FROM penduduk";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Penduduk Kecamatan</title>
</head>
<body>

    <h2>Data Penduduk Kecamatan</h2>

    <a href="input/index.html">Input Data</a>

    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Kecamatan</th>
            <th>Longitude</th>
            <th>Latitude</th>
            <th>Luas</th>
            <th>Jumlah Penduduk</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row["id"] ?></td>
            <td><?= htmlspecialchars($row["kecamatan"]) ?></td>
            <td><?= $row["longitude"] ?></td>
            <td><?= $row["latitude"] ?></td>
            <td><?= $row["luas"] ?></td>
            <td><?= number_format($row["jumlah_penduduk"], 0, ',', '.') ?></td>
        </tr>
        <?php } ?>

    </table>

</body>
</html>

<?php
$conn->close();
?>
