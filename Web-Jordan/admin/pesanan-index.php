<?php
  include "../functions.php";
  cekAdminLogin();
  
  $pesanan = query("SELECT * FROM `pesanan` ORDER BY tanggal_pembelian ASC");

  if (isset($_GET['start']) & isset($_GET['end'])) {
    $start_date = $_GET['start'];
    $end_date = $_GET['end'];
    $pesanan = query("SELECT * FROM pesanan WHERE tanggal_pembelian >= '$start_date' AND tanggal_pembelian <= '$end_date' ORDER BY tanggal_pembelian ASC");
  }

  if(isset($_POST["hapus"])){
    $id = $_POST["id"];
    $result = mysqli_query($conn, "DELETE FROM `pesanan` WHERE id_pesanan='$id'");
    if($result){
      header("Location: pesanan-index.php");
      exit;
    }
  }

  if(isset($_POST['filter'])){
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    // $query = "SELECT * FROM pesanan WHERE tanggal_pembelian >= '$start_date' AND tanggal_pembelian <= '$end_date' ORDER BY tanggal_pembelian ASC";
    
    header("Location: pesanan-index.php?start=$start_date&end=$end_date");
  }


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
    <!-- css -->
    <link rel="stylesheet" href="css/pesanan-index.css" />
    <!-- icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css" />

  </head>
  <body>
    <!-- Navbar -->
    <?php include "navbar.php" ?>
    
    <!-- slide -->
    <?php include "carousel.php" ?>

    <!-- produk -->
    <section id="headerPesanan">
      <div class="container-fluid card shadow">
        <div class="row p-3">
          <div class="col-md-12">
            <h3>Pesanan</h3>
            <p>Informasi Pesanan Pembelian Produk</p>
          </div>
          <form action="" method="post" class="col-md-12 d-flex flex-wrap align-items-end">
            <div class="mb-3 me-2">
              <label for="start_date" class="form-label">Tanggal Awal</label>
              <input type="date" name="start_date" class="form-control" id="start_date" required>
            </div>
            <div class="mb-3 me-2">
              <label for="end_date" class="form-label">Tanggal Akhir</label>
              <input type="date" name="end_date" class="form-control" id="end_date" required>
            </div>
            <div class="mb-3 me-2">
              <button type="submit" name="filter" class="btn btn-primary">Tampilkan</button>
            </div>
          </form>
        </div>
      </div>
    </section>

    <section class="produk">
      <div class="container-fluid card shadow my-3">
        <div class="row">
          <div class="col-md-12 p-4">
            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thead>
                  <tr>
                    <th class="col-md-0">No</th>
                    <th class="col-md-4">ID</th>
                    <th class="col-md-4">Tanggal</th>
                    <th class="col-md-4">Nama</th>
                    <th class="col-md-4 action-header">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($pesanan as $index => $p): ?>
                  <tr>
                    <th scope="row"><?= $index+1; ?></th>
                    <td>#<?= $p['id_pesanan'] ?></td>
                    <td style="white-space: nowrap;"><?= $p['tanggal_pembelian'] ?></td>
                    <td style="white-space: nowrap;"><?= $p['nama_lengkap'] ?></td>
                    <td class="d-flex action-content">
                      <a href="pesanan-show.php?idPesanan=<?= $p['id_pesanan'] ?>"><span class="badge text-bg-info">Informasi</span></a>
                      <form action="" method="post" class="d-inline">
                        <input type="hidden" name="id" value="<?= $p['id_pesanan'] ?>">
                        <button type="submit" name="hapus" class="border-0 bg-transparent" onclick="return confirm('Yakin Ingin Menghapus?')">
                          <span class="badge text-bg-danger">Hapus</span>
                        </button>
                      </form>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
              <button onclick="window.print()" class="btn btn-primary">Cetak Laporan</button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="print">
      <div class="container">
        <div class="row text-center">
          <div class="col-12">
            <h1>Daftar Pesanan</h1>
            <p>Daftar Pesanan Sepatu Jordan</p>
            <hr>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
          <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thead>
                  <tr>
                    <th class="col-md-0">No</th>
                    <th class="col-md-4">ID</th>
                    <th class="col-md-4">Tanggal</th>
                    <th class="col-md-4">Nama</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($pesanan as $index => $p): ?>
                  <tr>
                    <th scope="row"><?= $index+1; ?></th>
                    <td>#<?= $p['id_pesanan'] ?></td>
                    <td style="white-space: nowrap;"><?= $p['tanggal_pembelian'] ?></td>
                    <td style="white-space: nowrap;"><?= $p['nama_lengkap'] ?></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>
