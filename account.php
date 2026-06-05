<?php
session_start();

if(!isset($_SESSION["driver"])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Мой аккаунт</title>
<link rel="stylesheet" href="taxi1.css">

<style>
.account-box{
    max-width:700px;
    margin:50px auto;
    background:#fff;
    padding:30px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,.15);
}

.account-box h1{
    margin-bottom:25px;
}

.account-item{
    margin:15px 0;
    padding:12px;
    background:#f5f5f5;
    border-radius:8px;
    font-size:18px;
}

.account-buttons{
    margin-top:30px;
    display:flex;
    gap:15px;
}

.btn{
    padding:12px 20px;
    border:none;
    border-radius:8px;
    cursor:pointer;
    text-decoration:none;
    font-size:16px;
}

.back-btn{
    background:#4caf50;
    color:white;
}

.logout-btn{
    background:#d32f2f;
    color:white;
}
</style>

</head>
<body>

<div class="account-box">

    <h1>Мой аккаунт</h1>

    <div class="account-item">
        <b>Имя:</b>
        <?php echo $_SESSION["first_name"]; ?>
    </div>

    <div class="account-item">
        <b>Фамилия:</b>
        <?php echo $_SESSION["last_name"]; ?>
    </div>

    <div class="account-buttons">
        <a href="index.php" class="btn back-btn">
            Назад
        </a>

        <a href="logout.php" class="btn logout-btn">
            Выйти из аккаунта
        </a>
    </div>

</div>

</body>
</html>