<?php
  include "functions.php";

  session_start();
  if( isset($_SESSION["loginAdmin"]) ){
      header ('Location: admin/index.php');
      exit;
  }
  if( isset($_SESSION["loginUser"]) ){
      header ('Location: user/index.php');
      exit;
  }

  if( isset($_POST["login"])){

      $username = $_POST["username"];
      $password = $_POST["password"];

      $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

      if( mysqli_num_rows($result) === 1){

          $row = mysqli_fetch_assoc($result);
          if( $password == $row["password"] ){
              if($row["level"] == 1){
                $_SESSION["loginAdmin"] = true;
                header("Location: admin/index.php");
                exit;
              } else {
                $_SESSION["loginUser"] = true;
                $_SESSION["user_id"] = $row["id_user"];
                header("Location: user/index.php");
                exit;
              }
          }
      }
      $error = true;
  }


?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />

    <!-- CSS -->
    <link rel="stylesheet" href="login.css" />
  </head>
  <body>
    <section id="login">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-6 col-md-2 mt-5">
            <img src="images/logo-removebg-preview.png" alt="image" class="img-fluid" />
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-md-9 text-center text-white">
            <h1>Penjualan Sepatu Jordan</h1>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-11 col-md-5">
            <div class="login-box">
              <p>Login</p>
              <?php if( isset($error) ) : ?>
                <p style="color: red; font-style: italic;" class="text-center">Username / Password Salah!</p>
              <?php endif ?>
              <form action="" method="POST">
                <div class="user-box">
                  <input required="" name="username" type="text" />
                  <label>Username</label>
                </div>
                <div class="user-box">
                  <input required="" name="password" type="password" />
                  <label>Password</label>
                </div>
                <p class="text-white m-0">Belum punya akun? 
                  <a href="register.php" class="text-white">Buat Sekarang!</a>
                </p>
                <button type="submit" name="login">
                  <span></span>
                  <span></span>
                  <span></span>
                  <span></span>
                  Submit
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  </body>
</html>
