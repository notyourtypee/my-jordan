<?php
  include "../functions.php";
  cekAdminLogin();
  
  $idPesanan = $_GET['idPesanan'];
  $pesanan = query("SELECT * FROM `pesanan` WHERE id_pesanan='$idPesanan'")[0];
  $ukurans = explode(",", $pesanan['ukurans']);
  $produks_id = explode(",", $pesanan['produks_id']);

  $produks = [];
  foreach ($produks_id as $index => $p) {
    $produks[] = query("SELECT * FROM `produk` WHERE id_produk=$p")[0];
  }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>infoPesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
    <!-- css -->
    <link rel="stylesheet" href="css/pesanan-show.css" />
    <!-- icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css" />
  </head>
  <body>
    <!-- Navbar -->
    <?php include "navbar.php" ?>
    
    <!-- slide -->
    <?php include "carousel.php" ?>

    <section id="header-informasi">
      <div class="container">
        <div class="row shadow p-5 justify-content-center">
          <div class="col-md-11 text-center">
            <h3>Informasi Pesanan</h3>
          </div>
        </div>
      </div>
    </section>

    <section id="informasi">
      <div class="container">
        <div class="row card shadow p-4 mt-3">
          <div class="col-md-12">
            <h4 class="card-header">Informasi</h4>
            <div class="card-body">
              <div class="col-6 col-md-6">
                <table class="table table-borderless table-responsive">
                  <p><strong>Pembeli :</strong></p>
                  <tbody>
                    <tr>
                      <td>Nama Pemesan</td>
                      <td>:</td>
                      <td><?= $pesanan['nama_lengkap'] ?></td>
                    </tr>
                    <tr>
                      <td>Email</td>
                      <td>:</td>
                      <td><?= $pesanan['email'] ?></td>
                    </tr>
                    <tr>
                      <td>No.Hp</td>
                      <td>:</td>
                      <td><?= $pesanan['phone'] ?></td>
                    </tr>
                    <tr>
                      <td>Alamat Pemesan</td>
                      <td>:</td>
                      <td><?= $pesanan['alamat'] ?></td>
                    </tr>
                    <tr>
                      <td>Tanggal Pemesanan</td>
                      <td>:</td>
                      <td><?= $pesanan['tanggal_pembelian'] ?></td>
                    </tr>
                    <tr>
                      <td>Total Bayar</td>
                      <td>:</td>
                      <td>Rp. <?= number_format($pesanan['total'], 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                      <td>Pembayaran</td>
                      <td>:</td>
                      <td>
                        <?php if ($pesanan['pembayaran'] == 1) :?>
                          BCA
                        <?php elseif($pesanan['pembayaran'] == 2): ?>
                          BNI
                        <?php elseif($pesanan['pembayaran'] == 3): ?>
                          BRI
                        <?php elseif($pesanan['pembayaran'] == 4): ?>
                          Mandiri
                        <?php endif ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Total Bayar</td>
                      <td>:</td>
                      <td>Rp. <?= number_format($pesanan['total'], 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                      <td>Jumlah Pesanan</td>
                      <td>:</td>
                      <td><?= substr_count($pesanan['produks_id'], ",")+1 ?></td>
                    </tr>
                  </tbody>
                </table>
                <table class="table table-borderless table-responsive">
                  <p><strong>Produk :</strong></p>
                  <tbody>
                    <?php foreach ($produks as $index => $p) : ?>
                      <tr>
                        <td colspan="3" class="fw-bold">Produk ke <?= $index+1 ?></td>
                      </tr>
                      <tr>
                        <td>ID Produk</td>
                        <td>:</td>
                        <td>#<?= $p['id_produk'] ?></td>
                      </tr>
                      <tr>
                        <td>Nama Produk</td>
                        <td>:</td>
                        <td><?= $p['nama_produk'] ?></td>
                      </tr>
                      <tr>
                        <td>Size</td>
                        <td>:</td>
                        <td><?= $ukurans[$index] ?></td>
                      </tr>
                      <tr>
                        <td>Warna</td>
                        <td>:</td>
                        <td><?= $p['warna'] ?></td>
                      </tr>
                      <tr>
                        <td>Harga</td>
                        <td>:</td>
                        <td>Rp. <?= number_format($p['harga'], 0, ',', '.'); ?></td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div>
              <button type="button" class="btn btn-primary" style="--bs-btn-padding-y: 0.25rem; --bs-btn-padding-x: 0.5rem; --bs-btn-font-size: 0.75rem">
                <a href="pesanan-index.php">Back</a>
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>
