<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>LOGIN ADMIN PUDDINGKU</title>

    <style>
        /* ---------- Background Animasi Pink ---------- */
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;

            /* Pink hidup + gradasi lebih lembut */
            background: linear-gradient(135deg,
                #ff8fb7,
                #ff7aa6,
                #ff6f91,
                #ffa1c4
            );
            background-size: 500% 500%;
            animation: pinkmove 12s ease-in-out infinite;
        }

        @keyframes pinkmove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* ---------- Kotak Login ---------- */
        .box {
            width: 360px;
            background: #ffffffdd;
            backdrop-filter: blur(7px);
            border-radius: 20px;
            padding: 100px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.20);
            text-align: center;
            animation: fadein 1.2s ease;
        }

        @keyframes fadein {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .box h2 {
            margin-top: 10px;
            font-size: 20px;
            letter-spacing: 1px;
            color: #ff5f8d;
            font-weight: bold;
        }

        .logo {
            width: 120px;
            height: 120px;
            border-radius: 100%;
            margin-bottom: 10px;
            object-fit: cover;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        /* ---------- Input ---------- */
        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 2px solid #ff8fb3;
            border-radius: 10px;
            outline: none;
            transition: .2s;
        }

        input:focus {
            border-color: #ff5f8d;
            box-shadow: 0 0 6px #ff5f8d;
        }

        /* ---------- Tombol ---------- */
        button {
            width: 50%;
            padding: 12px;
            background: #ff5f8d;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 5px;
            font-weight: bold;
            font-size: 14px;
            letter-spacing: 1px;
            transition: .2s;
        }

        button:hover {
            background: #ff3f73;
        }
    </style>
</head>

<body>

<div class="box">
    <img src="img/bg/logo_alfin.png" class="logo">

    <h2>LOGIN ADMIN PUDDINGKU</h2>

    <form action="login_proses.php" method="POST">
        <label style="float:left; font-size:14px; color:#ff5f8d;">USERNAME</label>
        <input type="text" name="id_karyawan" placeholder="Masukkan username..." required>

        <label style="float:left; font-size:14px; color:#ff5f8d;">PASSWORD</label>
        <input type="password" name="password" placeholder="Masukkan password..." required>

        <button type="submit">MASUK</button>
    </form>
</div>

</body>
</html>
