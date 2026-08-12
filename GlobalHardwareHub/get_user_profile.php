<?php
session_start();
require_once 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "success" => false,
        "message" => "User not logged in"
    ]);
    exit;
}

$user_id = $_SESSION['user_id'];

// STEP 2: Fetch user profile data with LEFT JOIN
$sql = "SELECT 
            u.user_id, 
            u.full_name, 
            u.email, 
            u.phone,
            up.profile_image,
            up.date_of_birth
        FROM users u
        LEFT JOIN user_profiles up ON u.user_id = up.user_id
        WHERE u.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode([
        "success" => false,
        "message" => "User not found"
    ]);
    $stmt->close();
    $conn->close();
    exit;
}

$user_data = $result->fetch_assoc();
$stmt->close();

// STEP 3: Handle null values from LEFT JOIN
if ($user_data['profile_image'] === null) {
    $user_data['profile_image'] = null;
}

if ($user_data['date_of_birth'] === null) {
    $user_data['date_of_birth'] = null;
}

// STEP 4: Return success response with data
echo json_encode([
    "success" => true,
    "data" => [
        "user_id" => $user_data['user_id'],
        "full_name" => $user_data['full_name'],
        "email" => $user_data['email'],
        "phone" => $user_data['phone'],
        "profile_image" => $user_data['profile_image'],
        "date_of_birth" => $user_data['date_of_birth']
    ]
]);

$conn->close();
?>