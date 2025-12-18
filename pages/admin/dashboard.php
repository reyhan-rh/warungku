<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Admin</title>
<style>
body {background:#0f0f0f;color:#fff;font-family:Arial, sans-serif;margin:0;padding:0;}
.container {max-width:800px;margin:60px auto;padding:0 20px;}
h2 {text-align:center;color:#ff9800;margin-bottom:30px;font-size:28px;animation:fadeUp 0.8s ease;}
.card {background:#181818;padding:25px;border-radius:16px;margin-bottom:20px;text-align:center;transition: transform 0.2s, box-shadow 0.2s;}
.card a {display:block;text-decoration:none;color:#000;background:#ff9800;padding:14px;border-radius:12px;font-weight:bold;transition:transform 0.2s,box-shadow 0.2s;}
.card a:hover {transform:translateY(-3px); box-shadow:0 8px 20px rgba(255,152,0,0.4);}
.logout {background:#ff5252;color:#fff;}
@keyframes fadeUp {0%{opacity:0;transform:translateY(20px);}100%{opacity:1;transform:translateY(0);}}
</style>
</head>
<body>

<div class="container">
<h2>Dashboard Admin</h2>

<div class="card">
<a href="../../index.php">← Kembali ke Warung</a>
</div>

<div class="card">
<a href="kategori.php">Kelola Kategori</a>
</div>

<div class="card">
<a href="produk.php">Kelola Produk</a>
</div>

<div class="card">
<a href="../logout.php" class="logout">Logout</a>
</div>
</div>

</body>
</html>
