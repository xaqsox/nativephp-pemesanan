<?php
include "../../config/auth.php";
include "../../config/database.php";

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM kurir WHERE id_kurir='$id'");
header("Location: list.php");
exit;
?>
