<?php
// get_payment_history.php

session_start();
header('Content-Type: application/json');

require_once "db_connect.php";

// Check login
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "success" => false,
        "message" => "Please login first"
    ]);
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    $sql = "
        SELECT 
            op.payment_id,
            o.order_id,
            op.payment_method,
            op.amount,
            op.status AS payment_status,
            o.status AS order_status,
            op.created_at AS payment_date
        FROM orders o
        INNER JOIN order_payments op ON o.order_id = op.order_id
        WHERE o.user_id = ?
        ORDER BY op.created_at DESC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $result = $stmt->get_result();

    $history = [];

    while ($row = $result->fetch_assoc()) {
        $history[] = [
            "payment_id"     => $row["payment_id"],
            "order_id"       => $row["order_id"],
            "payment_method" => $row["payment_method"],
            "amount"         => $row["amount"],
            "payment_status" => $row["payment_status"],
            "order_status"   => $row["order_status"],
            "payment_date"   => $row["payment_date"]
        ];
    }

    echo json_encode([
        "success" => true,
        "data" => $history
    ]);

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Unable to fetch payment history"
    ]);
}
?>