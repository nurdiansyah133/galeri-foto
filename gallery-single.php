<?php

include 'db.php';

session_start();
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] !== true) {
  echo '<script>window.location="login.php"</script>';
  exit;
}

///LIKE
if (isset($_GET['like'])) {
  // Tangkap galeri_id dari URL
  $galeri_id_like = $_GET['like'];

  // Ambil nama pengguna dari sesi
  $nama_user = $_SESSION['nama_user'];
  $id_user = $_SESSION['id'];

  // Periksa apakah pengguna sudah memberikan like pada galeri tersebut sebelumnya
  $query_check_like = "SELECT * FROM tb_like_unlike_unduh WHERE galeri_id = '$galeri_id_like' AND id_user = '$id_user'";
  $result_check_like = mysqli_query($conn, $query_check_like);

  if (mysqli_num_rows($result_check_like) == 0) {
    // Jika pengguna belum memberikan like pada galeri tersebut sebelumnya
    // Buat tanggal 
    $tanggal = date('Y-m-d H:i:s');

    // Simpan data
    $query = "INSERT INTO `tb_like_unlike_unduh` (`like_id`, `galeri_id`, `nama_user`, `id_user`, `suka`, `tidaksuka`, `tanggal`, `unduh`, `unduh_id`) VALUES (NULL, '$galeri_id_like', '$nama_user', '$id_user', '1', '0', '$tanggal', '0', '0')";

    $result = mysqli_query($conn, $query);

    // Memeriksa eksekusi
    if ($result) {
      echo '<script>alert("Anda berhasil like")</script>';
      echo "<script>window.location='gallery-single.php?galeri=$galeri_id_like'</script>";

    } else {
      echo '<script>alert("Error")</script>';
    }
  } else {
    // Jika pengguna sudah memberikan like pada galeri tersebut sebelumnya
    echo '<script>alert("Anda sudah memberikan like untuk galeri ini")</script>';
    echo "<script>window.location='gallery-single.php?galeri=$galeri_id_like'</script>";
  }



}

///UNLIKE 
if (isset($_GET['unlike'])) {
  // Tangkap galeri_id dari URL
  $galeri_id_like = $_GET['unlike'];

  // Ambil nama pengguna dari sesi
  $nama_user = $_SESSION['nama_user'];
  $id_user = $_SESSION['id'];

  // Periksa apakah pengguna sudah memberikan unlike pada galeri tersebut sebelumnya
  $query_check_like = "SELECT * FROM tb_like_unlike_unduh WHERE galeri_id = '$galeri_id_like' AND id_user = '$id_user'";
  $result_check_like = mysqli_query($conn, $query_check_like);

  if (mysqli_num_rows($result_check_like) == 0) {
    // Jika pengguna belum memberikan unlike pada galeri tersebut sebelumnya
    // Buat tanggal 
    $tanggal = date('Y-m-d H:i:s');

    // Simpan data
    $query = "INSERT INTO `tb_like_unlike_unduh` (`like_id`, `galeri_id`, `nama_user`, `id_user`, `suka`, `tidaksuka`, `tanggal`, `unduh`, `unduh_id`) VALUES (NULL, '$galeri_id_like', '$nama_user', '$id_user', '0', '1', '$tanggal', '0', '0')";

    $result = mysqli_query($conn, $query);

    // Memeriksa eksekusi
    if ($result) {
      echo '<script>alert("Anda berhasil unlike")</script>';
      echo "<script>window.location='gallery-single.php?galeri=$galeri_id_like'</script>";

    } else {
      echo '<script>alert("Error")</script>';
    }
  } else {
    // Jika pengguna sudah memberikan unlike pada galeri tersebut sebelumnya
    echo '<script>alert("Anda sudah memberikan unlike untuk galeri ini")</script>';
    echo "<script>window.location='gallery-single.php?galeri=$galeri_id_like'</script>";
  }



}

