<?php
session_start();
require_once 'db_connect.php';

$vendorId = $_SESSION['user_id'] - 10;
$rating = isset($_GET['rating']) ? (int)$_GET['rating'] : 0;

echo "Vendor ID: $vendorId<br>";
echo "Rating filter: $rating<br><br>";

$sql = "SELECT vr.rating, p.name, u.full_name 
        FROM vendor_reviews vr
        INNER JOIN products p ON vr.product_id = p.product_id
        INNER JOIN users u ON vr.user_id = u.user_id
        WHERE vr.vendor_id = $vendorId";

if ($rating > 0) {
    $sql .= " AND vr.rating = $rating";
}

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "Rating: " . $row['rating'] . " - Product: " . $row['name'] . " - Customer: " . $row['full_name'] . "<br>";
}

$conn->close();
?>