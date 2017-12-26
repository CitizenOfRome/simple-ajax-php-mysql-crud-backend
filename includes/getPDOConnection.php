<?php

$conn = new PDO("mysql:host=localhost;dbname=simple_ajax_php_mysql", 'root', '');
// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

return $conn;