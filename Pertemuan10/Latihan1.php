<?php
// hostname atau IP server
$servername = "localhost";

// username dan password database
$dbusername = "root";
$dbpassword = "";

// koneksi ke server MySQL
$link = mysqli_connect($servername, $dbusername, $dbpassword);

// cek koneksi
if (!$link) {
    die("Tidak dapat terhubung ke server: " . mysqli_connect_error());
} else {
    echo "OK.... koneksi berhasil";
}
?>