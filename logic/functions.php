<?php 

  // koneksi database
  $hostName = "localhost";
  $username = "root";
  $password = "";
  $dbName = "perpustakaan";

  $conn = mysqli_connect($hostName, $username, $password, $dbName);

  // funntion read data
  function query($query){

    global $conn;

    $result = mysqli_query($conn, $query);

    $rows = [];

    while($row = mysqli_fetch_assoc($result)){

      $rows[] = $row;

    }

    return $rows;

  }

  // TODO ================== BUKU ==================    

  // function tambah_buku
  function tambah_buku($post){

    global $conn;

    // abil tiap-tipa data dalam form
    // stripslashes() : unutk menghilangkan backlashes ( \ ) dari user
    $judul = htmlspecialchars(stripslashes($post["judul"]));
    $penulis = htmlspecialchars(stripslashes($post["penulis"]));
    $penerbit = htmlspecialchars(stripslashes($post["penerbit"]));
    $kategori = htmlspecialchars(stripslashes($post["kategori"]));
    $tahunTerbit = htmlspecialchars(stripslashes($post["tahun-terbit"]));
    $stokBuku= htmlspecialchars(stripslashes($post["stok-buku"]));

    // query ke database
    $queryInsert = "INSERT INTO buku(id, judul, penulis, penerbit, kategori, tahun_terbit, stok)
                    VALUES 
                    ('', '$judul', '$penulis', '$penerbit', '$kategori', $tahunTerbit, $stokBuku)";

    mysqli_query($conn, $queryInsert);
            
    return mysqli_affected_rows($conn);

  }

  // hapus buku
  function hapus_buku($id) {

    global $conn;
    
    mysqli_query($conn, "DELETE FROM buku WHERE id = $id");

    return mysqli_affected_rows($conn);

  }

  // update buku
  function update_buku($post){

    global $conn;

    // abil tiap-tipa data dalam form
    // stripslashes() : unutk menghilangkan backlashes ( \ ) dari user
    $id = $post["id"];
    $judul = htmlspecialchars(stripslashes($post["judul"]));
    $penulis = htmlspecialchars(stripslashes($post["penulis"]));
    $kategori = htmlspecialchars(stripslashes($post["kategori"]));
    $penerbit = htmlspecialchars(stripslashes($post["penerbit"]));
    $tahunTerbit = htmlspecialchars(stripslashes($post["tahun-terbit"]));
    $stokBuku= htmlspecialchars(stripslashes($post["stok-buku"]));

    $query_update = "UPDATE buku
                     SET judul = '$judul', penulis = '$penulis', kategori = '$kategori', penerbit = '$penerbit',
                     tahun_terbit = $tahunTerbit, stok = $stokBuku WHERE id = $id";

    mysqli_query($conn, $query_update);

    return mysqli_affected_rows($conn);

  }

  // TODO =============== ANGGOTA =====================

    // tambah anggota
    function tambah_anggota($post){

    global $conn;

    // abil tiap-tipa data dalam form
    // stripslashes() : unutk menghilangkan backlashes ( \ ) dari user
    $nama = htmlspecialchars(stripslashes($post["nama"]));
    $email = htmlspecialchars(stripslashes($post["email"]));
    $phone = htmlspecialchars(stripslashes($post["phone"]));
    $alamat = htmlspecialchars(stripslashes($post["alamat"]));

    // query ke database
    $queryInsert = "INSERT INTO anggota(id, nama, email, phone, alamat)
                    VALUES 
                    ('', '$nama', '$email', '$phone', '$alamat')";

    // cek apakah email sudah ada atau belum
    $cekEmail = mysqli_query($conn, "SELECT email FROM anggota WHERE email = '$email'");
    
    if(mysqli_fetch_assoc($cekEmail)){
      // set session email sudah terdaftar
      $_SESSION["emailTedaftar"] = true;
      return false;
    }

    mysqli_query($conn, $queryInsert);
            
    return mysqli_affected_rows($conn);

  }

  // hapus anggota
  function hapus_anggota($id){

    global $conn;

    mysqli_query($conn, "DELETE FROM anggota WHERE id = $id");

    return mysqli_affected_rows($conn);

  }

  // update anggota
  function update_anggota($post){

    global $conn;

    // abil tiap-tipa data dalam form
    // stripslashes() : unutk menghilangkan backlashes ( \ ) dari user
    $id = $post["id"];
    $nama = htmlspecialchars(stripslashes($post["nama"]));
    $email = htmlspecialchars(stripslashes($post["email"]));
    $phone = htmlspecialchars(stripslashes($post["phone"]));
    $alamat = htmlspecialchars(stripslashes($post["alamat"]));

    $query_update = "UPDATE anggota
                     SET nama = '$nama', email = '$email', phone = '$phone', alamat = '$alamat'
                     WHERE id = $id";

    mysqli_query($conn, $query_update);

    return mysqli_affected_rows($conn);

  }

  // TODO =================== Admin ====================

  // tambah admin
  function tambah_admin($post){

    global $conn;
  
    // ambil tiap-tipa data dalam form
    // stripslashes() : unutk menghilangkan backlashes ( \ ) dari user
    $nama = htmlspecialchars(strtolower(stripslashes($post["nama"])));
    $email = htmlspecialchars(strtolower(stripslashes($post["email"])));
    $phone = htmlspecialchars($post["phone"]);
    $password = htmlspecialchars(mysqli_real_escape_string($conn, $post["password"]));
    $passwordConfirm = htmlspecialchars(mysqli_real_escape_string($conn, $post["confirm-password"]));
    $passwordSaatLogin = htmlspecialchars($post["password-saat-login"]); // pass saat login

    // periaksa email apakah sudah terdaftar atau belum
    $cekEmail = mysqli_query($conn, "SELECT * FROM admin WHERE email = '$email'");
    if(mysqli_num_rows($cekEmail) === 1){
      // set session email sudah terdaftar
      $_SESSION["emailTerdaftar"] = true;

      return false;
      exit;
    }

    // periksa konfirmasi password
    if($password !== $passwordConfirm){    
      // set session password tidak sama
      $_SESSION["passwordTidakSama"] = true;
      return false;
      exit;

    }

    // ambil email admin berdasarkan session
    $emailAdmin = $_SESSION["email_admin"];
    $cekEmailPasswordLogin = mysqli_query($conn, "SELECT * FROM admin WHERE email = '$emailAdmin'");
    // periksa password saat login
    if(mysqli_num_rows($cekEmailPasswordLogin) === 1){

      $row = mysqli_fetch_assoc($cekEmailPasswordLogin);

      if(password_verify($passwordSaatLogin, $row["password"])){

        // enskripsi password
        $passwordEnkripsi = password_hash($password, PASSWORD_DEFAULT);

        $query_insert = "INSERT INTO admin(id, nama, email, phone, password) VALUES
                        ('', '$nama', '$email', '$phone', '$passwordEnkripsi')";

        mysqli_query($conn, $query_insert);
 
        return mysqli_affected_rows($conn);

      }

    }

    // password tidak terdaftar
    // set session password tidak terdaftar
    $_SESSION["passwordTidakTerdaftar"] = true;
    return false;

  }

  // hapus admin
  function hapus_admin($id){

    global $conn;

    $passwordHapus = htmlspecialchars($_POST["password-hapus"]);

    $emailAdmin = $_SESSION["email_admin"];
    $cekEmail = mysqli_query($conn, "SELECT * FROM admin WHERE email = '$emailAdmin'");

    if(mysqli_num_rows($cekEmail) === 1){

      $row = mysqli_fetch_assoc($cekEmail);

      if(password_verify($passwordHapus, $row["password"])){

        mysqli_query($conn, "DELETE FROM admin WHERE id = $id");

        return mysqli_affected_rows($conn);

      }

    }

    // set session password tidak terdaftar
    $_SESSION["passwordHapusSalah"] = true;
    return false;

  }

  // update admin
  function update_admin($post){

    global $conn;

    // ambil tiap-tipa data dalam form
    // stripslashes() : unutk menghilangkan backlashes ( \ ) dari user
    $id = $post["id"];
    $nama = htmlspecialchars(strtolower(stripslashes($post["nama"])));
    $email = htmlspecialchars(strtolower(stripslashes($post["email"])));
    $phone = htmlspecialchars($post["phone"]);
    $passwordSaatLogin = htmlspecialchars($post["password-saat-login"]); // pass saat login

    // perikasa password yang terdaftar
    $emailAdmin = $_SESSION["email_admin"];
    $cekPassword = mysqli_query($conn, "SELECT * FROM admin WHERE email = '$emailAdmin'");
    if(mysqli_num_rows($cekPassword) === 1){

      $row = mysqli_fetch_assoc($cekPassword);

      if(password_verify($passwordSaatLogin, $row["password"])){

        $query_update = "UPDATE admin SET nama = '$nama', email = '$email', phone = '$phone' WHERE id = $id";

        mysqli_query($conn, $query_update);

        return mysqli_affected_rows($conn);

      }


    }

    // set session password tidak terdaftar
    $_SESSION["passwordAdminTidakTerdaftar"] = true;
    return false;

  }

  // update password
  function update_password_admin($post){

    global $conn;

    // ambil data pada form
    $id = $post["id"];

    $emailAdmin = $_SESSION["email_admin"];
    $passwordAktif = htmlspecialchars($post["password-aktif"]); // pass saat login
    $passwordBaru= htmlspecialchars(mysqli_real_escape_string($conn, $post["password-baru"]));
    $passwordConfirm = htmlspecialchars(mysqli_real_escape_string($conn, $post["confirm-password"]));

    $cekEmail = mysqli_query($conn, "SELECT * FROM admin WHERE email = '$emailAdmin'");
    if(mysqli_num_rows($cekEmail) === 1){

      $row = mysqli_fetch_assoc($cekEmail);

      if(password_verify($passwordAktif, $row["password"])){

        // cek konfirmasi password
        if($passwordBaru !== $passwordConfirm){

          $_SESSION["passwordKonfimrasiSalah"] = true;
          return false;
          exit;

        }

        // enskripsi password
        $enkripsiPasswordBaru = password_hash($passwordBaru, PASSWORD_DEFAULT);

        $query_update = "UPDATE admin SET password = '$enkripsiPasswordBaru' WHERE id = $id";

        mysqli_query($conn, $query_update);

        return mysqli_affected_rows($conn);

      }

    }

    // set session password tidak terdaftar
    $_SESSION["passwordAdminAktifSalah"] = true;
    return false;
    exit;

  }

  // TODO =================== Peminjam Buku ====================
  function tambah_peminjam($post){

    global $conn;

    $idBuku = mysqli_real_escape_string($conn, $post["pilih-buku"]);
    $idAnggota = mysqli_real_escape_string($conn, $post["pilih-anggota"]);
    $tanggalPengembalian = mysqli_real_escape_string($conn, $post["tanggal_pengembalian"]);

    // masukkan ke database
    $query_insert = "INSERT INTO peminjam(id, id_buku, id_anggota, tanggal_pengembalian) VALUES
                    ('', '$idBuku', '$idAnggota', '$tanggalPengembalian')";

    // update stok buku
    $updeteStokBuku = "UPDATE buku SET stok = stok - 1 WHERE id = $idBuku";
    mysqli_query($conn, $updeteStokBuku);

    mysqli_query($conn, $query_insert);

    return mysqli_affected_rows($conn);

  }

  // hapus peminjam
    // hapus anggota
  function hapus_peminjam($id){

    global $conn;

    mysqli_query($conn, "DELETE FROM peminjam WHERE id = $id");

    return mysqli_affected_rows($conn);

  }

  // UPDATE PEMINJAM
  function update_peminjam($post){

    global $conn;

    $id = $post['id'];
    $idBuku = mysqli_real_escape_string($conn, $post["pilih-buku"]);
    $idAnggota = mysqli_real_escape_string($conn, $post["pilih-anggota"]);
    $tanggalPengembalian = mysqli_real_escape_string($conn, $post["tanggal_pengembalian"]);
    $statusKembalikan = mysqli_real_escape_string($conn, $post["status-pengembalian"]);

    $query_update = "
        UPDATE peminjam
        SET id_buku = '$idBuku', id_anggota = '$idAnggota', tanggal_pengembalian = '$tanggalPengembalian', statu_pengembalian = '$statusKembalikan' WHERE id = $id;
    ";

    mysqli_query($conn, $query_update);

    return mysqli_affected_rows($conn);

  }

?>