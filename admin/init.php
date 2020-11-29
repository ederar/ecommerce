<?php
include 'connect.php';
// ROOTS 

$tmp = 'includes/templates/';
$css = 'layout/css/';
$funcs = 'includes/funcs/';
///$func = 'includes/funcs/';


include $tmp . 'header.php';
//include $func . 'funk.php';

include $funcs . 'funk.php';


if (!isset($nonav)) {
  
include  $tmp . 'navbar.php';
}
