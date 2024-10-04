<?php
$servername = "localhost"; // Ganti dengan nama server Anda
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "dial";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mengambil ID dari permintaan GET
$service_id = $_GET['id'];

// Mengambil data layanan berdasarkan ID
$sql = "SELECT service_name, description FROM services WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $service_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $service = $result->fetch_assoc();
    echo json_encode($service); // Mengembalikan data dalam format JSON
} else {
    echo json_encode(["error" => "Service not found."]);
}

$stmt->close();
$conn->close();
?>
