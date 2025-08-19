<?php
include "../../config/auth.php";
include "../../config/database.php";

$result = mysqli_query($conn, "
  SELECT p.*, pl.nama AS nama_pelanggan
  FROM pemesanan p
  LEFT JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
  WHERE DATE(p.tanggal_pesan) = CURDATE()
  ORDER BY p.id_pemesanan DESC
  ");

  ?>
  <!DOCTYPE html>
  <html lang="id">
  <head>
    <meta charset="UTF-8">
    <title>Data Pemesanan - AquaFresh</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
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
            
              <li class="breadcrumb-item active" aria-current="page">Data Pemesanan</li>
            </ol>
          </nav>

          <div class="card">
            <div class="card-header text-white" style="background:#5D5CDE;">
              <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Data Pemesanan</h4>
                 <h4 class="mb-0"><a href="add.php" class="btn btn-transparent text-white">Tambah Pemesanan</a></h4>
               </div>
             </div>
             <div class="card-body">
           
              <div class="table-responsive">
                <table id="datatable" class="table table-bordered">
                  <thead class="table-light">
                    <tr>
                      <th>No</th>
                      <th>Tanggal</th>
                      <th>Pelanggan</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no=1; while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                      <td><?= $no++; ?></td>
                      <td><?= date("d-m-Y H:i", strtotime($row['tanggal_pesan'])); ?></td>
                      <td><?= htmlspecialchars($row['nama_pelanggan']); ?></td>
                      <td>
                        <?php if($row['status']=='pending'): ?>
                          <span class="badge bg-warning text-dark">Pending</span>
                        <?php elseif($row['status']=='diproses'): ?>
                          <span class="badge bg-primary">Diproses</span>
                        <?php elseif($row['status']=='siap_dikirim'): ?>
                          <span class="badge bg-success">Siap Dikirim</span>
                        <?php else: ?>
                          <?= htmlspecialchars($row['status']); ?>
                        <?php endif; ?>
                      </td>
                      <td>
                        <a href="view.php?id=<?= $row['id_pemesanan']; ?>" class="btn btn-sm btn-info">
                          <i class="fas fa-eye"></i>
                        </a>
                        <a href="edit.php?id=<?= $row['id_pemesanan']; ?>" class="btn btn-sm btn-warning">
                          <i class="fas fa-edit"></i>
                        </a>
                        <a href="delete.php?id=<?= $row['id_pemesanan']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus pesanan ini?');">
                          <i class="fas fa-trash"></i>
                        </a>
                      </td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
      <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
      <script>
        $(document).ready(function() {
          $('#datatable').DataTable();
        });
      </script>
      <?php include "../../partials/footer.php"; ?>
    </body>
    </html>
