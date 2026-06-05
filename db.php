<?php

$conn = new mysqli(
    "localhost",
    "root",
    "mysql",
    "taxiregister_db"
);

if ($conn->connect_error) {
    die("Ошибка подключения к базе данных");
}

?>