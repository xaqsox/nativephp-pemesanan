<?php
include "config/auth.php";
include "config/database.php";

$role = $_SESSION['role'];
$nama = $_SESSION['nama_lengkap'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<?php include "partials/header.php"; ?>
<div class="container-fluid">
  <div class="row">
    <?php include "partials/sidebar.php"; ?>
    <div class="col-md-10 p-4">
      <h3>Selamat Datang, <?= htmlspecialchars($nama) ?></h3>
      <p class="lead">Anda login sebagai <strong><?= ucfirst($role) ?></strong>.</p>

      <?php if ($role == 'owner' || $role == 'admin'): ?>
      <div class="row">
        <div class="col-md-4">
          <div class="card text-bg-primary mb-3">
            <div class="card-body">
              <h5 class="card-title">Total Pengguna</h5>
              <?php
              $res = mysqli_query($conn, "SELECT COUNT(*) AS total FROM pengguna");
              $data = mysqli_fetch_assoc($res);
              ?>
              <p class="display-6"><?= $data['total'] ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-bg-success mb-3">
            <div class="card-body">
              <h5 class="card-title">Total Pelanggan</h5>
              <?php
              $res = mysqli_query($conn, "SELECT COUNT(*) AS total FROM pelanggan");
              $data = mysqli_fetch_assoc($res);
              ?>
              <p class="display-6"><?= $data['total'] ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-bg-warning mb-3">
            <div class="card-body">
              <h5 class="card-title">Pesanan Hari Ini</h5>
              <?php
              $today = date('Y-m-d');
              $res = mysqli_query($conn, "SELECT COUNT(*) AS total FROM pemesanan WHERE DATE(tanggal_pesan) = '$today'");
              $data = mysqli_fetch_assoc($res);
              ?>
              <p class="display-6"><?= $data['total'] ?></p>
            </div>
          </div>
        </div>
      </div>

      <!-- Tabel Pesanan Terbaru -->
      <div class="card">
        <div class="card-header bg-secondary text-white">
          <h5 class="mb-0">Pesanan Terbaru</h5>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-striped table-bordered mb-0">
              <thead class="table-light">
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Pelanggan</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $result = mysqli_query($conn, "
                  SELECT p.tanggal_pesan, p.status, pl.nama
                  FROM pemesanan p
                  LEFT JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
                  ORDER BY p.tanggal_pesan DESC
                  LIMIT 5
                ");
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)):
                ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= date('d-m-Y H:i', strtotime($row['tanggal_pesan'])) ?></td>
                  <td><?= htmlspecialchars($row['nama']) ?></td>
                  <td>
                    <?php if($row['status']=='pending'): ?>
                      <span class="badge bg-warning text-dark">Pending</span>
                    <?php elseif($row['status']=='diproses'): ?>
                      <span class="badge bg-primary">Diproses</span>
                    <?php else: ?>
                      <span class="badge bg-success">Siap Dikirim</span>
                    <?php endif; ?>
                  </td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <?php endif; ?>

      <?php if ($role == 'pelanggan'): ?>
        <div class="alert alert-info">
          Gunakan menu <strong>Pemesanan</strong> untuk melakukan pemesanan air galon.
        </div>
      <?php endif; ?>

      <?php if ($role == 'kurir'): ?>
        <div class="alert alert-info">
          Gunakan menu <strong>Tracking</strong> untuk melihat pesanan yang harus dikirim.
        </div>
      <?php endif; ?>

    </div>
  </div>
</div>
<?php include "partials/footer.php"; ?>
</body>
</html>
