<?php
// $id = $_REQUEST['id'];
$inputJSON = file_get_contents('php://input');
$inputData = json_decode($inputJSON);
// var_dump($inputData);

try {
    $conn = new PDO("mysql:host=localhost;dbname=simple_ajax_php_mysql", 'root', '');
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
