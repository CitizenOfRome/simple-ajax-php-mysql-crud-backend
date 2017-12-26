<?php
try {
    $conn = require('./includes/getPDOConnection.php');

    // prepare sql and bind parameters
    $stmt = $conn->prepare("SELECT * FROM students");
    $success = $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result, JSON_FORCE_OBJECT);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}