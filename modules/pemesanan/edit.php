<?php
include "../../config/auth.php";
include "../../config/database.php";

$id = $_GET['id'];

// Ambil data pemesanan
$result = mysqli_query($conn, "
  SELECT p.*, pl.nama AS nama_pelanggan
  FROM pemesanan p
  LEFT JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
  WHERE p.id_pemesanan='$id'
");
$data = mysqli_fetch_assoc($result);

if (!$data) {
  die("Data tidak ditemukan.");
}

// Proses update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $status = mysqli_real_escape_string($conn, $_POST['status']);
  mysqli_query($conn, "UPDATE pemesanan SET status='$status' WHERE id_pemesanan='$id'");
  header("Location: list.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Ubah Status Pemesanan - AquaFresh</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<?php include "../../partials/header.php"; ?>
<div class="container-fluid">
  <div class="row">
    <?php include "../../partials/sidebar.php"; ?>
    <div class="col-md-10 p-4">
      <h3>Ubah Status Pemesanan</h3>
      <form method="post">
        <div class="mb-3">
          <label>Pelanggan</label>
          <input type="text" class="form-control" value="<?= htmlspecialchars($data['nama_pelanggan']); ?>" readonly>
        </div>
        <div class="mb-3">
          <label>Tanggal Pesan</label>
          <input type="text" class="form-control" value="<?= date("d-m-Y H:i", strtotime($data['tanggal_pesan'])); ?>" readonly>
        </div>
        <div class="mb-3">
          <label>Status</label>
          <select name="status" class="form-control" required>
            <option value="pending" <?= ($data['status']=='pending')?'selected':''; ?>>Pending</option>
            <option value="diproses" <?= ($data['status']=='diproses')?'selected':''; ?>>Diproses</option>
            <option value="siap_dikirim" <?= ($data['status']=='siap_dikirim')?'selected':''; ?>>Siap Dikirim</option>
          </select>
        </div>
        <button class="btn btn-primary"><i class="fas fa-save me-1"></i>Update Status</button>
        <a href="list.php" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </div>
</div>
<?php include "../../partials/footer.php"; ?>
</body>
</html>
