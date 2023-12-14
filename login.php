<?php
require_once 'database/config.php';
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (loginUser($username, $password)) {
        // Входът е успешен
        header('Location: admin/index.php'); // Пренасочване към основната страница след успешен вход
        exit();
    } else {
        $error = "Невалидно потребителско име или парола. Моля, опитайте отново.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
</head>
<body>

<h2>Вход</h2>

<?php if (isset($error)) { echo "<p>$error</p>"; } ?>

<form method="POST">
    <label for="username">Потребителско име:</label>
    <input type="text" name="username" required><br>

    <label for="password">Парола:</label>
    <input type="password" name="password" required><br>

    <input type="submit" value="Вход">
</form>

</body>
</html>
