<?php 

  session_start();
  if(!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
  }
  
  require "logic/functions.php";

  $admin = query("SELECT id, nama, email, phone FROM admin");


?>


<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Daftar Buku</title>

  <!-- bootstrap css -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />

  <!-- css data table -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.css">

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
      color: #fff;
      width: 20%;
      height: 100vh;
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
  
  <div class="container-fluid d-flex justify-content-start p-0 align-items-streach"> 

    <!-- aside -->
    <section class="p-3 aside col-md-5 fixed-top">
      <aside>
        <div class="admin d-flex mb-4">
          <div class="img me-3">
              <img src="assets/icons/administrator-dashaboard.png" alt="Logo admin" width="50px">
          </div>

          <div class="info-admin">
              <h3 class="text-white fs-5 mb-0 text-capitalize"><?= $_SESSION["nama_admin"] ?></h3>
              <span class="badge text-bg-primary">Administrator</span>
          </div>
        </div>

        <nav>
          <h3 class="fs-6 text-uppercase ">Main Navigation</h3>
          <ul class="nav flex-column mt-3">
            <li class="nav-item color-white d-flex align-items-center">
              <img src="assets/icons/logo_dashboard-new2.png" alt="Dashboard Logo" width="20px">
              <a class="nav-link text-light" href="index.php">Dashboard</a>
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
          <ul class="nav nav-pills flex-column">
            <li class="nav-item d-flex align-items-center mt-3">
              <img src="assets/icons/logo-admin-new.png" alt="Dashboard Logo" width="20px">
              <a class="nav-link text-light actived" href="admin.php">Admin Terdaftar</a>
            </li>
            <li class="nav-item d-flex align-items-center mt-3">
              <img src="assets/icons/logout-dashboard.png" alt="Dashboard Logo" width="20px">
              <a class="nav-link text-light" href="logout.php">Logout</a>
            </li>
          </ul>

          <div class="d-flex align-items-center position-absolute bottom-0 start-0 ms-3">
            <img src="assets/icons/logo-perpus-2.png" alt="Logo Perpus" width="30px"/>
            <h3 class="fs-6 text-uppercase mt-4 mb-4 ms-2" style="font-weight: 300;">E-Perpus</h3>
          </div>
        </nav>
      </aside>
    </section>
  
    <!-- main -->
    <section class="main mt-4 col-md-5 flex-fill mb-4 position-relative">

      <!-- admin berhasil ditambahkan -->
      <?php if(isset($_SESSION["tambahAdminBerhasil"])) : ?>

        <div class="alert alert-success alert-dismissible fade show position-absolute top-0 start-50 translate-middle-x shadow" role="alert" style="width: 50%;">
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          <strong>Admin BERHASIL ditambahkan!</strong>
        </div>
        <!-- hapus sesssion tambah admin -->
        <?php unset($_SESSION["tambahAdminBerhasil"]); ?>

      <?php endif;?>

      <?php if(isset($_SESSION["hapusBerhasil"])) : ?>

        <div class="alert alert-warning alert-dismissible fade show position-absolute top-0 start-50 translate-middle-x shadow" role="alert" style="width: 50%;">
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          <strong>Admin BERHASIL dihapus!</strong>
        </div>
        <!-- hapus sesssion hapus admin -->
        <?php unset($_SESSION["hapusBerhasil"]); ?>

      <?php endif ?>

      <!-- update berhasil -->
      <?php if(isset($_SESSION["updateAdminBerhasil"])) : ?>
        <div class="alert alert-success alert-dismissible fade show position-absolute top-0 start-50 translate-middle-x shadow" role="alert" style="width: 50%;">
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          <strong>Admin BERHASIL diupdate!</strong>
        </div>
        <!-- hapus sesssion update admin -->
        <?php unset($_SESSION["updateAdminBerhasil"]); ?>

      <?php endif; ?>

      <!-- update password berhasil -->
      <?php if(isset($_SESSION["updatePasswordBerhasil"])) : ?>
        <div class="alert alert-success alert-dismissible fade show position-absolute top-0 start-50 translate-middle-x shadow" role="alert" style="width: 50%;">
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          <strong>Password BERHASIL diupdate!</strong>
        </div>
        <!-- hapus sesssion update admin -->
        <?php unset($_SESSION["updatePasswordBerhasil"]); ?>

      <?php endif; ?>      


      <header style="margin-left: 89px;" class="d-flex justify-content-between pb-3">
        <div class="col-md-6 d-flex flex-column">
          <h3 class="fs-5">Admin yang terdaftar dalam sistem.</h3>

        <!-- button untuk tambah data -->
          <a href="logic/tambah_admin.php">
            <button class="btn btn-warning d-flex align-items-center mt-2" type="button">
              <img src="assets/icons/tambah_admin_hitam.png" alt="Logo Tambah Data" title="Tambah Data" 
              width="20px" class="me-1"/>
              Add New
            </button>
          </a>
        </div>

        <div class="col-md-4 d-flex align-items-center">
          <nav aria-label="breadcrumb" class="ms-5">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Daftar Admin</li>
            </ol>
          </nav>
        </div>
      </header>

      <div class="row justify-content-center mt-2">
        <div class="col-md-10">
          <table class="table table-striped shadow-sm" id="table-data">
            <thead>
              <tr class="align-middle text-center">    
                <th class="text-start">#</th>
                <th class="text-start">Nama Lengkap</th>
                <th class="text-start">Email</th>
                <th class="text-start">Phone</th>
                <th class="text-start">Action</th>
              </tr>
            </thead>

            <tbody class="align-middle">
              <?php $i = 1 ?>
              <?php foreach($admin as $admins) : ?>
                <tr>
                  <td class="text-start"><?= $i ?></td>
                  <td class="text-start"> 
                    <?php if($admins["nama"] === $_SESSION["nama_admin"]) : ?>
                      <strong><?= $admins["nama"] ?> (Anda) </strong>

                    <?php else : ?>
                      <?= $admins["nama"] ?> 

                    <?php endif ?>
                  </td>
                  <td class="text-start"><?= $admins["email"] ?></td>
                  <td class="text-start"><?= $admins["phone"] ?></td>
                  <td>
                    <!-- tombol update -->
                      <a href="logic/update_admin.php?id=<?= $admins["id"] ?>">
                       <img src="assets/icons/ubah-icon.png" alt="Icon Update" width="30px" title="Update buku" >
                      </a>

                    <?php if($admins["nama"] !== $_SESSION["nama_admin"]) : ?>
                      <!-- tombol hapus --> 
                      <a href="logic/hapus_admin.php?id=<?= $admins["id"] ?>" 
                      onclick ="return confirm(`Yakin Ingin menghapus admin ini, dengan nama <?= $admins['nama'] ?> ?` )">
                        <img src="assets/icons/delete-bulat.png" alt="Icons Delete" width="30px" title="Hapus Buku" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
                      </a>
                    <?php endif ?>
                  </td>

                </tr>
                <?php $i++ ?>
              <?php endforeach; ?>     
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>

  <!-- js table data -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.min.js"></script>
  <script>
   $(document).ready(function() {
      $('#table-data').DataTable({
        "columns": [
            { "data": "#" },
            { "data": "Nama Lengkap" },
            { "data": "Email" },
            { "data": "Phone" },
            { "data": "Action" }
        ],

        "language": {
            "search": "",
            "searchPlaceholder": "Search admin..."
        }
      });
    })

  </script>

<!-- js bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>