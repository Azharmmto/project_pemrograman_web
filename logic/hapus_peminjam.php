<?php 

session_start();
if(!isset($_SESSION["login"])){
  header("Location: ../login.php");
  exit;
}

require "functions.php";

$id = $_GET["id"];

if(hapus_peminjam($id) > 0){

  // set session hapus berhasil
  $_SESSION["peminjamDihapus"] = true;
  header("Location: ../peminjam.php");
  exit;

}


?>