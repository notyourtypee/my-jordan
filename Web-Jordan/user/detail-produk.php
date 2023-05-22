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

  $produk = query("SELECT produk.*, kategori.nama_kategori 
									FROM `produk`
									JOIN kategori ON produk.kategori_id = kategori.id_kategori
									");

  $idProduk = $_GET['idProduk'];
  $dp = query("SELECT produk.*, kategori.*
							FROM produk
							JOIN kategori ON produk.kategori_id = kategori.id_kategori
							WHERE produk.id_produk = $idProduk
							")[0];
  $p_ukuran = explode(",", $dp['p_ukuran']);

	if (isset($_POST['addToCart'])) {
    $id = sprintf("%006d", rand(0, 999999));
		$user_id = $_POST['user_id'];
		$produk_id = $_POST['produk_id'];
		$ukuran = $_POST['ukuran'];

		$query = "INSERT INTO `cart` VALUES (
							'$id',
							'$user_id',
							'$produk_id',
							'$ukuran'
							)";
		
		$result = mysqli_query($conn, $query);

		if ($result) {
			header("Location: cart.php");
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />

        <!--========== BOX ICONS ==========-->
        <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>

        <!--========== CSS ==========-->
        <link rel="stylesheet" href="assets/css/styles.css">
        
        <!--========== CSS SLICK ==========-->
        <link rel="stylesheet" type="text/css" href="assets/css/slick.css"/>
        <link rel="stylesheet" type="text/css" href="assets/css/slick-theme.css"/>
        
        <title>website Jordan</title>
    </head>
    <body>

        <!--========== SCROLL TOP ==========-->
        <a href="#" class="scrolltop" id="scroll-top">
            <i class='bx bx-chevron-up scrolltop__icon'></i>
        </a>

        <!--========== HEADER ==========-->
        <header class="l-header" id="header">
            <nav class="nav bd-container">
                <div class="nav__toggle" id="nav-toggle">
                    <i class='bx bx-menu'></i>
                </div>

                <a href="#" class="nav__logo">Jordan</a>

                <div class="nav__menu" id="nav-menu">
                    <ul class="nav__list">
                        <li class="nav__item"><a href="index.php" class="nav__link active-link">Home</a></li>
                        <li class="nav__item"><a href="index.php#about" class="nav__link">About</a></li>
                        <li class="nav__item"><a href="index.php#services" class="nav__link">Quality</a></li>
                        <li class="nav__item"><a href="#products" class="nav__link">Product</a></li>
                        <li class="nav__item"><a href="index.php#size" class="nav__link">Size Chart</a></li>
                        <li class="nav__item"><a href="index.php#contact" class="nav__link">Contact us</a></li>

                        <li><i class='bx bx-toggle-left change-theme' id="theme-button"></i></li>
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
                        <li><a href="#"> <i class='bx bxs-home'></i>  Home</a></li>
                        <li>Detail</li>
                    </div>
                    <div class="breadcrumb-pagination">
                    </div>
                </div>
            </section>    
       
            <!--========== DETAIL ==========-->
            <section class="detail bd-container" id="detail">
                <div class="detail__container  bd-grid">
                    <div class="detail__img">
                        <div class="product-pic-zoom">
                            <img class="product-big-img" src="../images/produk/<?= $dp['gambar1']?>" alt="" />
                        </div>
                        <div class="product-thumbs ">
                            <div class="product-thumbs-track ps-slider bd-grid multiple-items">
                                <div class="pt active" data-imgbigurl="../images/produk/<?= $dp['gambar1']?>">
                                    <img src="../images/produk/<?= $dp['gambar1']?>" alt="" />
                                </div>
                                <div class="pt active" data-imgbigurl="../images/produk/<?= $dp['gambar2']?>">
                                    <img src="../images/produk/<?= $dp['gambar2']?>" alt="" />
                                </div>
                                <div class="pt" data-imgbigurl="../images/produk/<?= $dp['gambar3']?>">
                                    <img src="../images/produk/<?= $dp['gambar3']?>" alt="" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="detail__data">
                        <form action="" method="post">
                            <input type="hidden" name="user_id" value="<?=$user_id?>">
                            <input type="hidden" name="produk_id" value="<?=$dp['id_produk']?>">
                            <span class="section-subtitle detail__initial">Air Jordan</span>
                            <h2 class="section-title detail__initial"><?= $dp["nama_produk"] ?></h2>
                            <p class="detail__description"> <b>GENERAL SPECIFICATION</b><br>                       
                                Color : <?= $dp["warna"] ?>

                                <div class="size_detail-container">
                                    <b>SIZE</b>
                                    <div class="sizes_detail" >
                                        <?php foreach ($p_ukuran as $index => $ukuran) : ?>
                                            <label for="<?=$ukuran?>" class="size_detail"><?=$ukuran?></label>
                                            <input type="radio" value="<?=$ukuran?>" name="ukuran" id="<?=$ukuran?>" required style="display: none;">
                                        <?php endforeach ?>
                                    </div>
                                </div>   
                                <b>MATERIALS</b><br>
                                <?= str_replace("\n", "<br>", $dp['deskripsi']) ?>
                                <div class="price_detail">
                                    <b>Rp.<?= number_format($dp['harga'], 0, ',', '.'); ?></b>
                                </div>
                                <br>    
                            <button type="submit" name="addToCart" class="button" style="border: 0;">Add to Cart</button>
                        </form>
                    </div> 
                </div>
            </section>

            <!--========== PRODUCTS ==========-->
            <section class="products section bd-container" id="products">
                <h2 class="section-title">Related Products</h2>

                <div class="products__container bd-grid logo-slider slick_two">
                  <?php foreach ($produk as $index => $p): ?>
                    <div class="products__content">
                        <img src="../images/produk/<?= $p['gambar1']?>" alt="" class="products__img">
                        <h3 class="products__name"><?= $p['nama_produk']?></h3>
                        <span class="products__detail"><?= $p['nama_kategori']?></span><br>
                        <span class="products__preci">Rp. <?= number_format($p['harga'], 0, ',', '.'); ?></span>
                        <a href="detail-produk.php?idProduk=<?= $p['id_produk'] ?>" class="button products__button_detail">Detail Product</i></a>
                        <a href="detail-produk.php?idProduk=<?= $p['id_produk'] ?>" class="button products__button"><i class='bx bx-cart-alt'></i></a>
                    </div>
                  <?php endforeach ?>
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
                        <a href="#" class="footer__social"><i class='bx bxl-facebook'></i></a>
                        <a href="#" class="footer__social"><i class='bx bxl-instagram'></i></a>
                        <a href="#" class="footer__social"><i class='bx bxl-twitter'></i></a>
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
        <script  src="assets/js/slick.js"></script>
        <script  src="assets/js/slick.min.js"></script>

        <script>
            $('.slick_two').slick({
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
                        slidesToScroll: 1
                    }
                    },
                    {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                    }
                ]
            });

            $('.multiple-items').slick({
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 3
            });

            /*---Single Product---*/
            $('.product-thumbs-track .pt').on('click', function () {
                $('.product-thumbs-track .pt').removeClass('active');
                $(this).addClass('active');
                var imgurl = $(this).data('imgbigurl');
                var bigImg = $('.product-big-img').attr('src');
                if (imgurl != bigImg) {
                    $('.product-big-img').attr({
                        src: imgurl
                    });
                    $('.zoomImg').attr({
                        src: imgurl
                    });
                }
            });

            $('.product-pic-zoom').zoom();
        </script>
     
    </body>
</html>