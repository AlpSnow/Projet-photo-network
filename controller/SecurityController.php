<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\UserManager;
    use Model\Managers\FollowManager;
use Model\Managers\PhotoManager;

    class SecurityController extends AbstractController implements ControllerInterface{

        public function index(){

            if(isset($_SESSION['user'])) {

                if($_SESSION['user']->hasRole('ROLE_ADMIN')) {

                    $userManager = new UserManager();
            
                    return [
                            "view" => VIEW_DIR."user/listUsers.php",
                            "data" => [
                                "users" => $userManager->findAll(["pseudonym", "ASC"]),
                                "admins" => $userManager->findListAdmins()
                            ]
                        ];

                } else {
                    header("Location:index.php");
                }

            } else {
                header("Location:index.php");
            }

        }
        


        public function seeUserById($id){

            $userManager = new UserManager();
            $photoManager = new PhotoManager();

            if(isset($_SESSION['user'])){

                return [
                    "view" => VIEW_DIR."user/detailUser.php",
                    "data" => [
                        "user" => $userManager->findOneById($id),
                        "photos" => $photoManager->findPhotosByUser($id),
                        "followedUser" => $userManager->seeFollowedUsers($id),
                        "followedUs" => $userManager->confirmFollowUnfollow($_SESSION['user']->getId())
                    ]
                ];

            } else {

                return [
                    "view" => VIEW_DIR."user/detailUser.php",
                    "data" => [
                        "user" => $userManager->findOneById($id),
                        "photos" => $photoManager->findPhotosByUser($id),
                        "followedUser" => $userManager->seeFollowedUsers($id)
                    ]
                ];

            }

        }


        public function registerForm(){

            return [
                "view" => VIEW_DIR."user/login.php",
                "data" => null
            ];
        }


        public function register(){

            
            
            // if(Session::checkTokenDebug($_POST['g-recaptcha-response'], SECRET_KEY, true)){
            //         echo "oui";
            //         var_dump($_POST['g-recaptcha-response']);
            //         die;
            //     } else {
            //         echo "non";
            //         var_dump($_POST['g-recaptcha-response']);
            //         die;
            //     }
                    
            if(Session::checkToken($_POST['g-recaptcha-response'], SECRET_KEY)){
                        
                if(isset($_SESSION["user"])) {
                    Session::addFlash("error", "Vous êtes déjà inscrit");
                    $this->redirectTo("security", "seeUserById", $_SESSION["user"]->getId());
                }

                if(!empty($_POST)){

                    // $pseudo = htmlspecialchars($_POST["pseudo"]);
                    $pseudo = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    // $email = strtolower(filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL));
                    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);

                    $passwordSanitize = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    
                    $password = filter_var($passwordSanitize, FILTER_VALIDATE_REGEXP,
                        array(
                            "options" => array("regexp" => '/^\S*(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=\S*[\W])[a-zA-Z\d]{9,}\S*$/')
                        )    
                    );


                    //? Full Strong Password Validation With PHP

                    //     Min 8 chars long
                    //     Min One Digit
                    //     Min One Uppercase
                    //     Min One Lower Case
                    //     Min One Special Chars

                    // /^\S*(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=\S*[\W])[a-zA-Z\d]{8,}\S*$/

                
                    $confirmPassword = filter_input(INPUT_POST, "confirmPassword", FILTER_SANITIZE_FULL_SPECIAL_CHARS);


                    // var_dump($pseudo);
                    // var_dump($email);
                    // var_dump($password);
                    // var_dump($confirmPassword);
                    // die;

                    if(!empty($email) && !empty($pseudo)){

                        if ($email && (filter_var($email, FILTER_VALIDATE_EMAIL))){

                            if($pseudo && (preg_match('`^([a-zA-Z0-9-_]{3,36})$`', $pseudo))) {

                                if ($password && (strlen($password) >= 8) && (strlen($password) <= 64)) {

                                    if($password == $confirmPassword) {

                                        $userManager = new UserManager();

                                        $userPseudo = $userManager->findIfPseudoExist($pseudo);
                                        // var_dump($userPseudo);
                                        // die;
                                        $userEmail = $userManager->findIfMailExist($email);
                                        // var_dump($userEmail);
                                        // die;
                                        if ($userPseudo == false) {

                                            if ($userEmail == false) {

                                                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                                                $user = $userManager->add([
                                                    "pseudonym" => $pseudo,
                                                    "email" => $email,
                                                    "password" => $passwordHash,
                                                    "roles" => json_encode(['ROLE_USER'])
                                                ]);

                                                // var_dump($user);
                                
                                                Session::addFlash("success", "Votre compte a bien été crée");
                                                $this->redirectTo("security", "registerForm");

                                            } else {
                                                Session::addFlash("error", "Cet e-mail est déjà utilisé");
                                                $this->redirectTo("security", "registerForm");
                                            }

                                        } else {
                                            Session::addFlash("error", "Ce pseudonyme est déjà utilisé");
                                            $this->redirectTo("security", "registerForm");
                                        }

                                    } else {
                                        Session::addFlash("error", "Les deux mots de passe doivent être identiques");
                                        $this->redirectTo("security", "registerForm");
                                    }

                                } else {
                                    Session::addFlash("error", "Votre mot de passe doit contenir au moins 8 caractères dont 1 chiffre, 1 majuscule, 1 minuscule ainsi que 1 caractère spécial. Il ne doit pas dépasser 64 caractères.");
                                    $this->redirectTo("security", "registerForm");
                                }
                    
                            } else {
                                Session::addFlash("error", "Votre pseudonyme doit contenir entre 3 et 36 caractères. Seules les lettres, les majuscules, les chiffres, le tiret du milieu et le tiret du bas sont autorisés");
                                $this->redirectTo("security", "registerForm");
                            }
                    
                        } else {
                            Session::addFlash("error", "Le format de votre adresse e-mail est invalide");
                            $this->redirectTo("security", "registerForm");
                        } 

                    } else {
                        Session::addFlash("error", "Veuillez remplir les champs");
                        $this->redirectTo("security", "registerForm");
                    }

                } else {
                    Session::addFlash("error", "Veuillez remplir les champs");
                    $this->redirectTo("security", "registerForm");
                }

            } else {
                Session::addFlash("error", "Erreur");
                $this->redirectTo("security", "registerForm");
            }

        }



        public function login(){

            
            // if(Session::checkTokenDebug($_POST['g-recaptcha-response'], SECRET_KEY, true)){
                //     echo "oui";
                //     var_dump($_POST['g-recaptcha-response']);
                //     die;
                // } else {
                    //     echo "non";
                    //     die;
                    // }
                    
            if(Session::checkToken($_POST['g-recaptcha-response'], SECRET_KEY)){
                        
                if(isset($_SESSION["user"])) {
                    Session::addFlash("error", "Vous êtes déjà connecté");
                    $this->redirectTo("security", "seeUserById", $_SESSION["user"]->getId());
                }

                if(!empty($_POST)){

                    // $email = filter_input(INPUT_POST, "emailConnect", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
                    $email = filter_input(INPUT_POST, "emailConnect", FILTER_SANITIZE_EMAIL);
                    // $password = filter_input(INPUT_POST, "passwordConnect", FILTER_VALIDATE_REGEXP,
                    //     array(
                    //         "options" => array("regexp" => '/[A-Za-z0-9]{8,64}/')
                    //     )    
                    // );
                    $password = filter_input(INPUT_POST, "passwordConnect", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $memorize = filter_input(INPUT_POST, 'memorize', FILTER_SANITIZE_NUMBER_INT);



                    if($email && $password) {

                        $userManager = new UserManager();

                        $userOne = $userManager->findOneByEmail($email);

                        // var_dump($userEmail->current()->getPassword());
                        // die;

                        if (isset($userOne)) {
                    
                            if(password_verify($password, $userOne->current()->getPassword())){

                                // var_dump($userEmail->current());
                                // die;
                                $user = $userManager->findUserInformations($email);
                                SESSION::setUser($user->current());
                                // var_dump($_SESSION['user']);


                                // $_SESSION["connect"] = 1;
                                // $_SESSION["user"] = $user->current();
            
                                if($memorize == 1){
                                    setcookie("Id", $user->current()->getId(), time()+365*24*3600, null, null, false, true);
                                    setcookie("Email", $user->current()->getEmail(), time()+365*24*3600, null, null, false, true);
                                }

                                Session::addFlash("success", "Vous êtes connecté");
                                $this->redirectTo("security", "seeUserById", $user->current()->getId());


                            } else {
                                Session::addFlash("error", "Identifiant incorrect");
                                $this->redirectTo("security", "registerForm");
                            }

                        } else {
                            Session::addFlash("error", "Identifiant incorrect");
                            $this->redirectTo("security", "registerForm");
                        }

                    } else {
                        Session::addFlash("error", "Veuillez remplir les champs");
                        $this->redirectTo("security", "registerForm");
                    }

                } else {
                    Session::addFlash("error", "Veuillez remplir les champs");
                    $this->redirectTo("security", "registerForm");
                }

            } else {
                Session::addFlash("error", "Erreur");
                $this->redirectTo("security", "registerForm");
            }

        }



        // ? Suppression :


        public function remoteDeleteUser($id){
            
            if(isset($_SESSION["user"])) {
                
                $userManager = new UserManager();
                $user = $userManager->findOneById($id)->getId();

                if($user == $_SESSION['user']->getId()){

                    return [
                        "view" => VIEW_DIR."user/deleteUser.php",
                        "data" => [
                            "user" => $userManager->findOneById($id)
                        ]
                    ];

                } else {
                    header("Location:index.php");
                }
                
            } else {
                // $this->redirectTo("homee");
                header("Location:index.php");
            }

        }
    

        public function deleteUser($id){

            if(isset($_SESSION['user'])) {

                $userManager = new UserManager();
                $user = $userManager->findOneById($id)->getId();

                if($user == $_SESSION['user']->getId()){


                    $followManager = new FollowManager();
        
        
                    $imageProfile = $userManager->findOneById($id)->getImage();
        
        
                    if( ($imageProfile != "") && ($imageProfile != null) ){
                                            
                        $cheminFichier = 'C:/laragon/www/projet-photo-network/public/image/profiles/'.$imageProfile;
                        
                        if( file_exists ($cheminFichier)){
                            unlink($cheminFichier);
                        };
                    }
        
                    $followManager->deletePeopleFollowedUs($id);
                    $followManager->deleteAllFollow($id);
        
                    // Si un système de messagerie se met en place, 
                    // il faudra "ici" prévenir les utilisateurs qui suivent la personne qui vient de supprimer son compte
        
                    $userManager->delete($id);
                    session_unset();
        
                    setcookie("Id", "", time()-1);
                    setcookie("Email", "", time()-1);
        
                    Session::addFlash("success", "Votre profil a été supprimé avec succès");
                    $this->redirectTo("security", "registerForm");


                } else {
                    header("Location:index.php");
                }

            } else {
                header("Location:index.php");
            }

        }


        public function logout(){

            session_unset();
            // session_destroy(); // normalement on ne fait pas ça --> session_destroy(). c'est uniquement pour être 100% sûr que ça fonctionne. Unset est la manière classique
            // setcookie("Id", "", time()-1);
            // setcookie("Email", "", time()-1);
            Session::addFlash("success", "Vous êtes deconnecté");
            $this->redirectTo("security", "registerForm");
        }

        public function deleteCookies($id){

            setcookie("Id", "", time()-1);
            setcookie("Email", "", time()-1);

            Session::addFlash("success", "Vos cookies ont bien été effacés");
            $this->redirectTo("security", "seeUserById", $id);
        }



        // ? Modifications :


        public function remoteModifyPassword($id){
            
            if(isset($_SESSION["user"])) {
                
                $userManager = new UserManager();
                $user = $userManager->findOneById($id)->getId();

                if($user == $_SESSION['user']->getId()){

                    return [
                        "view" => VIEW_DIR."user/detailUserPassword.php",
                        "data" => [
                            "user" => $userManager->findOneById($id)
                        ]
                    ];

                } else {
                    header("Location:index.php");
                }
                
            } else {
                // $this->redirectTo("homee");
                header("Location:index.php");
            }

        
        }


        public function modifyPassword($id){


            // if(Session::checkTokenDebug($_POST['g-recaptcha-response'], SECRET_KEY, true)){
            //     echo "oui";
            //     var_dump($_POST['g-recaptcha-response']);
            //     die;
            // } else {
            //     echo "non";
            //     die;
            // }

            if(Session::checkToken($_POST['g-recaptcha-response'], SECRET_KEY)){

                if(!empty($_POST)){


                    $passwordOld = filter_input(INPUT_POST, "passwordOld", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $passwordNew = filter_input(INPUT_POST, "passwordNew", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $passwordNewConfirm = filter_input(INPUT_POST, "passwordNewConfirm", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                    if($passwordOld && $passwordNew && $passwordNewConfirm){

                        $userManager = new UserManager();

                        $userPasswordCurrent = $userManager->findOneById($id);
                     
                        if(password_verify($passwordOld, $userPasswordCurrent->getPassword())){
                            
                            if(preg_match('/^\S*(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=\S*[\W])[a-zA-Z\d]{9,}\S*$/', $passwordNew)) {

                                if($passwordNew == $passwordNewConfirm){

                                    $passwordHash = password_hash($passwordNew, PASSWORD_DEFAULT);

                                    $userManager->update([
                                        "password" => $passwordHash
                                    ], 
                                    $id);
        
                                    // $email = $userPasswordCurrent->getEmail();
                                    // $user = $userManager->findUserInformations($email);
                                    // SESSION::setUser($user->current());

                                    Session::addFlash("success", "Votre mot de passe a été modifié avec succès");
                                    $this->redirectTo("security", "seeUserById", $id);


                                } else {
                                    Session::addFlash("error", "Les deux mots de passe doivent être identiques");
                                    $this->redirectTo("security", "remoteModifyPassword", $id);
                                } 

                            } else {
                                Session::addFlash("error", "Votre mot de passe doit contenir au moins 8 caractères dont 1 chiffre, 1 majuscule, 1 minuscule ainsi que 1 caractère spécial. Il ne doit pas dépasser 64 caractères.");
                                $this->redirectTo("security", "remoteModifyPassword", $id);
                            }

                        } else {
                            Session::addFlash("error", "Mot de passe erroné");
                            $this->redirectTo("security", "remoteModifyPassword", $id);
                        }
                       
                    } else {
                        Session::addFlash("error", "Veuillez remplir les champs");
                        $this->redirectTo("security", "remoteModifyPassword", $id);
                    }

                } else {
                    Session::addFlash("error", "Veuillez remplir les champs");
                    $this->redirectTo("security", "remoteModifyPassword", $id);
                }

            } else {
                Session::addFlash("error", "Erreur");
                $this->redirectTo("security", "remoteModifyPassword", $id);
            }
                   
        }


        public function remoteUploadUser($id){

            if(isset($_SESSION["user"])) {

                $userManager = new UserManager();
                $user = $userManager->findOneById($id)->getId();
    
                if($user == $_SESSION['user']->getId()){

                    return [
                        "view" => VIEW_DIR."user/detailUserUpload.php",
                        "data" => [
                            "user" => $userManager->findOneById($id)
                        ]
                    ];

                } else {
                    header("Location:index.php");
                }

            } else {
                header("Location:index.php");
            }
    
        }
        
        
        public function uploadUser($id){

            // if(Session::checkTokenDebug($_POST['g-recaptcha-response'], SECRET_KEY, true)){
            //     echo "oui";
            //     var_dump($_POST['g-recaptcha-response']);
            //     die;
            // } else {
            //     echo "non";
            //     die;
            // }
        
            if(Session::checkToken($_POST['g-recaptcha-response'], SECRET_KEY)){
              
                
                if(!empty($_POST)){
                
                    // $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
                    $pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $imageProfile = filter_input(INPUT_POST, 'userOldImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
                    
                    $userManager = new UserManager();
    
    
                    // $checkImageUser = $userManager->findIfImageExist($id);
                    // var_dump($checkImageUser->current());
                    // die;
    
    
                    // var_dump($imageProfile);
                    // die;
    
                    // var_dump($_FILES['image']);
                    // die;
    
    
                    if(!empty($_FILES['image']['type'])){
    
                        $tmpName = $_FILES['image']['tmp_name'];
                        $name = $_FILES['image']['name'];
                        $size = $_FILES['image']['size'];
                        $error = $_FILES['image']['error'];
    
    
                        // explode() —> Scinde une chaîne de caractères en segments
                        // Retourne un tableau de chaînes de caractères créées en scindant la chaîne du paramètre string en plusieurs morceaux suivant le paramètre separator.
                        $tabExtension = explode('.', $name);
                        $extension = strtolower(end($tabExtension));
                        
    
                        $extensions = ['jpg', 'png', 'jpeg', 'gif'];
                
                        // 1 000 000 octet Soit 1 000 Ko Soit 1 Mo 
                        $maxSize = 1000000; 
    
                        if($size <= $maxSize){
    
                            // Si l'extension du fichier de l'utilisateur est compris dans notre tableau $extensions :
                            if(in_array($extension, $extensions) && $error == 0){
        
                                // uniqid() : Génère un identifiant unique, préfixé, basé sur la date et heure courante en microsecondes.
                                // uniqid() produira une valeur comme : 4b340550242239.64159797.
                                $uniqueName = uniqid('', true);
        
                                // $file = 4b340550242239.64159797.jpg
                                $file = $uniqueName.".".$extension;
        
                                move_uploaded_file($tmpName, './public/image/profiles/'.$file);
        
                                
                                
                                /* Fichier à supprimer du dossier */
                                
                                if($imageProfile != ""){
                                    
                                    $cheminFichier = 'C:/laragon/www/projet-photo-network/public/image/profiles/'.$imageProfile;
                                    
                                    if( file_exists ($cheminFichier)){
                                        unlink($cheminFichier);
                                    };
                                }
                                
                                $imageProfile = $file;
        
        
                            } else {
        
                                Session::addFlash("error", "Une erreur est survenue lors du téléchargement de l'image <br> Veuillez réessayer");
                                $this->redirectTo("security", "remoteUploadUser", $id);
                            }
    
                        } else {
                            Session::addFlash("error", "La taille de votre image de profil ne doit pas dépasser 1 Mo");
                            $this->redirectTo("security", "remoteUploadUser", $id);
                        }
    
                    }

                    if ($email && $pseudo){

                        if (filter_var($email, FILTER_VALIDATE_EMAIL)){

                            if(preg_match('`^([a-zA-Z0-9-_]{3,36})$`', $pseudo)) {

                                // ($imageProfile == "") ? null : $imageProfile

                                // Renvoie des valeurs non réinitialisées si la valeur existe, sinon retourne false :
                                $userPseudo = $userManager->findIfPseudoExist($pseudo);
                                $userEmail = $userManager->findIfMailExist($email);

                                // Si le pseudo n'existe pas en BDD ou si le pseudo est celui de l'utilisateur en cours :
                                if ($userPseudo == false || $pseudo == $_SESSION["user"]->getPseudonym()) {

                                    // Si l'email n'existe pas en BDD ou si l'email est celui de l'utilisateur en cours :
                                    if ($userEmail == false || $email == $_SESSION["user"]->getEmail()) {

                                        // Si l'utilisateur n'a pas soumis d'image dans le formulaire :
                                        if ($imageProfile == "") {

                                            $userManager->update([
                                                "email" => $email,
                                                "pseudonym" => $pseudo,
                                            ], 
                                            $id);
        
                                        } else {
        
                                            $userManager->update([
                                                "email" => $email,
                                                "pseudonym" => $pseudo,
                                                "image" => $imageProfile,
                                            ], 
                                            $id);
        
                                        }

                                        // On met l'utilisateur avec ses modifications en session :

                                        $user = $userManager->findUserInformations($email);
                                        SESSION::setUser($user->current());

                                        // Redirection :

                                        Session::addFlash("success", "Votre profil a été modifié avec succès");
                                        $this->redirectTo("security", "seeUserById", $id);

                                    } else {
                                        Session::addFlash("error", "Cet e-mail est déjà utilisé");
                                        $this->redirectTo("security", "remoteUploadUser", $id);
                                    }

                                } else {
                                    Session::addFlash("error", "Ce pseudonyme est déjà utilisé");
                                    $this->redirectTo("security", "remoteUploadUser", $id);
                                }

                            } else {
                                Session::addFlash("error", "Votre pseudonyme doit contenir entre 3 et 36 caractères. Seules les lettres, les majuscules, les chiffres, le tiret du milieu et le tiret du bas sont autorisés");
                                $this->redirectTo("security", "remoteUploadUser", $id);
                            }

                        } else {
                            Session::addFlash("error", "Le format de votre adresse e-mail est invalide");
                            $this->redirectTo("security", "remoteUploadUser", $id);
                        }

                    } else {
                        Session::addFlash("error", "Veuillez remplir les champs");
                        $this->redirectTo("security", "remoteUploadUser", $id);
                    }

                } else {
                    Session::addFlash("error", "Veuillez remplir les champs");
                    $this->redirectTo("security", "remoteUploadUser", $id);
                }
        
            } else {
                Session::addFlash("error", "Erreur");
                $this->redirectTo("security", "remoteUploadUser", $id);
            }

        }




        public function banUser($id){

            if(isset($_SESSION['user'])) {

                if($_SESSION['user']->hasRole('ROLE_ADMIN')) {

                    $userManager = new UserManager();
        
                    $userManager->update([
                        "status" => 0
                    ], 
                    $id);
                    
        
                    Session::addFlash("success", "l'utilisateur ".$userManager->findOneById($id)->getPseudonym()." a bien été banni");
                    $this->redirectTo("security", "index");


                } else {
                    header("Location:index.php");
                }

            } else {
                header("Location:index.php");
            }

        }


        public function unbanUser($id){


            if(isset($_SESSION['user'])) {

                if($_SESSION['user']->hasRole('ROLE_ADMIN')) {

                    $userManager = new UserManager();
        
                    $userManager->update([
                        "status" => 1
                    ], 
                    $id);
        
                    Session::addFlash("success", "l'utilisateur ".$userManager->findOneById($id)->getPseudonym()." n'est plus banni");
                    $this->redirectTo("security", "index");


                } else {
                    header("Location:index.php");
                }

            } else {
                header("Location:index.php");
            }

        }


        public function addAdminStatus($id){


            if(isset($_SESSION['user'])) {

                if($_SESSION['user']->hasRole('ROLE_ADMIN')) {

                    $userManager = new UserManager();
        
                    $userManager->update([
                        "roles" => json_encode(["ROLE_ADMIN", "ROLE_USER"])
                    ], 
                    $id);
        
                    Session::addFlash("success", "l'utilisateur ".$userManager->findOneById($id)->getPseudonym()." est à présent administrateur");
                    $this->redirectTo("security", "index");


                } else {
                    header("Location:index.php");
                }

            } else {
                header("Location:index.php");
            }

        }


        public function removeAdminStatus($id){


            if(isset($_SESSION['user'])) {

                if($_SESSION['user']->hasRole('ROLE_ADMIN')) {

                    $userManager = new UserManager();
        
                    $userManager->update([
                        "roles" => json_encode(['ROLE_USER'])
                    ], 
                    $id);
        
                    Session::addFlash("success", "l'utilisateur ".$userManager->findOneById($id)->getPseudonym()." n'est plus administrateur");
                    $this->redirectTo("security", "index");


                } else {
                    header("Location:index.php");
                }

            } else {
                header("Location:index.php");
            }

        }
        





        

    }

