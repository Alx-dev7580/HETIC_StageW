<?php 
    include('init.php');

    // Reading JSON POST using PHP
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    $result = array();

    if(is_array($data))
    {

        $update = $usr->updatePassword($data["data"]['apwd'], $data["data"]['npwd'], $data["data"]['id']);
        if($update){
            $result["data"]["return"] = 'success';
        } else {
            $result["data"]["return"] = 'mot de passe incorrect';
        }

        $result["data"]["error"] = false;
    }
    else{
        $result["data"]["error"] = 'Erreur de perte de données';
        $result["data"]["return"] = false;
    }

    echo json_encode($result);


    include('close.php');
?>