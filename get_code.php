<?php
session_start();

$response = array();

if (isset($_SESSION['verification_code']) && isset($_SESSION['verification_time'])) {
    $time_generated = $_SESSION['verification_time'];

    // Cek apakah kode masih valid dalam batas waktu 1 menit
    if ((time() - $time_generated) <= 60) {
        $response['verification_code'] = $_SESSION['verification_code'];
    } else {
        $response['verification_code'] = null; // Kosongkan kode jika sudah kadaluwarsa
    }
} else {
    $response['verification_code'] = null;
}

header('Content-Type: application/json');
echo json_encode($response);
?>
