<?php
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Password tidak sama";
    } else {
        if (registerUser($username, $password)) {
            header("Location: login.php?registered=1");
            exit();
        } else {
            $error = "Pendaftaran gagal. Username mungkin sudah digunakan.";
        }
    }
}

redirectIfLoggedIn();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Bidan Sunarti</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <header>
            <h1>Daftar Akun</h1>
            <h2>Bidan Sunarti</h2>
        </header>

        <main>
            <form method="POST" class="register-form">
                <?php if (isset($error)): ?>
                    <div class="alert error"><?php echo $error; ?></div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="username">User</label>
                    <input type="text" id="username" name="username" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Konfirmasi Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>

                <button type="submit" class="btn">Simpan</button>

                <div class="login-link">
                    Sudah punya akun? <a href="login.php">Login disini</a>
                </div>
            </form>
        </main>
    </div>
</body>

</html>