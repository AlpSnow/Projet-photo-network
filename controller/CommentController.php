<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\CommentManager;
    use Model\Managers\UserManager;
    use DateTime;


    class CommentController extends AbstractController implements ControllerInterface{

        public function index(){
          
           $commentManager = new CommentManager();

            return [
                "view" => VIEW_DIR."",
                "data" => [
                    "comments" => $commentManager->findAll(["creationDate", "DESC"])
                ]
            ];
        
        }




        // ? Ajouts :

        public function addCommentByPhoto($id){


            if(isset($_SESSION["user"])) {

                $userManager = new UserManager;
                $user = $userManager->findOneById($_SESSION['user']->getId());
    
                if($user->getStatus() == "actif") {
    
                    if(!empty($_POST)){
        
                        $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           
                        $commentManager = new commentManager();
        
                        if($comment){
        
                            $commentManager->add([
                                "content" => $comment,
                                "user_id" => $_SESSION['user']->getId(),
                                "photo_id" => $id
                            ]);
        
                        }
        
                        Session::addFlash("success", "Votre commentaire a été ajouté avec succès");
                        $this->redirectTo("photo", "seePhotoById", $id, 1);
        
                    } else {
                        Session::addFlash("error", "Veuillez remplir les champs");
                        $this->redirectTo("photo", "seePhotoById", $id, 1);
                    }
    
                } else {
                    Session::addFlash("error", "Vous ne pouvez pas ajouter de commentaires, votre compte est banni");
                    $this->redirectTo("photo", "seePhotoById", $id, 1);
                }

            } else {
                header("Location:index.php");
            }

        }


        // ? Suppression :
    

        public function deleteComment($idComplet){

            if(isset($_SESSION["user"])) {

                $findId = explode(".", $idComplet);
                $idComment = $findId[0];
                $idPhoto = $findId[1];


                $commentManager = new CommentManager();
    
                $user = $commentManager->findOneById($idComment)->getUser()->getId();

                if(($user == $_SESSION['user']->getId()) || ($_SESSION['user']->hasRole('ROLE_ADMIN'))){

                    $commentManager->delete($idComment);
        
        
                    Session::addFlash("success", "Votre commentaire a été supprimé avec succès");
                    $this->redirectTo("photo", "seePhotoById", $idPhoto, 1);


                } else {
                    header("Location:index.php");
                }


            } else {
                header("Location:index.php");
            }

        }



        // ? Modifications :


        public function remoteUploadComment($id){

            if(isset($_SESSION["user"])) {

                $commentManager = new CommentManager();

                $user = $commentManager->findOneById($id)->getUser()->getId();

                if(($user == $_SESSION['user']->getId()) || ($_SESSION['user']->hasRole('ROLE_ADMIN'))){

                    return [
                        "view" => VIEW_DIR."photo/detailCommentUpload.php",
                        "data" => [
                            "comment" => $commentManager->findOneById($id)
                        ]
                    ];


                } else {
                    header("Location:index.php");
                }

            } else {
                header("Location:index.php");
            }

        }


        public function uploadComment($idComplet){


            if(isset($_SESSION['user'])) {

                $findId = explode(".", $idComplet);
                $idComment = $findId[0];
                $idPhoto = $findId[1];
    
    
                $userManager = new UserManager;
                $user = $userManager->findOneById($_SESSION['user']->getId());
    
                if($user->getStatus() == "actif") {
    
                    if(!empty($_POST)){
        
                        $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
                        $commentManager = new CommentManager();
        
                        if($comment){
        
                            $dateModification = new DateTime("now", new \DateTimeZone('Europe/Paris'));
        
                            $commentManager->update([
                                "content" => $comment,
                                "modifiedDate" => $dateModification->format("Y-m-d H:i:s")
                            ], 
                            $idComment);
        
                            
                            Session::addFlash("success", "Votre commentaire a été modifié avec succès");
                            $this->redirectTo("photo", "seePhotoById", $idPhoto, 1);
        
        
                        } else {
                            Session::addFlash("error", "Votre commentaire ne doit pas être vide");
                            $this->redirectTo("comment", "remoteUploadComment", $idComment);
                        }
        
                    } else {
                        Session::addFlash("error", "Veuillez remplir les champs");
                        $this->redirectTo("comment", "remoteUploadComment", $idComment);
                    }
    
                } else {
                    Session::addFlash("error", "Vous ne pouvez pas modifier de commentaires, votre compte est banni");
                    $this->redirectTo("comment", "remoteUploadComment", $idComment);
                }

            } else {
                header("Location:index.php");
            }

        }

        


    }
