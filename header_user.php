<!-- ======= Header ======= -->
<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center  me-auto me-lg-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <i class="bi bi-camera"></i>
        <h1>Galeri Foto</h1>
      </a>

      <nav id="navbar" class="navbar">


        <ul>
          <li><a href="index.php">Dashboard</a></li>
          <li><a href="pengaturan_user.php">Pengaturan</a></li>
          <li><a href="data_foto_user.php">Data Foto</a></li>
          <li class="dropdown"><a href="gallery-single.php?galeri=<?php echo $row['galeri_id'];  ?>"><span>Gallery</span> <i
                class="bi bi-chevron-down dropdown-indicator"></i></a>
            <ul>
              <?php
              $query = "SELECT nama_kategori FROM tb_kategori";
              $result = mysqli_query($conn, $query);

              if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                  $kategori = $row['nama_kategori'];
                  echo "<li><a href=\"index.php?kategori=$kategori\">$kategori</a></li>";
                }
              } else {
                echo "Error kategori: " . mysqli_error($connection);
              }
              ?>

            </ul>
          </li>
          <li><a href="keluar.php">Keluar</a></li>
        </ul>
      </nav><!-- .navbar -->

      <div class="header-social-links">

        <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
        <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

      </div>
  </header><!-- End Header -->