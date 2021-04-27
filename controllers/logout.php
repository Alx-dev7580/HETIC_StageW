<?php 
    include('init.php');
    
    $_SESSION = array();
    session_destroy();
    header("location:../");

    include('close.php');
?>