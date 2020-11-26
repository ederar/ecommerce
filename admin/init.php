<?php
include 'connect.php';
// ROOTS 

$tmp = 'includes/templates/';
$css = 'layout/css/';
///$func = 'includes/funcs/';


include $tmp . 'header.php';
//include $func . 'funk.php';

if (!isset($nonav)) {
  
include  $tmp . 'navbar.php';
}
