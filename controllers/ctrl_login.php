<?php 
    include('init.php');

    // Reading JSON POST using PHP
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    $result = array();

    if(is_array($data))
    {
       if(!$cmn->verifMail($data["data"]['email'])){
        $result["data"]["return"] = "Le format de l'email est incorrect";
        $result["data"]["error"] = false;
       } else {
            $login = $usr->login($data["data"]['email'], $data["data"]['password']);
            if($login){
                $_SESSION["usr_hetic"] = $login->id;
                $_SESSION["is_admin"] = $login->account;
                $result["data"]["return"] = 'success';
            } else {
                $result["data"]["return"] = 'Email ou mot de passe incorrect';
            }

            $result["data"]["error"] = false;
       }
    }
    else{
        $result["data"]["error"] = 'Erreur de perte de données';
        $result["data"]["return"] = false;
    }

    echo json_encode($result);


    include('close.php');
?>