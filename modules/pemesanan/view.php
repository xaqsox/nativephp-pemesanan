<?php
include "../../config/auth.php";
include "../../config/database.php";

$id = $_GET['id'];

// Ambil data header pesanan
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

// Ambil data detail item
$items = mysqli_query($conn, "
  SELECT d.*, a.nama_produk, a.harga
  FROM detail_pesanan d
  LEFT JOIN air_minum a ON d.id_air = a.id_air
  WHERE d.id_pemesanan='$id'
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Detail Pemesanan - AquaFresh</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<?php include "../../partials/header.php"; ?>
<div class="container-fluid">
  <div class="row">
    <?php include "../../partials/sidebar.php"; ?>
    <div class="col-md-10 p-4">
      <h3>Detail Pemesanan</h3>
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
        <input type="text" class="form-control" value="<?= htmlspecialchars($data['status']); ?>" readonly>
      </div>

      <h5>Daftar Produk:</h5>
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead class="table-light">
            <tr>
              <th>No</th>
              <th>Produk</th>
              <th>Harga Satuan</th>
              <th>Jumlah</th>
              <th>Subtotal</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $no=1; 
          $total=0;
          while($row = mysqli_fetch_assoc($items)):
            $total += $row['subtotal'];
          ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= htmlspecialchars($row['nama_produk']); ?></td>
              <td>Rp <?= number_format($row['harga']); ?></td>
              <td><?= $row['jumlah']; ?></td>
              <td>Rp <?= number_format($row['subtotal']); ?></td>
            </tr>
          <?php endwhile; ?>
          <tr>
            <th colspan="4" class="text-end">Total</th>
            <th>Rp <?= number_format($total); ?></th>
          </tr>
          </tbody>
        </table>
      </div>
      <a href="list.php" class="btn btn-secondary">Kembali</a>
    </div>
  </div>
</div>
<?php include "../../partials/footer.php"; ?>
</body>
</html>
