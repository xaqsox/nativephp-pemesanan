<?php
include "../../config/auth.php";
include "../../config/database.php";

$result = mysqli_query($conn, "
  SELECT pg.*, p.id_pemesanan, pl.nama AS nama_pelanggan, k.nama AS nama_kurir
  FROM pengiriman pg
  LEFT JOIN pemesanan p ON pg.id_pemesanan = p.id_pemesanan
  LEFT JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
  LEFT JOIN kurir k ON pg.id_kurir = k.id_kurir
  ORDER BY pg.id_pengiriman DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Pengiriman - AquaFresh</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
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
              <li class="breadcrumb-item">Pengiriman</li>
              
            </ol>
          </nav>

          <div class="card">
            <div class="card-header text-white" style="background:#5D5CDE;">
              <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Data Pengiriman<h4>
                 <h4 class="mb-0"><a href="add.php" class="btn btn-transparent text-white">Tambah Pengriman</a></h4>
               </div>
             </div>
             <div class="card-body">
    
      <div class="table-responsive">
        <table id="datatable" class="table table-bordered">
          <thead class="table-light">
            <tr>
              <th>No</th>
              <th>No. Pesanan</th>
              <th>Pelanggan</th>
              <th>Kurir</th>
              <th>Tanggal Pengiriman</th>
              <th>Status Pengiriman</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
          <?php $no=1; while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?= $no++; ?></td>
              <td>#<?= htmlspecialchars($row['id_pemesanan']); ?></td>
              <td><?= htmlspecialchars($row['nama_pelanggan']); ?></td>
              <td><?= htmlspecialchars($row['nama_kurir']); ?></td>
              <td><?= date("d-m-Y", strtotime($row['tanggal_pengiriman'])); ?></td>
              <td>
                <?php if($row['status_pengiriman']=='dikirim'): ?>
                  <span class="badge bg-warning text-dark">Dikirim</span>
                <?php elseif($row['status_pengiriman']=='selesai'): ?>
                  <span class="badge bg-success">Selesai</span>
                <?php elseif($row['status_pengiriman']=='gagal'): ?>
                  <span class="badge bg-danger">Gagal</span>
                <?php else: ?>
                  <?= htmlspecialchars($row['status_pengiriman']); ?>
                <?php endif; ?>
              </td>
              <td>
                <a href="edit.php?id=<?= $row['id_pengiriman']; ?>" class="btn btn-sm btn-warning">
                  <i class="fas fa-edit"></i>
                </a>
                <a href="delete.php?id=<?= $row['id_pengiriman']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus pengiriman ini?');">
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
