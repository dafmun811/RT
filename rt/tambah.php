<?php
// tambah.php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_lengkap = $_POST['nama_lengkap'];
    $nomor_kk = $_POST['nomor_kk'];
    $nik = $_POST['nik'];
    $alamat = $_POST['alamat'];
    $status = $_POST['status'];
    $iuran = isset($_POST['iuran']) ? $_POST['iuran'] : 0;

    $sql = "INSERT INTO warga (nama_lengkap, nomor_kk, nik, alamat, status, iuran) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssssi", $nama_lengkap, $nomor_kk, $nik, $alamat, $status, $iuran);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Warga</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Tambah Data Warga</h1>
        <form action="" method="POST" class="form">
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" required>
            </div>
            <div class="form-group">
                <label for="nomor_kk">Nomor KK</label>
                <input type="text" id="nomor_kk" name="nomor_kk" required>
            </div>
            <div class="form-group">
                <label for="nik">NIK</label>
                <input type="text" id="nik" name="nik" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea id="alamat" name="alamat" required></textarea>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="Kepala Keluarga">Kepala Keluarga</option>
                    <option value="Anggota Keluarga">Anggota Keluarga</option>
                </select>
            </div>
            <div class="form-group">
                <label for="iuran">Iuran (opsional)</label>
                <input type="number" id="iuran" name="iuran" value="0">
            </div>
            <button type="submit" class="button-submit">Simpan</button>
            <a href="index.php" class="button-cancel">Kembali</a>
        </form>
    </div>
</body>
</html>