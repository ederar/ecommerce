<?php 
session_start();
if (isset($_SESSION['username'])) {
    include 'init.php';
    //echo 'welcome';

    

    include $tmp . 'footer.php';
} 
else {
    header('location: index.php');
    exit();
}
