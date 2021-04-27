<?php 
    include('init.php');

    $result = array();
    $dataForm = $_REQUEST;

    $update = $usr->updateProfil($dataForm);
    if($update == "pseudo"){$result["data"]["return"] = "ce pseudo est déjà utilisé";}
    else if($update == "photo"){$result["data"]["return"] = "impossible de téléverser cette image. Son poid ne doit pas dépasser les 2 Mo";}
    else {$result["data"]["return"] = $update;}
    $result["data"]["error"] = false;

    echo json_encode($result);

    include('close.php');
?>