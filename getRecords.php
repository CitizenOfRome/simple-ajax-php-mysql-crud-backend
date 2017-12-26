<?php
try {
    $conn = require('./includes/getPDOConnection.php');

    // prepare sql and bind parameters
    $searchName = $_GET['searchName'];
    $searchSpecialization = $_GET['searchSpecialization'];
    $searchAge = $_GET['searchAge'];
    $query = "SELECT * FROM students ";
    if(!empty($searchName) || !empty($searchSpecialization) || !empty($searchAge)) {
        $query .= 'WHERE ';
        $queryParts = array();
        if(!empty($searchName)) {
            $queryParts []= ' name LIKE CONCAT(\'%\', :name, \'%\')';
        }
        if(!empty($searchSpecialization)) {
            $queryParts []= ' specialization LIKE CONCAT(\'%\', :specialization, \'%\')';
        }
        if(!empty($searchAge)) {
            $queryParts []= ' age=:age ';
        }
        $query .= implode(' AND ', $queryParts);
    }
    $stmt = $conn->prepare($query);
    if(!empty($searchName)) {
        $stmt->bindParam(':name', $searchName);
    }
    if(!empty($searchSpecialization)) {
        $stmt->bindParam(':specialization', $searchSpecialization);
    }
    if(!empty($searchAge)) {
        $stmt->bindParam(':age', $searchAge);
    }
    $success = $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result, JSON_FORCE_OBJECT);
} catch(PDOException $e) {
    echo json_encode(array('message' => "Error: " . $e->getMessage(), 'success' => false));
}