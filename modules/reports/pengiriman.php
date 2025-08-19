<?php
include "../../config/auth.php";
include "../../config/database.php";
//include "../../config/role_check.php";
//only(['owner', 'admin']);

$from = $_GET['from'] ?? date('Y-m-01');
$to = $_GET['to'] ?? date('Y-m-d');

$query = mysqli_query($conn, "
  SELECT pg.id_pengiriman, pg.tanggal_pengiriman, pg.status_pengiriman,
         k.nama AS nama_kurir,
         p.id_pemesanan, pl.nama AS nama_pelanggan
  FROM pengiriman pg
  LEFT JOIN kurir k ON pg.id_kurir = k.id_kurir
  LEFT JOIN pemesanan p ON pg.id_pemesanan = p.id_pemesanan
  LEFT JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
  WHERE DATE(pg.tanggal_pengiriman) BETWEEN '$from' AND '$to'
  ORDER BY pg.tanggal_pengiriman DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Pengiriman</title>
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
        <li class="breadcrumb-item active" aria-current="page">Laporan Pengiriman</li>
      </ol>
    </nav>

    <div class="card">
      <div class="card-header text-white" style="background:#5D5CDE;">
       <h4 class="mb-0">Laporan Pengiriman </h4>
     </div>
     <div class="card-body">
      <form class="row row-cols-lg-auto g-3 align-items-end mb-3" method="get">
        <div class="col">
          <label>Dari Tanggal</label>
          <input type="date" name="from" value="<?= $from ?>" class="form-control" required>
        </div>
        <div class="col">
          <label>Sampai Tanggal</label>
          <input type="date" name="to" value="<?= $to ?>" class="form-control" required>
        </div>
        <div class="col">
          <button class="btn btn-primary">Tampilkan</button>
          <a href="pengiriman_pdf.php?from=<?= $from ?>&to=<?= $to ?>" class="btn btn-danger" target="_blank">
            <i class="fas fa-file-pdf"></i> Cetak PDF
          </a>
        </div>
      </form>

      <div class="table-responsive">
        <table class="table table-bordered">
          <thead class="table-light">
            <tr>
              <th>No</th>
              <th>Tanggal Pengiriman</th>
              <th>No. Pesanan</th>
              <th>Pelanggan</th>
              <th>Kurir</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php $no=1; while($row = mysqli_fetch_assoc($query)): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= date("d-m-Y", strtotime($row['tanggal_pengiriman'])) ?></td>
                <td>#<?= $row['id_pemesanan'] ?></td>
                <td><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
                <td><?= htmlspecialchars($row['nama_kurir']) ?></td>
                <td>
                  <?php if($row['status_pengiriman']=='dikirim'): ?>
                    <span class="badge bg-warning text-dark">Dikirim</span>
                  <?php elseif($row['status_pengiriman']=='selesai'): ?>
                    <span class="badge bg-success">Selesai</span>
                  <?php else: ?>
                    <span class="badge bg-danger">Gagal</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php include "../../partials/footer.php"; ?>
</body>
</html>
