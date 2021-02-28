<?php
//koneksi ke database

use PhpMyAdmin\SqlParser\Utils\Query;

$link =  mysqli_connect("localhost", "root", "", "phpdasar");

function query($query)
{
    global $link;
    $result = mysqli_query($link, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function tambah($data)
{
    global $link;
    $nrp = htmlspecialchars($data["nrp"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    // Upload gambar
    $gambar = upload();
    if (!$gambar) {
        return false;
    }

    // query insert data
    $query = "INSERT INTO mahasiswa VALUES ('', '$nrp', '$nama', '$email', '$jurusan', '$gambar')";
    mysqli_query($link, $query);
    return mysqli_affected_rows($link);
}

function upload()
{
    $namafile = $_FILES['gambar']['name'];
    $ukuranfile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    //Cek apakah tidak ada gambar yang diupload
    if ($error === 4) {
        echo "<script> 
            alert('Pilih Gambar Dulu Lur!!');
        </script>";
        return false;
    }

    // Cek yg diupload adalah gambar
    $ekstensiGambarUtuh = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namafile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarUtuh)) {
        echo "<script> 
            alert('Bukan Gambar Lur!!');
        </script>";
        return false;
    }
    // cek jika ukurannya terlalu besar
    if ($ukuranfile > 1000000) {
        echo "<script> 
            alert('Ukuran Gambar terlalu Besar!!');
        </script>";
        return false;
    }
    // generate nama gambar baru
    $namafileBaru = uniqid();
    $namafileBaru .= '.';
    $namafileBaru .= $ekstensiGambar;

    //Lolos 
    move_uploaded_file($tmpName, 'img/' . $namafileBaru);
    return $namafileBaru;
}


function hapus($id)
{
    global $link;
    mysqli_query($link, "DELETE FROM mahasiswa WHERE id=$id");

    return mysqli_affected_rows($link);
}

function ubah($data)
{
    global $link;
    $id = $data["id"];
    $nrp = htmlspecialchars($data["nrp"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    $gambarLama = htmlspecialchars($data["gambarLama"]);

    //cek upload gambar
    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }


    // query update data
    $query = "UPDATE mahasiswa SET nrp='$nrp', nama='$nama', email='$email', jurusan='$jurusan', gambar='$gambar' WHERE id=$id";
    mysqli_query($link, $query);
    return mysqli_affected_rows($link);
}

function cari($keyword)
{
    $query = "SELECT * FROM mahasiswa WHERE 
                nama LIKE '%$keyword%' OR
                nrp LIKE '%$keyword%' OR
                email LIKE '%$keyword%' OR
                jurusan LIKE '%$keyword%' 
    ";
    return Query($query);
}

function registrasi($data)
{
    global $link;
    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($link, $data["password"]);
    $password2 = mysqli_real_escape_string($link, $data["password2"]);

    $result = mysqli_query($link, "SELECT username FROM users WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>
            alert('username sudah terdaftar!')
        </script>";
        return false;
    }
    //cek password
    if ($password !== $password2) {
        echo "<script>
                alert('Konfirmasi password tidak sesuai!');
            </script>";
        return false;
    }
    $password = password_hash($password, PASSWORD_DEFAULT);
    mysqli_query($link, "INSERT INTO users VALUES('', '$username', '$password')");
    return mysqli_affected_rows($link);
}
