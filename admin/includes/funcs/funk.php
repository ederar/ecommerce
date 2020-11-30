<?php 

function tittle(){
    global $pagetitle;
    if (isset($pagetitle)) {
        echo $pagetitle;
    }
}


// Check Item Function 

function checkItems($select, $from, $value) {

    global $conn ;
    $statement = $conn->prepare("SELECT $select FROM $from WHERE $select = ?");
    $statement->execute(array($value));
    $count = $statement->rowCount();
    return $count;
}


//Count Items Function 

function countItems($item , $table) {
    global $conn ;
    $stmt2 = $conn->prepare("SELECT count($item) FROM $table");
    $stmt2->execute();
    return $stmt2->fetchColumn();
}


//Get Latest Items 
function latestItems($select, $table, $order, $limit = 5) {

    global $conn;
    $stmt3 = $conn->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
    $stmt3->execute();
    $rows = $stmt3->fetchAll();
    return $rows;
}