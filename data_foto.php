<?php
include 'db.php';

session_start();
if (!isset($_SESSION['sebagaiadmin']) || $_SESSION['sebagaiadmin'] !== true) {
    echo '<script>window.location="login.php"</script>';
    exit;
}



/// LOGIKA CRUD
// UPDATE FOTO
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editfoto'])) {

    $idgambar = $_POST['idgambar'];
    $editnamafoto = $_POST['editnamafoto'];
    $editdeskripsi = $_POST['editdeskripsi'];
    $editkategori = $_POST['editkategori'];
    $editstatus = $_POST['editstatus'];
    $foto = $_POST['editgambar'];

    // Data gambar yang baru 
    $filename = $_FILES['gambar']['name'];
    $tmp_name = $_FILES['gambar']['tmp_name'];

    $idadmin = $_SESSION['id'];
    $nama_user = $_SESSION['nama_user'];

    // Jika admin mengganti gambar
    if ($filename != '') {

        $type1 = explode('.', $filename);
        $type2 = $type1[1];

        $newname = 'foto' . time() . '.' . $type2;

        // Menampung data format file yang diizinkan
        $tipe_diizinkan = array('jpg', 'jpeg', 'png', 'gif');

        // Validasi format file
        if (!in_array($type2, $tipe_diizinkan)) {
            // Jika format file tidak ada di dalam tipe diizinkan
            echo '<script>alert("Format file tidak diizinkan")</script>';

        } else {
            // Hapus gambar lama
            unlink('./foto/' . $foto);
            // Pindahkan file baru ke direktori foto
            move_uploaded_file($tmp_name, './foto/' . $newname);
            // Tetapkan nama gambar baru
            $namagambar = $newname;
        }

    } else {
        // Jika admin tidak mengganti gambar, gunakan nama gambar lama
        $namagambar = $foto;

    }
    // Query untuk update data produk
    $update = mysqli_query($conn, "UPDATE tb_galeri SET
            galeri_name       = '" . $editnamafoto . "',
            galeri_deskripsi  = '" . $editdeskripsi . "',
            gambar            = '" . $namagambar . "',
            galeri_status     = '" . $editstatus . "',
            kategori_galeri   = '" . $editkategori . "',
            user_id           = '$idadmin',
            admin_name        = '$nama_user'
            WHERE galeri_id   = '" . $idgambar . "' ");

    if ($update) {
        echo '<script>alert("Ubah data berhasil")</script>';
        echo '<script>window.location="data_foto.php"</script>';
    } else {
        echo 'gagal' . mysqli_error($conn);
    }
}


//HAPUS FOTO
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_galarry = $_GET['id'];

    //query hapus
    $query = "DELETE FROM tb_galeri WHERE galeri_id = $id_galarry";
    $hapus = mysqli_query($conn, $query);

    if ($hapus) {
        echo '<script>window.location="data_foto.php"</script>';
        exit();
    } else {
        echo "Gagal menghapus pengguna.";
    }
}


