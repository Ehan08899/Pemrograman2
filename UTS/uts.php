<?php
// ===== KONEKSI DATABASE =====
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli("localhost", "root", "", "uts");
    $conn->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

$pesan = "";

// ===== PROSES SIMPAN =====
if (isset($_POST['simpan'])) {

    $tgl_input      = $_POST['tgl_input'];
    $kode           = strtoupper($_POST['kode']);
    $nama           = $_POST['nama'];
    $jk             = $_POST['jk'];
    $asal_sekolah   = $_POST['asal_sekolah'];
    $pekerjaan_ortu = $_POST['pekerjaan_ortu'];
    $tempat_lahir   = $_POST['tempat_lahir'];
    $tgl_lahir      = $_POST['tgl_lahir'];

    $mat  = (int) $_POST['mat'];
    $bing = (int) $_POST['bing'];
    $umum = (int) $_POST['umum'];

    // Hitung rata-rata
    $rata = ($mat + $bing + $umum) / 3;

    // Menentukan keterangan
    if ($rata >= 70) {
        $keterangan = "Lulus";
    } elseif ($rata >= 60) {
        $keterangan = "Cadangan";
    } else {
        $keterangan = "Tidak Lulus";
    }

    // Menentukan tempat tes berdasarkan kode
    $kode_awal = substr($kode, 0, 1);

    if ($kode_awal == "A") {
        $tempat_tes = "Gedung A";
    } elseif ($kode_awal == "B") {
        $tempat_tes = "Gedung B";
    } elseif ($kode_awal == "V") {
        $tempat_tes = "Viktor";
    } else {
        $tempat_tes = "Tidak Diketahui";
    }

    // Simpan ke database
    try {
        $stmt = $conn->prepare("INSERT INTO pendaftar
            (tgl_input, kode, nama, jk, asal_sekolah, pekerjaan_ortu, tempat_lahir, tgl_lahir, mat, bing, umum, rata_rata, tempat_tes, keterangan)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

        $stmt->bind_param(
            "ssssssssiiidss",
            $tgl_input, $kode, $nama, $jk, $asal_sekolah, $pekerjaan_ortu,
            $tempat_lahir, $tgl_lahir, $mat, $bing, $umum, $rata, $tempat_tes, $keterangan
        );
        $stmt->execute();
        $stmt->close();

        $pesan = "Data berhasil disimpan. Klik tombol <b>TAMPILKAN DATA</b> untuk melihat data.";
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            $pesan = "Gagal menyimpan: Kode pendaftaran <b>" . htmlspecialchars($kode) . "</b> sudah terdaftar.";
        } else {
            $pesan = "Gagal menyimpan: " . htmlspecialchars($e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UTS PHP - Pendaftaran Mahasiswa</title>

    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            margin: 30px;
            background: #f4f4f4;
        }

        .container{
            width: 900px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }

        h2{
            text-align: center;
        }

        table{
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td{
            border: 1px solid black;
        }

        th, td{
            padding: 10px;
            text-align: center;
        }

        input[type=text],
        input[type=number],
        input[type=date]{
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
        }

        .btn{
            background: blue;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        .btn:hover{
            background: darkblue;
        }

        .info{
            margin-top: 20px;
            padding: 10px;
            background: #eef;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>FORM PENDAFTARAN MAHASISWA BARU</h2>

    <form method="POST">

        <label>Tanggal Input</label>
        <input type="date" name="tgl_input" required>

        <label>Kode Pendaftaran</label>
        <input type="text" name="kode" placeholder="Contoh : A2" required>

        <label>Nama Pendaftar</label>
        <input type="text" name="nama" required>

        <label>Jenis Kelamin</label><br>
        <input type="radio" name="jk" value="Laki-Laki" required> Laki-Laki
        <input type="radio" name="jk" value="Perempuan"> Perempuan
        <br><br>

        <label>Asal Sekolah</label>
        <input type="text" name="asal_sekolah" required>

        <label>Pekerjaan Orang Tua</label>
        <input type="text" name="pekerjaan_ortu" required>

        <label>Tempat Lahir</label>
        <input type="text" name="tempat_lahir" required>

        <label>Tanggal Lahir</label>
        <input type="date" name="tgl_lahir" required>

        <label>Matematika</label>
        <input type="number" name="mat" required>

        <label>Bahasa Inggris</label>
        <input type="number" name="bing" required>

        <label>Umum</label>
        <input type="number" name="umum" required>

        <button type="submit" name="simpan" class="btn">SIMPAN</button>
        <button type="submit" name="tampil" class="btn" formnovalidate>TAMPILKAN DATA</button>

    </form>

    <?php
    // ===== PESAN SETELAH SIMPAN =====
    if ($pesan != "") {
        echo "<div class='info'>$pesan</div>";
    }

    // ===== TAMPILKAN DATA (hanya saat tombol diklik) =====
    if (isset($_POST['tampil'])) {

        $result = $conn->query("SELECT * FROM pendaftar ORDER BY id ASC");

        echo "
        <table>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>JK</th>
                <th>Tgl Lahir</th>
                <th>Asal Sekolah</th>
                <th>Pekerjaan Ortu</th>
                <th>Tempat Tes</th>
                <th>MAT</th>
                <th>B. Inggris</th>
                <th>Umum</th>
                <th>Rata-rata</th>
                <th>Keterangan</th>
            </tr>
        ";

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "
                <tr>
                    <td>" . htmlspecialchars($row['kode']) . "</td>
                    <td>" . htmlspecialchars($row['nama']) . "</td>
                    <td>" . htmlspecialchars($row['jk']) . "</td>
                    <td>" . htmlspecialchars($row['tempat_lahir']) . ", " . $row['tgl_lahir'] . "</td>
                    <td>" . htmlspecialchars($row['asal_sekolah']) . "</td>
                    <td>" . htmlspecialchars($row['pekerjaan_ortu']) . "</td>
                    <td>" . htmlspecialchars($row['tempat_tes']) . "</td>
                    <td>" . $row['mat'] . "</td>
                    <td>" . $row['bing'] . "</td>
                    <td>" . $row['umum'] . "</td>
                    <td>" . number_format($row['rata_rata'], 2) . "</td>
                    <td>" . $row['keterangan'] . "</td>
                </tr>
                ";
            }
        } else {
            echo "<tr><td colspan='12'>Belum ada data</td></tr>";
        }

        echo "</table>";

        // Rekap data dari database
        $rekap = $conn->query("
            SELECT
                COUNT(*) AS jumlah_pendaftar,
                COALESCE(SUM(keterangan = 'Lulus'), 0) AS jumlah_lulus,
                COALESCE(SUM(keterangan <> 'Lulus'), 0) AS jumlah_tidak_lulus
            FROM pendaftar
        ")->fetch_assoc();

        echo "
        <div class='info'>
            <h3>Rekap Data:</h3>
            <p>Jumlah Pendaftar : <b>{$rekap['jumlah_pendaftar']}</b></p>
            <p>Jumlah Peserta Lulus : <b>{$rekap['jumlah_lulus']}</b></p>
            <p>Jumlah Tidak Lulus : <b>{$rekap['jumlah_tidak_lulus']}</b></p>
        </div>
        ";

        echo "
        <div class='info'>
            <h3>Keterangan:</h3>
            <p><b>Kode Tempat Tes:</b></p>
            <ul>
                <li>A = Gedung A</li>
                <li>B = Gedung B</li>
                <li>V = Viktor</li>
            </ul>

            <p><b>Hasil Seleksi:</b></p>
            <ul>
                <li>Rata-rata ≥ 70 = Lulus</li>
                <li>Rata-rata 60 - 69 = Cadangan</li>
                <li>Rata-rata &lt; 60 = Tidak Lulus</li>
            </ul>
        </div>
        ";
    }
    ?>

</div>

</body>
</html>