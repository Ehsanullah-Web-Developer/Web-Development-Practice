<?php
require_once 'db_connect.php';

$vendors = [11, 12, 13, 14, 15, 16, 17, 18];
$newPassword = 'admin@123';

echo "<h2>Fixing Vendor Passwords</h2>";

foreach ($vendors as $userId) {
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password_hash = ? WHERE user_id = ?");
    $stmt->bind_param('si', $hashedPassword, $userId);
    
    if ($stmt->execute()) {
        echo "✅ Vendor ID $userId updated successfully<br>";
    } else {
        echo "❌ Failed for Vendor ID $userId<br>";
    }
    $stmt->close();
}

$conn->close();
echo "<br>🎉 All vendors can now login with password: <strong>$newPassword</strong>";
echo "<br><br><a href='LogIn.php'>Go to Login Page</a>";
?>