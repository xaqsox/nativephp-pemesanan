<?php
include "../../config/auth.php";
include "../../config/database.php";

// Ambil pesanan yang belum dikirim
$pesanan = mysqli_query($conn, "
  SELECT p.id_pemesanan, pl.nama AS nama_pelanggan
  FROM pemesanan p
  LEFT JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
  WHERE p.id_pemesanan NOT IN (SELECT id_pemesanan FROM pengiriman)
  ORDER BY p.id_pemesanan DESC
");

// Ambil kurir
$kurir = mysqli_query($conn, "SELECT * FROM kurir ORDER BY nama ASC");

// Proses submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id_pemesanan = mysqli_real_escape_string($conn, $_POST['id_pemesanan']);
  $id_kurir = mysqli_real_escape_string($conn, $_POST['id_kurir']);
  $tanggal = date("Y-m-d");
  $status = "dikirim";

  mysqli_query($conn, "
    INSERT INTO pengiriman (id_pemesanan, id_kurir, tanggal_pengiriman, status_pengiriman)
    VALUES ('$id_pemesanan','$id_kurir','$tanggal','$status')
  ");

  header("Location: list.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Pengiriman - AquaFresh</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
   <style>
      .breadcrumb {
        background-color: #f8f9fa;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
      }
    </style>
</head>
<body>
<?php include "../../partials/header.php"; ?>
<div class="container-fluid">
  <div class="row">
    <?php include "../../partials/sidebar.php"; ?>
    <div class="col-md-10 p-4">
      <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/dashboard.php"><i class="fas fa-house"></i></a></li>
              <li class="breadcrumb-item">Pengiriman</li>
              <li class="breadcrumb-item">Data Pengiriman</li>
              <li class="breadcrumb-item active" aria-current="page">Tambah Pengiriman</li>
            </ol>
          </nav>

          <div class="card">
            <div class="card-header text-white" style="background:#5D5CDE;">
               <h4 class="mb-0">Tambah Pengiriman </h4>
             </div>
             <div class="card-body">
      <form method="post">
        <div class="mb-3">
          <label>Pesanan</label>
          <select name="id_pemesanan" class="form-control" required>
            <option value="">-- Pilih Pesanan --</option>
            <?php while($p = mysqli_fetch_assoc($pesanan)): ?>
              <option value="<?= $p['id_pemesanan']; ?>">#<?= $p['id_pemesanan']; ?> - <?= htmlspecialchars($p['nama_pelanggan']); ?></option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="mb-3">
          <label>Kurir</label>
          <select name="id_kurir" class="form-control" required>
            <option value="">-- Pilih Kurir --</option>
            <?php while($k = mysqli_fetch_assoc($kurir)): ?>
              <option value="<?= $k['id_kurir']; ?>"><?= htmlspecialchars($k['nama']); ?></option>
            <?php endwhile; ?>
          </select>
        </div>
      <div class="mb-3">
    <label>Tanggal Pengiriman</label>
    <input type="text" class="form-control" value="<?= date("Y-m-d"); ?>" readonly>
    </div>
        <button class="btn btn-success"><i class="fas fa-save me-1"></i>Simpan Pengiriman</button>
        <a href="list.php" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </div>
</div>
<?php include "../../partials/footer.php"; ?>
</body>
</html>
