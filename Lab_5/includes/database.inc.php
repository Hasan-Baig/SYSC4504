<?php
require_once('book-config.inc.php');

function setConnectionInfo() {}
function runQuery() {}

function readAllEmployees() {
    $pdo = new PDO(DBCONNECTION ,DBUSER,DBPASS);
    $sql = "select * from employees order by LastName";
    $result = $pdo->query($sql);
    $output = array();
    while ($row = $result->fetch()) {
        $output[$row['EmployeeID']] = $row;
    }
    return $output;
}

function readSelectEmployeesByName($search) {
    $pdo = new PDO(DBCONNECTION,DBUSER,DBPASS);
    $sql = "select * from employees where LastName =:search";
    $result = $pdo->prepare($sql);
    $result->bindValue(':search', $search);
    $result->execute();
    $output = array();
    while ($row = $result->fetch()) {
        $output[$row['EmployeeID']] = $row;
    }
    return $output;
}

function readSelectEmployeeByID($employee) {
    $pdo = new PDO(DBCONNECTION,DBUSER,DBPASS);
    $sql = "select * from employees where EmployeeID =:employee";
    $result = $pdo->prepare($sql);
    $result->bindValue(':employee', $employee);
    $result->execute();
    return $result;
}

function readTODOs($employee) {
    $pdo = new PDO(DBCONNECTION,DBUSER,DBPASS);
    $sql = "select * from employeetodo where EmployeeID =:employee order by dateby";
    $result = $pdo->prepare($sql);
    $result->bindValue(':employee', $employee);
    $result->execute();
    $output = array();
    while ($row = $result->fetch()) {
        $output[$row['ToDoID']] = $row;
    }
    return $output;
}

?>
