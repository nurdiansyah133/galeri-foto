<?php
include 'db.php';

session_start();
if (!isset($_SESSION['sebagaiadmin']) || $_SESSION['sebagaiadmin'] !== true) {
  echo '<script>window.location="login.php"</script>';
  exit; 
}


///UPDATE
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updatekategori'])) {
    $id_kategori = $_POST['id_kategori'];
    $nama_kategori = $_POST['nama_kategori'];


    $update = mysqli_query($conn, "UPDATE tb_kategori SET nama_kategori='$nama_kategori' WHERE id_kategori='$id_kategori'");
    if ($update) {
        echo '<script>alert("Berhasil")</script>';
        echo '<script>window.location="data_kategori.php"</script>';
        exit();
    } else {
        echo '<script>alert("Gagal: ' . mysqli_error($conn) . '")</script>';
    }
}


///HAPUS
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_kategori = $_GET['id'];

    //query hapus
    $query = "DELETE FROM tb_kategori WHERE id_kategori = $id_kategori";
    $hapus = mysqli_query($conn, $query);

    if ($hapus) {
        echo '<script>window.location="data_kategori.php"</script>';
        exit();
    } else {
        echo "Gagal menghapus pengguna.";
    }
}

// Tambah kategori
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambahkategori'])) {
    // menampung inputan dari form
    $namakategori = $_POST['namakategori'];
    $insert = mysqli_query($conn, "INSERT INTO `tb_kategori` (`id_kategori`, `nama_kategori`) VALUES (NULL, '$namakategori');");

    if ($insert) {
        echo '<script>alert("Tambah Kategori berhasil")</script>';
        echo '<script>window.location="data_kategori.php"</script>';
        exit();
    } else {
        echo 'gagal' . mysqli_error($conn);
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
    <title>Galeri</title>


</head>

<body>

<?php 
include "header.php"
?>

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="hero d-flex flex-column justify-content-center align-items-center" data-aos="fade"
        data-aos-delay="1500">
        <h1>Data Kategori</h1>
        <div class="col-md-5">


            <div class="container">
                <div class="row">
                    <div class="col">
                        <form action="data_kategori.php" method="GET" class="d-flex justify-content-start">
                            <div class="input-box">
                                <input type="text" name="search" placeholder="Cari Nama Kategori" id="search"
                                    class="input-control">
                                <i class='bx bxs-lock-alt'></i>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-4">
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                            data-target="#Tambahfoto">Tambah Kategori</button>

                        <div class="modal fade" id="Tambahfoto">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Tambah Kategori</h4>
                                    </div>
                                    <!-- Modal Body -->
                                    <div class="modal-body">
                                        <form action="" method="POST">
                                            <div class="input-box">
                                                <label>Nama Kategori:</label>
                                                <input type="text" name="namakategori" placeholder="Kategori"
                                                    id="namakategori" class="input-control">
                                                <i class='bx bxs-lock-alt'></i>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Tutup</button>
                                                <button type="submit" name="tambahkategori"
                                                    class="btn btn-primary">Tambah
                                                    Kategori</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>


            <table>
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th>Nama Kategori</th>
                        <th width="30%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $limit = 10; // Jumlah data per halaman
                    $page = isset($_GET['page']) ? $_GET['page'] : 1; // Halaman saat ini
                    
                    $keyword = isset($_GET['search']) ? $_GET['search'] : '';



                    // Menghitung offset
                    $offset = ($page - 1) * $limit;

                    // Query untuk mengambil jumlah total data
                    $total_records_query = mysqli_query($conn, "SELECT COUNT(*) FROM tb_kategori");
                    $total_records = mysqli_fetch_array($total_records_query)[0];

                    // Pagination
                    $total_pages = ceil($total_records / $limit); // Menghitung total halaman
                    
                    // Query utama untuk mengambil data sesuai dengan batasan limit dan offset
                    $query = "SELECT * FROM tb_kategori";

                    // Tambahkan kondisi WHERE jika ada keyword pencarian
                    if (!empty($keyword)) {
                        $query .= " WHERE nama_kategori LIKE '%$keyword%' OR nama_kategori LIKE '%$keyword%'";
                    }

                    $query .= " LIMIT $limit OFFSET $offset";


                    $cek = mysqli_query($conn, $query);

                    if (mysqli_num_rows($cek) > 0) {
                        while ($d = mysqli_fetch_object($cek)) {
                            echo "<tr>";
                            echo "<td>" . $d->id_kategori . "</td>";
                            echo "<td>" . $d->nama_kategori . "</td>";
                            echo "<td> <button type='button' class='btn btn-primary editBtn' data-toggle='modal' data-target='#editModal' data-id='" . $d->id_kategori . "' data-nama='" . $d->nama_kategori . "' >Edit</button>
        <a href='data_kategori.php?id=" . $d->id_kategori . "' class='btn btn-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus pengguna ini?\")'>Hapus</a> </td>";

                            echo "</tr>";
                        }
                    } else {
                        echo "Tidak ada data yang ditemukan.";
                    }

                    ?>

                </tbody>
            </table>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <?php if ($page > 1): ?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo ($page - 1); ?>">Previous</a></li>
                    <?php else: ?>
                        <li class="page-item disabled"><span class="page-link">Previous</span></li>
                    <?php endif; ?>

                    <!-- Menampilkan tombol pertama dan tombol sebelumnya jika halaman saat ini bukan halaman pertama -->
                    <?php if ($page > 1): ?>
                        <li class="page-item"><a class="page-link" href="?page=1">1</a></li>
                        <?php if ($page > 2): ?>
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php endif; ?>
                    <?php endif; ?>

                    <!-- Menampilkan tombol halaman saat ini serta dua tombol halaman sebelumnya dan dua tombol halaman sesudahnya -->
                    <?php
                    $start = max(2, $page - 2);
                    $end = min($total_pages - 1, $page + 2);
                    for ($i = $start; $i <= $end; $i++):
                        ?>
                        <li class="page-item <?php if ($page == $i)
                            echo 'active'; ?>"><a class="page-link" href="?page=<?php echo $i; ?>">
                                <?php echo $i; ?>
                            </a></li>
                    <?php endfor; ?>

                    <!-- Menampilkan tombol terakhir dan tombol sesudahnya jika halaman saat ini bukan halaman terakhir -->
                    <?php if ($page < $total_pages): ?>
                        <?php if ($page < $total_pages - 1): ?>
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php endif; ?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo $total_pages; ?>">
                                <?php echo $total_pages; ?>
                            </a></li>
                    <?php endif; ?>

                    <?php if ($page < $total_pages): ?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo ($page + 1); ?>">Next</a></li>
                    <?php else: ?>
                        <li class="page-item disabled"><span class="page-link">Next</span></li>
                    <?php endif; ?>
                </ul>
            </nav>

        </div>
    </section>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Kategori</h5>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        <input type="hidden" name="id_kategori" id="userId">
                        <div class="input-box">
                            <label>Nama Kategori:</label>
                            <input type="text" name="nama_kategori" placeholder="nama kategori" id="editKategori"
                                class="input-control">
                            <i class='bx bxs-lock-alt'></i>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" name="updatekategori" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



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

    <!-- Modal -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



    <script>
        $(document).ready(function () {
            // Menangani klik tombol "Edit"
            $('.editBtn').click(function () {
                // Mendapatkan ID pengguna dari atribut data-id
                var userId = $(this).data('id');
                var userName = $(this).data('nama');
                // Menyalin ID dan nama pengguna ke dalam input di dalam modal edit
                $('#userId').val(userId);
                $('#editUserId').val(userId);
                $('#editKategori').val(userName);
            });
        });
    </script>


    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
</body>

</html>