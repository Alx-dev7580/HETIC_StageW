<?php 
    include('init.php');

    if($_GET['id'] && $_GET['id']!=1){
        $req = $db->prepare("UPDATE users SET update_at=NOW(), pwd=:pwd WHERE id=:id");
        $req->execute(array("pwd"=>$cmn->cryptPass('123456'),"id"=>$_GET['id']));
    } 

    header('location: ../?p=dashboard');

    include('close.php');
?>