<?php 

  session_start();
  if(!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
  }

  require "functions.php";

  $id = $_GET["id"];

  $loan = query("
  
    SELECT peminjam.id as 'id peminjam', anggota.nama AS 'nama anggota', buku.judul AS 'judul buku', 
    peminjam.tanggal_pinjam as 'tanggal pinjam', peminjam.tanggal_pengembalian as 'tanggal dikembalikan', 
    peminjam.dikembalikan as 'status dikembalikan'
    FROM peminjam
    JOIN anggota ON peminjam.id_anggota = anggota.id
    JOIN buku ON peminjam.id_buku = buku.id 
    WHERE peminjam.id = $id;

  ")[0];

  // $member = query("SELECT id, nama, email FROM anggota WHERE id = $id")[0];
  // $book = query("SELECT id, judul, penulis FROM buku WHERE id = $id")[0];

  // $loanID = query("SELECT * from peminjam");

  if(isset($_POST["update-peminjam"])){

    if(update_peminjam($_POST) > 0){

      $_SESSION["updatePeminjamBerhasil"] = true;
      header("Location:../peminjam.php");
      exit;

    }

  };


?>



<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Add Loans</title>

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
                <a class="nav-link text-light" href="../buku.php">Daftar Buku</a>
              </li>
              <li class="nav-item d-flex align-items-center mt-3">
                <img src="../assets/icons/person-dashboard.png" alt="Dashboard Logo" width="20px">
                <a class="nav-link text-light" href="../anggota.php">Daftar Anggota</a>
              </li>
              <li class="nav-item d-flex align-items-center mt-3">
                <img src="../assets/icons/pinjam-dashboard.png" alt="Dashboard Logo" width="20px">
                <a class="nav-link text-light actived" href="#">Daftar Peminjam</a>
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
            <a href="../peminjam.php">
              <button type="button" class="btn btn-secondary d-flex align-items-center" title="Kembali">
                <img src="../assets/icons/arrow-left.png" alt="Icons Kembali" width="20px">
              </button>
            </a>
          </div>

          <div class="col-md-4 me-5">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../index.php">Dashboard</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="../peminjam.php">Daftar Peminjam</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Loans</li>
              </ol>
            </nav>
          </div>
        </div>

        <div class="container position-relative bg-white rounded p-3 mb-4" style="max-width: 80%;">

            <div class="col">
              <h1 class="fs-3">Add Loans</h1>
              <form action="" method="post">

                <!-- <input type="hidden" name="id" value="<?= $loanID["id"] ?>" /> -->

                <div class="mb-2">
                  <!-- judul -->
                  <label for="judul" class="col-form-label">Pilih Anggota</label>
                  <select class="form-select" aria-label="Default select example" name="pilih-anggota">
                      <option selected value="<?= $member["id"] ?>">
                        <?= $loan["nama anggota"] ?>
                      </option>
                    <?php foreach($member as $members) : ?>
                      <option value="<?= $members["id"] ?>">
                        <?= $members["nama"] ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                  <div id="passwordHelpBlock" class="form-text">
                    Jika anggota tidak ada, sillahkan daftarkan di menu <a href="../anggota.php">daftar anggota</a>.
                  </div>
                </div>

                <!-- penulis -->
                <div class="mb-2">
                  <label for="judul" class="col-form-label">Pilih Buku</label>
                  <select class="form-select" aria-label="Default select example" name="pilih-buku">
                      <option selected value="<?= $book["id"] ?>">
                        <?= $loan["judul buku"] ?>
                      </option>
                       <?php foreach($book as $books) : ?>
                          <option value="<?= $books["id"] ?>">
                            <?= $books["judul"] ?> penulis <i><?= $books["penulis"] ?></i>
                          </option>
                       <?php endforeach; ?>
                  </select>
                  <div id="passwordHelpBlock" class="form-text">
                    Jika buku tidak tersedia, sillahkan tambahkan di menu <a href="../buku.php">daftar buku</a>.
                  </div>
                </div>

                <!-- tahun terbit buku -->
                <div class="mb-2">
                  <label for="tanggal_pengembalian" class="col-form-label">Tanggal pengembalian</label>
                  <input type="date" class="form-control" id="tanggal_pengembalian" name="tanggal_pengembalian" 
                  value="<?= $loan["tanggal dikembalikan"] ?>" required />
                  
                  <div id="passwordHelpBlock" class="form-text">
                    Tanggal peminjaman otomatis tertulis sesuai dengan tanggal dan waktu perangkat.
                  </div>
                </div>
                
                <div class="mb-2">
                  <label for="judul" class="col-form-label">Pilih Buku</label>
                  <select class="form-select" aria-label="Default select example" name="status-pengembalian">
                      <option selected>
                         <?php if( $loan["status dikembalikan"] == 0) : ?>

                            <?= "Belum" ?>
                    
                          <?php endif ?>
                      </option>
                      <option value="1">Sudah</option>
                  </select>
                </div>

                <!-- tombol  -->
                <div class="row mt-3 d-flex justify-content-between">
                  <div class="col text-end">
                    <button type="submit" class="btn btn-success" name="update-peminjam">
                      Update
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