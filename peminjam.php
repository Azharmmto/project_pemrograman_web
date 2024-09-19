<?php 

  session_start();
  if(!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
  }

  require "logic/functions.php";

  $loan = query("
  
      SELECT peminjam.id as 'id peminjam', anggota.nama AS 'nama anggota', buku.judul AS 'judul buku', 
      peminjam.tanggal_pinjam as 'tanggal pinjam', peminjam.tanggal_pengembalian as 'tanggal dikembalikan', 
      peminjam.dikembalikan as 'status dikembalikan'
      FROM peminjam
      JOIN anggota ON peminjam.id_anggota = anggota.id
      JOIN buku ON peminjam.id_buku = buku.id;

  ")


?>


<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Dafatr Peminjam Buku</title>

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
              <img src="assets/icons/administrator-dashaboard.png" alt="Logo admin" width="50px">
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
              <img src="assets/icons/logo_dashboard-new2.png" alt="Dashboard Logo" width="20px">
              <a class="nav-link text-light" href="index.php">Dashboard</a>
            </li>
            <li class="nav-item d-flex align-items-center mt-3">
              <img src="assets/icons/book-dashboard.png" alt="Dashboard Logo" width="20px">
              <a class="nav-link text-light" href="buku.php">Daftar Buku</a>
            </li>
            <li class="nav-item d-flex align-items-center mt-3">
              <img src="assets/icons/person-dashboard.png" alt="Dashboard Logo" width="20px">
              <a class="nav-link text-light " href="anggota.php">Daftar Anggota</a>
            </li>
            <li class="nav-item d-flex align-items-center mt-3">
              <img src="assets/icons/pinjam-dashboard.png" alt="Dashboard Logo" width="20px">
              <a class="nav-link text-light actived" href="#">Daftar Peminjam</a>
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

          <div class="d-flex align-items-center position-absolute bottom-0 start-0 ms-3 mb-3">
            <img src="assets/icons/logo-perpus-2.png" alt="Logo Perpus" width="30px"/>
            <h3 class="fs-6 text-uppercase mt-4 mb-3 ms-2">E-Perpus</h3>
          </div>
        </nav>
      </aside>
    </section>
  
    <!-- main -->
    <section class="main mt-4 flex-fill position-relative">

        <?php if(isset($_SESSION["pemimjamDiTambahkan"])) : ?>
          <div class="alert alert-success alert-dismissible fade show shadow position-absolute top-0 start-50 translate-middle mt-3" role="alert" style="width: 50%;">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>Peminjam buku BERHASIL ditambahkan!</strong>.
          </div>
          <!-- hapus sesssion -->
          <?php unset($_SESSION["pemimjamDiTambahkan"]); ?>
        <?php endif ?>

        <?php if(isset($_SESSION["peminjamDihapus"])) : ?>
          <div class="alert alert-warning alert-dismissible fade show shadow position-absolute top-0 start-50 translate-middle mt-3" role="alert" style="width: 50%;">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>Peminjam buku BERHASIL dihapus!</strong>.
          </div>
          <!-- hapus sesssion -->
          <?php unset($_SESSION["peminjamDihapus"]); ?>
        <?php endif ?>

        <?php if(isset($_SESSION["updatePeminjamBerhasil"])) : ?>
          <div class="alert alert-success alert-dismissible fade show shadow position-absolute top-0 start-50 translate-middle mt-3" role="alert" style="width: 50%;">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>Update anggota BERHASIL!</strong>.
          </div>
          <!-- hapus sesssion -->
          <?php unset($_SESSION["updatePeminjamBerhasil"]); ?>
        <?php endif ?>

      <header style="margin-left: 89px;" class="d-flex justify-content-between pb-3">
        <div class="col-md-3 d-flex align-items-center">
          <h3 class="fs-5 me-2">Members</h3>

        <!-- button untuk tambah data -->
          <a href="logic/tambah_peminjam.php">
            <button class="btn btn-primary d-flex align-items-center" type="button">
              <img src="assets/icons/pinjam-dashboard.png" alt="Logo Tambah Data" title="Tambah Data" 
              width="20px" class="me-1"/>
              <span>Add New</span>
            </button>
          </a>
        </div>

        <div class="col-md-3 d-flex align-items-center me-5">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Peminjam</li>
            </ol>
          </nav>
        </div>
      </header>

      <div class="row justify-content-center mt-2 mb-3">

        <div class="col-md-11">

          <table class="table table-striped shadow-sm" id="table-data">
            <thead>
              <tr class="align-middle">    
                <th class="text-start">#</th>
                <th class="text-start">Nama Anggota</th>
                <th class="text-start">Buku Dipinjam</th>
                <th class="text-start">Tanggal Pinjam</th>
                <th class="text-start">Tanggal Penggembalian</th>
                <th class="text-start">Status Dikembalikan</th>
                <th class="text-start">Action</th>
              </tr>
            </thead>

            <tbody class="align-middle">
              <?php $i = 1 ?>
              <?php foreach($loan as $loans) : ?>
                <tr>
                  <td class="text-start"><?= $i  ?></td>
                  <td class="text-start"><?= $loans["nama anggota"]  ?></td>
                  <td class="text-start"><?= $loans["judul buku"]  ?></td>
                  <td class="text-start"><?= $loans["tanggal pinjam"]  ?></td>
                  <td class="text-start"><?= $loans["tanggal dikembalikan"]  ?></td>
                  <td class="text-start">

                    <?php if( $loans["status dikembalikan"] == 0) : ?>

                      <?= "Belum" ?>
                    
                    <?php else : ?>

                      <?= "Sudah" ?>

                    <?php endif ?>

                  </td>
                  <td>
                    <!-- tombol update -->
                    <a href="logic/update_peminjam.php?id=<?=  $loans["id peminjam"] ?>">
                      <img src="assets/icons/ubah-icon.png" alt="Icon Update" width="33px" title="Update buku" >
                    </a>

                    <!-- tombol hapus --> 
                    <a href="logic/hapus_peminjam.php?id=<?= $loans["id peminjam"] ?>" 
                    onclick="return confirm(`Yakin Ingin menghapus peminjam ini, bernama <?= $loans['nama anggota'] ?> buku yang dipinjam <?= $loans['judul buku'] ?> ? `)">
                      <img src="assets/icons/delete-bulat.png" alt="Icons Delete" width="33px" title="Hapus Buku" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
                    </a>
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


<!-- js bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- js table data -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.min.js"></script>
<script>

  // js data table
  $(document).ready(function() {
    $('#table-data').DataTable({
      "columns": [
          { "data": "#" },
          { "data": "Nama" },
          { "data": "Email" },
          { "data": "Phone" },
          { "data": "Alamat" },
          { "data": "Added" },
          { "data": "Action" }
      ],

      "language": {
          "search": "",
          "searchPlaceholder": "Search peminjam buku..."
      }
    });
  });

  // my js
  let alertPesan = document.getElementById("alert-pesan");
  let closeAlertPesan = document.getElementById("close-alert-pesan");

  closeAlertPesan.addEventListener("click", function(){

    alertPesan.style.display = "none";

  })

</script>



</body>
</html>