<?php 

  session_start();
  require "functions.php";
  if(!isset($_SESSION["login"])){
    header("Location: ../login.php");
    exit;
  }

  // ketika tombol tambah di klik
  if(isset($_POST["tambah"])){

    // cek apakah berhasil tamabh buku
    tambah_buku($_POST) > 0 ? $addBook = true : $addBook = false;

  }


?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>AddBuku</title>

  <!-- bootstrap css -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />

  <!-- google icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

  <style>

    body{
        background: rgb(249,244,243);
        background: linear-gradient(90deg, rgba(249,244,243,1) 0%, rgba(246,234,226,1) 1%, rgba(242,239,228,1) 100%);
        overflow-x: hidden;
    }

    a{
      text-decoration: none;
    }

    section.aside{
      background-color: #3a3939;
      min-height: 100vh;
      color: #fff;
      width: 20%;
    }

    section.aside nav ul li a:hover{
      color: blue !important;
    }

    section.aside nav ul li a.actived{
      color: blue !important;
    }

    section.main{
      margin-left: 290px;
    }

  </style>
</head>

<body>

    <div class="container-fluid d-flex p-0 position-relative">

      <!-- aside -->
      <section class="p-3 aside fixed-top">
        <aside>
          <div class="admin d-flex mb-4">
            <div class="img me-3">
                <img src="../assets/icons/administrator-dashaboard.png" alt="Logo admin" width="50px">
            </div>

            <div class="info-admin">
                <h3 class="text-white fs-5 mb-0 text-capitalize"><?= $_SESSION["nama_admin"] ?></h3>
                <span class="badge text-bg-primary">Administrator</span>
            </div>
          </div>

          <nav>
            <h3 class="fs-6 text-uppercase">Main Navigation</h3>
            <ul class="nav flex-column mt-3">
              <li class="nav-item color-white d-flex align-items-center">
                <img src="../assets/icons/logo_dashboard-new2.png" alt="Dashboard Logo" width="20px">
                <a class="nav-link text-light" href="../index.php">Dashboard</a>
              </li>
              <li class="nav-item d-flex align-items-center mt-3">
                <img src="../assets/icons/book-dashboard.png" alt="Dashboard Logo" width="20px">
                <a class="nav-link text-light actived" href="#">Daftar Buku</a>
              </li>
              <li class="nav-item d-flex align-items-center mt-3">
                <img src="../assets/icons/person-dashboard.png" alt="Dashboard Logo" width="20px">
                <a class="nav-link text-light" href="../anggota.php">Daftar Anggota</a>
              </li>
              <li class="nav-item d-flex align-items-center mt-3">
                <img src="../assets/icons/pinjam-dashboard.png" alt="Dashboard Logo" width="20px">
                <a class="nav-link text-light" href="../peminjam.php">Daftar Peminjam</a>
              </li>
            </ul>

            <h3 class="fs-6 text-uppercase mt-4">Setting</h3>
            <ul class="nav nav-pills flex-column">
              <li class="nav-item d-flex align-items-center mt-3">
                <img src="../assets/icons/logo-admin-new.png" alt="Dashboard Logo" width="20px">
                <a class="nav-link text-light" href="../admin.php">Admin Terdaftar</a>
              </li>
              <li class="nav-item d-flex align-items-center mt-3">
                <img src="../assets/icons/logout-dashboard.png" alt="Dashboard Logo" width="20px">
                <a class="nav-link text-light" href="../logout.php">Logout</a>
              </li>
            </ul>

            <div class="d-flex align-items-center position-absolute bottom-0 start-0 ms-3 mb-3">
              <img src="../assets/icons/logo-perpus-2.png" alt="Logo Perpus" width="30px"/>
              <h3 class="fs-6 text-uppercase mt-4 mb-3 ms-2" style="font-weight: 300;">E-Perpus</h3>
            </div>
          </nav>
        </aside>
      </section>
  
      <!-- main -->
      <section class="main mt-4 flex-fill">
        <div class="row align-items-center justify-content-between mb-4" style="margin-left: 50px;">
          <div class="col-md-3">
            <a href="../buku.php">
              <button type="button" class="btn btn-secondary d-flex align-items-center" title="Kembali">
                <img src="../assets/icons/arrow-left.png" alt="Icons Kembali" width="20px">
              </button>
            </a>
          </div>

          <div class="col-md-4 me-4">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../index.php">Dashboard</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="../buku.php">Daftar Buku</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Buku</li>
              </ol>
            </nav>
          </div>
        </div>

        <div class="container position-relative bg-white rounded p-3 mb-4" style="max-width: 80%;">

          <div class="row"> 
            <!-- confirm berhasil tambah buku atau tidak -->
            <?php if(isset($_POST["tambah"])) : ?>
              <?php if(isset($addBook)) : ?>
                
                <!-- buku berhasil ditambahkan -->
                <div class="alert alert-success position-absolute top-0 start-50 translate-middle-x shadow" role="alert" id="alert-pesan">
                  <h3 class="fs-5">Buku BERHASIL ditambahkan!</h3>

                  <button type="button" class="btn-close position-absolute top-50 end-0 translate-middle-y me-3" aria-label="Close" id="close-alert-pesan"></button>
                </div>

              <?php elseif(!isset($addBook)) : ?>

                <!-- buku gagal ditambahkan -->
                <div class="alert alert-danger position-absolute top-0 start-50 translate-middle-x shadow" role="alert" id="alert-pesan">
                  <h3 class="fs-5">Buku GAGAL berhasil ditambahkan!</h3>
                  <p>Perikasa kembali inputan yang Anda masukkan.</p>

                  <button type="button" class="btn-close position-absolute top-50 end-0 translate-middle-y me-3" aria-label="Close" id="close-alert-pesan"></button>
                </div>

              <?php endif ?>
            <?php endif ?>

            <div class="col">
              <h1 class="fs-3">Add Book</h1>
              <form action="" method="post">

                <div class="mb-2">
                  <!-- judul -->
                  <label for="judul" class="col-form-label">Judul</label>
                  <input type="text" class="form-control" id="judul" name="judul" maxlength="255" autofocus required />
                </div>

                <!-- penulis -->
                <div class="mb-2">
                  <label for="penulis" class="col-form-label">Penulis</label>
                  <input type="text" class="form-control" id="penulis" name="penulis" maxlength="255"  required />
                </div>

                <!-- kategori -->
                <div class="mb-2">
                  <label for="phone" class="col-form-label">Kategori</label>
                  <select class="form-select" aria-label="Default select example" name="kategori">
                    <option selected>Pilih kategori...</option>
                    <option value="Biografi">Biografi</option>
                    <option value="Cerita Pendek">Cerita Pendek</option>
                    <option value="Ilmu Pengetahuan">Ilmu Pengetahuan</option>
                    <option value="Pembelajaran">Pembelajaran</option>
                    <option value="Sejarah">Sejarah</option>
                    <option value="Teknologi">Teknologi</option>
                    <option value="Fiksi Ilmiah">Fiksi Ilmiah</option>
                    <option value="Novel">Majalah</option>
                    <option value="Novel">Komik</option>
                    <option value="Novel">Novel</option>
                  </select>
                </div>

                <!-- tahun terbit buku -->
                <div class="mb-2">
                  <label for="penerbit" class="col-form-label">Penerbit</label>
                  <input type="text" class="form-control" id="penerbit" name="penerbit" required />
                </div>            

                <!-- tahun terbit buku -->
                <div class="mb-2">
                  <label for="tahun-terbit" class="col-form-label">Tahun Terbit</label>
                  <input type="number" class="form-control" id="tahun-terbit" name="tahun-terbit" required min="1900" max="2099" step="1" />
                </div>

                <!-- stok buku -->
                <div class="mb-2">
                  <label for="stok-buku" class="col-form-label">Stok Buku</label>
                  <input type="number" id="stok-buku" name="stok-buku" class="form-control" required/>
                </div>
                
                <!-- tombol  -->
                <div class="row mt-3 d-flex justify-content-between">
                  <div class="col text-end">
                    <button type="submit" class="btn btn-success" name="tambah">
                      Add Book
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>


<!-- js bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- my js -->
<script>

  const alertPesan = document.getElementById("alert-pesan");
  const closeAlertPesan = document.getElementById("close-alert-pesan");

  closeAlertPesan.addEventListener("click", function(){

    alertPesan.style.display = "none";

  })

</script>

</body>
</html>