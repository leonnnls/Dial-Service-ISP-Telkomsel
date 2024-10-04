<?php
session_start(); // Mulai sesi

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_code = $_POST['verification_code'];

    // Cek apakah ada kode verifikasi yang disimpan dalam session
    if (isset($_SESSION['verification_code']) && isset($_SESSION['verification_time'])) {
        $saved_code = $_SESSION['verification_code'];
        $time_generated = $_SESSION['verification_time'];

        // Cek apakah waktu pembuatan kode masih dalam batas 1 menit
        if ((time() - $time_generated) <= 60) {
            // Bandingkan kode yang diinput dengan kode yang disimpan
            if ($input_code == $saved_code) {
                echo "<script>alert('Verifikasi berhasil!'); window.location.href='dial/dial.html';</script>";
                // Hapus session kode setelah berhasil
                unset($_SESSION['verification_code']);
                unset($_SESSION['verification_time']);
            } else {
                echo "<script>alert('Kode verifikasi salah! Silakan coba lagi.'); window.location.href='verifikasi.html';</script>";
            }
        } else {
            // Jika kode kadaluwarsa
            echo "<script>alert('Kode verifikasi telah kedaluwarsa. Silakan request ulang.'); window.location.href='index.html';</script>";
            // Hapus session kode setelah kadaluwarsa
            unset($_SESSION['verification_code']);
            unset($_SESSION['verification_time']);
        }
    } else {
        echo "<script>alert('Tidak ada kode verifikasi yang tersedia. Silakan request ulang.'); window.location.href='index.html';</script>";
    }
}
?>
