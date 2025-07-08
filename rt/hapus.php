<?php
// hapus.php
include 'koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];


$sql_check = "SELECT nama_lengkap FROM warga WHERE id = ?";
$stmt_check = mysqli_prepare($conn, $sql_check);
mysqli_stmt_bind_param($stmt_check, "i", $id);
mysqli_stmt_execute($stmt_check);
$result_check = mysqli_stmt_get_result($stmt_check);

if (mysqli_num_rows($result_check) == 0) {
    echo "Data tidak ditemukan.";
    exit();
}
$data_to_delete = mysqli_fetch_assoc($result_check);
mysqli_stmt_close($stmt_check);

if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
    $sql = "DELETE FROM warga WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
} else {
    header("Location: index.php");
    exit();
}
?>