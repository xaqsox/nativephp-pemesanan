<?php
include "../../config/auth.php";
include "../../config/database.php";

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM kurir WHERE id_kurir='$id'");
$data = mysqli_fetch_assoc($result);

if (!$data) {
  die("Data tidak ditemukan.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama = mysqli_real_escape_string($conn, $_POST['nama']);
  $kendaraan = mysqli_real_escape_string($conn, $_POST['kendaraan']);
  $plat_nomor = mysqli_real_escape_string($conn, $_POST['plat_nomor']);

  mysqli_query($conn, "UPDATE kurir SET nama='$nama', kendaraan='$kendaraan', plat_nomor='$plat_nomor' WHERE id_kurir='$id'");
  header("Location: list.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Kurir - AquaFresh</title>
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
            <li class="breadcrumb-item">Kurir</li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Kurir</li>
        </ol>
      </nav>

      <div class="card">
        <div class="card-header text-white" style="background:#5D5CDE;">
          <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Data Kurir<h4>

           </div>
         </div>
         <div class="card-body">
          <form method="post">
            <div class="mb-3">
              <label>Nama</label>
              <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['nama']); ?>" required>
            </div>
            <div class="mb-3">
              <label>Kendaraan</label>
              <input type="text" name="kendaraan" class="form-control" value="<?= htmlspecialchars($data['kendaraan']); ?>" required>
            </div>
            <div class="mb-3">
              <label>Plat Nomor</label>
              <input type="text" name="plat_nomor" class="form-control" value="<?= htmlspecialchars($data['plat_nomor']); ?>" required>
            </div>
            <button class="btn btn-primary"><i class="fas fa-save me-1"></i>Update</button>
            <a href="list.php" class="btn btn-secondary">Kembali</a>
          </form>
        </div>
      </div>
    </div>
    <?php include "../../partials/footer.php"; ?>
  </body>
  </html>
