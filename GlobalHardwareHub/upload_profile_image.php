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

// Check if file was uploaded
if (!isset($_FILES['profile_image']) || $_FILES['profile_image']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode([
        "success" => false,
        "message" => "No file uploaded or upload error occurred"
    ]);
    exit;
}

$file = $_FILES['profile_image'];

// STEP 1: Validate file type and size
$allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
$max_size = 2 * 1024 * 1024; // 2MB

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$file_type = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);

if (!in_array($file_type, $allowed_types)) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid file type. Only JPG, JPEG, PNG are allowed"
    ]);
    exit;
}

if ($file['size'] > $max_size) {
    echo json_encode([
        "success" => false,
        "message" => "File too large. Maximum size is 2MB"
    ]);
    exit;
}

// STEP 2: Generate unique filename and upload
$upload_dir = 'uploads/profile/';

// Create directory if it doesn't exist
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

$extension = '';
switch ($file_type) {
    case 'image/jpeg':
    case 'image/jpg':
        $extension = 'jpg';
        break;
    case 'image/png':
        $extension = 'png';
        break;
}

$filename = 'profile_' . $user_id . '_' . time() . '.' . $extension;
$file_path = $upload_dir . $filename;

if (!move_uploaded_file($file['tmp_name'], $file_path)) {
    echo json_encode([
        "success" => false,
        "message" => "Upload failed. Could not save file"
    ]);
    exit;
}

// STEP 3: Save or update profile image in database
$image_url = $upload_dir . $filename;

// Check if user profile exists
$check_sql = "SELECT user_id FROM user_profiles WHERE user_id = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("i", $user_id);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    // Update existing record
    $update_sql = "UPDATE user_profiles SET profile_image = ? WHERE user_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("si", $image_url, $user_id);
    
    if (!$update_stmt->execute()) {
        // Delete uploaded file if database update fails
        unlink($file_path);
        echo json_encode([
            "success" => false,
            "message" => "Failed to update profile image in database"
        ]);
        exit;
    }
    $update_stmt->close();
} else {
    // Insert new record
    $insert_sql = "INSERT INTO user_profiles (user_id, profile_image) VALUES (?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("is", $user_id, $image_url);
    
    if (!$insert_stmt->execute()) {
        // Delete uploaded file if database insert fails
        unlink($file_path);
        echo json_encode([
            "success" => false,
            "message" => "Failed to save profile image to database"
        ]);
        exit;
    }
    $insert_stmt->close();
}

$check_stmt->close();

// STEP 4: Return success response
echo json_encode([
    "success" => true,
    "image_url" => $image_url
]);
?>