<?php
    include 'db.php';

    session_start();
    if (!isset($_SESSION['sebagaiadmin']) || $_SESSION['sebagaiadmin'] !== true) {
      echo '<script>window.location="login.php"</script>';
      exit; 
    }
//totaluser
    function totaluser($conn) {
        $total_records_query = mysqli_query($conn, "SELECT COUNT(*) FROM tb_user");
        if ($total_records_query) {
            $total_records = mysqli_fetch_array($total_records_query)[0];
            echo "" . $total_records;
        } else {
            echo "" . mysqli_error($conn);
        }
    }
//totalgaleri
    function totalgaleri($conn) {
        $total_records_query = mysqli_query($conn, "SELECT COUNT(*) FROM tb_galeri");
        if ($total_records_query) {
            $total_records = mysqli_fetch_array($total_records_query)[0];
            echo "" . $total_records;
        } else {
            echo "" . mysqli_error($conn);
        }
    }
    function totalike($conn) {
        $total_records_query = mysqli_query($conn, "SELECT COUNT(*) AS suka FROM tb_like_unlike_unduh WHERE suka = 1");
        if ($total_records_query) {
            $total_records = mysqli_fetch_array($total_records_query)['suka'];
            echo $total_records;
        } else {
            echo mysqli_error($conn);
        }
    }

    
    function unlike($conn) {
        $total_records_query = mysqli_query($conn, "SELECT COUNT(*) AS tidaksuka FROM tb_like_unlike_unduh WHERE tidaksuka = 1");
        if ($total_records_query) {
            $total_records = mysqli_fetch_array($total_records_query)['tidaksuka'];
            echo $total_records;
        } else {
            echo mysqli_error($conn);
        }
    }

    
    function totalunduh($conn) {
        $total_records_query = mysqli_query($conn, "SELECT COUNT(*) AS unduh FROM tb_like_unlike_unduh WHERE unduh = 1");
        if ($total_records_query) {
            $total_records = mysqli_fetch_array($total_records_query)['unduh'];
            echo $total_records;
        } else {
            echo mysqli_error($conn);
        }
    }



    function totalkomen($conn) {
        $total_records_query = mysqli_query($conn, "SELECT COUNT(*) FROM tb_komentar ");
        if ($total_records_query) {
            $total_records = mysqli_fetch_array($total_records_query)[0];
            echo $total_records;
        } else {
            echo mysqli_error($conn);
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
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Cardo:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

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
include "header.php"
?>


  <!-- ======= Hero Section ======= -->
  <section id="hero" class="hero d-flex flex-column justify-content-center align-items-center" data-aos="fade" data-aos-delay="1500">
    <div class="container">
      <div class="row justify-content-center">
        
      </div>
    </div>
  </section><!-- End Hero Section -->

  <main id="main" data-aos="fade" data-aos-delay="1500">

    <!-- content -->
    <div class="section">
        <div class="container">
        <h4>Selamat Datang <?php echo $_SESSION['nama_user'] ?> di Website Galeri Foto</h4>
        </div>

        <div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="custom-box">
                <div class="rounded-lg bg-accent-dark p-2 text-center rounded-full bg-accent font-semibold text-white transition-all hover:bg-accent-dark">
                    <span class="text-fill-transparent bg-gradient-to-r from-[#FFE993] to-[#FFB770] bg-clip-text font-display text-5xl font-semibold"><?php totaluser($conn); ?></span>
                    <div class="mt-2">
                        <span class="text-lg text-jacarta-700 text-white font-semibold">Total Pengguna</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="custom-box">
                <div class="rounded-lg bg-accent-dark p-2 text-center rounded-full bg-accent font-semibold text-white transition-all hover:bg-accent-dark">
                    <span class="text-fill-transparent bg-gradient-to-r from-[#FFE993] to-[#FFB770] bg-clip-text font-display text-5xl font-semibold"><?php totalike($conn); ?></span>
                    <div class="mt-2">
                        <span class="text-lg text-jacarta-700 text-white font-semibold">Total Like</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="custom-box">
                <div class="rounded-lg bg-accent-dark p-2 text-center rounded-full bg-accent font-semibold text-white transition-all hover:bg-accent-dark">
                    <span class="text-fill-transparent bg-gradient-to-r from-[#FFE993] to-[#FFB770] bg-clip-text font-display text-5xl font-semibold"><?php unlike($conn); ?></span>
                    <div class="mt-2">
                        <span class="text-lg text-jacarta-700 text-white font-semibold">Total Unlike</span>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="custom-box">
                <div class="rounded-lg bg-accent-dark p-2 text-center rounded-full bg-accent font-semibold text-white transition-all hover:bg-accent-dark">
                    <span class="text-fill-transparent bg-gradient-to-r from-[#FFE993] to-[#FFB770] bg-clip-text font-display text-5xl font-semibold"><?php totalkomen($conn); ?></span>
                    <div class="mt-2">
                        <span class="text-lg text-jacarta-700 text-white font-semibold">Total Komen</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="custom-box">
                <div class="rounded-lg bg-accent-dark p-2 text-center rounded-full bg-accent font-semibold text-white transition-all hover:bg-accent-dark">
                    <span class="text-fill-transparent bg-gradient-to-r from-[#FFE993] to-[#FFB770] bg-clip-text font-display text-5xl font-semibold"><?php totalgaleri($conn); ?></span>
                    <div class="mt-2">
                        <span class="text-lg text-jacarta-700 text-white font-semibold">Total Galeri Foto</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="custom-box">
                <div class="rounded-lg bg-accent-dark p-2 text-center rounded-full bg-accent font-semibold text-white transition-all hover:bg-accent-dark">
                    <span class="text-fill-transparent bg-gradient-to-r from-[#FFE993] to-[#FFB770] bg-clip-text font-display text-5xl font-semibold"><?php totalunduh($conn); ?></span>
                    <div class="mt-2">
                        <span class="text-lg text-jacarta-700 text-white font-semibold">Total Download</span>
                    </div>
                </div>
            </div>
        </div>




    </div>
</div>

<div class="section">
<div class="container">
        <h4>Data Galeri Foto Terbaru</h4>

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


  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

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