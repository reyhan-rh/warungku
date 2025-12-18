<?php
session_start();
include "../config/koneksi.php";

$error = "";

// Jika sudah login, langsung ke dashboard
if (isset($_SESSION['admin'])) {
    header("Location: admin/dashboard.php"); // path diperbaiki
    exit;
}

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $q = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username'");
    $data = mysqli_fetch_assoc($q);

    if ($data && password_verify($password, $data['password'])) {
        $_SESSION['admin'] = $data;
        header("Location: admin/dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login Admin</title>
<style>
/* Reset & Font */
* {box-sizing: border-box; font-family: 'Segoe UI', sans-serif; margin: 0; padding: 0;}
body {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #0f0f0f;
}

/* Animasi masuk */
@keyframes fadeUp {
    from {opacity: 0; transform: translateY(25px);}
    to {opacity: 1; transform: translateY(0);}
}

/* Card login */
.login-card {
    background: #181818;
    width: 360px;
    padding: 32px;
    border-radius: 14px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.6);
    animation: fadeUp 0.7s ease;
}

.login-card h2 {
    color: #fff;
    text-align: center;
    margin-bottom: 8px;
    font-weight: 600;
}

.login-card p {
    color: #aaa;
    text-align: center;
    font-size: 14px;
    margin-bottom: 28px;
}

.login-card label {
    color: #bbb;
    font-size: 13px;
    display: block;
    margin-bottom: 6px;
}

.login-card input {
    width: 100%;
    padding: 11px;
    margin-bottom: 18px;
    border-radius: 8px;
    border: 1px solid #333;
    background: #101010;
    color: #fff;
    outline: none;
    transition: border 0.3s;
}

.login-card input:focus {
    border-color: #ff9800;
}

.login-card button {
    width: 100%;
    padding: 11px;
    border: none;
    border-radius: 8px;
    background: #ff9800;
    color: #000;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
}

.login-card button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(255,152,0,0.4);
}

/* Error message */
.error {
    background: rgba(255,0,0,0.1);
    color: #ff6b6b;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 18px;
    text-align: center;
    font-size: 14px;
}
</style>
</head>
<body>

<div class="login-card">
    <h2>Admin Login</h2>
    <p>Warung Management System</p>

    <?php if ($error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Username</label>
        <input type="text" name="username" placeholder="Username" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" name="login">Masuk</button>
    </form>
</div>

</body>
</html>
