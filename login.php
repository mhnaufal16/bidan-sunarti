<?php
session_start();
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username']);
    $password = $_POST['password'];

    $user_id = authenticateUser($username, $password);

    if ($user_id) {
        $_SESSION['user_id'] = $user_id;

        // Remember me functionality
        if (isset($_POST['remember'])) {
            setcookie('remember_user', $user_id, time() + (30 * 24 * 60 * 60), '/');
        }

        // Redirect to intended page or dashboard
        $redirect_url = $_SESSION['redirect_url'] ?? 'dashboard.php';
        unset($_SESSION['redirect_url']);

        header("Location: " . $redirect_url);
        exit();
    } else {
        $error = "Username atau password salah";
    }
}

redirectIfLoggedIn();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bidan Sunarti</title>
    <style>
        :root {
            --primary-color: #4CAF50;
            --primary-hover: #45a049;
            --error-color: #f44336;
            --success-color: #4CAF50;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: rgba(3, 77, 0, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #333;
            background: linear-gradient(rgba(3, 77, 0, 0.9), rgba(3, 77, 0, 0.9)),
                url('image/background.jpg') center/cover no-repeat fixed;
        }

        .container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            width: 380px;
            overflow: hidden;
            text-align: center;
        }

        header {
            padding: 25px 0 15px;
            border-bottom: 1px solid #eee;
        }

        header h1 {
            color: var(--primary-color);
            margin: 0;
            font-size: 28px;
        }

        header h2 {
            color: #666;
            margin: 5px 0 0;
            font-size: 16px;
            font-weight: normal;
        }

        .login-form {
            padding: 25px 40px;
        }

        .alert {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 14px;
        }

        .error {
            background-color: #ffebee;
            color: var(--error-color);
            border: 1px solid #ffcdd2;
        }

        .success {
            background-color: #e8f5e9;
            color: var(--success-color);
            border: 1px solid #c8e6c9;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 14px;
            transition: border 0.3s;
        }

        .form-group input:focus {
            border-color: var(--primary-color);
            outline: none;
        }

        .remember {
            display: flex;
            align-items: center;
            margin: 15px 0 25px;
        }

        .remember input {
            width: auto;
            margin-right: 10px;
        }

        .btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: var(--primary-hover);
        }

        .register-link {
            margin-top: 20px;
            color: #666;
            font-size: 14px;
        }

        .register-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <h1>Login</h1>
            <h2>Bidan Sunarti</h2>
        </header>

        <main>
            <form method="POST" class="login-form">
                <?php if (isset($error)): ?>
                    <div class="alert error"><?php echo $error; ?></div>
                <?php endif; ?>

                <?php if (isset($_GET['registered'])): ?>
                    <div class="alert success">Pendaftaran berhasil! Silakan login.</div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="username">User</label>
                    <input type="text" id="username" name="username" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group remember">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember me</label>
                </div>

                <button type="submit" class="btn">Login</button>

    </div>
    </form>
    </main>
    </div>
</body>

</html>