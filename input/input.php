
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "latihan";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.html");
    exit;
}

$kecamatan = trim($_POST["kecamatan"] ?? "");
$longitude = $_POST["longitude"] ?? "";
$latitude = $_POST["latitude"] ?? "";
$luas = $_POST["luas"] ?? "";
$jumlah_penduduk = $_POST["jumlah_penduduk"] ?? "";

if (
    $kecamatan === "" ||
    !is_numeric($longitude) ||
    !is_numeric($latitude) ||
    !is_numeric($luas) ||
    !filter_var($jumlah_penduduk, FILTER_VALIDATE_INT) ||
    (float)$longitude < -180 ||
    (float)$longitude > 180 ||
    (float)$latitude < -90 ||
    (float)$latitude > 90 ||
    (float)$luas <= 0 ||
    (int)$jumlah_penduduk < 1
) {
    die("Data tidak valid. Periksa kembali input kamu.");
}

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

$sql = "INSERT INTO penduduk
        (kecamatan, longitude, latitude, luas, jumlah_penduduk)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

$longitude = (float)$longitude;
$latitude = (float)$latitude;
$luas = (float)$luas;
$jumlah_penduduk = (int)$jumlah_penduduk;

$stmt->bind_param(
    "sdddi",
    $kecamatan,
    $longitude,
    $latitude,
    $luas,
    $jumlah_penduduk
);

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();

    header("Location: ../index.php");
    exit;
} else {
    echo "Data gagal disimpan.";
}

$stmt->close();
$conn->close();
?>