//UNDUH
if (isset($_GET['unduh'])) {
  // Tangkap galeri_id dari URL
  $galeri_id = $_GET['unduh'];

  // Query untuk mengambil informasi gambar berdasarkan galeri_id
  $query_select_gambar = "SELECT * FROM tb_galeri WHERE galeri_id = $galeri_id";
  $result_select_gambar = mysqli_query($conn, $query_select_gambar);

  if ($result_select_gambar && mysqli_num_rows($result_select_gambar) > 0) {
    $row = mysqli_fetch_assoc($result_select_gambar);
    $gambar_path = 'foto/' . $row['gambar']; // Path menuju gambar

    // Set header untuk memberitahu browser bahwa ini adalah file yang akan diunduh
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($gambar_path) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($gambar_path));
    readfile($gambar_path); // Mengirimkan gambar ke browser

    // Setelah pengguna berhasil mengunduh gambar, sisipkan data unduhan ke dalam database
    $nama_user = $_SESSION['nama_user'];
    $id_user = $_SESSION['id'];
    $tanggal = date('Y-m-d H:i:s');

    // Query untuk menyisipkan data unduhan ke dalam tabel tb_like_unlike_unduh
    $query_insert_unduhan = "INSERT INTO tb_like_unlike_unduh (galeri_id, nama_user, id_user, tanggal, unduh) VALUES ('$galeri_id', '$nama_user', '$id_user', '$tanggal', 1)";
    $result_insert_unduhan = mysqli_query($conn, $query_insert_unduhan);

    if ($result_insert_unduhan) {
      echo '<script>alert("Anda berhasil unduh");</script>';
      echo "<script>window.location='gallery-single.php?galeri=$galeri_id'</script>";

    } else {
      echo '<script>alert("Gagal menyimpan data unduhan");</script>';
    }

    exit;
  } else {
    echo "Gambar tidak ditemukan";
  }
}
//total like
function totallike($conn)
{
  if (isset($_GET['galeri'])) {
    $galeri_id_like = $_GET['galeri'];

    $total_records_query = mysqli_query($conn, "SELECT COUNT(*) FROM tb_like_unlike_unduh WHERE galeri_id = $galeri_id_like AND suka = 1");
    if ($total_records_query) {
      $total_records = mysqli_fetch_array($total_records_query)[0];
      echo $total_records;
    } else {
      echo mysqli_error($conn);
    }
  } else {
    echo "Galeri ID tidak ditemukan.";
  }
}

//total unlike
function totalunlike($conn)
{
  if (isset($_GET['galeri'])) {
    $galeri_id_like = $_GET['galeri'];

    $total_records_query = mysqli_query($conn, "SELECT COUNT(*) FROM tb_like_unlike_unduh WHERE galeri_id = $galeri_id_like AND tidaksuka = 1");
    if ($total_records_query) {
      $total_records = mysqli_fetch_array($total_records_query)[0];
      echo $total_records;
    } else {
      echo mysqli_error($conn);
    }
  } else {
    echo "Galeri ID tidak ditemukan.";
  }
}

//total download
function totaldownload($conn)
{
  if (isset($_GET['galeri'])) {
    $galeri_id_like = $_GET['galeri'];

    $total_records_query = mysqli_query($conn, "SELECT COUNT(*) FROM tb_like_unlike_unduh WHERE galeri_id = $galeri_id_like AND unduh = 1");
    if ($total_records_query) {
      $total_records = mysqli_fetch_array($total_records_query)[0];
      echo $total_records;
    } else {
      echo mysqli_error($conn);
    }
  } else {
    echo "Galeri ID tidak ditemukan.";
  }
}


///TAMBAH KOMENTAR
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambahkomentar'])) {
  // menampung inputan dari form
  $iduser = $_SESSION['id'];
  $nama_user = $_SESSION['nama_user'];
  $komentar = $_POST['komentar'];
  $galeri_id = $_GET['galeri'];
  $insert = mysqli_query($conn, "INSERT INTO `tb_komentar` (`id_komentar`, `id_user`, `id_galeri`, `nama_user`, `description`) VALUES (NULL, '$iduser', '$galeri_id', '$nama_user', '$komentar');");

  if ($insert) {
    echo '<script>alert("Anda berhasil membuat komentar");</script>';
    echo "<script>window.location='gallery-single.php?galeri=$galeri_id'</script>";
      exit();
  } else {
      echo 'gagal' . mysqli_error($conn);
  }


}

