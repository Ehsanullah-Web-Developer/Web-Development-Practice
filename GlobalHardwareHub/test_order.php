<?php
session_start();
require_once 'db_connect.php';
header('Content-Type: application/json');

// Simple test
echo json_encode([
    'success' => false, 
    'message' => 'Test: ' . ($conn ? 'DB Connected' : 'DB Failed')
]);
?>