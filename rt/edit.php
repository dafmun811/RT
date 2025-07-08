<?php
// edit.php
include 'koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$sql = "SELECT * FROM warga WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    echo "Data tidak ditemukan.";
    exit();
}

$data = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_lengkap = $_POST['nama_lengkap'];
    $nomor_kk = $_POST['nomor_kk'];
    $nik = $_POST['nik'];
    $alamat = $_POST['alamat'];
    $status = $_POST['status'];
    $iuran = $_POST['iuran'];

    $sql_update = "UPDATE warga SET nama_lengkap = ?, nomor_kk = ?, nik = ?, alamat = ?, status = ?, iuran = ? WHERE id = ?";
    $stmt_update = mysqli_prepare($conn, $sql_update);
    mysqli_stmt_bind_param($stmt_update, "sssssii", $nama_lengkap, $nomor_kk, $nik, $alamat, $status, $iuran, $id);

    if (mysqli_stmt_execute($stmt_update)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt_update);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Warga</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Edit Data Warga</h1>
        <form action="" method="POST" class="form">
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo htmlspecialchars($data['nama_lengkap']); ?>" required>
            </div>
            <div class="form-group">
                <label for="nomor_kk">Nomor KK</label>
                <input type="text" id="nomor_kk" name="nomor_kk" value="<?php echo htmlspecialchars($data['nomor_kk']); ?>" required>
            </div>
            <div class="form-group">
                <label for="nik">NIK</label>
                <input type="text" id="nik" name="nik" value="<?php echo htmlspecialchars($data['nik']); ?>" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea id="alamat" name="alamat" required><?php echo htmlspecialchars($data['alamat']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="Kepala Keluarga" <?php echo ($data['status'] == 'Kepala Keluarga') ? 'selected' : ''; ?>>Kepala Keluarga</option>
                    <option value="Anggota Keluarga" <?php echo ($data['status'] == 'Anggota Keluarga') ? 'selected' : ''; ?>>Anggota Keluarga</option>
                </select>
            </div>
            <div class="form-group">
                <label for="iuran">Iuran</label>
                <input type="number" id="iuran" name="iuran" value="<?php echo htmlspecialchars($data['iuran']); ?>" required>
            </div>
            <button type="submit" class="button-submit">Simpan Perubahan</button>
            <a href="index.php" class="button-cancel">Kembali</a>
        </form>
    </div>
</body>
</html>