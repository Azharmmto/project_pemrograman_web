<?php 

  session_start();
  if(!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
  }
  
  require "logic/functions.php";

  $jumlahBuku = mysqli_query($conn, "SELECT COUNT(*) as 'jumlah buku' FROM buku");
  $jumlahAnggota = mysqli_query($conn, "SELECT COUNT(*) as 'jumlah anggota' FROM anggota");
  $jumlahPeminjam = mysqli_query($conn, "SELECT COUNT(*) as 'jumlah peminjam' FROM peminjam");
  $jumlahAdmin = mysqli_query($conn, "SELECT COUNT(*) as 'jumlah admin' FROM admin");

  // ambil rows yag dikembalikan
  $rowBuku = mysqli_fetch_assoc($jumlahBuku);
  $rowAnggota = mysqli_fetch_assoc($jumlahAnggota);
  $rowPeminjam = mysqli_fetch_assoc($jumlahPeminjam);
  $rowAdmin = mysqli_fetch_assoc($jumlahAdmin);

  // ambil id berdasarkan email
  $emailAdmin = $_SESSION["email_admin"];
  $idAdmin = mysqli_query($conn, "SELECT id FROM admin WHERE email = '$emailAdmin'");

  $row = mysqli_fetch_assoc($idAdmin);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard E-Perpus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>

      body{
        background: rgb(249,244,243);
        background: linear-gradient(90deg, rgba(249,244,243,1) 0%, rgba(246,234,226,1) 1%, rgba(242,239,228,1) 100%);
      }

      a{
        text-decoration: none;
        color: black;
      }

      .container .dashboard-card:hover{
          border: 1px solid #fd7e14;
      }

      section.aside{
        background-color: #3a3939;
        height: 100vh;
        color: #fff;
        width: 20%;
      }

      section.aside nav ul li a.actived{
        color: blue !important;
      }

      section.aside nav ul li a:hover{
        color: blue !important;
      }

      section.main{
        margin-left: 200px;
      }

      section.aside .admin{
        padding-bottom: 10px;
        transition: 0.3s all;
        border-bottom: 1px solid #3a3950;
        position: relative;
      }

      section.aside .admin:hover{
        border-bottom: 1px solid blue;
      }
      
    </style>

  </head>
  <body>
    
    <div class="container mt-4 d-flex">

     <section class="p-3 position-absolute top-0 start-0 aside">
      <aside>
        <div class="admin d-flex mb-4">
          <a href="logic/update_foto.php?id=<?= $row["id"] ?>" title="Update data">
            <div class="img me-3">
                <img src="assets/icons/administrator-dashaboard.png" alt="Logo admin" width="50px">
            </div>
          </a>
            
          <a href="logic/update_foto.php?id=<?= $row ["id"] ?>" title="Update data">
            <div class="info-admin">
              <h3 class="text-white fs-5 mb-0 text-capitalize"><?= $_SESSION["nama_admin"] ?></h3>
              <span class="badge text-bg-primary">Administrator</span>
            </div>
            </a>
        </div>

        <nav>
          <h3 class="fs-6 text-uppercase">Main Navigation</h3>
          <ul class="nav flex-column mt-3">
            <li class="nav-item color-white d-flex align-items-center">
              <img src="assets/icons/logo_dashboard-new2.png" alt="Dashboard Logo" width="20px">
              <a class="nav-link text-light actived" href="#">Dashboard</a>
            </li>
            <li class="nav-item d-flex align-items-center mt-3">
              <img src="assets/icons/book-dashboard.png" alt="Dashboard Logo" width="20px">
              <a class="nav-link text-light" href="buku.php">Daftar Buku</a>
            </li>
            <li class="nav-item d-flex align-items-center mt-3">
              <img src="assets/icons/person-dashboard.png" alt="Dashboard Logo" width="20px">
              <a class="nav-link text-light" href="anggota.php">Daftar Anggota</a>
            </li>
            <li class="nav-item d-flex align-items-center mt-3">
              <img src="assets/icons/pinjam-dashboard.png" alt="Dashboard Logo" width="20px">
              <a class="nav-link text-light" href="peminjam.php">Daftar Peminjam</a>
            </li>
          </ul>

          <h3 class="fs-6 text-uppercase mt-4">Setting</h3>
          <ul class="nav nav-pills flex-column ">
            <li class="nav-item d-flex align-items-center mt-3">
              <img src="assets/icons/logo-admin-new.png" alt="Dashboard Logo" width="20px">
              <a class="nav-link text-light" href="admin.php">Admin Terdaftar</a>
            </li>
            <li class="nav-item d-flex align-items-center mt-3">
              <img src="assets/icons/logout-dashboard.png" alt="Dashboard Logo" width="20px">
              <a class="nav-link text-light" href="logout.php">Logout</a>
            </li>
          </ul>

          <div class="d-flex align-items-center position-absolute bottom-0 start-0 ms-3">
            <img src="assets/icons/logo-perpus-2.png" alt="Logo Perpus" width="30px"/>
            <h3 class="fs-6 text-uppercase mt-4 mb-3 ms-2" style="font-weight: 300;">E-Perpus</h3>
          </div>
        </nav>
      </aside>
    </section>

      
    <section class="main">
      <div class="row justify-content-between align-items-center">
        <div class="colxampp-md-4">
          <h1 class="fs-3">Dashboard E-Perpus</h1>
        </div>
      </div>

      <hr class="border border-success border-1 opacity-10">

      <div class="row mt-3">

        <!-- buku -->
        <div class="col-md-4">
          <a href="buku.php">
            <div class="card bg-primary bg-gradient mb-3 dashboard-card" style="min-width: 18rem; height: 170px">
              <div class="card-body d-flex justify-content-between">
                <div>
                  <h4 class="card-title">Buku</h5>
                  <h1 class="mt-2 ms-4"><?= $rowBuku["jumlah buku"] ?> </h1>
                </div>
                <img src="assets/icons/logo_daftar_buku2.png" alt="Logo Buku" width="100px" />
              </div>
              <div class="card-footer">Menu informasi buku yang tersedia.</div>
            </div>
          </a>
        </div>

        <!-- anggota -->
        <div class="col-md-4">
          <a href="anggota.php">
            <div class="card bg-info bg-gradient mb-3 dashboard-card" style="min-width: 18rem; height: 170px">
              <div class="card-body d-flex justify-content-between">
                <div>
                  <h4 class="card-title">Anggota</h5>
                  <h1 class="mt-2 ms-4"><?= $rowAnggota["jumlah anggota"] ?> </h1>
                </div>
                <img src="assets/icons/logo_anggota_new2.png" alt="Tambah icons" width="100px">
              </div>
              <div class="card-footer">Menu informasi anggota perpus.</div>
            </div>
          </a>
        </div>

        <!-- peminjam -->
        <div class="col-md-4">
          <a href="peminjam.php">
            <div class="card bg-primary-subtle mb-3 dashboard-card" style="min-width: 20rem; height: 170px">
              <div class="card-body d-flex justify-content-between">
                <div>
                  <h4 class="card-title">Peminjam</h5>
                  <h1 class="mt-2 ms-4"><?= $rowPeminjam["jumlah peminjam"] ?> </h1>
                </div>
                <img src="assets/icons/logo_pinjam_2.png" alt="Tambah icons" width="100px">
              </div>
              <div class="card-footer d-flex align-items-center">Menu informasi daftar peminjam buku.</div>
            </div>
          </a>
        </div>
      </div>

      <div class="row mt-3">
        <div class="col-md-4">
          <a href="admin.php">
            <div class="card bg-info bg-gradient mb-3 dashboard-card" style="min-width: 20rem; height: 170px">
              <div class="card-body d-flex justify-content-between">
                <div>
                  <h4 class="card-title">Daftar Admin</h5>
                  <h1 class="mt-2 ms-4"><?= $rowAdmin["jumlah admin"] ?> </h1>
                </div>
                <img src="assets/icons/admin-card-dashboard.png" alt="Tambah icons" width="100px">
              </div>
              <div class="card-footer">Menu informasi Admin yang terdaftar.</div>
            </div>
          </a>
        </div>

      </div>

      </section>
    </div>


    <!-- js boottrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>