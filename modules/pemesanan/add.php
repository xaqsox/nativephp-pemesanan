<?php
include "../../config/auth.php";
include "../../config/database.php";

// Ambil semua pelanggan
$pelanggan = mysqli_query($conn, "SELECT * FROM pelanggan ORDER BY nama ASC");

// Ambil semua produk air
$produk = mysqli_query($conn, "SELECT * FROM air_minum ORDER BY nama_produk ASC");

// Proses submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id_pelanggan = mysqli_real_escape_string($conn, $_POST['id_pelanggan']);
  $tanggal_pesan = date("Y-m-d H:i:s");
  $status = "pending";

  // Insert ke tabel pemesanan
  mysqli_query($conn, "INSERT INTO pemesanan (id_pelanggan, tanggal_pesan, status) VALUES ('$id_pelanggan','$tanggal_pesan','$status')");

  // Ambil ID pesanan baru
  $id_pemesanan = mysqli_insert_id($conn);

  // Loop data item
 foreach ($_POST['id_air'] as $i => $id_air) {
  $jumlah = mysqli_real_escape_string($conn, $_POST['jumlah'][$i]);
  $harga = mysqli_real_escape_string($conn, $_POST['harga'][$i]);
  $subtotal = $jumlah * $harga;

  // Tambahkan detail pemesanan
  mysqli_query($conn, "INSERT INTO detail_pesanan (id_pemesanan, id_air, jumlah, subtotal) VALUES ('$id_pemesanan','$id_air','$jumlah','$subtotal')");

  // Kurangi stok air
  mysqli_query($conn, "UPDATE air_minum SET stok = stok - $jumlah WHERE id_air = '$id_air'");
}


  header("Location: list.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Pemesanan - AquaFresh</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
      .breadcrumb {
        background-color: #f8f9fa;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
      }
    </style>
  <style>
    .table-form td { vertical-align: middle; }
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
              <li class="breadcrumb-item">Pemesanan</li>
              <li class="breadcrumb-item">Data Pemesanan</li>
              <li class="breadcrumb-item active" aria-current="page">Tambah Pemesanan</li>
            </ol>
          </nav>

          <div class="card">
            <div class="card-header text-white" style="background:#5D5CDE;">
               <h4 class="mb-0">Tambah Pemesanan </h4>
             </div>
             <div class="card-body">
      <form method="post">
        <div class="mb-3">
          <label>Pelanggan</label>
          <select name="id_pelanggan" class="form-control" required>
            <option value="">-- Pilih Pelanggan --</option>
            <?php while($p = mysqli_fetch_assoc($pelanggan)): ?>
              <option value="<?= $p['id_pelanggan']; ?>"><?= htmlspecialchars($p['nama']); ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <table class="table table-bordered table-form">
          <thead class="table-light">
            <tr>
              <th>Produk Air Minum</th>
              <th>Harga</th>
              <th>Jumlah</th>
              <th>Subtotal</th>
              <th><button type="button" class="btn btn-success btn-sm" id="addRow"><i class="fas fa-plus"></i></button></th>
            </tr>
          </thead>
          <tbody id="itemRows">
            <tr>
              <td>
                <select name="id_air[]" class="form-control air-select" required>
                  <option value="">-- Pilih Produk --</option>
                  <?php mysqli_data_seek($produk, 0); while($a = mysqli_fetch_assoc($produk)): ?>
                    <option value="<?= $a['id_air']; ?>" data-harga="<?= $a['harga']; ?>">
                      <?= htmlspecialchars($a['nama_produk']); ?>
                    </option>
                  <?php endwhile; ?>
                </select>
              </td>
              <td><input type="number" name="harga[]" class="form-control harga" readonly></td>
              <td><input type="number" name="jumlah[]" class="form-control jumlah" min="1" value="1"></td>
              <td><input type="number" name="subtotal[]" class="form-control subtotal" readonly></td>
              <td><button type="button" class="btn btn-danger btn-sm removeRow"><i class="fas fa-trash"></i></button></td>
            </tr>
          </tbody>
        </table>

        <button class="btn btn-success"><i class="fas fa-save me-1"></i>Simpan Pesanan</button>
        <a href="list.php" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
$(document).ready(function(){

  function updateSubtotal(row) {
    var harga = parseFloat(row.find(".harga").val()) || 0;
    var jumlah = parseInt(row.find(".jumlah").val()) || 0;
    var subtotal = harga * jumlah;
    row.find(".subtotal").val(subtotal);
  }

  // Saat produk dipilih
  $(document).on("change",".air-select",function(){
    var harga = $(this).find(':selected').data('harga') || 0;
    var row = $(this).closest('tr');
    row.find(".harga").val(harga);
    updateSubtotal(row);
  });

  // Saat jumlah diubah
  $(document).on("input",".jumlah",function(){
    var row = $(this).closest('tr');
    updateSubtotal(row);
  });

  // Tambah baris
  $("#addRow").click(function(){
    var newRow = $("#itemRows tr:first").clone();
    newRow.find("select").val("");
    newRow.find("input").val("");
    $("#itemRows").append(newRow);
  });

  // Hapus baris
  $(document).on("click",".removeRow",function(){
    if($("#itemRows tr").length > 1){
      $(this).closest("tr").remove();
    }else{
      alert("Minimal satu item.");
    }
  });
});
</script>
<?php include "../../partials/footer.php"; ?>
</body>
</html>