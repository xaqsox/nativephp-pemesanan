<?php
include "../../config/auth.php";
include "../../config/database.php";

// Ambil semua jenis pelanggan
$jenis = mysqli_query($conn, "SELECT * FROM jenis_pelanggan ORDER BY nama_jenis ASC");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id_jenis = mysqli_real_escape_string($conn, $_POST['id_jenis_pelanggan']);
  $nama = mysqli_real_escape_string($conn, $_POST['nama']);
  $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
  $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);

  mysqli_query($conn, "INSERT INTO pelanggan (id_jenis_pelanggan, nama, alamat, telepon) VALUES ('$id_jenis','$nama','$alamat','$telepon')");
  header("Location: list.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Pelanggan - AquaFresh</title>
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
       <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/dashboard.php"><i class="fas fa-house"></i></a></li>
        <li class="breadcrumb-item">Pelanggan</li>
        <li class="breadcrumb-item">Data Pelanggan</li>
        <li class="breadcrumb-item active" aria-current="page">Tambah Pelanggan</li>
      </ol>
    </nav>

    <div class="card">
      <div class="card-header text-white" style="background:#5D5CDE;">
        <div class="d-flex justify-content-between align-items-center">
          <h4 class="mb-0">Tambah Pelanggan </h4>
        </div>
      </div>
      <div class="card-body">
        <form method="post">
          <div class="mb-3">
            <label>Jenis Pelanggan</label>
            <select name="id_jenis_pelanggan" class="form-control" required>
              <option value="">-- Pilih Jenis Pelanggan --</option>
              <?php while($j = mysqli_fetch_assoc($jenis)): ?>
                <option value="<?= $j['id_jenis_pelanggan']; ?>"><?= htmlspecialchars($j['nama_jenis']); ?></option>
              <?php endwhile; ?>
            </select>
          </div>
          <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" required></textarea>
          </div>
          <div class="mb-3">
            <label>Telepon</label>
            <input type="text" name="telepon" class="form-control" required>
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
