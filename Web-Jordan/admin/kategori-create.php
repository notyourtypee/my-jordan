<?php
  include "../functions.php";
  cekAdminLogin();
  
  if(isset($_POST["tambah"])){

    $id = sprintf("%006d", rand(0, 999999));
    $name = htmlspecialchars($_POST["nama"]);
    $query = "INSERT INTO `kategori` VALUES ('$id','$name')";
    $result = mysqli_query($conn, $query);

    if($result){
      header("Location: kategori-index.php");
      exit;
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>+Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
    <!-- css -->
    <link rel="stylesheet" href="css/kategori-create.css" />
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
            <a href="kategori-index.php"
              ><button type="button" class="btn btn-primary"><i class="bi bi-arrow-left-circle"></i></button
            ></a>
          </div>
          <div class="col-12 text-center">
            <h3>Tambah Kategori</h3>
            <p>Tambahkan Kategori pada colom dibawah</p>
          </div>
        </div>
      </div>
    </section>

    <section id="TambahKategori">
      <div class="container-fluid">
        <div class="row m-4 justify-content-center">
          <div class="col-md-6 mb-3">
            <div class="card">
              <div class="login-box">
                <form action="" method="post">
                  <h4 class="mb-4 text-center">Kategori</h4>
                  <div class="user-box">
                    <input type="text" name="nama" required="" />
                    <label class="text-black">Nama Seri</label>
                  </div>
                  <div class="row text-center mb-4">
                    <div class="col-md-12">
                      <div class="login-box">
                        <button type="submit" name="tambah" class="card">
                          Tambah
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
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>
