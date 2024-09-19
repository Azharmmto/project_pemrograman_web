<?php 

  session_start();
  if(!isset($_SESSION["login"])){
    header("Location: ../login.php");
    exit;
  }
  require "functions.php";

  $id = $_GET["id"];

  if(hapus_anggota($id) > 0){

    $_SESSION["hapusBerhasil"] = true;
    header("Location: ../anggota.php");

  } else{

    $_SESSION["hapusGagal"] = true;
    header("Location: ../anggota.php");

  }


?>