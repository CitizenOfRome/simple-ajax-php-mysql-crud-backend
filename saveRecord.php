<?php
// $id = $_REQUEST['id'];
$inputJSON = file_get_contents('php://input');
$inputData = json_decode($inputJSON);
// var_dump($inputData);

try {
    $conn = require('./includes/getPDOConnection.php');

    // prepare sql and bind parameters
    if(!empty($inputData -> id)) {
        $stmt = $conn->prepare("UPDATE students SET name=:name, specialization=:specialization, age=:age WHERE id=:id");
        $stmt->bindParam(':id', $inputData -> id);
    } else {
        $stmt = $conn->prepare("INSERT INTO students (name, specialization, age) 
        VALUES (:name, :specialization, :age)");
    }
    $stmt->bindParam(':name', $inputData -> name);
    $stmt->bindParam(':specialization', $inputData -> specialization);
    $stmt->bindParam(':age', $inputData -> age);
    $success = $stmt->execute();

    echo json_encode(array('message' => "Record added/updated", 'success' => $success));
} catch(PDOException $e) {
    echo json_encode(array('message' => "Error: " . $e->getMessage(), 'success' => false));
}
