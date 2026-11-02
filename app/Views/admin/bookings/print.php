<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Struk Reservasi <?= esc($booking['booking_code']) ?></title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
      color: #111;
      font-size: 14px;
    }
    .receipt-box {
      max-width: 600px;
      margin: 0 auto;
      border: 1px dashed #777;
      padding: 24px;
      border-radius: 6px;
    }
    .header {
      text-align: center;
      border-bottom: 2px solid #222;
      padding-bottom: 12px;
      margin-bottom: 16px;
    }
    .header h2 {
      margin: 0 0 4px 0;
      color: #047857;
    }
    .meta-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 8px;
    }
    .table-detail {
      width: 100%;
      border-collapse: collapse;
      margin: 16px 0;
    }
    .table-detail th, .table-detail td {
      border-bottom: 1px solid #ddd;
      padding: 8px 4px;
      text-align: left;
    }
    .table-detail th {
      background-color: #f7f7f7;
    }
    .total-row {
      font-size: 16px;
      font-weight: bold;
      text-align: right;
      padding-top: 10px;
    }
    .footer {
      text-align: center;
      font-size: 12px;
      color: #555;
      margin-top: 20px;
      border-top: 1px dashed #aaa;
      padding-top: 10px;
    }
    .no-print {
      text-align: center;
      margin-bottom: 15px;
    }
    .btn {
      padding: 8px 16px;
      background: #047857;
      color: #fff;
      border: none;
      cursor: pointer;
      border-radius: 4px;
      font-weight: bold;
    }
    @media print {
      .no-print {
        display: none;
      }
      .receipt-box {
        border: none;
        padding: 0;
      }
    }
  </style>
</head>
<body>

  <div class="no-print">
    <button class="btn" onclick="window.print()">Cetak Struk Sekarang</button>
    <button class="btn" style="background:#555;" onclick="window.close()">Tutup Jendela</button>
  </div>

  <div class="receipt-box">
    <div class="header">
      <h2>ARENASPORT CENTER</h2>
      <div>Pusat Gelanggang Olahraga Modern</div>
      <div style="font-size:12px; color:#555;">Jl. Gelanggang Olahraga No. 88 &bull; Telp: 0812-3456-7890</div>
    </div>

    <div class="meta-row">
      <span>Kode Booking: <strong><?= esc($booking['booking_code']) ?></strong></span>
      <span>Tanggal Cetak: <?= date('d/m/Y H:i') ?></span>
    </div>

    <div class="meta-row">
      <span>Nama Pemesan: <strong><?= esc($booking['customer_name']) ?></strong></span>
      <span>No. HP: <?= esc($booking['customer_phone']) ?></span>
    </div>

    <table class="table-detail">
      <thead>
        <tr>
          <th>Keterangan</th>
          <th>Jadwal Main</th>
          <th>Durasi</th>
          <th style="text-align:right;">Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <strong><?= esc($booking['court_name']) ?></strong><br>
            <span style="font-size:12px; color:#555;"><?= esc($booking['category_name']) ?> (<?= esc($booking['court_type']) ?>)</span>
          </td>
          <td>
            <?= date('d/m/Y', strtotime($booking['booking_date'])) ?><br>
            <?= substr($booking['start_time'], 0, 5) ?> - <?= substr($booking['end_time'], 0, 5) ?> WIB
          </td>
          <td><?= $booking['total_hours'] ?> Jam</td>
          <td style="text-align:right; font-weight:bold;"><?= rupiah($booking['total_price']) ?></td>
        </tr>
      </tbody>
    </table>

    <div class="meta-row" style="margin-top:12px;">
      <span>Metode Bayar: <strong><?= esc($booking['payment_method']) ?></strong></span>
      <span>Status: <strong><?= strtoupper($booking['payment_status'] === 'paid' ? 'LUNAS' : $booking['payment_status']) ?></strong></span>
    </div>

    <div class="total-row">
      TOTAL TAGIHAN: <?= rupiah($booking['total_price']) ?>
    </div>

    <div class="footer">
      <div>Terima kasih atas kunjungan Anda di ArenaSport!</div>
      <div>Harap hadir 15 menit sebelum waktu pemesanan dimulai. Selamat berolahraga!</div>
    </div>
  </div>

</body>
</html>
