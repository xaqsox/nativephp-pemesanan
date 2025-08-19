<?php
include "../../config/auth.php";
include "../../config/database.php";

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM pengguna WHERE id_pengguna='$id'");
header("Location: list.php");
exit;
?>
