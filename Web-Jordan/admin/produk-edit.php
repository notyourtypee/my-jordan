<?php
  include "../functions.php";
  cekAdminLogin();
  
  $idProduk = $_GET["idProduk"];
  $produk = query("SELECT produk.*, kategori.*
                  FROM produk
                  JOIN kategori ON produk.kategori_id = kategori.id_kategori
                  WHERE produk.id_produk = $idProduk
                  ")[0];
  $p_ukuran = explode(",", $produk["p_ukuran"]);
  $kategori = query("SELECT * FROM `kategori`");

  if(isset($_POST["edit"])){

    $id = $_POST["id"];
    $kode = htmlspecialchars($_POST["kode"]);
    $nama_produk = htmlspecialchars($_POST["nama_produk"]);
    $warna = htmlspecialchars($_POST["warna"]);
    $harga = htmlspecialchars($_POST["harga"]);
    $stok = htmlspecialchars($_POST["stok"]);
    $deskripsi = str_replace("\n", "<br>", $_POST['deskripsi']);
    $gambar1Lama = htmlspecialchars($_POST["gambar1Lama"]);
    $gambar2Lama = htmlspecialchars($_POST["gambar2Lama"]);
    $gambar3Lama = htmlspecialchars($_POST["gambar3Lama"]);
    $kategori_id = htmlspecialchars($_POST["kategori_id"]);
  
    if(!isset($_POST["p_ukuran"])){
      $p_ukuran = null;
    } else {
      $p_ukuran = implode(',', $_POST["p_ukuran"]);
    }

    // cek apakah user pilih gambar1 baru atau tidak
    if( $_FILES['gambar1']['error'] === 4){
      $gambar1 = $gambar1Lama;
    }else{
      unlink("../images/produk/$gambar1Lama");
      $gambar1 = uploadGambar('gambar1');
      if( $gambar1 === false){
        echo "<script>
                  alert ('Data gagal ditambahkan');
                  document.location.href='produk-edit.php';
              </script>";
      }
    }
    
    // cek apakah user pilih gambar2 baru atau tidak
    if( $_FILES['gambar2']['error'] === 4){
      $gambar2 = $gambar2Lama;
    }else if (isset($_FILES['gambar2'])){  
      unlink("../images/produk/$gambar2Lama");
      $gambar2 = uploadGambar('gambar2');
      if( $gambar2 === false){
        echo "<script>
                  alert ('Data gagal ditambahkan');
                  document.location.href='produk-edit.php';
              </script>";
      }
    }
    
    // cek apakah user pilih gambar3 baru atau tidak
    if( $_FILES['gambar3']['error'] === 4){
      $gambar3 = $gambar3Lama;
    }else if (isset($_FILES['gambar3'])){
      unlink("../images/produk/$gambar3Lama");
      $gambar3 = uploadGambar('gambar3');
      if( $gambar3 === false){
        echo "<script>
                  alert ('Data gagal ditambahkan');
                  document.location.href='produk-edit.php';
              </script>";
      }
    }
    
    $query = "UPDATE `produk` SET 
              kode = '$kode',
              nama_produk = '$nama_produk',
              warna = '$warna',
              harga = '$harga',
              stok = '$stok',
              p_ukuran = '$p_ukuran',
              deskripsi = '$deskripsi',
              gambar1 = '$gambar1',
              gambar2 = '$gambar2',
              gambar3 = '$gambar3',
              kategori_id = '$kategori_id'
              WHERE id_produk = '$id'";
  
    $result = mysqli_query($conn, $query);
  
    if($result){
      header("Location: produk-index.php");
      exit;
    }
  }
  
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
    <!-- css -->
    <link rel="stylesheet" href="css/produk-create.css" />
    <!-- icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css" />
  </head>
  <body>
    <!-- Navbar -->
    <?php include "navbar.php" ?>
    
    <!-- slide -->
    <?php include "carousel.php" ?>

    <section id="header-tambahProduk">
      <div class="container-fluid card shadow-lg">
        <div class="row mt-3">
          <div class="col-2">
            <a href="produk-index.php"
              ><button type="button" class="btn btn-primary"><i class="bi bi-arrow-left-circle"></i></button
            ></a>
          </div>
          <div class="col-12 text-center">
            <h3>Edit Produk</h3>
            <p>Edit Produk pada colom dibawah</p>
          </div>
        </div>
      </div>
    </section>

    <div id="section">
      <div class="container-fluid">
        <div class="row m-4 justify-content-center">
          <div class="col-md-6 mb-3">
            <div class="card">
              <div class="login-box">
                <form action="" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="id" value="<?= $produk['id_produk']; ?>">
                  <h4 class="mb-4 text-center">Produk</h4>
                  <div class="user-box">
                    <input type="text" name="kode" value="<?= $produk['kode']; ?>" required="" />
                    <label class="text-black">Kode Produk <span class="wajib">*</span></label>
                  </div>
                  <div class="user-box">
                    <input type="text" name="nama_produk" value="<?= $produk['nama_produk']; ?>" required="" />
                    <label class="text-black">Nama Produk <span class="wajib">*</span></label>
                  </div>
                  <div class="user-box">
                    <input type="text" name="warna" value="<?= $produk['warna']; ?>" required="" />
                    <label class="text-black">Warna <span class="wajib">*</span></label>
                  </div>
                  <div class="user-box">
                    <input type="text" name="harga" value="<?= $produk['harga']; ?>" required="" />
                    <label class="text-black">Harga <span class="wajib">*</span></label>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="user-box">
                        <input type="number" name="stok" value="<?= $produk['stok']; ?>" required="" />
                        <label class="text-black">Stok <span class="wajib">*</span></label>
                      </div>
                    </div>
                  </div>
                  <p>Ukuran Sepatu Tersedia <span class="wajib">*</span></p>
                  <div class="mb-3">
                    <?php for ($i=20; $i <= 40 ; $i++) :?>
                      <label for="p_ukuran<?=$i?>"><?=$i?></label>
                      <input type="checkbox" name="p_ukuran[]" value="<?=$i?>" id="p_ukuran<?=$i?>" <?php if (in_array($i, $p_ukuran)):?> checked <?php endif; ?>>
                    <?php endfor; ?>
                  </div>
                  <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Deskripsi Produk <span class="wajib">*</span></label>
                    <textarea class="form-control" name="deskripsi" id="exampleFormControlTextarea1" rows="3" required>
<?= $produk['deskripsi'] ?></textarea>
                  </div>
                  <div class="row mb-3">
                    <div class="col-md-5">
                      <div>
                        <label for="text-black">Pilih kategori <span class="wajib">*</span></label>
                        <select class="form-select" name="kategori_id" aria-label="Default select example" required>
                          <option hidden>Kategori Produk</option>
                          <?php foreach ($kategori as $index => $k) : ?>
                            <option value="<?= $k['id_kategori']; ?>" <?php if ($k['id_kategori'] == $produk["kategori_id"]): ?> selected <?php endif; ?>>
                              <?= $k['nama_kategori']; ?>
                            </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="formFile" class="form-label">Masukkan foto produk </label>
                    <br> <small>Kosongka Jika tidak ingin mengganti gambar</small>
                    <input class="form-control" type="file" name="gambar1" id="formFile"/>
                    <input type="hidden" name="gambar1Lama" value="<?= $produk['gambar1']; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="formFile" class="form-label">Masukkan foto produk ke-2 </label>
                    <br> <small>Kosongka Jika tidak ingin mengganti gambar</small>
                    <input class="form-control" type="file" name="gambar2" id="formFile"/>
                    <input type="hidden" name="gambar2Lama" value="<?= $produk['gambar2']; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="formFile" class="form-label">Masukkan foto produk ke-3 </label>
                    <br> <small>Kosongka Jika tidak ingin mengganti gambar</small>
                    <input class="form-control" type="file" name="gambar3" id="formFile"/>
                    <input type="hidden" name="gambar3Lama" value="<?= $produk['gambar3']; ?>">
                  </div>
                  <div class="row text-center my-4">
                    <div class="col-md-12">
                      <div class="login-box">
                        <button type="submit" name="edit" class="card">
                          Edit
                          <span></span>
                        </button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>
