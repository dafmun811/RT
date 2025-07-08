<?php
// index.php
include 'koneksi.php';

$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM warga WHERE nama_lengkap LIKE '%$search%' ORDER BY nama_lengkap ASC";
} else {
    $sql = "SELECT * FROM warga ORDER BY nama_lengkap ASC";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Data Warga RT</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Daftar Warga RT</h1>

        <div class="controls">
            <form action="" method="GET" class="search-form">
                <input type="text" name="search" placeholder="Cari berdasarkan nama" value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="button-search">Cari</button>
            </form>
            <a href="tambah.php" class="button-add">+ Tambah Warga</a>
        </div>

        <?php if (mysqli_num_rows($result) > 0): ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>Alamat</th>
                    <th>Status</th>
                    <th>Iuran (Rp)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nama_lengkap']); ?></td>
                    <td><?php echo htmlspecialchars($row['nik']); ?></td>
                    <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td><?php echo number_format($row['iuran'], 0, ',', '.'); ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="button-action">Edit</a> |
                        <a href="hapus.php?id=<?php echo $row['id']; ?>" class="button-action" onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p class="no-data">Tidak ada data warga.</p>
        <?php endif; ?>
    </div>
</body>
</html>