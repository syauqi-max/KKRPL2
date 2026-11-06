<?php
include 'koneksi.php';

$pesan = "";

if (isset($_POST['submit'])) {
    $nama      = mysqli_real_escape_string($koneksi, $_POST['nama_produk']);
    $harga     = (int)$_POST['harga'];
    $stok      = (int)$_POST['stok'];
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);

    // Konfigurasi Upload Gambar
    $nama_file  = $_FILES['gambar']['name'];
    $tmp_file   = $_FILES['gambar']['tmp_name'];
    $error_file = $_FILES['gambar']['error'];

    if ($error_file === 0) {
        $ekstensi_valid = ['jpg', 'jpeg', 'png', 'webp'];
        $ekstensi_file  = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

        if (in_array($ekstensi_file, $ekstensi_valid)) {
            // Generate nama file baru agar unik
            $nama_gambar_baru = uniqid('prod_', true) . '.' . $ekstensi_file;
            $tujuan_upload    = 'uploads/' . $nama_gambar_baru;

            if (move_uploaded_file($tmp_file, $tujuan_upload)) {
                // Query Simpan
                $query = "INSERT INTO produk (nama_produk, harga, stok, deskripsi, gambar) 
                          VALUES ('$nama', '$harga', '$stok', '$deskripsi', '$nama_gambar_baru')";

                if (mysqli_query($koneksi, $query)) {
                    header("Location: index.php?status=sukses");
                    exit();
                } else {
                    $pesan = "Gagal menyimpan ke database: " . mysqli_error($koneksi);
                }
            } else {
                $pesan = "Gagal mengunggah gambar ke server.";
            }
        } else {
            $pesan = "Format file tidak didukung! Pilih gambar berformat JPG, JPEG, PNG, atau WEBP.";
        }
    } else {
        $pesan = "Silakan pilih gambar produk terlebih dahulu!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk Baru</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background-color: #f9f9f9; }
        .container { max-width: 500px; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="number"], textarea, input[type="file"] { width: 100%; padding: 8px; box-sizing: border-box; }
        button { padding: 10px 15px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .btn-batal { text-decoration: none; color: #666; margin-left: 10px; }
        .error { color: red; margin-bottom: 15px; }
    </style>
</head>
<body>

<div class="container">
    <h2>Tambah Produk Baru</h2>
    
    <?php if ($pesan): ?>
        <p class="error"><?= $pesan; ?></p>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" name="nama_produk" required>
        </div>
        <div class="form-group">
            <label>Harga (Rp)</label>
            <input type="number" name="harga" required>
        </div>
        <div class="form-group">
            <label>Stok</label>
            <input type="number" name="stok" required>
        </div>
        <div class="form-group">
            <label>Gambar Produk</label>
            <input type="file" name="gambar" accept="image/*" required>
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" rows="4"></textarea>
        </div>
        <button type="submit" name="submit">Simpan Produk</button>
        <a href="index.php" class="btn-batal">Batal</a>
    </form>
</div>

</body>
</html>