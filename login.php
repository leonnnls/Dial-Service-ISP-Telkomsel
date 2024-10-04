<?php
session_start(); // Mulai sesi untuk menyimpan data sementara

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dial";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone_number = $_POST['phone'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE phone_number = ?");
    $stmt->bind_param("s", $phone_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Jika nomor ada, arahkan ke halaman verifikasi
        $verification_code = rand(100000, 999999); // Buat kode verifikasi acak
        $_SESSION['verification_code'] = $verification_code;
        $_SESSION['verification_time'] = time(); // Simpan waktu saat kode dibuat
        echo "<script>alert('Verifikasi telah dikirim. Silakan periksa SMS Anda.'); window.location.href='verifikasi.html';</script>";
    } else {
        // Jika nomor tidak ada, tambahkan ke database
        $verification_code = rand(100000, 999999); // Buat kode verifikasi acak
        $stmt = $conn->prepare("INSERT INTO users (phone_number, verification_code) VALUES (?, ?)");
        $stmt->bind_param("ss", $phone_number, $verification_code);

        if ($stmt->execute()) {
            $_SESSION['verification_code'] = $verification_code;
            $_SESSION['verification_time'] = time(); // Simpan waktu saat kode dibuat
            echo "<script>alert('Verifikasi telah dikirim. Silakan periksa SMS Anda.'); window.location.href='verifikasi.html';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $stmt->close();
}
$conn->close();
?>
