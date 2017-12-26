<?php
// $id = $_REQUEST['id'];
$inputJSON = file_get_contents('php://input');
$inputData = json_decode($inputJSON);
// var_dump($inputData);

try {
    $conn = require('./includes/getPDOConnection.php');

    // prepare sql and bind parameters
    $stmt = $conn->prepare("INSERT INTO students (name, specialization, age) 
    VALUES (:name, :specialization, :age)");
    $stmt->bindParam(':name', $inputData -> name);
    $stmt->bindParam(':specialization', $inputData -> specialization);
    $stmt->bindParam(':age', $inputData -> age);
    $success = $stmt->execute();

    echo "New records created successfully - ". $success;
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
