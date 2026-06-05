<?php

include "db.php";

$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$phone = $_POST["phone"];
$password = $_POST["password"];
$confirm_password = $_POST["confirm_password"];

// Проверка совпадения паролей

if ($password != $confirm_password) {
    die("Пароли не совпадают!");
}

// Шифруем пароль

$password = password_hash($password, PASSWORD_DEFAULT);

// Записываем в базу

$sql = "INSERT INTO users (first_name, last_name, phone, password)
VALUES ('$first_name', '$last_name', '$phone', '$password')";

if ($conn->query($sql) === TRUE) {

    session_start();
    $_SESSION["driver"] = true;

    $_SESSION["first_name"] = $first_name;
$_SESSION["last_name"] = $last_name;

    header("Location: index.php");
    exit();

} else {
    echo "Ошибка: " . $conn->error;
}

$conn->close();

?>