<?php
  include "../functions.php";
	cekLoginUser();
  $user_id = $_SESSION['user_id'];
  
  $cartProduk = query("SELECT cart.*, produk.*
                FROM cart
                JOIN produk ON cart.produk_id = produk.id_produk
                WHERE user_id='$user_id'");
  
  $totalHarga = 0;
  $jumlahBarang = 0;

  foreach ($cartProduk as $cart) {
      $totalHarga += $cart['harga'];
      $jumlahBarang++;
  }

  if (isset($_POST['hapusCart'])) {
    $idCart = $_POST['idCart'];
    $result = mysqli_query($conn, "DELETE FROM `cart`  WHERE id_cart=$idCart");
    if($result){
      header("Location: cart.php");
      exit;
    }
  }

  if (isset($_POST['tambahPesanan'])) {
    
    $id = sprintf("%006d", rand(0, 999999));
    $user_id = $_POST["user_id"];
    $produks_id = implode(',', $_POST["produks_id"]);
    $ukurans = implode(',', $_POST["ukurans"]);
    $nama_lengkap = htmlspecialchars($_POST["nama_lengkap"]);
    $email = htmlspecialchars($_POST["email"]);
    $phone = htmlspecialchars($_POST["phone"]);
    $alamat = htmlspecialchars($_POST["alamat"]);
    $pembayaran = $_POST["pembayaran"];
    $total = $_POST["total"];
    $tanggal_pembelian = date('Y-m-d');

    $query =  "INSERT INTO `pesanan` VALUES (
          '$id',
          '$user_id',
          '$produks_id',
          '$ukurans',
          '$nama_lengkap',
          '$email',
          '$phone',
          '$alamat',
          '$pembayaran',
          '$total',
          '$tanggal_pembelian'
          )";
    $result = mysqli_query($conn, $query);

    if($result){
      mysqli_query($conn, "DELETE FROM cart WHERE user_id ='$user_id'");
      // die("Success");
      header("Location: payment.php?idPesanan=$id");
      exit;
    }

  }



