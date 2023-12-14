<?php
require_once 'database/config.php';
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $school = $_POST['school'];
    $city = $_POST['city'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];

    if (registerUser($username, $password, $firstName, $lastName, $email, $school, $city, $phone, $role)) {
        // Регистрацията е успешна
        header('Location: login.php');
        exit();
    } else {
        $error = "Грешка при регистрацията. Моля, опитайте отново.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
</head>
<body>

<h2>Регистрация</h2>

<?php if (isset($error)) { echo "<p>$error</p>"; } ?>

<form method="POST">
    <label for="first_name">Първо име:</label>
    <input type="text" name="first_name" required><br>

    <label for="last_name">Фамилия:</label>
    <input type="text" name="last_name" required><br>

    <label for="email">И-мейл:</label>
    <input type="email" name="email" required><br>

    <label for="username">Потребителско име:</label>
    <input type="text" name="username" required><br>

    <label for="password">Парола:</label>
    <input type="password" name="password" required><br>

    <label for="school">Училище:</label>
    <input type="text" name="school" required><br>

    <label for="city">Град:</label>
    <input type="text" name="city" required><br>

    <label for="phone">Телефон:</label>
    <input type="tel" name="phone" required><br>

    <label for="role">Роля:</label>
    <select name="role" required>
        <option value="expert_mk">Държавен експерт</option>
        <option value="director_nms">Директор НМУ</option>
    </select><br>

    <input type="submit" value="Регистрирай се">
</form>

</body>
</html>
