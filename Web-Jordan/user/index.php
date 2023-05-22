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
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!--========== BOX ICONS ==========-->
        <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>

        <!--========== CSS ==========-->
        <link rel="stylesheet" href="assets/css/styles.css">
        
        <!--========== CSS SLICK ==========-->
        <link rel="stylesheet" type="text/css" href="assets/css/slick.css"/>
        <link rel="stylesheet" type="text/css" href="assets/css/slick-theme.css"/>
        
        <title>Website Jordan </title>
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
                        <li class="nav__item"><a href="#home" class="nav__link active-link">Home</a></li>
                        <li class="nav__item"><a href="#about" class="nav__link">About</a></li>
                        <li class="nav__item"><a href="#services" class="nav__link">Quality</a></li>
                        <li class="nav__item"><a href="#products" class="nav__link">Product</a></li>
                        <li class="nav__item"><a href="#size" class="nav__link">Size Chart</a></li>
                        <li class="nav__item"><a href="#contact" class="nav__link">Contact us</a></li>
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
                                    <button type="submit" name="hapusCart" onclick="return confirm('Yakin Ingin Menghapus?')" style="border: none; background: transparent; cursor:pointer">
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
            <!--========== HOME ==========-->
            <section class="home" id="home">
                <div class="slideshow-container">

                    <div class="mySlides fade">
                        <div class="home__container bd-container bd-grid">
                            <div class="home__data">
                                <h1 class="home__title">Air Jordan 1 High Tropical </h1>
                                <h2 class="home__subtitle">Sneakers lokal hasil kolaborasi terbaik pada tahun 2020.</h2>
                                <a href="#products" class="button">Explore Now</a>
                            </div>
                            <img src="assets/img/home1.jpg" alt="" class="home__img">
                        </div>
                    </div>
                    <div class="mySlides fade">
                        <div class="home__container bd-container bd-grid">
                            <div class="home__data">
                                <h1 class="home__title">Air Jordan 1 High Purple</h1>
                                <h2 class="home__subtitle">Kolaborasi pertama Jordan dengan nevertoolavish.</h2>
                                <a href="#products" class="button">Explore Now</a>
                            </div>
                            <img src="assets/img/home2.jpg" alt="" class="home__img">
                        </div>
                    </div>

                    <div class="mySlides fade">
                        <div class="home__container bd-container bd-grid">
                            <div class="home__data">
                                <h1 class="home__title">Air Jordan 1 mid Bright citrus</h1>
                                <h2 class="home__subtitle">Kolaborasi dengan Badjatex menggunakan denim.</h2>
                                <a href="#products" class="button">Explore Now</a>
                            </div>
                            <img src="assets/img/home3.jpg" alt="" class="home__img">
                        </div>
                    </div>
                        
                        
                </div>
                <br>
                
            </section>
            <!-- Next and previous buttons -->
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
            <!-- The dots/circles -->
            <div style="text-align:center">
                <span class="dots" onclick="currentSlide(1)"></span>
                <span class="dots" onclick="currentSlide(2)"></span>
                <span class="dots" onclick="currentSlide(3)"></span>
                <span class="dot"></span>
            </div>

            
            <!--========== ABOUT ==========-->
            <section class="about section bd-container" id="about">
                <div class="about__container  bd-grid">
                    <div class="about__data">
                        <span class="section-subtitle about__initial">About us</span>
                        <h2 class="section-title about__initial">We create the best <br> local sneakers</h2>
                        <p class="about__description">Jordan Shoes mulai di perkenalkan pada tahun 2017 oleh William Jordan, 
                            seorang pemilik pabrik sepatu vulkanisir sejak tahun 1989 di Bandung, Jawa Barat.</p>
                        <a href="#" class="button">Explore history</a>
                    </div>

                    <img src="assets/img/about.jpg" alt="" class="about__img">
                </div>
            </section>


            <!--========== SERVICES ==========-->
            <section class="services section bd-container" id="services">
                <span class="section-subtitle">Offering</span>
                <h2 class="section-title">Our amazing quality</h2>

                <div class="services__container  bd-grid">
                    <div class="services__content">
                        <img src="assets/img/upper.jpg" alt="" class="services__img">
                        <h3 class="services__title">Upper </h3>
                        <p class="services__description">Air Jordan menggunakan material kulit asli yang dapat terasa kokoh,
                            tetapi tetap fleksibel dan menimbulkan bau kulit yang khas.</p>
                    </div>

                    <div class="services__content">
                        <img src="assets/img/insole.jpg" alt="" class="services__img">
                        <h3 class="services__title">Insole</h3>
                        <p class="services__description">Jordan menggunakan insole yang dirancang khusus untuk memberikan penyangga pada kaki,
                              membantu mencegah cedera dan memberikan kenyamanan ekstra pada kaki selama aktivitas fisik yang intens.</p>
                    </div>

                    <div class="services__content">
                        <img src="assets/img/stitching.jpg" alt="" class="services__img">
                        <h3 class="services__title">Stitching</h3>
                        <p class="services__description">Stitching yang rapih menjadikan sepatu memiliki bentuk yang 
                            bagus, kokoh, nyaman, dan tahan lama.</p>
                    </div>
                </div>
            </section>

            <!--========== PRODUCTS ==========-->
            <section class="products section bd-container" id="products">
                <span class="section-subtitle">Special</span>
                <h2 class="section-title">PRODUCTS of the week</h2>

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
                    <?php endforeach; ?>
                </div>
            </section>

            <!--===== SIZE CHART =======-->
            <section class="size section bd-container" id="size">
                <div class="size__container bd-grid">
                    <div class="size__data">
                        <span class="section-subtitle size__initial">Size Chart</span>
                        <h2 class="section-title size__initial">Find Your Size</h2>
                        <p class="size__description">Silakan luangkan waktu Anda sejenak untuk mengamati size chart kami.
                            Ini akan membantu Anda mengetahui ukuran yang sesuai.</p>
                    </div>
                    <img src="assets/img/size-chart.jpg" alt="" class="size__img">
                </div>
            </section> 

            <!--========== CONTACT US ==========-->
            <section class="contact section bd-container" id="contact">
                <div class="contact__container bd-grid">
                    <div class="contact__data">
                        <span class="section-subtitle contact__initial">Let's talk</span>
                        <h2 class="section-title contact__initial">Contact us</h2>
                        <p class="contact__description">Jika Anda ingin membeli sepatu Jordan di toko kami, hubungi kami dan kami akan segera melayani Anda dengan layanan 24/7.</p>
                    </div>

                    <div class="contact__button">
                        <a href="contact.html" class="button">Contact us now</a>
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
                        <a href="https://web.facebook.com/profile.php?id=100034450933748" class="footer__social"><i class='bx bxl-facebook'></i></a>
                        <a href="https://www.instagram.com/athansss_/" class="footer__social"><i class='bx bxl-instagram'></i></a>
                        <a href="https://www.nike.com/w/jordan-37eef" class="footer__social"><i class='bx bxl-website'>Website</i></a>
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
                        <li>Jl. Gading Serpong Boulevard No.1 F</li>
                        <li>Tangerang- Indonesia</li>
                        <li>Phone : +085713005963</li>
                        <li>WhatsApp : 085713005963</li>
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
        </script>
     
    </body>
</html>