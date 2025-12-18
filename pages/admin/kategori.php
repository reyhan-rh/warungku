<?php
session_start();
include "../../config/koneksi.php";
if(!isset($_SESSION['admin'])){ header("Location: ../login.php"); exit; }

if(isset($_POST['tambah'])){
    $nama = htmlspecialchars($_POST['nama']);
    mysqli_query($koneksi,"INSERT INTO kategori (nama_kategori) VALUES ('$nama')");
    header("Location: kategori.php");
    exit;
}

if(isset($_GET['hapus'])){
    $id=$_GET['hapus'];
    mysqli_query($koneksi,"DELETE FROM kategori WHERE id='$id'");
    header("Location: kategori.php");
    exit;
}

$data=mysqli_query($koneksi,"SELECT * FROM kategori ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kelola Kategori</title>
<style>
body{background:#0f0f0f;color:#fff;font-family:Arial,sans-serif;margin:20px;}
.container{max-width:800px;margin:0 auto;animation:fadeUp 0.7s;}
h2{text-align:center;color:#ff9800;margin-bottom:30px;}
.back{display:inline-block;margin-bottom:20px;padding:12px 20px;background:#ffaa33;color:#000;border-radius:12px;text-decoration:none;font-weight:bold;transition:0.2s;}
.back:hover{transform:translateY(-3px);box-shadow:0 8px 20px rgba(255,152,0,0.4);}
.form-card{background:#181818;padding:25px;border-radius:16px;margin-bottom:30px;}
input,button{width:100%;padding:12px;margin-bottom:15px;border-radius:8px;border:none;}
input{background:#101010;color:#fff;border:1px solid #333;}
button{background:#ff9800;color:#000;font-weight:bold;cursor:pointer;transition:0.2s;}
button:hover{transform:translateY(-3px);box-shadow:0 8px 20px rgba(255,152,0,0.4);}
table{width:100%;border-collapse:collapse;}
th,td{padding:12px;border-bottom:1px solid #333;}
th{color:#aaa;}
.hapus{color:#ff6b6b;text-decoration:none;}
.hapus:hover{text-decoration:underline;}
@keyframes fadeUp{from{opacity:0;transform:translateY(20px);}to{opacity:1;transform:translateY(0);}}
</style>
</head>
<body>

<div class="container">
<h2>Kelola Kategori</h2>
<a href="dashboard.php" class="back">← Kembali ke Dashboard</a>

<div class="form-card">
<form method="POST">
<input type="text" name="nama" placeholder="Nama Kategori" required>
<button type="submit" name="tambah">Tambah Kategori</button>
</form>
</div>

<table>
<tr><th>No</th><th>Nama Kategori</th><th>Aksi</th></tr>
<?php $no=1; while($row=mysqli_fetch_assoc($data)): ?>
<tr>
<td><?= $no++ ?></td>
<td><?= $row['nama_kategori'] ?></td>
<td><a class="hapus" href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Hapus kategori ini?')">Hapus</a></td>
</tr>
<?php endwhile; ?>
</table>
</div>

</body>
</html>