?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />

    <!--========== BOX ICONS ==========-->
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css" rel="stylesheet" />

    <!--========== CSS ==========-->
    <link rel="stylesheet" href="assets/css/styles.css" />

    <!--========== CSS SLICK ==========-->
    <link rel="stylesheet" type="text/css" href="assets/css/slick.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/slick-theme.css" />

    <title>website Jordan</title>
  </head>
  <body>
    <!--========== SCROLL TOP ==========-->
    <a href="#" class="scrolltop" id="scroll-top">
      <i class="bx bx-chevron-up scrolltop__icon"></i>
    </a>

    <!--========== HEADER ==========-->
    <header class="l-header" id="header">
      <nav class="nav bd-container">
        <div class="nav__toggle" id="nav-toggle">
          <i class="bx bx-menu"></i>
        </div>

        <a href="#" class="nav__logo">Jordan</a>

        <div class="nav__menu" id="nav-menu">
          <ul class="nav__list">
            <li class="nav__item"><a href="index.php" class="nav__link active-link">Home</a></li>
            <li class="nav__item"><a href="#about" class="nav__link">About</a></li>
            <li class="nav__item"><a href="#services" class="nav__link">Quality</a></li>
            <li class="nav__item"><a href="#products" class="nav__link">Product</a></li>
            <li class="nav__item"><a href="#size" class="nav__link">Size Chart</a></li>
            <li class="nav__item"><a href="#contact" class="nav__link">Contact us</a></li>

            <li><i class="bx bx-toggle-left change-theme" id="theme-button"></i></li>
            <li class="nav__item"><a href="../logout.php" class="nav__link">Logout</a></li>
          </ul>
        </div>

        <div class="nav__shop">
          <a href="#" class="nav__icon">
            <i class="bx bx-shopping-bag"></i>
            <span><?=$jumlahBarang?></span>
          </a>

          <div class="nav__shop-content">
            <div class="title_shop">
              <span>Keranjang Belanja</span>
            </div>
            <?php if ($jumlahBarang != 0) : ?>
              <?php foreach ($cartProduk as $index => $cp): ?>
                <div class="item">
                  <div class="image_cart">
                    <div class="image_c">
                      <img src="../images/produk/<?= $cp['gambar1']?>" alt="" />
                    </div>
                  </div>
                  <div class="description">
                    <span><?= $cp['nama_produk']?></span>
                  </div>
                  <div class="total-price">Rp. <?= number_format($cp['harga'], 0, ',', '.'); ?></div>
                  <form action="" method="post" class="d-inline">
                    <input type="hidden" name="idCart" value="<?= $cp['id_cart'] ?>">
                    <button type="submit" name="hapusCart" class="border-0 bg-transparent" onclick="return confirm('Yakin Ingin Menghapus?')">
                      <i class="bx bx-x"></i>
                    </button>
                  </form>
                </div>
              <?php endforeach ?>
            <?php else: ?>
              <h6 class="w-100" style="white-space: nowrap;">
                Belum Ada Produk Yang Ditambahkan
              </h6>
            <?php endif ?>
            <div class="total-all">
              <span>Total</span>
              <span>Rp. <?= number_format($totalHarga, 0, ',', '.'); ?></span>
            </div>
            <div class="btn-viewcard">
              <a href="cart.php" class="button-top">View Card</a>
            </div>
            <div class="btn-checkout">
              <a href="cart.php" class="button-top2">Check Out</a>
            </div>
          </div>
        </div>
      </nav>
    </header>

    <main class="l-main">
      <!--========== PAGINATION ==========-->
      <section class="section bd-container" id="breadcrumb">
        <div class="bd-grid breadcrumb">
          <div class="breadcrumb">
            <li>
              <a href="#"> <i class="bx bxs-home"></i> Home</a>
            </li>
            <li>Shopping Cart</li>
          </div>
          <div class="breadcrumb-pagination"></div>
        </div>
      </section>

      <!--========== CART ==========-->
      <section class="cart bd-container" id="cart">
        <div class="cart__container bd-grid">
          <div class="shopping-cart">
            <div class="cart-table">
              <table>
                <thead>
                  <tr>
                    <th>Image</th>
                    <th>ID Produk</th>
                    <th class="p-name text-center">Product Name</th>
                    <th>Size</th>
                    <th>Price</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($cartProduk as $index => $cp) : ?>
                    <tr>
                      <td class="cart-pic first-row">
                        <img src="../images/produk/<?= $cp['gambar1'] ?>" />
                      </td>
                      <td>#<?= $cp['id_produk'] ?></td>
                      <td class="cart-title first-row text-center"><?= $cp['nama_produk'] ?></td>
                      <td class="p-size first-row"><?= $cp['ukuran'] ?></td>
                      <td class="p-price first-row">Rp. <?= number_format($cp['harga'], 0, ',', '.'); ?></td>
                      <td class="delete-item-sc first-row">
                        <form action="" method="post" class="d-inline">
                          <input type="hidden" name="idCart" value="<?= $cp['id_cart'] ?>">
                          <button type="submit" name="hapusCart" class="border-0 bg-transparent" onclick="return confirm('Yakin Ingin Menghapus?')">
                            <i class="bx bx-x"></i>
                          </button>
                        </form>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                  <tr class="text-dark fw-bold border">
                    <td>Total</td>
                    <td colspan="5">Rp. <?= number_format($totalHarga, 0, ',', '.'); ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          
          <div>
            <h3 class="mb-4">Informasi Pembeli:</h3>
            <div class="user-checkout">
              <form action="" method="post">
                <input type="hidden" name="user_id" value="<?=$user_id?>">
                <?php foreach ($cartProduk as $index => $cp) : ?>
                  <input type="hidden" name="produks_id[]" value="<?= $cp['id_produk'] ?>">
                  <input type="hidden" name="ukurans[]" value="<?= $cp['ukuran'] ?>">
                <?php endforeach ?>
                <input type="hidden" name="total" value="<?=$totalHarga?>">
                <div class="form-group">
                  <label for="namaLengkap">Nama Lengkap</label>
                  <input type="text" class="form-control" name="nama_lengkap" id="namaLengkap" aria-describedby="namaHelp" placeholder="Masukan Nama Lengkap" required/>
                </div>
                <div class="form-group">
                  <label for="namaLengkap">Alamat Email</label>
                  <input type="email" class="form-control" name="email" id="emailAddress" aria-describedby="emailHelp" placeholder="Masukan Alamat Email" required/>
                </div>
                <div class="form-group">
                  <label for="namaLengkap">Telepon</label>
                  <input type="text" class="form-control" name="phone" id="noHP" aria-describedby="noHPHelp" placeholder="Masukan Telepon" required/>
                </div>
                <div class="form-group">
                  <label for="alamatLengkap">Alamat Lengkap</label>
                  <textarea class="form-control" name="alamat" id="alamatLengkap" rows="3" required></textarea>
                </div>
                <div class="col-md card-header my-3">
                  <p>Pilih Pembayaran</p>
                </div>
                <div class="col-md-12 pb-4">
                  <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Virtual Account</button>
                      </h2>
                      <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                          <div class="row">
                            <div class="col-6 col-md-10 p-3">
                              <div class="form-check">
                                <input class="form-check-input" type="radio" value="1" name="pembayaran" id="payment1" required/>
                                <label class="form-check-label" for="payment1">
                                  <div><img src="assets/img/payment1.png" alt="dm" class="img-fluid border-bottom border-3" /></div>
                                </label>
                              </div>
                            </div>
                            <div class="col-6 col-md-10 p-3">
                              <div class="form-check">
                                <input class="form-check-input" type="radio" value="2" name="pembayaran" id="payment2" required/>
                                <label class="form-check-label" for="payment2">
                                  <div><img src="assets/img/payment2.png" alt="dm" class="img-fluid border-bottom border-3" /></div>
                                </label>
                              </div>
                            </div>
                            <div class="col-6 col-md-10 p-3">
                              <div class="form-check">
                                <input class="form-check-input" type="radio" value="3" name="pembayaran" id="payment3" required/>
                                <label class="form-check-label" for="payment3">
                                  <div><img src="assets/img/payment3.png" alt="dm" class="img-fluid border-bottom border-3" /></div>
                                </label>
                              </div>
                            </div>
                            <div class="col-6 col-md-10 p-3">
                              <div class="form-check">
                                <input class="form-check-input" type="radio" value="4" name="pembayaran" id="payment4" required/>
                                <label class="form-check-label" for="payment4">
                                  <div><img src="assets/img/payment4.png" alt="dm" class="img-fluid border-bottom border-3" /></div>
                                </label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> 
                <button class="w-100 btn text-white" name="tambahPesanan" style="background-color: #012D80;">checkout</button>
              </form>
            </div>
          </div>

        </div>
      </section>
    </main>

    <!--========== FOOTER ==========-->
    <footer class="footer section bd-container">
      <div class="footer__container bd-grid">
        <div class="footer__content">
          <a href="#" class="footer__logo">Jordan</a>
          <span class="footer__description">Store</span>
          <div>
            <a href="#" class="footer__social"><i class="bx bxl-facebook"></i></a>
            <a href="#" class="footer__social"><i class="bx bxl-instagram"></i></a>
            <a href="#" class="footer__social"><i class="bx bxl-twitter"></i></a>
          </div>
        </div>

        <div class="footer__content">
          <h3 class="footer__title">Services</h3>
          <ul>
            <li><a href="#" class="footer__link">Shipping And Returns</a></li>
            <li><a href="#" class="footer__link">Measurement Guide</a></li>
            <li><a href="#" class="footer__link">Size Conversion Chart</a></li>
          </ul>
        </div>

        <div class="footer__content">
          <h3 class="footer__title">Information</h3>
          <ul>
            <li><a href="#" class="footer__link">Event</a></li>
            <li><a href="#" class="footer__link">Contact us</a></li>
            <li><a href="#" class="footer__link">Privacy policy</a></li>
            <li><a href="#" class="footer__link">Terms of services</a></li>
          </ul>
        </div>

        <div class="footer__content">
          <h3 class="footer__title">Adress</h3>
          <ul>
            <li>Jl. Kopo Katapang KM 12.8</li>
            <li>Bandung 40971 - Indonesia</li>
            <li>Phone : +62-22 5891445</li>
            <li>WhatsApp : 08112406969</li>
          </ul>
        </div>
      </div>

      <p class="footer__copy">&#169; 2023 Muhammad Atha Nassa. All right reserved</p>
    </footer>

    <!--========== SCROLL REVEAL ==========-->
    <script src="https://unpkg.com/scrollreveal"></script>

    <!--========== MAIN JS ==========-->
    <script src="assets/js/main.js"></script>

    <!--========== JS SLICK ==========-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="assets/js/slick.js"></script>
    <script src="assets/js/slick.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    <script>
      $(".slick_two").slick({
        dots: true,
        arrows: true,
        infiniite: true,
        autoplay: true,
        speed: 2000,
        autoplaySpeed: 2000,
        responsive: [
          {
            breakpoint: 5000,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 1,
            },
          },
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 1,
            },
          },
        ],
      });

      $(".multiple-items").slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 3,
      });

      /*---Single Product---*/
      $(".product-thumbs-track .pt").on("click", function () {
        $(".product-thumbs-track .pt").removeClass("active");
        $(this).addClass("active");
        var imgurl = $(this).data("imgbigurl");
        var bigImg = $(".product-big-img").attr("src");
        if (imgurl != bigImg) {
          $(".product-big-img").attr({
            src: imgurl,
          });
          $(".zoomImg").attr({
            src: imgurl,
          });
        }
      });

      $(".product-pic-zoom").zoom();
    </script>
  </body>
</html>
