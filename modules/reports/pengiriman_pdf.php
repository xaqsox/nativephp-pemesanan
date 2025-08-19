<?php
require_once '../../vendor/autoload.php';
include "../../config/database.php";

use Dompdf\Dompdf;

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

$html = '<h3 style="text-align:center">Laporan Pengiriman</h3>';
$html .= '<p>Periode: ' . date('d/m/Y', strtotime($from)) . ' s.d. ' . date('d/m/Y', strtotime($to)) . '</p>';
$html .= '<table border="1" cellpadding="6" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>No. Pesanan</th>
                <th>Pelanggan</th>
                <th>Kurir</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>';

$no = 1;
while($row = mysqli_fetch_assoc($query)) {
  $html .= '<tr>
              <td>' . $no++ . '</td>
              <td>' . date('d-m-Y', strtotime($row['tanggal_pengiriman'])) . '</td>
              <td>#' . $row['id_pemesanan'] . '</td>
              <td>' . htmlspecialchars($row['nama_pelanggan']) . '</td>
              <td>' . htmlspecialchars($row['nama_kurir']) . '</td>
              <td>' . ucfirst($row['status_pengiriman']) . '</td>
            </tr>';
}

$html .= '</tbody></table>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream('laporan_pengiriman.pdf', array("Attachment" => false));
?>
