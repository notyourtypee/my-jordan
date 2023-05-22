<?php
  include "../functions.php";
  cekAdminLogin();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
    <!-- css -->
    <link rel="stylesheet" href="css/dashboard.css" />
    <!-- icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css" />
  </head>
  <body>
    <!-- Navbar -->
    <?php include "navbar.php" ?>

    <section id="dashboard">
      <div class="container h-100 text-center">
        <div class="row h-100 align-content-center justify-content-center">
          <div class="col-md-12 text-white">
            <h1>E-Commerce</h1>
          </div>
          <div class="col-md-4">
            <img src="../images/air-jordan-1-mid-grey-camo.png" alt="img" class="img-fluid">
          </div>
          <div class="col-md-12 text-white">
            <h2>Toko Sepatu Jordan</h2>
          </div>
        </div>
      </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>
