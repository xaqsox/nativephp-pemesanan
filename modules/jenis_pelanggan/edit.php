<?php
include "../../config/auth.php";
include "../../config/database.php";

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM jenis_pelanggan WHERE id_jenis_pelanggan='$id'");
$data = mysqli_fetch_assoc($result);

if (!$data) {
  die("Data tidak ditemukan.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama = mysqli_real_escape_string($conn, $_POST['nama_jenis']);

  mysqli_query($conn, "UPDATE jenis_pelanggan SET nama_jenis='$nama' WHERE id_jenis_pelanggan='$id'");
  header("Location: list.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Jenis Pelanggan - AquaFresh</title>
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
            <li class="breadcrumb-item">Pelanggan</li>
            <li class="breadcrumb-item">Jenis Pelanggan</li>
            <li class="breadcrumb-item active" aria-current="page">Edit Jenis Pelanggan</li>
          </ol>
        </nav>

        <div class="card">
          <div class="card-header text-white" style="background:#5D5CDE;">
            <div class="d-flex justify-content-between align-items-center">
              <h4 class="mb-0">Jenis Pelanggan<h4>

              </div>
            </div>
            <div class="card-body">
              <form method="post">
                <div class="mb-3">
                  <label>Nama Jenis Pelanggan</label>
                  <input type="text" name="nama_jenis" class="form-control" value="<?= htmlspecialchars($data['nama_jenis']); ?>" required>
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
