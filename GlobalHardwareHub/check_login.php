<?php
session_start();
require_once 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "success" => true,
        "logged_in" => false,
        "message" => "User not logged in"
    ]);
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user information from database
$sql = "SELECT user_id, full_name, email, user_type FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Session exists but user not found in database (should not happen)
    echo json_encode([
        "success" => true,
        "logged_in" => false,
        "message" => "User not found"
    ]);
    $stmt->close();
    $conn->close();
    exit;
}

$user = $result->fetch_assoc();
$stmt->close();
$conn->close();

// Return success response with user data
echo json_encode([
    "success" => true,
    "logged_in" => true,
    "user" => [
        "user_id" => $user['user_id'],
        "full_name" => $user['full_name'],
        "email" => $user['email'],
        "user_type" => $user['user_type']
    ]
]);
?>