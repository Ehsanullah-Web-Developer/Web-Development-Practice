<?php
session_start();

// Generate new CAPTCHA
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $num1 = rand(1, 10);
    $num2 = rand(1, 10);
    $_SESSION['captcha_result'] = $num1 + $num2;
    
    header('Content-Type: application/json');
    echo json_encode([
        'question' => "$num1 + $num2 = ?",
        'answer' => $num1 + $num2
    ]);
    exit;
}
?>