<?php
include "../../config/auth.php";
include "../../config/database.php";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $nama = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
  $role = mysqli_real_escape_string($conn, $_POST['role']);
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

  $cek = mysqli_query($conn, "SELECT * FROM pengguna WHERE username='$username'");
  if(mysqli_num_rows($cek) > 0){
    $error = "Username sudah terdaftar.";
  } else {
    mysqli_query($conn, "INSERT INTO pengguna (username, password, nama_lengkap, role) VALUES ('$username','$password','$nama','$role')");
    header("Location: list.php");
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Pengguna - AquaFresh</title>
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
          <li class="breadcrumb-item active" aria-current="page">Tambah Pengguna</li>
        </ol>
      </nav>

      <div class="card">
        <div class="card-header text-white" style="background:#5D5CDE;">
          <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Ubah Pengguna<h4>

           </div>
         </div>
         <div class="card-body">
      <?php if($error): ?>
      <div class="alert alert-danger"><?= $error; ?></div>
      <?php endif; ?>
      <form method="post">
        <div class="mb-3">
          <label>Username</label>
          <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Nama Lengkap</label>
          <input type="text" name="nama_lengkap" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Role</label>
          <select name="role" class="form-control">
            <option value="owner">Owner</option>
            <option value="admin">Admin</option>
            <option value="kurir">Kurir</option>
          </select>
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
