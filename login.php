<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход — TaxiHub</title>

    <link rel="stylesheet" href="taxi1.css">

    <style>
        body {
            background-color: var(--bg-light);
        }

        .header-simple {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            padding: 20px 0;
            box-shadow: var(--card-shadow);
        }

        .header-simple .container {
            position: relative;
            text-align: center;
        }

        .back-btn {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
        }

        .back-btn:hover {
            opacity: 0.8;
        }

        .header-simple a.logo-link {
            color: white;
            text-decoration: none;
        }

        .auth-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 180px);
            padding: 40px 20px;
        }

        .auth-card {
            background: white;
            width: 100%;
            max-width: 420px;
            padding: 40px;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            border: 1px solid var(--border-color);
        }

        .auth-title {
            font-size: 24px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 30px;
        }

        .auth-form .filter-group {
            margin-bottom: 20px;
        }

        .auth-footer {
            margin-top: 24px;
            text-align: center;
            font-size: 14px;
        }

        .auth-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .auth-card {
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>

<header class="header-simple">
    <div class="container">

        <a href="index.php" class="back-btn">
            ← Назад
        </a>

        <a href="index.php" class="logo-link">
            <h1 class="logo" style="font-size:28px;margin:0;">
                TaxiHub
            </h1>
        </a>

    </div>
</header>

<div class="auth-container">
    <div class="auth-card">

        <h2 class="auth-title">
            Вход в аккаунт
        </h2>

        <form action="check_login.php" method="POST" class="auth-form">

            <div class="filter-group">
                <label>Имя</label>
                <input
                    type="text"
                    name="first_name"
                    class="filter-input"
                    required>
            </div>

            <div class="filter-group">
                <label>Фамилия</label>
                <input
                    type="text"
                    name="last_name"
                    class="filter-input"
                    required>
            </div>

            <div class="filter-group">
                <label>Пароль</label>
                <input
                    type="password"
                    name="password"
                    class="filter-input"
                    required>
            </div>

            <button type="submit" class="search-btn">
                Войти
            </button>

        </form>

        <div class="auth-footer">
            Нет аккаунта?
            <a href="register.php">
                Зарегистрироваться
            </a>
        </div>

    </div>
</div>

</body>
</html>