<?php
include "../../config/auth.php";
include "../../config/database.php";

// Ambil semua kategori
$jenis = mysqli_query($conn, "SELECT * FROM jenis_air_minum ORDER BY nama_jenis ASC");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id_jenis = mysqli_real_escape_string($conn, $_POST['id_jenis_air']);
  $nama = mysqli_real_escape_string($conn, $_POST['nama_produk']);
  $harga = mysqli_real_escape_string($conn, $_POST['harga']);
  $stok = mysqli_real_escape_string($conn, $_POST['stok']);

  mysqli_query($conn, "INSERT INTO air_minum (id_jenis_air, nama_produk, harga, stok) VALUES ('$id_jenis','$nama','$harga','$stok')");
  header("Location: list.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Air Minum - AquaFresh</title>
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
              <li class="breadcrumb-item">Air Minum</li>
              <li class="breadcrumb-item">Data Air Minum</li>
              <li class="breadcrumb-item active" aria-current="page">Tambah Air Minum</li>
            </ol>
          </nav>

          <div class="card">
            <div class="card-header text-white" style="background:#5D5CDE;">
               <h4 class="mb-0">Tambah Air Minum </h4>
             </div>
             <div class="card-body">
              <form method="post">
                <div class="mb-3">
                  <label>Jenis Air Minum</label>
                  <select name="id_jenis_air" class="form-control" required>
                    <option value="">-- Pilih Jenis Air --</option>
                    <?php while($j = mysqli_fetch_assoc($jenis)): ?>
                      <option value="<?= $j['id_jenis_air']; ?>"><?= htmlspecialchars($j['nama_jenis']); ?></option>
                    <?php endwhile; ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label>Nama Produk</label>
                  <input type="text" name="nama_produk" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label>Harga</label>
                  <input type="number" name="harga" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label>Stok</label>
                  <input type="number" name="stok" class="form-control" required>
                </div>
                <button class="btn btn-success"><i class="fas fa-save me-1"></i>Simpan</button>
                <a href="list.php" class="btn btn-secondary">Kembali</a>
              </form>
            </div>
          </div>
        </div>
        <?php include "../../partials/footer.php"; ?>
      </body>
      </html>
