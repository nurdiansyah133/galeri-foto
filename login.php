<!DOCTYPE html>

<?php
session_start();
include 'db.php';

if (isset($_SESSION['sebagaiadmin']) && $_SESSION['sebagaiadmin'] === true) {
    // Pengguna adalah admin, arahkan ke halaman admin
    header("Location: halaman_admin.php");
    exit;
} elseif (isset($_SESSION['sebagaiuser']) && $_SESSION['sebagaiuser'] === true) {
    // Pengguna adalah user biasa, arahkan ke halaman utama
    header("Location: index.php");
    exit;
}
?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Galeri Foto</title>
  
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <div class="wrapper">
  <form action="" method="POST">
      <h1>Login</h1>
      <div class="input-box">
        <input type="text" name="user" placeholder="Username" class="input-control" required>
        <i class='bx bxs-lock-alt'></i>
      </div>
      <div class="input-box">
        <input type="password"name="pass" placeholder="Password" class="input-control" required>
        <i class='bx bxs-lock-alt' ></i>
      </div>
      <input type="submit" name="submit" value="Login" class="btn">
      <div class="register-link">
        <p>Belum memiliki akun ? <a href="registrasi.php">Register</a></p>
      </div>
    </form>
    <?php
		     if(isset($_POST['submit'])){



				  


				 $user = mysqli_real_escape_string($conn, $_POST['user']);
				 $pass = mysqli_real_escape_string($conn, $_POST['pass']);
				 
					$cek = mysqli_query($conn, "SELECT * FROM tb_user WHERE username = '".$user."'AND password = '".$pass."'");
					if(mysqli_num_rows($cek) > 0){
						$d = mysqli_fetch_object($cek);

						$user_akses = $d->user_akses;

						if ($user_akses == "admin") {
							$_SESSION['sebagaiadmin'] = true;
							$_SESSION['id'] = $d->id_user;
							$_SESSION['nama_user'] = $d->nama_user;
							$_SESSION['status_login'] = true;
							echo '<script>window.location="halaman_admin.php"</script>';					
						}else{
							$_SESSION['status_login'] = true;
							$_SESSION['id'] = $d->id_user;
							$_SESSION['sebagaiuser'] = true;
							$_SESSION['nama_user'] = $d->nama_user;	
							$_SESSION['user_telp'] = $d->user_telp;
							$_SESSION['user_alamat'] = $d->user_alamat;
							$_SESSION['user_addres'] = $d->user_addres;
							echo '<script>window.location="index.php"</script>';
						}


				 }else{
					 echo '<script>alert("Username atau password anda salah")</script>';
				 }
			 }
	     ?><br />
  </div>
</body>
</html>