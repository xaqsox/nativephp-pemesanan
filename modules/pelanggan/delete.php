<?php
include "../../config/auth.php";
include "../../config/database.php";

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM pelanggan WHERE id_pelanggan='$id'");
header("Location: list.php");
exit;
?>
