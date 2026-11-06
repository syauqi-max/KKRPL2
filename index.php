<?php
include 'koneksi.php';

$query  = "SELECT * FROM produk ORDER BY id DESC";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background-color: #f9f9f9; }
        .container { max-width: 900px; margin: auto; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; vertical-align: top; }
        th { background-color: #f4f4f4; }
        .img-produk { width: 70px; height: 70px; object-fit: cover; border-radius: 4px; }
        .btn-tambah { padding: 9px 15px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; display: inline-block; }
        .sukses { color: green; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <h2>Daftar Produk</h2>

    <?php if (isset($_GET['status']) && $_GET['status'] == 'sukses'): ?>
        <p class="sukses">✓ Produk berhasil ditambahkan!</p>
    <?php endif; ?>

    <a href="input.php" class="btn-tambah">+ Tambah Produk Baru</a>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (mysqli_num_rows($result) > 0): 
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)): 
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td>
                        <?php if (!empty($row['gambar']) && file_exists('uploads/' . $row['gambar'])): ?>
                            <img src="uploads/<?= htmlspecialchars($row['gambar']); ?>" class="img-produk" alt="Gambar Produk">
                        <?php else: ?>
                            <small>Tidak Ada Gambar</small>
                        <?php endif; ?>
                    </td>
                    <td><b><?= htmlspecialchars($row['nama_produk']); ?></b></td>
                    <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                    <td><?= $row['stok']; ?></td>
                    <td><?= nl2br(htmlspecialchars($row['deskripsi'])); ?></td>
                </tr>
            <?php 
                endwhile; 
            else: 
            ?>
                <tr>
                    <td colspan="6" style="text-align: center;">Belum ada data produk.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>