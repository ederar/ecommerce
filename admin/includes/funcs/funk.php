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