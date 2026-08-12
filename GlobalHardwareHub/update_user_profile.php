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

// Check if required POST fields are set
if (!isset($_POST['full_name']) || !isset($_POST['email'])) {
    echo json_encode([
        "success" => false,
        "message" => "Missing required fields"
    ]);
    exit;
}

$full_name = trim($_POST['full_name']);
$email = trim($_POST['email']);
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$date_of_birth = isset($_POST['date_of_birth']) ? trim($_POST['date_of_birth']) : '';

// STEP 1: Validate input
if (empty($full_name)) {
    echo json_encode([
        "success" => false,
        "message" => "Full name is required"
    ]);
    exit;
}

if (empty($email)) {
    echo json_encode([
        "success" => false,
        "message" => "Email is required"
    ]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid email format"
    ]);
    exit;
}

// Validate phone if provided (basic validation - digits, spaces, dashes, plus)
if (!empty($phone)) {
    if (!preg_match('/^[\+\d\s\-\(\)]{8,20}$/', $phone)) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid phone number format"
        ]);
        exit;
    }
}

// Validate date of birth if provided
if (!empty($date_of_birth)) {
    $date_parts = explode('-', $date_of_birth);
    if (count($date_parts) !== 3 || !checkdate($date_parts[1], $date_parts[2], $date_parts[0])) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid date of birth format"
        ]);
        exit;
    }
}

// STEP 2: User ID already obtained from session

// STEP 3: Update users table
$update_user_sql = "UPDATE users SET full_name = ?, email = ?, phone = ? WHERE user_id = ?";
$update_user_stmt = $conn->prepare($update_user_sql);
$update_user_stmt->bind_param("sssi", $full_name, $email, $phone, $user_id);

if (!$update_user_stmt->execute()) {
    echo json_encode([
        "success" => false,
        "message" => "Failed to update profile"
    ]);
    $update_user_stmt->close();
    exit;
}
$update_user_stmt->close();

// STEP 4: Handle user_profiles table for date_of_birth
$check_profile_sql = "SELECT user_id FROM user_profiles WHERE user_id = ?";
$check_profile_stmt = $conn->prepare($check_profile_sql);
$check_profile_stmt->bind_param("i", $user_id);
$check_profile_stmt->execute();
$check_result = $check_profile_stmt->get_result();

if ($check_result->num_rows > 0) {
    // Update existing profile
    if (!empty($date_of_birth)) {
        $update_profile_sql = "UPDATE user_profiles SET date_of_birth = ? WHERE user_id = ?";
        $update_profile_stmt = $conn->prepare($update_profile_sql);
        $update_profile_stmt->bind_param("si", $date_of_birth, $user_id);
        
        if (!$update_profile_stmt->execute()) {
            echo json_encode([
                "success" => false,
                "message" => "Failed to update profile information"
            ]);
            $update_profile_stmt->close();
            $check_profile_stmt->close();
            exit;
        }
        $update_profile_stmt->close();
    }
} else {
    // Insert new profile record
    if (!empty($date_of_birth)) {
        $insert_profile_sql = "INSERT INTO user_profiles (user_id, date_of_birth) VALUES (?, ?)";
        $insert_profile_stmt = $conn->prepare($insert_profile_sql);
        $insert_profile_stmt->bind_param("is", $user_id, $date_of_birth);
        
        if (!$insert_profile_stmt->execute()) {
            echo json_encode([
                "success" => false,
                "message" => "Failed to create profile information"
            ]);
            $insert_profile_stmt->close();
            $check_profile_stmt->close();
            exit;
        }
        $insert_profile_stmt->close();
    }
}
$check_profile_stmt->close();

// STEP 5: Profile image handling is separate (upload_profile_image.php)
// This API does not handle image upload

// STEP 6: Return success response
echo json_encode([
    "success" => true,
    "message" => "Profile updated successfully"
]);

$conn->close();
?>