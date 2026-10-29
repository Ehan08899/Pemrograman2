
<?php
$con = mysqli_connect("localhost", "root", "", "lat_dbase");

if (!$con) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$sql = "UPDATE tbl_mhs SET Age = 36 WHERE FirstName = 'Karina' AND LastName = 'Suwandi'";

if (mysqli_query($con, $sql)) {
    if (mysqli_affected_rows($con) > 0) {
        echo "Data Karina Suwandi berhasil diperbarui.";
    } else {
        echo "Query berhasil, tetapi tidak ada data yang berubah.";
    }
} else {
    echo "Error: " . mysqli_error($con);
}

mysqli_close($con);
?>
