<?php
// debug_stripe_detailed.php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Stripe Detailed Debug</h2>";

// Set test user
$_SESSION['user_id'] = 1;

// Check PHP version
echo "<h3>PHP Version: " . phpversion() . "</h3>";

// Check if Stripe library is loaded
echo "<h3>Checking Stripe Library:</h3>";
if (file_exists('vendor/autoload.php')) {
    echo "✅ vendor/autoload.php exists<br>";
} else {
    echo "❌ vendor/autoload.php NOT found. Run: composer require stripe/stripe-php<br>";
}

// Include files
require_once 'db_connect.php';
require_once 'config/stripe.php';

echo "<h3>Database Check:</h3>";
if ($conn) {
    echo "✅ Database connected<br>";
    
    $user_id = 1;
    $query = "SELECT SUM(quantity * price) as total FROM cart WHERE user_id = $user_id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $total = $row['total'] ?? 0;
    
    echo "User ID: $user_id<br>";
    echo "Cart total: $$total<br>";
    
    if ($total <= 0) {
        echo "❌ Cart is empty. Let's add a test item...<br>";
        
        // Add test item to cart
        $insertQuery = "INSERT INTO cart (user_id, product_id, quantity, price) VALUES (1, 1, 1, 99.99)";
        if (mysqli_query($conn, $insertQuery)) {
            echo "✅ Test item added to cart<br>";
            $total = 99.99;
        } else {
            echo "❌ Failed to add test item: " . mysqli_error($conn) . "<br>";
        }
    }
} else {
    echo "❌ Database connection failed<br>";
}

echo "<h3>Stripe PaymentIntent Creation:</h3>";

try {
    $amountInCents = (int)round($total * 100);
    echo "Amount: $$total → {$amountInCents} cents<br>";
    
    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => $amountInCents,
        'currency' => 'usd',
        'metadata' => ['user_id' => $user_id],
        'description' => 'Debug test payment'
    ]);
    
    echo "<span style='color:green'>✅ PaymentIntent created successfully!</span><br>";
    echo "PaymentIntent ID: " . $paymentIntent->id . "<br>";
    echo "Client Secret: " . $paymentIntent->client_secret . "<br>";
    
} catch (Exception $e) {
    echo "<span style='color:red'>❌ Stripe Error: " . $e->getMessage() . "</span><br>";
    
    // Common error solutions
    $errorMsg = $e->getMessage();
    if (strpos($errorMsg, 'No such payment intent') !== false) {
        echo "<br><strong>Solution:</strong> Your secret key might be invalid or from a different Stripe account.<br>";
    } elseif (strpos($errorMsg, 'Invalid API Key') !== false) {
        echo "<br><strong>Solution:</strong> Your Stripe secret key is invalid. Get a new key from Stripe Dashboard.<br>";
    } elseif (strpos($errorMsg, 'currency') !== false) {
        echo "<br><strong>Solution:</strong> Check if 'usd' is supported by your Stripe account.<br>";
    } elseif (strpos($errorMsg, 'amount') !== false) {
        echo "<br><strong>Solution:</strong> Amount must be at least $0.50 USD (50 cents).<br>";
    }
}

mysqli_close($conn);
?>