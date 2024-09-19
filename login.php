<?php 

  session_start();
  if(isset($_SESSION["login"])){
    header("Location: index.php");
    exit;
  }

  require "logic/functions.php";

  if(isset($_POST["login"])){

    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    $cekEmail = mysqli_query($conn, "SELECT * FROM admin WHERE email = '$email'");

    if(mysqli_num_rows($cekEmail) === 1){

      // cek password
      $row = mysqli_fetch_assoc($cekEmail);

      if(password_verify($password, $row["password"])){

        // simpan dalam sessin nama
        $_SESSION["nama_admin"] = $row["nama"];
        $_SESSION["email_admin"] = $row["email"];
        $_SESSION["login"] = true;
        header("Location: index.php?");

        exit;

      }

    }

    $erorLogin = true;

  }


?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login E-Perpus</title>

    <!-- bootstrp css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- my css -->
    <style>
      body{
        background: rgb(249,244,243);
        background: linear-gradient(90deg, rgba(249,244,243,1) 0%, rgba(246,234,226,1) 1%, rgba(242,239,228,1) 100%);
      }

      .login{
          display: flex;
          flex-direction: column;
          align-items: center;
          height: 80vh;
      }


      main{
          width: 30%;
          margin: auto;
          border-top: 2px solid #dc3545;
      }

      main button[type="submit"]{
          width: 100%;
      }

      .login main section:nth-child(1){
          font-size: 1.2rem;
          font-weight: 500;
          color: #9d9d9d;
      }

    </style>
  </head>
  <body class="bg-body-tertiary">

    <div class="login">
      <main class="p-4 rounded-2 bg-white shadow-lg">
       
        <section class="mt-1 d-flex align-items-center mb-3 font-weight-light ">
          <img src="assets/icons/logo-perpus-2.png" alt="Logo perpus" width="30px" class="me-1">
          <span>E-Perpus</span>
        </section>

        <section>
          <h1 class="fs-4">Login E-Perpus</h1>
        </section>

        <section class="position-relative">

          <?php if(isset($erorLogin)) : ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>Email atau Password salah.</strong>
              </div>
          <?php endif ?>

          <form action="" method="post">

            <div class="mb-2">
              <!-- email -->
              <label for="email" class="col-form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" autofocus required />
            </div>

            <!-- password -->
            <div class="mb-2">
              <label for="password" class="col-form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" required />
            </div>
            
            <div class="row mt-3">
              <div class="col text-center">
                <button type="submit" class="btn btn-success" name="login">Login</button>
              </div>
            </div>

          </form>
        </section>
      </main>

      <footer>
        Copyright &copy; Kelompok 4
      </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  </body>
</html>