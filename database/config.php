<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mk_test";

// Създаване на връзка
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Проверка на връзката
if (!$conn) {
    die("Няма връзка: " . mysqli_connect_error());
}
?>