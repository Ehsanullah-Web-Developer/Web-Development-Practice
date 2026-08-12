<?php
session_start();
header('Content-Type: application/json');

echo json_encode([
    'session_id' => session_id(),
    'user_id' => $_SESSION['user_id'] ?? 'Not set',
    'user_email' => $_SESSION['user_email'] ?? 'Not set',
    'user_role' => $_SESSION['user_role'] ?? 'Not set'
]);
?>