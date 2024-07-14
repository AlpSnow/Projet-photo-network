<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\TownManager;
    
    class HomeController extends AbstractController implements ControllerInterface{

        public function index(){
            
            $townManager = new TownManager();

            return [
                "view" => VIEW_DIR."home.php",
                "data" => [
                    "towns" => $townManager->findMostPopularTown()
                ]
            ];
        }




    }