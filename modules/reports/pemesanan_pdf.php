<?php
require_once '../../vendor/autoload.php';
include "../../config/database.php";

use Dompdf\Dompdf;

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

$html = '<h3 style="text-align:center">Laporan Pemesanan</h3>';
$html .= '<p>Periode: ' . date('d/m/Y', strtotime($from)) . ' s.d. ' . date('d/m/Y', strtotime($to)) . '</p>';
$html .= '<table border="1" cellpadding="6" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Total Item</th>
                <th>Total Harga</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>';

$no = 1;
while($row = mysqli_fetch_assoc($query)) {
  $html .= '<tr>
              <td>' . $no++ . '</td>
              <td>' . date('d-m-Y', strtotime($row['tanggal_pesan'])) . '</td>
              <td>' . htmlspecialchars($row['nama_pelanggan']) . '</td>
              <td>' . $row['total_item'] . '</td>
              <td>Rp' . number_format($row['total_harga'], 0, ',', '.') . '</td>
              <td>' . ucfirst($row['status']) . '</td>
            </tr>';
}

$html .= '</tbody></table>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream('laporan_pemesanan.pdf', array("Attachment" => false));
?>
