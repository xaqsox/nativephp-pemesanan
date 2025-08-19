<?php
include "../../config/auth.php";
include "../../config/database.php";

$id = $_GET['id'];

// Ambil data pengiriman
$result = mysqli_query($conn, "
  SELECT pg.*, p.id_pemesanan, pl.nama AS nama_pelanggan, k.nama AS nama_kurir
  FROM pengiriman pg
  LEFT JOIN pemesanan p ON pg.id_pemesanan = p.id_pemesanan
  LEFT JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
  LEFT JOIN kurir k ON pg.id_kurir = k.id_kurir
  WHERE pg.id_pengiriman='$id'
");
$data = mysqli_fetch_assoc($result);

if (!$data) {
  die("Data tidak ditemukan.");
}

// Proses update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $status = mysqli_real_escape_string($conn, $_POST['status_pengiriman']);
  mysqli_query($conn, "UPDATE pengiriman SET status_pengiriman='$status' WHERE id_pengiriman='$id'");
  header("Location: list.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Ubah Status Pengiriman - AquaFresh</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<?php include "../../partials/header.php"; ?>
<div class="container-fluid">
  <div class="row">
    <?php include "../../partials/sidebar.php"; ?>
    <div class="col-md-10 p-4">
      <h3>Ubah Status Pengiriman</h3>
      <form method="post">
        <div class="mb-3">
          <label>No. Pesanan</label>
          <input type="text" class="form-control" value="#<?= htmlspecialchars($data['id_pemesanan']); ?>" readonly>
        </div>
        <div class="mb-3">
          <label>Pelanggan</label>
          <input type="text" class="form-control" value="<?= htmlspecialchars($data['nama_pelanggan']); ?>" readonly>
        </div>
        <div class="mb-3">
          <label>Kurir</label>
          <input type="text" class="form-control" value="<?= htmlspecialchars($data['nama_kurir']); ?>" readonly>
        </div>
        <div class="mb-3">
          <label>Tanggal Pengiriman</label>
          <input type="text" class="form-control" value="<?= date("d-m-Y", strtotime($data['tanggal_pengiriman'])); ?>" readonly>
        </div>
        <div class="mb-3">
          <label>Status Pengiriman</label>
          <select name="status_pengiriman" class="form-control" required>
            <option value="dikirim" <?= ($data['status_pengiriman']=='dikirim')?'selected':''; ?>>Dikirim</option>
            <option value="selesai" <?= ($data['status_pengiriman']=='selesai')?'selected':''; ?>>Selesai</option>
            <option value="gagal" <?= ($data['status_pengiriman']=='gagal')?'selected':''; ?>>Gagal</option>
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
