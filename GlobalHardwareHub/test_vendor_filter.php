<?php
session_start();
echo "Logged-in user_id: " . $_SESSION['user_id'] . "<br>";
echo "Mapped vendor_id: " . ($_SESSION['user_id'] - 10) . "<br>";

require_once 'db_connect.php';
$vendorId = $_SESSION['user_id'] - 10;

$sql = "SELECT rating, COUNT(*) as count FROM vendor_reviews WHERE vendor_id = ? GROUP BY rating";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $vendorId);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo "Rating: " . $row['rating'] . " - Count: " . $row['count'] . "<br>";
}
?>