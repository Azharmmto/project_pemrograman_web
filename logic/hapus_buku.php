<?php

session_start();
  if(!isset($_SESSION["login"])){
    header("Location: ../login.php");
    exit;
  }
  
require "functions.php";

$id = $_GET["id"];

if(hapus_buku($id) > 0){

  // set sesssion berhasil hapus
  $_SESSION["hapusBerhasil"] = true;
  header("Location:../buku.php");

}

?>