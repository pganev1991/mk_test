<?php
function registerUser($username, $password, $firstName, $lastName, $email, $school, $city, $phone, $role) {
    global $conn;

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, password, first_name, last_name, email, school, city, phone, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $username, $hashedPassword, $firstName, $lastName, $email, $school, $city, $phone, $role);

    return $stmt->execute();
}

function loginUser($username, $password) {
    global $conn;

    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id, $hashedPassword, $role);

    if ($stmt->fetch() && password_verify($password, $hashedPassword)) {
        $_SESSION['user_id'] = $id;
        $_SESSION['role'] = $role;
        return true;
    } else {
        return false;
    }
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}
?>
