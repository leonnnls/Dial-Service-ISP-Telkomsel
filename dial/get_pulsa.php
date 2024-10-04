<?php
// Koneksi ke database
$servername = "localhost"; // Ubah jika berbeda
$username = "root"; // Username database
$password = ""; // Password database
$dbname = "dial"; // Nama database

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die(json_encode(['error' => 'Koneksi database gagal']));
}

// Ambil nomor telepon dari URL
if (isset($_GET['phone_number'])) {
    $phone_number = $_GET['phone_number'];

    // Query untuk mengambil data pulsa berdasarkan nomor telepon
    $sql = "SELECT pulsa FROM users WHERE phone_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $phone_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(['pulsa' => $row['pulsa']]);
    } else {
        echo json_encode(['error' => 'Nomor telepon tidak ditemukan']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Nomor telepon tidak disediakan']);
}

$conn->close();
?>
