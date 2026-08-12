<?php
// test_payment_init.php
session_start();

// Set a test user (use a user_id that has items in cart)
$_SESSION['user_id'] = 1;

// Call the payment init file
$response = file_get_contents('http://localhost/BackendWebSite/create_payment_init.php');

echo "<h2>Response from create_payment_init.php:</h2>";
echo "<pre>";
print_r(json_decode($response, true));
echo "</pre>";
?>