<?php
include "../../config/auth.php";
include "../../config/database.php";

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM pengguna WHERE id_pengguna='$id'");
$data = mysqli_fetch_assoc($result);

if (!$data) {
  die("Data tidak ditemukan.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
  $role = mysqli_real_escape_string($conn, $_POST['role']);

  if(!empty($_POST['password'])){
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    mysqli_query($conn, "UPDATE pengguna SET nama_lengkap='$nama', role='$role', password='$password' WHERE id_pengguna='$id'");
  } else {
    mysqli_query($conn, "UPDATE pengguna SET nama_lengkap='$nama', role='$role' WHERE id_pengguna='$id'");
  }
  header("Location: list.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Pengguna - AquaFresh</title>
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
          <li class="breadcrumb-item">Pengguna</li>
          <li class="breadcrumb-item active" aria-current="page">Ubah Pengguna</li>
        </ol>
      </nav>

      <div class="card">
        <div class="card-header text-white" style="background:#5D5CDE;">
          <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Ubah Pengguna<h4>

           </div>
         </div>
         <div class="card-body">
          <form method="post">
            <div class="mb-3">
              <label>Username</label>
              <input type="text" class="form-control" value="<?= htmlspecialchars($data['username']); ?>" disabled>
            </div>
            <div class="mb-3">
              <label>Nama Lengkap</label>
              <input type="text" name="nama_lengkap" class="form-control" value="<?= htmlspecialchars($data['nama_lengkap']); ?>" required>
            </div>
            <div class="mb-3">
              <label>Password Baru (kosongkan jika tidak diubah)</label>
              <input type="password" name="password" class="form-control">
            </div>
            <div class="mb-3">
              <label>Role</label>
              <select name="role" class="form-control">
                <option value="owner" <?= $data['role']=='owner'?'selected':''; ?>>Owner</option>
                <option value="admin" <?= $data['role']=='admin'?'selected':''; ?>>Admin</option>
                <option value="kurir" <?= $data['role']=='kurir'?'selected':''; ?>>Kurir</option>
              </select>
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
