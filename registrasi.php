<?php
	include 'db.php';
  session_start();
  
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
<!DOCTYPE html>
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
      <h1>Register</h1>
      <div class="input-box">
        <input type="text" name="nama" placeholder="Nama User" class="input-control" required>
        <i class='bx bxs-lock-alt' ></i>
      </div>
      <div class="input-box">
        <input type="text" name="admin" placeholder="Username" class="input-control" required>
        <i class='bx bxs-lock-alt'></i>
      </div>
      <div class="input-box">
        <input type="text" name="pass" placeholder="Password" class="input-control" required>
        <i class='bx bxs-lock-alt' ></i>
      </div>
      <div class="input-box">
        <input type="text" name="tlp" placeholder="Telepon" class="input-control" required>
        <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">
        <input type="text" name="email" placeholder="Email" class="input-control" required>
        <i class='bx bxs-lock-alt' ></i>
      </div>
      <div class="input-box">
        <input type="text" name="almt" placeholder="Alamat" class="input-control" required>
        <i class='bx bxs-lock-alt' ></i>
      </div>
      
      <button type="submit" name="submit" class="btn">Submit</button>  
    </form>
    <?php
                   if(isset($_POST['submit'])){
					   
					   $nama = ucwords($_POST['nama']);
					   $username = $_POST['admin'];
					   $password = $_POST['pass'];
					   $telepon = $_POST['tlp'];
					   $email = $_POST['email'];
					   $alamat = ucwords($_POST['almt']);
					   
					   $insert = mysqli_query($conn, "INSERT INTO tb_user VALUES (
					                        null,
											'".$nama."',
											'".$username."',
											'".$password."',
											'".$telepon."',
											'".$email."',
											'".$alamat."',
                                            'user')
											
											");
						if($insert){
							echo '<script>alert("Registrasi berhasil")</script>';
							echo '<script>window.location="login.php"</script>';
						}else{
						    echo 'gagal '.mysqli_error($conn);
						}
						
					   }
			   ?>
  </div>
</body>
</html>