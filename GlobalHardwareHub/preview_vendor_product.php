<?php
/**
 * preview_vendor_product.php
 * 
 * This API endpoint returns a preview of product data before saving.
 * No database insertion - only validates and returns the input data.
 * Used when vendor clicks Preview button before submitting product.
 * 
 * Expected input: POST request with product form data
 * Expected output: JSON format with product preview data
 */

// Start session to check user login status
session_start();

// Set response header to JSON
header('Content-Type: application/json');

/**
 * Helper function to send JSON response and exit
 */
function sendResponse($success, $data = null, $message = null) {
    $response = ['success' => $success];
    
    if ($data !== null) {
        $response['data'] = $data;
    }
    
    if ($message !== null) {
        $response['message'] = $message;
    }
    
    echo json_encode($response);
    exit;
}

/**
 * STEP 1: Check if request method is POST
 */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, null, 'Invalid request method');
}

/**
 * STEP 2: Check if user is logged in (vendor only)
 */
if (!isset($_SESSION['user_id'])) {
    sendResponse(false, null, 'Please login first');
}

$loggedInUserId = $_SESSION['user_id'];

/**
 * STEP 3: Verify vendor account (user_id 11-18)
 */
$vendorId = $loggedInUserId - 10;
if ($vendorId < 1 || $vendorId > 8) {
    sendResponse(false, null, 'Access denied. Vendor account required.');
}

/**
 * STEP 4: Get POST data
 */
$inputData = json_decode(file_get_contents('php://input'), true);

// If JSON decoding failed, try regular POST
if ($inputData === null) {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $category = isset($_POST['category']) ? trim($_POST['category']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $regularPrice = isset($_POST['regular_price']) ? (float)$_POST['regular_price'] : 0;
    $salePrice = isset($_POST['sale_price']) ? (float)$_POST['sale_price'] : null;
    $imageUrl = isset($_POST['image_url']) ? trim($_POST['image_url']) : '';
    $status = isset($_POST['status']) ? trim($_POST['status']) : 'draft';
    $specifications = isset($_POST['specifications']) ? $_POST['specifications'] : [];
} else {
    $name = isset($inputData['name']) ? trim($inputData['name']) : '';
    $category = isset($inputData['category']) ? trim($inputData['category']) : '';
    $description = isset($inputData['description']) ? trim($inputData['description']) : '';
    $regularPrice = isset($inputData['regular_price']) ? (float)$inputData['regular_price'] : 0;
    $salePrice = isset($inputData['sale_price']) ? (float)$inputData['sale_price'] : null;
    $imageUrl = isset($inputData['image_url']) ? trim($inputData['image_url']) : '';
    $status = isset($inputData['status']) ? trim($inputData['status']) : 'draft';
    $specifications = isset($inputData['specifications']) ? $inputData['specifications'] : [];
}

/**
 * STEP 5: Basic validation for preview
 */
if (empty($name)) {
    sendResponse(false, null, 'Product name is required');
}

if ($regularPrice <= 0) {
    sendResponse(false, null, 'Valid regular price is required');
}

/**
 * STEP 6: Format specifications array
 */
$formattedSpecs = [];
if (is_array($specifications)) {
    foreach ($specifications as $spec) {
        if (is_array($spec)) {
            $key = isset($spec['key']) ? trim($spec['key']) : '';
            $value = isset($spec['value']) ? trim($spec['value']) : '';
            if (!empty($key) || !empty($value)) {
                $formattedSpecs[] = [
                    'key' => $key,
                    'value' => $value
                ];
            }
        }
    }
}

/**
 * STEP 7: Prepare preview data
 */
$previewData = [
    'name' => $name,
    'category' => $category,
    'description' => $description,
    'regular_price' => $regularPrice,
    'sale_price' => $salePrice,
    'image_url' => $imageUrl,
    'status' => $status,
    'specifications' => $formattedSpecs
];

// Add formatted price for display
$previewData['formatted_regular_price'] = '₹' . number_format($regularPrice, 2);
if ($salePrice && $salePrice > 0) {
    $previewData['formatted_sale_price'] = '₹' . number_format($salePrice, 2);
    $discount = round((($regularPrice - $salePrice) / $regularPrice) * 100);
    $previewData['discount_percentage'] = $discount;
}

// Add status badge
$statusBadges = [
    'active' => 'Active',
    'draft' => 'Draft',
    'out_of_stock' => 'Out of Stock'
];
$previewData['status_badge'] = $statusBadges[$status] ?? 'Draft';

/**
 * STEP 8: Return preview response
 */
sendResponse(true, $previewData);

$conn = null; // No database connection used
?>