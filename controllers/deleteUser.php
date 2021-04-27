<?php 
    include('init.php');

    if($_GET['id'] && $_GET['id']!=1){
        $req = $db->prepare("UPDATE users SET deleted_at=NOW() WHERE id=:id");
        $req->execute(array("id"=>$_GET['id']));
    } 

    header('location: ../?p=dashboard');

    include('close.php');
?>