<?php
include "../../config/auth.php";
include "../../config/database.php";

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM jenis_air_minum WHERE id_jenis_air='$id'");
header("Location: list.php");
exit;
?>
