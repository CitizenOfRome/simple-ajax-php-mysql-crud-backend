<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=simple_ajax_php_mysql", 'root', '');
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // prepare sql and bind parameters
    $stmt = $conn->prepare("SELECT * FROM students");
    $success = $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result, JSON_FORCE_OBJECT);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}