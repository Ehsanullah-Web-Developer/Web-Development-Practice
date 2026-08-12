<?php
echo "<h2>Network Connection Test</h2>";

// Test 1: Can we resolve Stripe's domain?
$host = 'api.stripe.com';
echo "<strong>Test 1: DNS Resolution</strong><br>";
$ip = gethostbyname($host);
if ($ip == $host) {
    echo "❌ Failed to resolve API.Stripe.com<br>";
} else {
    echo "✅ Resolved to IP: $ip<br>";
}

echo "<br>";

// Test 2: Can we connect using file_get_contents (bypasses cURL)
echo "<strong>Test 2: file_get_contents connection</strong><br>";
$opts = [
    'http' => ['method' => 'GET', 'timeout' => 10],
    'ssl' => ['verify_peer' => false, 'verify_peer_name' => false]
];
$context = stream_context_create($opts);
$result = @file_get_contents('https://api.stripe.com', false, $context);
if ($result === false) {
    echo "❌ Cannot connect to Stripe via file_get_contents<br>";
} else {
    echo "✅ Can connect to Stripe<br>";
}

echo "<br>";

// Test 3: Check if OpenSSL is enabled
echo "<strong>Test 3: OpenSSL Status</strong><br>";
if (extension_loaded('openssl')) {
    echo "✅ OpenSSL is enabled<br>";
} else {
    echo "❌ OpenSSL is NOT enabled<br>";
}

echo "<br>";

// Test 4: Google connection test (control test)
echo "<strong>Test 4: Can you reach Google?</strong><br>";
$google = @file_get_contents('https://www.google.com', false, $context);
if ($google === false) {
    echo "❌ Cannot reach Google - Your internet connection may be down<br>";
} else {
    echo "✅ Can reach Google - Internet is working<br>";
}
?>