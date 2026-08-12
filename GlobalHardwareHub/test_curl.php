<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$result = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);

echo "<h2>cURL Test Results</h2>";
if ($error) {
    echo "cURL Error: " . $error;
} else {
    echo "Successfully connected to Stripe!";
}
?>