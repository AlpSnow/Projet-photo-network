<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\FollowManager;
    use Model\Managers\UserManager;
    
    class FollowController extends AbstractController implements ControllerInterface{

        public function index(){
            
            $followManager = new FollowManager();

            return [
                "view" => VIEW_DIR."",
                "data" => [
                    "follows" => $followManager->findAll()
                ]
            ];
        }


        public function followUser($id){

            // Si on est connecté
            if(isset($_SESSION["user"])) {
                // Si l'utilisateur est différent de nous (on ne veut pas se suivre soit même) alors :
                if($id != $_SESSION["user"]->getId()) {
                    
                    $userManager = new UserManager();
                    $peopleFollowedUs = $userManager->confirmFollowUnfollow($_SESSION['user']->getId());
                    

                    // Si nous suivons des personnes :
                    if($peopleFollowedUs != null){

                        // Pour chaque personne que nous suivons :
                        foreach($peopleFollowedUs as $personfollowedByUs){
                                
                            // Si nous suivons déjà l'utilisateur :
                            if($personfollowedByUs->getId() == $id){

                                Session::addFlash("error", "Vous suivez déjà l'utilisateur");
                                $this->redirectTo("security", "seeUserById", $id);

                            }
                                
                        }
               
                    }

                    $followManager = new FollowManager();
        
                    $followManager->add([
                        "userSource_id" => $_SESSION['user']->getId(),
                        "userTarget_id" => $id
                    ]);
        
        
                    Session::addFlash("success", "Vous suivez cet utilisateur avec succès");
                    $this->redirectTo("security", "seeUserById", $id);

                } else {
                    Session::addFlash("error", "Vous ne pouvez pas vous suivre vous même");
                    $this->redirectTo("security", "seeUserById", $id);
                }

            } else {
                header("Location:index.php");
            }

        }
        

        public function stopFollowUser($id){


            if(isset($_SESSION["user"])) {

                $userManager = new UserManager();
                $peopleFollowedUs = $userManager->confirmFollowUnfollow($_SESSION['user']->getId());

                if($peopleFollowedUs != null){

                                
                    foreach($peopleFollowedUs as $personfollowedByUs){
                            

                        if($personfollowedByUs->getId() == $id){
                            
                            $followManager = new FollowManager();
                
                            $followManager->deleteFollow($_SESSION['user']->getId(), $id);
                
                            Session::addFlash("success", "Vous ne suivez plus cet utilisateur");
                            $this->redirectTo("security", "seeUserById", $id);


                        }
                            
                    }

                    Session::addFlash("error", "Impossible d'arrêter de suivre un utilisateur que vous ne suivez pas");
                    $this->redirectTo("security", "seeUserById", $id);


                } else {
                    Session::addFlash("error", "Impossible d'arrêter de suivre un utilisateur, vous ne suivez personne");
                    $this->redirectTo("security", "seeUserById", $id);
                }

            } else {
                header("Location:index.php");
            }


        }





    }