//HAPUS KOMENTAR
if (isset($_GET['id']) && !empty($_GET['id'])) {
  $galeri_id = $_GET['galeri'];
  $idkomentar = $_GET['id'];

  //query hapus
  $query = "DELETE FROM tb_komentar WHERE id_komentar = $idkomentar";
  $hapus = mysqli_query($conn, $query);

  if ($hapus) {
    echo '<script>alert("Anda berhasil mengahpus");</script>';
    echo "<script>window.location='gallery-single.php?galeri=$galeri_id'</script>";
      exit();
  } else {
      echo "Gagal menghapus pengguna.";
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Galeri Foto</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Cardo:ital,wght@0,400;0,700;1,400&display=swap"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center  me-auto me-lg-0">
        <i class="bi bi-camera"></i>
        <h1>Galeri Foto</h1>
      </a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="index.php">Dashboard</a></li>
          <li><a href="Keluar.php">Keluar</a></li>
          <li><a href="data_foto_user.php">Data Foto</a></li>

        </ul>
      </nav><!-- .navbar -->

      <div class="header-social-links">

      </div>
      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

    </div>
  </header><!-- End Header -->

  <main id="main" data-aos="fade" data-aos-delay="1500">

    <?php
    $galeriid = isset($_GET['galeri']) ? $_GET['galeri'] : '';

    $query = "SELECT * FROM tb_galeri  WHERE galeri_id = '$galeriid' LIMIT 1 ";

    if (!empty($galeriid)) {
      // Eksekusi query
      $result = mysqli_query($conn, $query);

      // Periksa apakah query berhasil dieksekusi
      if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        ?>
        <!-- ======= End Page Header ======= -->
        <div class="page-header d-flex align-items-center">
          <div class="container position-relative">
            <div class="row d-flex justify-content-center">
              <div class="col-lg-6 text-center">
                <h2>Foto
                  <?php echo $row['kategori_galeri']; ?>
                </h2>
              </div>
            </div>
          </div>
        </div><!-- End Page Header -->

        <!-- ======= Gallery Single Section ======= -->
        <section id="gallery-single" class="gallery-single">
          <div class="container">
            <div class="position-relative h-100">
              <div class="slides-1 portfolio-details-slider swiper">
                <div class="swiper-wrapper align-items-center">
                  <div class="swiper-slide">
                    <img src="foto/<?php echo $row['gambar']; ?>" alt="">
                    <a href="gallery-single.php?like=<?php echo $row['galeri_id']; ?>" class="details-link"><i
                        class="bi bi-hand-thumbs-up-fill"></i>
                      <?php totallike($conn); ?>
                    </a>
                    <a href="gallery-single.php?unlike=<?php echo $row['galeri_id']; ?>" class="details-link"><i
                        class="bi bi-hand-thumbs-down-fill"></i>
                      <?php totalunlike($conn); ?>
                    </a>
                    <a href="gallery-single.php?unduh=<?php echo $row['galeri_id']; ?>" class="details-link"><i
                        class="bi bi-cloud-arrow-down-fill"></i></i>
                      <?php totaldownload($conn); ?>
                    </a>
                  </div>
                </div>
                <div class="swiper-pagination"></div>
              </div>
              <div class="swiper-button-prev"></div>
              <div class="swiper-button-next"></div>
            </div>
            <div class="row justify-content-between gy-4 mt-4">
              <div class="col-lg-8">
                <div class="portfolio-description">
                  <h2>
                    <?php echo $row['galeri_name']; ?>
                  </h2>
                  <p>
                    <?php echo $row['galeri_deskripsi']; ?>
                  </p>



                </div>






                <?php
      } else {
        header("Location: index.php");
      }
    }else{
      header("Location: index.php");
    }
    ?>

            <?php
            $galeri_id = $_GET['galeri'];
            $query_komentar = "SELECT * FROM tb_komentar where id_galeri = '$galeri_id'";
            $result_komentar = mysqli_query($conn, $query_komentar);

            if (mysqli_num_rows($result_komentar) > 0) {
              while ($row = mysqli_fetch_assoc($result_komentar)) {
                $id_komentar = $row['id_komentar'];
                $id_user = $row['id_user'];
                $nama_user = $row['nama_user'];
                $description = $row['description'];
                ?>
                <?php
                if ($id_user == $_SESSION['id']) {
                  ?>
         <a href="gallery-single.php?galeri=<?php   $galeri_id = $_GET['galeri']; echo $galeri_id; ?>&id=<?php echo $id_komentar; ?>" class="signature-link" onclick='return confirm("Apakah Anda yakin ingin menghapus pengguna ini?")'>
    <i class="bi bi-trash-fill"></i>
</a>

                  <?php
                }
                ?>

                <div class="row">
                  <div class="col-md-1">
                    <img src="assets/img/user.png" width="100%" alt="Avatar" class="profile-picture">
                  </div>
                  <div class="col-md-8">
                    <h3 class="username">
                      <?php echo $nama_user; ?>
                    </h3>
                    <p class="user-bio">
                      <?php echo $description; ?>
                    </p>
                  </div>
                </div>
                <?php
              }
            } 
            ?>




            <form action="" method="post" class="d-flex justify-content-start">
              <div class="input-box">
                <input type="text" name="komentar" placeholder="Komentar" id="search" class="input-control">
                <i class='bx bxs-lock-alt'></i>
              </div>
              <div class="col-lg-4">
                <button type="submit" name="tambahkomentar" class="btn btn-primary">Komentar</button>
              </div>
            </form>



          </div>

        </div>
      </div>
    </section><!-- End Gallery Single Section -->


  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="container">


    </div>
  </footer><!-- End Footer -->

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <div id="preloader">
    <div class="line"></div>
  </div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>