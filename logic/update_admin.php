<?php 

  session_start();
  if(!isset($_SESSION["login"])){
    header("Location: ../login.php");
    exit;
  }

  require "functions.php";

  $id = $_GET["id"];

  $result = query("SELECT id, nama, email, phone FROM admin WHERE id = $id")[0];

  if(isset($_POST["update-admin"])){
    
    if(update_admin($_POST) > 0){

      $_SESSION["updateAdminBerhasil"] = true;
      header("Location: ../admin.php");
      exit;
    }

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
                <a class="nav-link text-light" href="index.php">Dashboard</a>
              </li>
              <li class="nav-item d-flex align-items-center mt-3">
                <img src="../assets/icons/book-dashboard.png" alt="Dashboard Logo" width="20px">
                <a class="nav-link text-light" href="#">Daftar Buku</a>
              </li>
              <li class="nav-item d-flex align-items-center mt-3">
                <img src="../assets/icons/person-dashboard.png" alt="Dashboard Logo" width="20px">
                <a class="nav-link text-light" href="anggota.php">Daftar Anggota</a>
              </li>
              <li class="nav-item d-flex align-items-center mt-3">
                <img src="../assets/icons/pinjam-dashboard.png" alt="Dashboard Logo" width="20px">
                <a class="nav-link text-light" href="peminjam.php">Daftar Peminjam</a>
              </li>
            </ul>

            <h3 class="fs-6 text-uppercase mt-4">Setting</h3>
            <ul class="nav nav-pills flex-column">
              <li class="nav-item d-flex align-items-center mt-3">
                <img src="../assets/icons/logo-admin-new.png" alt="Dashboard Logo" width="20px">
                <a class="nav-link text-light actived" href="admin.php">Admin Terdaftar</a>
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
            <a href="../admin.php">
              <button type="button" class="btn btn-secondary d-flex align-items-center" title="Kembali">
                <img src="../assets/icons/arrow-left.png" alt="Icons Kembali" width="20px">
              </button>
            </a>
          </div>

          <div class="col-md-5 me-4">
            <nav aria-label="breadcrumb" class="me-3">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../index.php">Dashboard</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="../admin.php">Admin Terdaftar</a></li>
                <li class="breadcrumb-item active" aria-current="page">Update Admin</li>
              </ol>
            </nav>
          </div>
        </div>

        <div class="container position-relative bg-white rounded p-3 mb-4" style="max-width: 80%;">

            <div class="col">

              <!-- password tidak terdaftar -->
              <?php if(isset($_SESSION["passwordAdminTidakTerdaftar"])) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  <strong>Gagal diupdate!</strong> Password admin salah.
                </div>
                <!-- hapus sesssion -->
                <?php unset($_SESSION["passwordAdminTidakTerdaftar"]); ?>
              <?php endif ?>

              <div class="row align-items-center justify-content-between">
                <div class="col-md-4">
                  <h1 class="fs-3">Update data Admin</h1>
                </div>

                <div class="col-md-4 text-end">
                  <a href="update_password_admin.php?id=<?= $result["id"] ?>">Ubah Password</a>
                </div>
              </div>

              <form action="" method="post">

                <input type="hidden" name="id" value="<?= $result["id"] ?>">

                <div class="mb-2">
                  <!-- judul -->
                  <label for="nama" class="col-form-label">Nama Lengkap</label>
                  <input type="text" class="form-control" id="nama" name="nama" minlength="5" maxlength="255" 
                  value="<?= $result["nama"] ?>" autofocus required />
                </div>

                <!-- penulis -->
                <div class="mb-2">
                  <label for="email" class="col-form-label">Email</label>
                  <input type="email" class="form-control" id="email" name="email" maxlength="255" 
                  value="<?= $result["email"] ?>" readonly required />
                    <span id="passwordHelpInline" class="form-text">
                      Email tidak bisa diubah.
                    </span>
                </div>

                <!-- tahun terbit buku -->
                <div class="mb-2">
                  <label for="phone" class="col-form-label">Phone</label>
                  <input type="number" class="form-control" id="phone" name="phone" maxlength="14" 
                  value="<?= $result["phone"] ?>" required />
                </div> 


                <div class="row mt-3">
                  <!-- password saat login -->
                  <div class="col-auto">
                    <label for="password-saat-login" class="col-form-label">Password Admin</label>
                  </div>

                  <div class="col-auto">
                    <input type="password" id="password-saat-login" class="form-control" aria-describedby="passwordHelpInline" name="password-saat-login" required />
                    <span id="passwordHelpInline" class="form-text">
                      Masukkan password yang Anda gunakan saat login ke aplikasi.
                    </span>
                  </div>

                  <!-- tombol -->
                  <div class="col text-end">
                    <button type="submit" class="btn btn-success" name="update-admin" style="min-width: 150px;">
                      Update Admin
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

</body>
</html>