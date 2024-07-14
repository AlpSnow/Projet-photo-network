<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\PhotoManager;
    use Model\Managers\TownManager;
    use Model\Managers\CommentManager;
    use Model\Managers\UserManager;

    class PhotoController extends AbstractController implements ControllerInterface{

        public function index(){
          
            $photoManager = new PhotoManager();
            //$townManager = new TownManager();


            return [
                "view" => VIEW_DIR."photo/search.php",
                "data" => [
                    "photos" => $photoManager->findLastPhotos()
                    // "towns" => $townManager->findAll(["name", "ASC"])
                ]
            ];
        
        }


        public function remoteAddPhoto(){

            if(isset($_SESSION['user'])) {
                
                $townManager = new TownManager();
    
                return [
                    "view" => VIEW_DIR."photo/addPhoto.php",
                    "data" => [
                        "towns" => $townManager->findAll(["name", "ASC"])
                    ]
                ];

            } else {
                header("Location:index.php");
            }

        }


        public function seePhotoById($id){


            $photoManager = new PhotoManager();
            $commentManager = new CommentManager();

            // Système de pagination : 

            $numberCommentsPerPage = 5;
            // $numberCommentsTotal = iterator_count($commentManager->findNumberCommentsByPhoto($id));
            // $numberPagesTotal = ceil($numberCommentsTotal / $numberCommentsPerPage);
            
            // 1 4 22

            // foreach ($comments as $comment){
            //     $numberCommentsTotal += 1 ;
            // }
            // var_dump($numberCommentsTotal);
            // die;

            $page = htmlspecialchars($_GET['page']);

            if(isset($page) && !empty($page) && ($page > 0)){
                // intval : si la valeur n'est pas un nombre retourne zéro 
                // https://www.php.net/manual/fr/function.intval.php
                $currentPage = intval($page);
                // var_dump($currentPage);
                // die;
            } else {
                $currentPage = 1;
            }

            $start = ($currentPage -1) * $numberCommentsPerPage;



            return [
                "view" => VIEW_DIR."photo/detailPhoto.php",
                "data" => [
                    "photo" => $photoManager->findOneById($id),
                    "comments" => $commentManager->seeCommentsByPhoto($id, $start, $numberCommentsPerPage),
                    "numberComments" => $commentManager->findCommentsIdByPhoto($id),
                    "currentPage" => $currentPage
                ]
            ];
        }


        public function seePhotoByTowns($id){

            $townManager = new TownManager();
            $photoManager = new PhotoManager();

            return [
                "view" => VIEW_DIR."photo/listPhotosByTown.php",
                "data" => [
                    "town" => $townManager->findOneById($id),
                    "photos" => $photoManager->findPhotosByTown($id)
                ]
            ];
        }



        // ? Ajouts :
        // Il faudra prévenir la faille nomfichier.jpg.exe

        public function addPhoto(){

            if(isset($_SESSION['user'])) {
                
                $userManager = new UserManager;
                $user = $userManager->findOneById($_SESSION['user']->getId());
    
                if($user->getStatus() == "actif") {
    
                    if(!empty($_POST)){
        
                        if(isset($_POST['ville'])){    
        
        
                            $idTown = filter_input(INPUT_POST, 'ville', FILTER_SANITIZE_NUMBER_INT);
                            // On pourrait aussi écrire : 
                            // $idTown = htmlspecialchars("$_POST['ville']");
                            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
                            if ($idTown == ""){
                                Session::addFlash("error", "Veuillez selectionner une ville");
                                $this->redirectTo("photo", "remoteAddPhoto");
                            }
        
                            if(isset($_FILES['photo'])){
                                $tmpName = $_FILES['photo']['tmp_name'];
                                $name = $_FILES['photo']['name'];
                                $size = $_FILES['photo']['size'];
                                $error = $_FILES['photo']['error'];
        
                                // var_dump($_FILES['photo']); die ;
        
                                // echo "<br>";
                                // var_dump($tmpName);
                                // echo "<br>";
                                // var_dump($name);
                                // echo "<br>";
                                // var_dump($size);
                                // echo "<br>";
                                // var_dump($error);
                                // die;
        
                                $tabExtension = explode('.', $name);
                                // explode() —> Scinde une chaîne de caractères en segments
                                // Retourne un tableau de chaînes de caractères créées en scindant la chaîne du paramètre string en plusieurs morceaux suivant le paramètre separator.
                                $extension = strtolower(end($tabExtension));
                                
        
                                $extensions = ['jpg', 'png', 'jpeg', 'gif'];
                                // 7 000 000 octet Soit 7 000 Ko Soit 7 Mo 
                                $maxSize = 7000000; 
        
                                if($size <= $maxSize){
                                    
                                    if(in_array($extension, $extensions) && $error == 0){
                                        $uniqueName = uniqid('', true);
                                        // uniqid() : Génère un identifiant unique, préfixé, basé sur la date et heure courante en microsecondes.
                                        // uniqid() produira une valeur comme : 4b340550242239.64159797.
            
                                        $file = $uniqueName.".".$extension;
                                        // $file = 4b340550242239.64159797.jpg
            
                                        move_uploaded_file($tmpName, './public/image/photos/'.$file);
            
                                        $photo = $file;
            
                                    } else {
                                        Session::addFlash("error", "Une erreur est survenue lors du téléchargement de l'image <br> Veuillez réessayer");
                                        $this->redirectTo("photo", "remoteAddPhoto");
                                    }
        
                                } else {
                                    Session::addFlash("error", "La taille de votre photo ne doit pas dépasser 7 Mo");
                                    $this->redirectTo("photo", "remoteAddPhoto");
                                }
                            }
        
        
                            $photoManager = new PhotoManager();
              
                            if($idTown && $photo){
            
                                $id = $photoManager->add([
                                    "fileName" => $photo,
                                    "description" => $description,
                                    "town_id" => $idTown,
                                    "user_id" => $_SESSION['user']->getId()
                                ]);
            
                            }
            
                            $this->redirectTo("photo", "seePhotoById", $id, 1);
        
                        }

                    } else {
                        Session::addFlash("error", "Veuillez remplir les champs");
                        $this->redirectTo("photo", "remoteAddPhoto");
                    }
    
                } else {
                    Session::addFlash("error", "Vous ne pouvez pas ajouter de photos, votre compte est banni");
                    $this->redirectTo("photo", "remoteAddPhoto");
                }

            } else {
                header("Location:index.php");
            }

        }




        // ? Suppression :


        public function deletePhoto($id){

            if(isset($_SESSION['user'])) {

                $photoManager = new PhotoManager();
                $photo = $photoManager->findOneById($id);
                $user = $photo->getUser()->getId();

                if( ($_SESSION['user']->hasRole('ROLE_ADMIN')) || $_SESSION['user']->getId() == $user ) {

                    /* Fichier à supprimer du dossier */
                    
                    $fichier = $photo;
         
                    $cheminFichier = 'C:/laragon/www/projet-photo-network/public/image/photos/'.$fichier->getFileName();
        
        
                    if( file_exists ($cheminFichier)){
                        unlink($cheminFichier);
                    };
        
        
                    // Suppresion dans la base de données : 
                    $commentManager = new CommentManager();


                    $commentManager->deleteAllCommentsByPhotoId($id);

                    
                    $photoManager->delete($id);
                    
                    // Redirection et message de succès :
                    
                    Session::addFlash("success", "Votre photo a été supprimé avec succès");
                    $this->redirectTo("photo", "index");
 

                } else {
                    header("Location:index.php");
                }
    
            } else {
                header("Location:index.php");
            }

        }



        // ? Modifications :


        public function remoteUploadPhoto($id){

            if(isset($_SESSION['user'])) {

                $photoManager = new PhotoManager();
                $user = $photoManager->findOneById($id)->getUser()->getId();
    
                if( ($_SESSION['user']->hasRole('ROLE_ADMIN')) || $_SESSION['user']->getId() == $user ) {

                    return [
                        "view" => VIEW_DIR."photo/detailPhotoUpload.php",
                        "data" => [
                            "photo" => $photoManager->findOneById($id)
                        ]
                    ];


                } else {
                    header("Location:index.php");
                }

            } else {
                header("Location:index.php");
            }

        }
        
        
        public function uploadPhoto($id){

            if(isset($_SESSION['user'])) {

                $userManager = new UserManager;
                $user = $userManager->findOneById($_SESSION['user']->getId());
    
                if($user->getStatus() == "actif") {
    
                    if(!empty($_POST)){
                
                        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        
                        $photoManager = new PhotoManager();
                                
                
                        if($description){
                
                            $photoManager->update([
                                "description" => $description,
                            ], 
                            $id);
                
                        }
        
                        if($description == ""){
                
                            $description = null;
                    
                            $photoManager->update([
                                "description" => $description,
                            ], 
                            $id);
                        }
                
                        Session::addFlash("success", "Votre description a été modifié avec succès");
                        $this->redirectTo("photo", "seePhotoById", $id, 1);
                
                    } else {
                        Session::addFlash("error", "Veuillez remplir les champs");
                        $this->redirectTo("photo", "remoteUploadPhoto", $id);
                    }
    
                } else {
                    Session::addFlash("error", "Vous ne pouvez pas modifier de descriptions, votre compte est banni");
                    $this->redirectTo("photo", "remoteUploadPhoto", $id);
                }

            } else {
                header("Location:index.php");
            }

        }

    
        

    }
