<?php
include "../../config/auth.php";
include "../../config/database.php";

$id = $_GET['id'];

// Hapus detail pesanan dulu
mysqli_query($conn, "DELETE FROM detail_pesanan WHERE id_pemesanan='$id'");

// Hapus header pesanan
mysqli_query($conn, "DELETE FROM pemesanan WHERE id_pemesanan='$id'");

header("Location: list.php");
exit;
?>