/// TAMBAH FOTO
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambahfoto'])) {
    // menampung inputan dari form
    $namafoto = $_POST['namafoto'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori'];
    $status = $_POST['status'];
    $idadmin = $_SESSION['id'];
    $nama_user = $_SESSION['nama_user'];

    $filename = $_FILES['gambar']['name'];
    $tmp_name = $_FILES['gambar']['tmp_name'];
    $type1 = explode('.', $filename);
    $type2 = end($type1); // Menggunakan end() untuk mendapatkan ekstensi file

    $newname = 'foto' . time() . '.' . $type2;

    // menampung data format file yang diizinkan
    $tipe_diizinkan = array('jpg', 'jpeg', 'png', 'gif');

    if (!in_array($type2, $tipe_diizinkan)) {
        // jika format file tidak ada di dalam tipe diizinkan
        echo '<script>alert("Format file tidak diizinkan")</script>';
    } else {

        move_uploaded_file($tmp_name, './foto/' . $newname);

        $insert = mysqli_query($conn, "INSERT INTO `tb_galeri` (`galeri_id`, `user_id`, `admin_name`, `galeri_name`, `galeri_deskripsi`, `gambar`, `galeri_status`, `tanggal_buat`, `kategori_galeri`) VALUES (NULL, '$idadmin', '$nama_user', '$namafoto', '$deskripsi', '$newname', '$status', current_timestamp(), '$kategori');");

        if ($insert) {
            echo '<script>alert("Tambah Foto berhasil")</script>';
            echo '<script>window.location="data_foto.php"</script>';
            exit();
        } else {
            echo 'gagal' . mysqli_error($conn);
        }
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
        <h1>Data Galeri</h1>
        <div class="col-md-9">

            <div class="container">
                <div class="row">
                    <div class="col">
                        <form action="data_foto.php" method="GET" class="d-flex justify-content-start">
                            <div class="input-box">
                                <input type="text" name="search" placeholder="Cari Nama Foto" id="search"
                                    class="input-control">
                                <i class='bx bxs-lock-alt'></i>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-2">
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                            data-target="#Tambahfoto">Tambah Foto</button>

                        <div class="modal fade" id="Tambahfoto">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Tambah Foto</h4>
                                    </div>
                                    <!-- Modal Body -->
                                    <div class="modal-body">
                                        <form action="" method="POST" enctype="multipart/form-data">
                                            <input type="hidden" id="userId" name="userId">
                                            <div class="input-box">
                                                <label>Nama Foto:</label>
                                                <input type="text" name="namafoto" placeholder="Nama Foto" id="namafoto"
                                                    class="input-control">
                                                <i class='bx bxs-lock-alt'></i>
                                            </div>
                                            <div class="input-box">
                                                <label>Deskripsi:</label>
                                                <input type="text" name="deskripsi" placeholder="Deskripsi"
                                                    id="deskripsi" class="input-control">
                                                <i class='bx bxs-lock-alt'></i>
                                            </div>

                                            <div class="input-box">
                                                <label for="editUserAkses">Kategori:</label>
                                                <select class="form-control" name="kategori" id="kategori">
                                                    <?php


                                                    $query = "SELECT nama_kategori FROM tb_kategori";
                                                    $result = mysqli_query($conn, $query);


                                                    if ($result) {

                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            $kategori = $row['nama_kategori'];
                                                            echo "<option value=\"$kategori\">$kategori</option>";
                                                        }
                                                    } else {

                                                        echo "Error kategori: " . mysqli_error($connection);
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="input-box">
                                                <label for="editUserAkses">Galeri Status:</label>
                                                <select class="form-control" name="status" id="status">
                                                    <option value="1">Aktif</option>
                                                    <option value="0">Tidak Aktif</option>
                                                </select>
                                            </div>

                                            <label for="editUserAkses">Unggah Foto:</label> <br>
                                            <input type="file" name="gambar" id="gambar" class="input-control">


                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Tutup</button>
                                                <button type="submit" name="tambahfoto" class="btn btn-primary">Tambah
                                                    Foto</button>
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
                        <th>Nama Admin</th>
                        <th>Nama Foto</th>
                        <th>Gambar</th>
                        <th></th>
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
                    $total_records_query = mysqli_query($conn, "SELECT COUNT(*) FROM tb_galeri");
                    $total_records = mysqli_fetch_array($total_records_query)[0];

                    // Pagination
                    $total_pages = ceil($total_records / $limit); // Menghitung total halaman
                    
                    // Query utama untuk mengambil data sesuai dengan batasan limit dan offset
                    $query = "SELECT * FROM tb_galeri";

                    // Tambahkan kondisi WHERE jika ada keyword pencarian
                    if (!empty($keyword)) {
                        $query .= " WHERE galeri_name LIKE '%$keyword%' OR admin_name LIKE '%$keyword%'";
                    }

                    $query .= " LIMIT $limit OFFSET $offset";


                    $cek = mysqli_query($conn, $query);



                    if (mysqli_num_rows($cek) > 0) {
                        while ($d = mysqli_fetch_object($cek)) {
                            echo "<tr>";
                            echo "<td>" . $d->galeri_id . "</td>";
                            echo "<td>" . $d->admin_name . " (" . $d->user_id . ")</td>";
                            echo "<td>" . $d->galeri_name . "</td>";
                            echo "<td>" . $d->gambar . "</td>";
                            echo "<td> <button type='button' class='btn btn-primary editBtn' data-toggle='modal' data-target='#editModal' 
                            data-id='" . $d->galeri_id . "' 
                            data-nama='" . $d->galeri_name . "' 
                            data-akses='" . $d->galeri_deskripsi . "'
                            data-gambar='" . $d->gambar . "'
                            data-tanggal='" . $d->tanggal_buat . "'
                            data-status='" . $d->galeri_status . "'
                            data-kategori='" . $d->kategori_galeri . "'

                            >Edit</button>
        <a href='data_foto.php?id=" . $d->galeri_id . "' class='btn btn-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus pengguna ini?\")'>Hapus</a> </td>";

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
                    <h5 class="modal-title" id="editModalLabel">Edit Galeri</h5>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <input type="hidden" id="idgambar" name="idgambar">
                        <div class="input-box">
                            <input type="hidden" name="editgambar" placeholder="Gambar" id="editgambar"
                                class="input-control">
                            <img src="" alt="Deskripsi Gambar" width="50%" height="50%" id="gambar-preview">
                        </div>
                        <div class="input-box">
                            <label>Nama Foto:</label>
                            <input type="text" name="editnamafoto" placeholder="Username" id="editnamafoto"
                                class="input-control">
                            <i class='bx bxs-lock-alt'></i>
                        </div>
                        <div class="input-box">
                            <label>Deskripsi:</label>
                            <input type="text" name="editdeskripsi" placeholder="Deskripsi" id="editdeskripsi"
                                class="input-control">
                            <i class='bx bxs-lock-alt'></i>
                        </div>
                        <div class="input-box">
                            <label>Tanggal Dibuat:</label>
                            <input type="text" name="tanggalfoto" id="tanggalfoto" disabled class="input-control">
                            <i class='bx bxs-lock-alt'></i>
                        </div>
                        <label for="editUserAkses">Unggah Foto Baru:</label> <br>
                        <input type="file" name="gambar" id="gambar" class="input-control">

                        <div class="input-box">
                            <label for="editUserAkses">Kategori:</label>
                            <select class="form-control" name="editkategori" id="editkategori">
                                <?php


                                $query = "SELECT nama_kategori FROM tb_kategori";
                                $result = mysqli_query($conn, $query);


                                if ($result) {

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $kategori = $row['nama_kategori'];
                                        echo "<option value=\"$kategori\">$kategori</option>";
                                    }
                                } else {

                                    echo "Error kategori: " . mysqli_error($connection);
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-box">
                            <label for="editUserAkses">Galeri Status:</label>
                            <select class="form-control" name="editstatus" id="editstatus">
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" name="editfoto" class="btn btn-primary">Simpan Perubahan</button>
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



    <script>
        $(document).ready(function () {
            // Menangani klik tombol "Edit"
            $('.editBtn').click(function () {
                // Mendapatkan data dari atribut data-*
                var userId = $(this).data('id');
                var galeri_name = $(this).data('nama');
                var galeri_deskripsi = $(this).data('akses');
                var gambar = $(this).data('gambar');
                var tanggalfoto = $(this).data('tanggal');
                var status = $(this).data('status');
                var kategori = $(this).data('kategori');


                // Menyalin data ke dalam input di dalam modal edit
                $('#idgambar').val(userId);
                $('#editnamafoto').val(galeri_name);
                $('#editdeskripsi').val(galeri_deskripsi);
                $('#editgambar').val(gambar);
                $('#tanggalfoto').val(tanggalfoto);
                $('#editstatus').val(status);
                $('#editkategori').val(kategori);


                $('#gambar-preview').attr('src', 'foto/' + gambar); // Ganti path_to_folder dengan path yang sesuai



            });
        });
    </script>



    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
</body>

</html>