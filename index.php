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
    } else {
      echo '<script>alert("Error")</script>';
    }
  } else {
    // Jika pengguna sudah memberikan like pada galeri tersebut sebelumnya
    echo '<script>alert("Anda sudah memberikan like untuk galeri ini")</script>';
  }



}


///UNLIKE 
if (isset($_GET['unlike'])) {
  // Tangkap galeri_id dari URL
  $galeri_id_like = $_GET['unlike'];

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
    $query = "INSERT INTO `tb_like_unlike_unduh` (`like_id`, `galeri_id`, `nama_user`, `id_user`, `suka`, `tidaksuka`, `tanggal`, `unduh`, `unduh_id`) VALUES (NULL, '$galeri_id_like', '$nama_user', '$id_user', '0', '1', '$tanggal', '0', '0')";

    $result = mysqli_query($conn, $query);

    // Memeriksa eksekusi
    if ($result) {
      echo '<script>alert("Anda berhasil unlike")</script>';
    } else {
      echo '<script>alert("Error")</script>';
    }
  } else {
    // Jika pengguna sudah memberikan like pada galeri tersebut sebelumnya
    echo '<script>alert("Anda sudah memberikan unlike untuk galeri ini")</script>';
  }



}

//UNDUH
if (isset($_GET['unduh'])) {
  // Tangkap galeri_id dari URL
  $galeri_id = $_GET['unduh'];

  // Query untuk mengambil informasi gambar berdasarkan galeri_id
  $query_select_gambar = "SELECT * FROM tb_galeri WHERE galeri_id = $galeri_id";
  $result_select_gambar = mysqli_query($conn, $query_select_gambar);

  if($result_select_gambar && mysqli_num_rows($result_select_gambar) > 0) {
      $row = mysqli_fetch_assoc($result_select_gambar);
      $gambar_path = 'foto/' . $row['gambar']; // Path menuju gambar

      // Set header untuk memberitahu browser bahwa ini adalah file yang akan diunduh
      header('Content-Description: File Transfer');
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename="'.basename($gambar_path).'"');
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
      } else {
          echo '<script>alert("Gagal menyimpan data unduhan");</script>';
      }

      exit;
  } else {
      echo "Gambar tidak ditemukan";
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

<?php 
include "header_user.php"
?>

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="hero d-flex flex-column justify-content-center align-items-center" data-aos="fade"
    data-aos-delay="1500">
    <marquee behavior="scroll" direction="left">
      <h4>Selamat Datang
        <?php echo $_SESSION['nama_user'] ?> di Website Galeri Foto
      </h4>
    </marquee>

  </section><!-- End Hero Section -->

  <main id="main" data-aos="fade" data-aos-delay="1500">

    <!-- ======= Gallery Section ======= -->
    <section id="gallery" class="gallery">
      <div class="container-fluid">


        <div class="row gy-4 justify-content-center">

          <?php

          $kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';

          $query = "SELECT * FROM tb_galeri WHERE galeri_status = 1";

          if (!empty($kategori)) {
            $query .= " AND kategori_galeri = '$kategori'";
          }

          $query .= " ORDER BY tanggal_buat DESC LIMIT 20";

          $total_records_query = mysqli_query($conn, $query);

          if ($total_records_query) {
            while ($row = mysqli_fetch_assoc($total_records_query)) {
              ?>
              <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="gallery-item h-100">
                  <img src="foto/<?php echo $row['gambar']; ?>" class="img-fluid" alt="image"
                    style="width:500px;height:270px;">
                  <div class="gallery-links d-flex align-items-center justify-content-center">

                    <a href="foto/<?php echo $row['gambar']; ?>" title="<?php echo $row['galeri_name']; ?>"
                      class="glightbox preview-link">
                      <i class="bi bi-arrows-angle-expand"></i>
                    </a>


                    <a href="gallery-single.php?galeri=<?php echo $row['galeri_id']; ?>" class="details-link"><i class="bi bi-link-45deg"></i></a>

                    <a href="index.php?like=<?php echo $row['galeri_id']; ?>" class="details-link"><i
                        class="bi bi-hand-thumbs-up-fill"></i></a>

                    <a href="index.php?unlike=<?php echo $row['galeri_id']; ?>" class="details-link"><i
                        class="bi bi-hand-thumbs-down-fill"></i></a>

                        
                    <a href="index.php?unduh=<?php echo $row['galeri_id']; ?>" class="details-link">
                    <i class="bi bi-cloud-arrow-down-fill"></i>
                    </a>


                  </div>

                </div>
              </div>
              <?php
            }
          } else {
            echo "Error: " . mysqli_error($conn);
          }
          ?>



        </div>

      </div>
    </section><!-- End Gallery Section -->

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