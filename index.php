<?php
require_once 'includes/functions.php';
redirectIfLoggedIn();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Pemeriksaan Kehamilan Bidan Sunarti</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333;
            /* Background dengan gambar dan gradient overlay */
            background: linear-gradient(rgba(3, 77, 0, 0.9), rgba(3, 77, 0, 0.9)),
                url('image/background.jpg') center/cover no-repeat fixed;
        }

        .container {
            width: 90%;
            max-width: 800px;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        header h1 {
            font-size: 2.5rem;
            color: #096800;
            margin-bottom: 10px;
            font-weight: 300;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
        }

        header h2 {
            font-size: 3rem;
            color: #096800;
            margin-top: 0;
            margin-bottom: 30px;
            font-weight: 600;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
        }

        .welcome-section p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            color: #555;
        }

        .btn {
            display: inline-block;
            background-color: #096800;
            color: white;
            text-decoration: none;
            padding: 15px 50px;
            border-radius: 50px;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 134, 18, 0.4);
            margin-bottom: 40px;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .btn:hover {
            background-color: #0a7a00;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 134, 18, 0.6);
        }

        .services {
            background-color: rgba(248, 249, 250, 0.8);
            padding: 20px;
            border-radius: 10px;
            margin-top: 30px;
            backdrop-filter: blur(3px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .services h3 {
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .services ul {
            list-style-type: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
        }

        .services li {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 10px 20px;
            border-radius: 50px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .services li:hover {
            transform: scale(1.05);
        }

        footer {
            margin-top: 40px;
            color: #777;
            font-size: 0.9rem;
        }

        @media (max-width: 600px) {
            header h1 {
                font-size: 1.8rem;
            }

            header h2 {
                font-size: 2.2rem;
            }

            .container {
                padding: 20px;
            }

            body {
                background-attachment: scroll;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <h1>Hello Welcome To</h1>
            <h2>Web Pemeriksaan Kehamilan<br>Bidan Sunarti</h2>
        </header>

        <main class="landing">
            <div class="welcome-section">
                <a href="login.php" class="btn">Start</a>
            </div>

            <div class="services">
                <h3>Pelayanan Kami:</h3>
                <ul>
                    <li>Pemeriksaan Kehamilan</li>
                    <li>Cek Lab Sederhana</li>
                    <li>Cukur Rambut Bayi</li>
                    <li>Pelayanan KB</li>
                    <li>Massage Bayi</li>
                    <li>Baby Spa</li>
                </ul>
            </div>
        </main>

        <footer>
            <p>&copy; <?php echo date('Y'); ?> Bidan Sunarti. Est. 2005</p>
            <p>Jl. Raya, Dusun II, Grogol, Sukoharjo</p>
        </footer>
    </div>
</body>

</html>