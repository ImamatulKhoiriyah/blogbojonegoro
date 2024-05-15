<?php
include '../connection.php';

if (isset($_POST['artadd'])) {

    $tanggal = isset($_POST['tanggal']) ? date('Y-m-d', strtotime($_POST['tanggal'])) : '';
    $judul = isset($_POST['judul']) ? $_POST['judul'] : '';
    $penulis = isset($_POST['penulis']) ? $_POST['penulis'] : '';
    $kategori = isset($_POST['id_kategori']) ? $_POST['id_kategori'] : '';
    $isi = isset($_POST['isi']) ? $_POST['isi'] : '';
    $gambar = upload_file();

    $tambah = mysqli_query($conn, "INSERT INTO artikel ( penulis, tanggal, judul, id_kategori, isi, gambar) 
    VALUES ('$penulis', '$tanggal', '$judul', '$kategori', '$isi', '$gambar')");
    
    if ($tambah) {
        echo "<script> 
        alert('Add article successful');
        document.location='viewArticle.php';
        </script>";
    } else {
        echo "<script> 
        alert('Add article failed');
        document.location='viewArticle.php';
        </script>";
    }
    mysqli_close($conn);
}


if (isset($_POST['artedit'])) {
    $id_artikel = isset($_POST['id_artikel']) ? $_POST['id_artikel'] : '';
    $penulis = isset($_POST['penulis']) ? $_POST['penulis'] : '';
    $tanggal = isset($_POST['tanggal']) ? date('Y-m-d', strtotime($_POST['tanggal'])) : '';
    $judul = isset($_POST['judul']) ? $_POST['judul'] : '';
    $kategori = isset($_POST['id_kategori']) ? $_POST['id_kategori'] : '';
    $isi = isset($_POST['isi']) ? $_POST['isi'] : '';
    $gambar_lama = isset($_POST['gambar_lama']) ? $_POST['gambar_lama'] : '';

    // Mengunggah file gambar hanya jika ada file yang dipilih
    if (isset($_FILES['gambar']) && $_FILES['gambar']['size'] > 0) {
        $file_name = $_FILES['gambar']['name'];
        $file_size = $_FILES['gambar']['size'];
        $file_tmp = $_FILES['gambar']['tmp_name'];
        $file_type = $_FILES['gambar']['type'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Mendefinisikan direktori penyimpanan file
        $target_dir = "../AdminController/img/";

        // Mendefinisikan nama file yang diunggah
        $target_file = $target_dir . basename($file_name);

        // Mendefinisikan ekstensi file yang diizinkan
        $allowed_extensions = array("jpg", "jpeg", "png");

        // Memeriksa ekstensi file yang diunggah
        if (in_array($file_ext, $allowed_extensions) === false) {
            echo "Error: Only JPG, JPEG, and PNG files are allowed.";
            exit();
        }

        // Memeriksa ukuran file yang diunggah
        if ($file_size > 2097152) { // Batas ukuran file 2MB (2097152 bytes)
            echo "Error: File size must be less than 2MB.";
            exit();
        }

        // Memindahkan file yang diunggah ke direktori tujuan
        if (move_uploaded_file($file_tmp, $target_file)) {
            $gambar = basename($file_name);
        } else {
            echo "Error: Failed to upload file.";
            exit();
        }
    } else {
        // Jika tidak ada file gambar yang dipilih, gunakan gambar lama
        $gambar = $gambar_lama;
    }

    $update = mysqli_query($conn, "UPDATE artikel SET tanggal = '$tanggal', judul = '$judul', id_kategori = '$kategori', isi = '$isi', gambar = '$gambar' WHERE id_artikel = '$id_artikel'");

    if ($update) {
        echo "<script> 
        alert('The article update was successful');
        window.location.href = 'viewArticle.php';
        </script>";
    } else {
        echo "<script> 
        alert('Article update failed');
        window.location.href = 'viewArticle.php';
        </script>";
    }
    mysqli_close($conn);
}

else if(isset($_POST['artdelete'])){
    $hapus = mysqli_query($conn, "DELETE FROM artikel WHERE id_artikel = '$_POST[id_artikel]'");

    if($hapus){
        echo "<script> 
        alert('Delete article successful');
        document.location='viewArticle.php';
        </script>";
    }else{
        echo "<script> 
        alert('Delete failed article');
        document.location='viewArticle.php';
        </script>";
    }
}

function upload_file(){
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    $extensifileValid = ['jpg', 'png', 'jpeg'];
    $extensifile = explode('.', $namaFile);
    $extensifile = strtolower(end($extensifile));

    if(!in_array($extensifile, $extensifileValid)){
        echo    "<script> 
                    alert('format gambar tidak valid');
                    document.location='viewArticle.php';
                </script>";
        die();
    }else if($ukuranFile > 2048000){
        echo    "<script> 
                    alert('Ukuran File Max 2 MB');
                    document.location='viewArticle.php';
                </script>";
        die();
    }
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $extensifile;
    move_uploaded_file($tmpName, 'img/'. $namaFileBaru); 
    return $namaFileBaru;
}
?>