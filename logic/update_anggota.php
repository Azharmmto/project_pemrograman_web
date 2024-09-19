<?php 

session_start();
if(!isset($_SESSION["login"])){
    header("Location: ../login.php");
    exit;
}

require "functions.php";

$id = $_GET["id"];

$hasil = query("SELECT * FROM anggota WHERE id = $id")[0];

// cek apakah tombol update sudah di klik
if(isset($_POST["update"])){

  if(update_anggota($_POST) > 0){

    // set session
    $_SESSION["updateBerhasil"] = true;
    header("Location: ../anggota.php");

  }

}


?>


<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Tambah Anggota</title>

  <!-- bootstrap css -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />

  <!-- my css -->
  <link rel="stylesheet" href="css/style.css" />

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
      height: 100vh;
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
 
  
  <div class="container-fluid p-0 d-flex position-relative">

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
              <a class="nav-link text-light actived" href="#">Daftar Anggota</a>
            </li>
            <li class="nav-item d-flex align-items-center mt-3">
              <img src="../assets/icons/pinjam-dashboard.png" alt="Dashboard Logo" width="20px">
              <a class="nav-link text-light" href="../peminjam.php">Daftar Peminjam</a>
            </li>
          </ul>

          <h3 class="fs-6 text-uppercase mt-4">Setting</h3>
          <ul class="nav nav-pills flex-column ">
            <li class="nav-item d-flex align-items-center mt-3">
              <img src="../assets/icons/logo-admin-new.png" alt="Dashboard Logo" width="20px">
              <a class="nav-link text-light" href="admin.php">Admin Terdaftar</a>
            </li>
            <li class="nav-item d-flex align-items-center mt-3">
              <img src="../assets/icons/logout-dashboard.png" alt="Dashboard Logo" width="20px">
              <a class="nav-link text-light" href="../logout.php">Logout</a>
            </li>
          </ul>

          <div class="d-flex align-items-center position-absolute bottom-0 start-0 ms-3 mb-3">
            <img src="../assets/icons/logo-perpus-2.png" alt="Logo Perpus" width="30px"/>
            <h3 class="fs-6 text-uppercase mt-3 mb-3 ms-2" style="font-weight: 300;">E-Perpus</h3>
          </div>
        </nav>
      </aside>
    </section>
  
    <!-- main -->
    <section class="main mt-4 flex-fill">
      <header style="margin-left: 89px;" class="d-flex justify-content-between pb-3">
        <div class="col-md-3 d-flex align-items-center">
          <a href="../anggota.php">
            <button class="btn btn-secondary d-flex align-items-center" type="button">
              <img src="../assets/icons/arrow-left.png" alt="Logo Tambah Data" title="Tambah Data" 
              width="20px" class="me-1"/>
            </button>
          </a>
        </div>

        <div class="col-md-5 d-flex align-items-center me-3">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="../index.php">Dashboard</a></li>
              <li class="breadcrumb-item" aria-current="page"><a href="../anggota.php">Daftar Anggota</a></li>
              <li class="breadcrumb-item active" aria-current="page">Add Anggota</li>
            </ol>
          </nav>
        </div>
      </header>

      <div class="row justify-content-center position-relative mt-2">

        <div class="col-md-10 bg-white p-4 rounded">

          <h1 class="fs-3">Update Member</h1>

          <form action="" method="post">

            <input type="hidden" name="id" value="<?= $hasil["id"] ?>" />

            <div class="mb-2">
              <!-- nama -->
              <label for="nama" class="col-form-label">Nama</label>
              <input type="text" class="form-control" id="nama" name="nama" maxlength="255" autofocus 
              value="<?= $hasil["nama"]; ?>" required />
            </div>

            <!-- Email -->
            <div class="mb-1">
              <label for="email" class="col-form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" maxlength="255" 
              value="<?= $hasil["email"]; ?>" aria-label="Disabled input example" readonly />
              <div id="passwordHelpBlock" class="form-text">
                Email tidak bisa di ubah atau di update.
              </div>
            </div>

            <!-- phone -->
            <div class="mb-2">
              <label for="phone" class="col-form-label">Phone</label>
              <input type="number" class="form-control" id="phone" name="phone" 
              value="<?= $hasil["phone"]; ?>" required />
            </div>            

            <!-- alamat -->
            <div class="mb-3">
              <label for="alamat" class="form-label">Alamat</label>
              <textarea class="form-control" id="alamat" rows="3" name="alamat"><?= $hasil["alamat"]; ?>"</textarea>
            </div>
            
            <!-- tombol  -->
            <div class="row mt-3 d-flex justify-content-between">
              <div class="col text-end">
                <button type="submit" class="btn btn-success" name="update">
                  Update Member
                </button>
              </div>
            </div>
          </form>
          
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