<?php 
    class Common {

        public function text($string) {
            $searched = array('&lt;','&gt;');
            $replaced = array('<','>');
    
            $string = htmlspecialchars($string, ENT_QUOTES, "UTF-8");
            $string = str_replace($searched,$replaced,$string);
    
            return $string;
        }

        public function uploadImage($file,$destination){
            // $destination = dirname(__DIR__).$destination_dir;
            $extre = explode('.',$file['name']);
            $fichier = round(microtime(true)).'.'.end($extre);
            if(move_uploaded_file($file['tmp_name'], $destination . $fichier)){
                return $fichier;
            } else {
                return false;
            }
        }

        public function verifMail($email) {
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        }

        public function cryptPass($password) {
            return hash('sha512',$password);
        }
    }
?>