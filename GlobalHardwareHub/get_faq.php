<?php
// ==============================================
// File: get_faq.php
// Description: API endpoint to fetch all FAQs from database
// Returns: JSON array of FAQs
// ==============================================

// Include database connection
require_once 'db_connect.php';

// Set header to return JSON response
header('Content-Type: application/json');

// ============== FETCH FAQS FROM DATABASE ==============
try {
    // Simple SELECT query to fetch all FAQs
    // ORDER BY created_at DESC to show latest FAQs first
    $sql = "SELECT faq_id, category, question, answer 
            FROM faq 
            ORDER BY created_at DESC";
    
    $result = $conn->query($sql);
    
    if (!$result) {
        throw new Exception("Query failed: " . $conn->error);
    }
    
    $faqs = array();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $faqs[] = array(
                "faq_id" => (int)$row['faq_id'],
                "category" => $row['category'],
                "question" => $row['question'],
                "answer" => $row['answer']
            );
        }
    }
    
    // Return FAQs as JSON
    echo json_encode($faqs);
    
} catch (Exception $e) {
    // Return error message if something goes wrong
    echo json_encode(array(
        "error" => true,
        "message" => "Database error: " . $e->getMessage()
    ));
}

// Close database connection
$conn->close();
?>