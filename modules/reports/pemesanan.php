<?php
include "../../config/auth.php";
include "../../config/database.php";
//include "../../config/role_check.php";
//only(['owner', 'admin']);

$from = $_GET['from'] ?? date('Y-m-01');
$to = $_GET['to'] ?? date('Y-m-d');

$query = mysqli_query($conn, "
  SELECT p.id_pemesanan, p.tanggal_pesan, pl.nama AS nama_pelanggan,
  SUM(dp.jumlah) AS total_item,
  SUM(dp.subtotal) AS total_harga,
  p.status
  FROM pemesanan p
  LEFT JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
  LEFT JOIN detail_pesanan dp ON p.id_pemesanan = dp.id_pemesanan
  WHERE DATE(p.tanggal_pesan) BETWEEN '$from' AND '$to'
  GROUP BY p.id_pemesanan
  ORDER BY p.tanggal_pesan DESC
  ");
  ?>
  <!DOCTYPE html>
  <html lang="id">
  <head>
    <meta charset="UTF-8">
    <title>Laporan Pemesanan</title>
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
            <li class="breadcrumb-item active" aria-current="page">Laporan Pemesanan</li>
          </ol>
        </nav>

        <div class="card">
          <div class="card-header text-white" style="background:#5D5CDE;">
           <h4 class="mb-0">Laporan Pemesanan </h4>
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
              <a href="pemesanan_pdf.php?from=<?= $from ?>&to=<?= $to ?>" class="btn btn-danger" target="_blank">
                <i class="fas fa-file-pdf"></i> Cetak PDF
              </a>
            </div>
          </form>

          <div class="table-responsive">
            <table class="table table-bordered">
              <thead class="table-light">
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Pelanggan</th>
                  <th>Total Item</th>
                  <th>Total Harga</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php $no=1; while($row = mysqli_fetch_assoc($query)): ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= date("d-m-Y", strtotime($row['tanggal_pesan'])) ?></td>
                  <td><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
                  <td><?= $row['total_item'] ?></td>
                  <td>Rp<?= number_format($row['total_harga'], 0, ',', '.') ?></td>
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
  </div>
  <?php include "../../partials/footer.php"; ?>
</body>
</html>
