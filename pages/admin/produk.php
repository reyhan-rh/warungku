<?php
session_start();
include "../../config/koneksi.php";
if(!isset($_SESSION['admin'])){ header("Location: ../login.php"); exit; }

$kategori = mysqli_query($koneksi,"SELECT * FROM kategori");

/* Tambah produk */
if(isset($_POST['tambah'])){
    $id_kategori=$_POST['id_kategori'];
    $nama=htmlspecialchars($_POST['nama']);
    $harga=$_POST['harga'];
    mysqli_query($koneksi,"INSERT INTO produk (id_kategori,nama_produk,harga) VALUES ('$id_kategori','$nama','$harga')");
    header("Location: produk.php");
    exit;
}

/* Edit produk */
if(isset($_POST['edit'])){
    $id = $_POST['id'];
    $id_kategori = $_POST['id_kategori'];
    $nama = htmlspecialchars($_POST['nama']);
    $harga = $_POST['harga'];
    mysqli_query($koneksi,"UPDATE produk SET id_kategori='$id_kategori', nama_produk='$nama', harga='$harga' WHERE id='$id'");
    header("Location: produk.php");
    exit;
}

/* Hapus produk */
if(isset($_GET['hapus'])){
    $id=$_GET['hapus'];
    mysqli_query($koneksi,"DELETE FROM produk WHERE id='$id'");
    header("Location: produk.php");
    exit;
}

$data=mysqli_query($koneksi,"SELECT produk.*, kategori.nama_kategori FROM produk JOIN kategori ON produk.id_kategori=kategori.id ORDER BY produk.id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kelola Produk</title>
<style>
body{background:#0f0f0f;color:#fff;font-family:Arial,sans-serif;margin:20px;}
.container{max-width:1000px;margin:0 auto;animation:fadeUp 0.8s;}
h2{text-align:center;color:#ff9800;margin-bottom:30px;}
.back{display:inline-block;margin-bottom:20px;padding:12px 20px;background:#ffaa33;color:#000;border-radius:12px;text-decoration:none;font-weight:bold;transition:0.2s;}
.back:hover{transform:translateY(-3px);box-shadow:0 8px 20px rgba(255,152,0,0.4);}
.form-card{background:#181818;padding:25px;border-radius:16px;margin-bottom:30px;}
input, select, button{width:100%;padding:12px;margin-bottom:15px;border-radius:8px;border:none;}
input, select{background:#101010;color:#fff;border:1px solid #333;}
button{background:#ff9800;color:#000;font-weight:bold;cursor:pointer;transition:0.2s;}
button:hover{transform:translateY(-3px);box-shadow:0 8px 20px rgba(255,152,0,0.4);}
.grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:20px;}
.card{background:#181818;border-radius:16px;padding:20px;text-align:center;transition:transform 0.3s,box-shadow 0.3s;}
.card:hover{transform:translateY(-8px);box-shadow:0 12px 30px rgba(255,152,0,0.3);}
.card h3{font-size:16px;margin-bottom:8px;}
.card span{font-size:14px;color:#aaa;display:block;margin-bottom:8px;}
.card .price{font-weight:bold;color:#ff9800;margin-bottom:12px;}
.card a, .edit-btn{display:inline-block;padding:8px 14px;background:#ff5252;color:#fff;border-radius:8px;text-decoration:none;font-size:14px;transition:0.2s;margin:2px;}
.card a:hover, .edit-btn:hover{transform:translateY(-2px);box-shadow:0 6px 15px rgba(255,82,82,0.4);}
.modal{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.7);justify-content:center;align-items:center;z-index:9999;}
.modal-content{background:#181818;padding:25px;border-radius:16px;max-width:400px;width:90%;}
.close{float:right;color:#ff5252;font-weight:bold;font-size:18px;cursor:pointer;}
@keyframes fadeUp{from{opacity:0;transform:translateY(20px);}to{opacity:1;transform:translateY(0);}}
</style>
</head>
<body>

<div class="container">
<h2>Kelola Produk</h2>
<a href="dashboard.php" class="back">← Kembali ke Dashboard</a>

<!-- Tambah Produk -->
<div class="form-card">
<form method="POST">
<select name="id_kategori" required>
<option value="">-- Pilih Kategori --</option>
<?php while($k=mysqli_fetch_assoc($kategori)): ?>
<option value="<?= $k['id'] ?>"><?= $k['nama_kategori'] ?></option>
<?php endwhile; ?>
</select>
<input type="text" name="nama" placeholder="Nama Produk" required>
<input type="number" name="harga" placeholder="Harga" required>
<button type="submit" name="tambah">Tambah Produk</button>
</form>
</div>

<!-- List Produk -->
<div class="grid">
<?php while($p=mysqli_fetch_assoc($data)): ?>
<div class="card">
<h3><?= $p['nama_produk'] ?></h3>
<span><?= $p['nama_kategori'] ?></span>
<div class="price">Rp <?= number_format($p['harga']) ?></div>
<a href="?hapus=<?= $p['id'] ?>" onclick="return confirm('Hapus produk ini?')">Hapus</a>
<button class="edit-btn" onclick="bukaEdit(<?= $p['id'] ?>,'<?= addslashes($p['nama_produk']) ?>',<?= $p['harga'] ?>,<?= $p['id_kategori'] ?>)">Edit</button>
</div>
<?php endwhile; ?>
</div>
</div>

<!-- Modal Edit -->
<div id="modalEdit" class="modal">
<div class="modal-content">
<span class="close" onclick="tutupEdit()">&times;</span>
<h3>Edit Produk</h3>
<form method="POST">
<input type="hidden" name="id" id="edit-id">
<select name="id_kategori" id="edit-kategori" required>
<?php
mysqli_data_seek($kategori,0); // Reset pointer kategori
while($k=mysqli_fetch_assoc($kategori)):
?>
<option value="<?= $k['id'] ?>"><?= $k['nama_kategori'] ?></option>
<?php endwhile; ?>
</select>
<input type="text" name="nama" id="edit-nama" placeholder="Nama Produk" required>
<input type="number" name="harga" id="edit-harga" placeholder="Harga" required>
<button type="submit" name="edit">Simpan Perubahan</button>
</form>
</div>
</div>

<script>
function bukaEdit(id,nama,harga,id_kategori){
    document.getElementById('modalEdit').style.display='flex';
    document.getElementById('edit-id').value=id;
    document.getElementById('edit-nama').value=nama;
    document.getElementById('edit-harga').value=harga;
    document.getElementById('edit-kategori').value=id_kategori;
}
function tutupEdit(){document.getElementById('modalEdit').style.display='none';}
</script>

</body>
</html>
