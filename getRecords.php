<?php
try {
    $conn = require('./includes/getPDOConnection.php');

    // prepare sql and bind parameters
    $searchName = $_GET['searchName'];
    $searchSpecialization = $_GET['searchSpecialization'];
    $searchAge = $_GET['searchAge'];
    $page = intval($_GET['page']);
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
    $queryWithoutLimitAndOffset = $query;
    $query .= ' LIMIT 5 ';
    $query .= ' OFFSET '. (($page-1)*5);
    $stmt = $conn->prepare($query);
    $stmtWithoutLimitAndOffset = $conn->prepare($queryWithoutLimitAndOffset);
    if(!empty($searchName)) {
        $stmt->bindParam(':name', $searchName);
        $stmtWithoutLimitAndOffset->bindParam(':name', $searchName);
    }
    if(!empty($searchSpecialization)) {
        $stmt->bindParam(':specialization', $searchSpecialization);
        $stmtWithoutLimitAndOffset->bindParam(':specialization', $searchSpecialization);
    }
    if(!empty($searchAge)) {
        $stmt->bindParam(':age', $searchAge);
        $stmtWithoutLimitAndOffset->bindParam(':age', $searchAge);
    }
    $success = $stmt->execute();
    $stmtWithoutLimitAndOffset->execute();
    $count = $stmtWithoutLimitAndOffset->rowCount();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(array(
        'data' => $result,
        'pagesCount' => ceil($count/5)
    ), JSON_FORCE_OBJECT);
} catch(PDOException $e) {
    echo json_encode(array('message' => "Error: " . $e->getMessage(), 'success' => false));
}