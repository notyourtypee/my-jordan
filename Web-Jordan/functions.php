<?php
  // menghubungkan database dengan php
  $host = "localhost";
  $user = "root"; //isi username
  $pass = ""; //isi ppassword
  $db = "jordan"; //isi nama database

  try {
    $dbh = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn = mysqli_connect("$host", "$user", "$pass", "$db");
  } catch (PDOException $e) {
    die ("Koneksi Gagal: " . $e->getMessage());
  }

  function query($query){
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result) ){
      $rows[] = $row;
    }
    return $rows;
  }

  function uploadGambar($namaGambar){
    $namaFile = $_FILES["$namaGambar"]['name'];
    $ukuranFile = $_FILES["$namaGambar"]['size'];
    $error = $_FILES["$namaGambar"]['error'];
    $tmpName = $_FILES["$namaGambar"]['tmp_name'];

    // cek apakah tidak gambar yg diupload
    if($error === 4){
      echo  "<script>
                alert('Pilih gambar dulu');
            </script>";
      return false;
    }

    // cek apakah yg di upload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)){
        echo    "<script>
                    alert('yg di upload bukan gambar!');
                </script>";
        return false;
    }


    // cek jika ukuran terlalu besar
    if($ukuranFile > 10000000)  { //10 mega
        echo    "<script>
                    alert('Ukuran gambar terlalu besar');
                </script>";
        return false;
    }

    // lolos pegecekan, gambar siap di upload
    // generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .='.';
    $namaFileBaru .=$ekstensiGambar;
    move_uploaded_file($tmpName, '../images/produk/' . $namaFileBaru);
    return $namaFileBaru;
  }

  function cekLoginUser()
  {
    session_start();
    if( !isset($_SESSION["loginUser"]) ){
        header("Location: ../index.php");
        exit;
    }
  }

  function cekAdminLogin()
  {
    session_start();
    if( !isset($_SESSION["loginAdmin"]) ){
        header("Location: ../index.php");
        exit;
    }
  }
?>