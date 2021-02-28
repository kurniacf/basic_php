<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("location: login.php");
    exit;
}

require 'functions.php';
$mahasiswa = query("SELECT * FROM mahasiswa");

//tombol cari
if (isset($_POST["cari"])) {
    $mahasiswa = cari($_POST["keyword"]);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <style>
        .loading {
            width: 100px;
            position: absolute;
            top: 115px;
            left: 300px;
            z-index: -1;
            display: none;
        }

        @media print {

            .logout,
            .tambah,
            .tombolCari,
            .aksi {
                display: none;
            }
        }
    </style>
</head>

<body>
    <a href="logout.php" class="logout">logout</a>
    <h1>Daftar Mahasiswa</h1>
    <a href="tambah.php" class="tambah">Tambah data mahasiswa</a>
    <br></br>
    <form action="" method="POST">
        <input type="text" name="keyword" size="40" autofocus placeholder="masukkan pencarian.." autocomplete="off" id="keyword" class="tombolCari">
        <button type="submit" name="cari" id="tombolCari">Cari</button>
        <img src="img/loading.gif" class="loading">

    </form>
    <br>
    <div id="container">
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>No.</th>
                <th class="aksi">Aksi</th>
                <th>Gambar</th>
                <th>NRP</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Jurusan</th>
            </tr>

            <?php $no = 1; ?>
            <?php foreach ($mahasiswa as $row) : ?>
                <tr>
                    <td><?= $no; ?></td>
                    <td class="aksi">
                        <a href="ubah.php?id=<?= $row["id"] ?>">edit</a> |
                        <a href="hapus.php?id=<?= $row["id"]; ?>" onclick="return confirm('yakin?');">delete</a>
                    </td>
                    <td><img src="img/<?= $row["gambar"]; ?>" width="50"></td>
                    <td><?= $row["nrp"]; ?></td>
                    <td><?= $row["nama"] ?></td>
                    <td><?= $row["email"] ?></td>
                    <td><?= $row["jurusan"] ?></td>
                </tr>
                <?php $no++; ?>
            <?php endforeach; ?>
        </table>
    </div>
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>