<?php 

  session_start();
  if(!isset($_SESSION["login"])){
    header("Location: ../login.php");
    exit;
  }
    
  require "functions.php";

  $id = $_GET["id"];

  $result = mysqli_query($conn, "SELECT nama, email FROM admin WHERE id = $id");

  $row = mysqli_fetch_assoc($result);

  if(isset($_POST["hapus"])){

    if(hapus_admin($id) > 0){
    
    // set session hapus erhasil
    $_SESSION["hapusBerhasil"] = true;
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
    <title>Konfimrasi Hapus Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
      body{
        background-color: rgba(0, 0, 0, 0.5);
      }
    </style>
  </head>
  <body>

  <div class="row d-flex align-items-center justify-content-center mt-5" style="height: 50vh;">
    <div class="col-md-5 bg-white shadow rounded pt-5 px-4" style="max-width: 35%;">

      <?php if(isset($_SESSION["passwordHapusSalah"])) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          <strong>Password admin salah.</strong> 
        </div>
        <!-- hapus sesssion -->
        <?php unset($_SESSION["passwordHapusSalah"]); ?>
      <?php endif ?>

      <form class="row g-3" method="post" action="">

        <div class="row">
          <div class="col">        
            <h1 class="fs-4">Konfirmasi penghapusan Admin.</h1>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">Nama <strong><?= $row["nama"] ?></strong></li>
              <li class="list-group-item">Email <strong><?= $row["email"] ?></strong></li>
            </ul>
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-auto">
            <label for="inputPassword2" class="visually-hidden">Password</label>
            <input type="password" class="form-control" id="inputPassword2" placeholder="Password" name="password-hapus">
            <div id="passwordHelpBlock" class="form-text">
              Masukkan password Admin.
            </div>
          </div>
          
          <div class="col-auto">
            <button type="submit" class="btn btn-warning mb-3" name="hapus">Konfimrasi</button>
          </div>
          <div class="col-auto mt-3">
            <a href="../admin.php" class="btn btn-info mb-3">Batal</a>
          </div>
        </div>
      </form>
    </div>
  </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>