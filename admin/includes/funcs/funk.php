<?php 

function tittle(){
    global $pagetitle;
    if (isset($pagetitle)) {
        echo $pagetitle;
    }
}