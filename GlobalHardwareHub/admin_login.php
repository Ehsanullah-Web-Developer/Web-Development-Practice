<?php
session_start();
require_once 'db_connect.php';

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method"
    ]);
    exit;
}

// STEP 2: Validate input
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

if (empty($email) || empty($password)) {
    echo json_encode([
        "success" => false,
        "message" => "Email and password are required"
    ]);
    exit;
}

// STEP 3: Fetch user by email
$sql = "SELECT user_id, full_name, email, password_hash, user_type FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid email or password"
    ]);
    $stmt->close();
    $conn->close();
    exit;
}

$user = $result->fetch_assoc();
$stmt->close();

// STEP 4: Verify admin role
if ($user['user_type'] !== 'admin') {
    echo json_encode([
        "success" => false,
        "message" => "Access denied. Admin only."
    ]);
    $conn->close();
    exit;
}

// STEP 5: Verify password
if (!password_verify($password, $user['password_hash'])) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid email or password"
    ]);
    $conn->close();
    exit;
}

// STEP 6: Create session
$_SESSION['user_id'] = $user['user_id'];
$_SESSION['user_type'] = $user['user_type'];
$_SESSION['admin_name'] = $user['full_name'];
$_SESSION['admin_email'] = $user['email'];

// STEP 7: Success response
echo json_encode([
    "success" => true,
    "message" => "Admin login successful",
    "redirect" => "AdminDashboard.php"
]);

$conn->close();
?>