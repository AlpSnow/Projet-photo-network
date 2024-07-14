<?php
    namespace App;

    class Session{

        private static $categories = ['error', 'success'];

 
        //? ajoute un message en session, dans la catégorie $categ

        public static function addFlash($categ, $msg){
            $_SESSION[$categ] = $msg;
        }


        //? renvoie un message de la catégorie $categ, s'il y en a !

        public static function getFlash($categ){
            
            if(isset($_SESSION[$categ])){
                $msg = $_SESSION[$categ];  
                unset($_SESSION[$categ]);
            }
            else $msg = "";
            
            return $msg;
        }


        //? met un user dans la session (pour le maintenir connecté)

        public static function setUser($user){
            $_SESSION["user"] = $user;
        }

        public static function getUser(){
            return (isset($_SESSION['user'])) ? $_SESSION['user'] : false;
        }

        public static function isAdmin(){
            if(self::getUser() && self::getUser()->hasRole("ROLE_ADMIN")){
                return true;
            }
            return false;
        }


        //? met un token en session pour la protection contre la faille CSRF

        public static function setTokenCSRF($token){
            $_SESSION["tokenCSRF"] = $token; 
        }

        public static function getTokenCSRF(){
            return (isset($_SESSION["tokenCSRF"])) ? $_SESSION["tokenCSRF"] : false;
        }


        //? recaptcha V3

        public static function checkToken($token, $secretKey){

            $verif_url  = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$token";
            $curl = curl_init($verif_url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($curl, CURLOPT_TIMEOUT, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $verif_response = curl_exec($curl);
            if ( empty($verif_response) ) return false;
            else { 
                    $json = json_decode($verif_response);
                    return $json->success;
                }
        }

        public static function checkTokenDebug($token,$secret_key,$DEBUG=false) {

            if ( $DEBUG ) {
                echo "<b>token =></b> $token<br><br>";
                echo "<b>clé secrète =></b> $secret_key<br><br>";
            }
        
            if ( empty($token) ) return false;
        
            $verif_url  = "https://www.google.com/recaptcha/api/siteverify?secret=$secret_key&response=$token";
        
            if ( function_exists('curl_version') ) {
        
                if ( $DEBUG ) echo "<b>Curl sur url =></b> ",htmlspecialchars($verif_url),"<br><br>";
                $curl = curl_init($verif_url);
                curl_setopt($curl, CURLOPT_HEADER, false);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_TIMEOUT, 1);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                $verif_response = curl_exec($curl);
        
            } else {
        
                if ( $DEBUG ) echo "On fait du file_get_content<br><br>";
        
                $verif_response = file_get_content($verif_url);
            }
        
            if ( $DEBUG )  echo "<b>Réponse =></b> $verif_response<br><br>";
        
            if ( empty($verif_response) ) return false;
        
            else  {
                 $json = json_decode($verif_response);
                return $json->success;
            }
        }

    }