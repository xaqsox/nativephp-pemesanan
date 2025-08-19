<?php
include "../../config/auth.php";
include "../../config/database.php";

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM air_minum WHERE id_air='$id'");
header("Location: list.php");
exit;
?>
