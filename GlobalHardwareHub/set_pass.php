<?php
require_once 'db_connect.php';

$newPassword = 'admin@123';
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

echo "Hash for '$newPassword' is: " . $hashedPassword . "<br><br>";

$sql = "UPDATE users SET password_hash = '$hashedPassword' WHERE user_id BETWEEN 11 AND 18";

if ($conn->query($sql)) {
    echo "✅ Passwords updated successfully!<br>";
    echo "All vendors can now login with password: <strong>admin@123</strong>";
} else {
    echo "❌ Error: " . $conn->error;
}

$conn->close();
?>