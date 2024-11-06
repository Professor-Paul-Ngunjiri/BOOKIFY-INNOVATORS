<?php
require 'db.php';

$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$phone = $_POST['phone'];

// Generate OTP
$otp = rand(100000, 999999);

$stmt = $pdo->prepare("INSERT INTO Users (username, email, password, phone, otp_code) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$username, $email, $password, $phone, $otp]);

// Send OTP to user's phone or email (pseudo-code)
sendOtp($phone, $otp);

echo json_encode(["status" => "success", "message" => "Registration successful. Please verify your account with the OTP sent to your phone."]);
?>
