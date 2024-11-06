<?php
// Database connection details
$servername = "localhost";
$username = "your_db_username";
$password = "your_db_password";
$dbname = "booking_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form validation and data sanitization
$fullName = htmlspecialchars(trim($_POST['full-name']));
$email = htmlspecialchars(trim($_POST['email']));
$phone = htmlspecialchars(trim($_POST['phone']));
$preferredDate = $_POST['date'];
$preferredTime = $_POST['time'];
$service = htmlspecialchars(trim($_POST['service']));

// Basic validation
$errors = [];
if (empty($fullName)) $errors[] = "Full name is required.";
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
if (empty($phone)) $errors[] = "Phone number is required.";
if (empty($preferredDate)) $errors[] = "Preferred date is required.";
if (empty($preferredTime)) $errors[] = "Preferred time is required.";
if (empty($service)) $errors[] = "Service selection is required.";

if (!empty($errors)) {
    // Display errors and halt execution if there are validation errors
    echo "<h3>Please correct the following errors:</h3><ul>";
    foreach ($errors as $error) {
        echo "<li>" . $error . "</li>";
    }
    echo "</ul>";
    exit;
}

// Prepare and bind the SQL statement to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO bookings (full_name, email, phone, preferred_date, preferred_time, service) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $fullName, $email, $phone, $preferredDate, $preferredTime, $service);

if ($stmt->execute()) {
    echo "<h3>Booking Successful!</h3>";
    echo "<p>Thank you, " . $fullName . "! Your booking for " . $service . " on " . $preferredDate . " at " . $preferredTime . " has been confirmed. We will reach out to you soon.</p>";
} else {
    echo "<h3>Error:</h3> " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>

