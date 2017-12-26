<?php
// $id = $_REQUEST['id'];
$inputJSON = file_get_contents('php://input');
$inputData = json_decode($inputJSON);
// var_dump($inputData);

try {
    $conn = require('./includes/getPDOConnection.php');

    // prepare sql and bind parameters
    $stmt = $conn->prepare("DELETE FROM students WHERE id=:id");
    $stmt->bindParam(':id', $inputData -> id);
    $success = $stmt->execute();

    echo json_encode(array('message' => "Record deleted - ", 'success' => $success));
} catch(PDOException $e) {
    echo json_encode(array('message' => "Error: " . $e->getMessage(), 'success' => false));
}
