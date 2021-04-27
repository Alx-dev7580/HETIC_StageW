<?php
    class Users {
        public function login($email, $pwd){
            global $cmn;
            global $db;

            $pass_crypt = $cmn->cryptPass($pwd);

            $requete = $db->prepare("SELECT * FROM users WHERE email=:email AND pwd=:pwd AND deleted_at IS NULL");
            $requete->execute(array(
                "email"=>$email,
                "pwd"=>  $pass_crypt
            ));
            return $requete->fetch(PDO::FETCH_OBJ);
        }

        public function getUser($id){
            global $cmn;
            global $db;

            $requete = $db->prepare("SELECT * FROM users WHERE id=:id");
            $requete->execute(array(
                "id"=>$id
            ));
            return $requete->fetch(PDO::FETCH_OBJ);
        }

        public function listUser(){
            global $cmn;
            global $db;

            $data = array();

            $requete = $db->prepare("SELECT * FROM users WHERE deleted_at IS NULL");
            $requete->execute();
            
            while($ligne = $requete->fetch(PDO::FETCH_OBJ)) {
                $data[] = $ligne;
            }
            return $data;
        }

        public function createUser($email){
            global $cmn;
            global $db;

            $verif = $db->prepare("SELECT COUNT(id) AS nb FROM users WHERE email=:email AND deleted_at IS NULL");
            $verif->execute(array(
                "email"=>$email
            ));
            $recup = $verif->fetch(PDO::FETCH_OBJ);

            if($recup->nb != 0){
                return false;
            } else {
                $params = array(
                    "email"=>$email,
                    "pwd"=>$cmn->cryptPass("123456"),
                    "avatar"=>"default.svg",
                    "account"=>0
                );
                $requete = $db->prepare("INSERT INTO users(email,pwd,avatar,account,created_at) VALUES(:email,:pwd,:avatar,:account,NOW())");
                $requete->execute($params);
                return true;
            }
        }

        public function updatePassword($apwd, $npwd, $id){
            global $cmn;
            global $db;

            $cryptApwd = $cmn->cryptPass($apwd);

            $verif = $db->prepare("SELECT COUNT(id) AS nb FROM users WHERE pwd=:pwd AND id=:id");
            $verif->execute(array(
                "pwd"=>$cryptApwd,
                "id"=>$id
            ));
            $recup = $verif->fetch(PDO::FETCH_OBJ);

            if($recup->nb == 0){
                return false;
            } else {
                $params = array(
                    "pwd"=>$cmn->cryptPass($npwd),
                    "id"=>$id
                );
                $requete = $db->prepare("UPDATE users SET update_at=NOW(), pwd=:pwd WHERE id=:id");
                $requete->execute($params);
                return true;
            }
        }

        public function updateProfil($dataForm){
            global $cmn;
            global $db;

            if(trim($dataForm['pseudo']) !== ""){
                $verif = $db->prepare("SELECT COUNT(id) AS nb FROM users WHERE pseudo=:pseudo AND id!=:id");
                $verif->execute(array(
                    "pseudo"=>trim($dataForm['pseudo']),
                    "id"=>$dataForm['id']
                ));
                $recup = $verif->fetch(PDO::FETCH_OBJ);
                if($recup->nb > 0){
                    return "pseudo";
                }
            } else {
                $dataForm['pseudo'] = NULL;
            }

            if($_FILES['photo']['name'] !== ""){
                $dataForm['photo'] = $cmn->uploadImage($_FILES['photo'],'../public/img/avatar/');
                if(!$dataForm['photo']){
                    return "photo";
                }
            } else {
                $dataForm['photo'] = $dataForm['old_photo'];
            }
           $requete = $db->prepare("UPDATE users SET update_at=NOW(), lastname=:lastname, firstname=:firstname, addresse=:addresse, pseudo=:pseudo, avatar=:avatar, birthday=:birthday WHERE id=:id");
            $requete->execute(array(
                "lastname"=>trim($dataForm['lastname']),
                "firstname"=>trim($dataForm['firstname']),
                "addresse"=>trim($dataForm['address']),
                "pseudo"=>trim($dataForm['pseudo']),
                "avatar"=>$dataForm['photo'],
                "birthday"=>$dataForm['date'],
                "id"=>$dataForm['id']
            ));
            return "success";
        }
    }

?>