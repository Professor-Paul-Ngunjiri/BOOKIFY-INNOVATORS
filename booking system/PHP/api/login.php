<?php
require 'db.php';

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $pdo->prepare("SELECT * FROM Users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    echo json_encode(["status" => "success", "message" => "Login successful."]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid credentials."]);
}
?>
