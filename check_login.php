<?php

session_start();

include "db.php";

$first_name = trim($_POST["first_name"]);
$last_name = trim($_POST["last_name"]);
$password = $_POST["password"];

// Ищем пользователя
$sql = "SELECT * FROM users
        WHERE first_name = '$first_name'
        AND last_name = '$last_name'";

$result = $conn->query($sql);

// Если пользователь найден
if ($result->num_rows > 0) {

    $user = $result->fetch_assoc();

    // Проверяем пароль
    if (password_verify($password, $user["password"])) {

        $_SESSION["driver"] = true;
        $_SESSION["first_name"] = $user["first_name"];
        $_SESSION["last_name"] = $user["last_name"];

        header("Location: index.php");
        exit();

    } else {

        echo "
        <h2 style='text-align:center; margin-top:50px;'>
        Неверный пароль!
        </h2>

        <div style='text-align:center; margin-top:20px;'>
            <a href='login.php'>Попробовать снова</a>
        </div>
        ";

    }

} else {

    echo "
    <h2 style='text-align:center; margin-top:50px;'>
    Пользователь не найден!
    </h2>

    <div style='text-align:center; margin-top:20px;'>
        <a href='login.php'>Попробовать снова</a>
    </div>
    ";

}

$conn->close();

?>