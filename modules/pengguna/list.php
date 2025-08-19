<?php
include "../../config/auth.php";
include "../../config/database.php";
$result = mysqli_query($conn, "SELECT * FROM pengguna ORDER BY id_pengguna ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Pengguna - AquaFresh</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <!-- DataTables CSS -->
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
        <nav aria-label="breadcrumb" class="mb-3">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/dashboard.php"><i class="fas fa-house"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">Pengguna</li>
          </ol>
        </nav>

        <div class="card">
          <div class="card-header text-white" style="background:#5D5CDE;">
            <div class="d-flex justify-content-between align-items-center">
              <h4 class="mb-0">Data Pengguna<h4>
               <h4 class="mb-0"><a href="add.php" class="btn btn-transparent text-white">Tambah Pengguna</a></h4>
             </div>
           </div>
           <div class="card-body">

            <?php if (isset($_GET['msg'])): ?>
              <div class="alert alert-success"><?= htmlspecialchars($_GET['msg']) ?></div>
            <?php endif; ?>
            <div class="table-responsive">
              <table id="datatable" class="table table-bordered">
                <thead class="table-light">
                  <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Nama Lengkap</th>
                    <th>Role</th>
               
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no=1; while($row = mysqli_fetch_assoc($result)): ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['username']); ?></td>
                    <td><?= htmlspecialchars($row['nama_lengkap']); ?></td>
                    <td><?= htmlspecialchars($row['role']); ?></td>
                   
                    <td>
                      <a href="edit.php?id=<?= $row['id_pengguna']; ?>" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i>
                      </a>
                      <a href="delete.php?id=<?= $row['id_pengguna']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus pengguna ini?');">
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
<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
  $(document).ready(function() {
    $('#datatable').DataTable({
      "language": {
        "search": "Cari:",
        "lengthMenu": "Tampilkan _MENU_ data",
        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        "paginate": {
          "previous": "Sebelumnya",
          "next": "Berikutnya"
        }
      }
    });
  });
</script>
<?php include "../../partials/footer.php"; ?>
</body>
</html>
