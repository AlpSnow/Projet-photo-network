<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\TownManager;

    class TownController extends AbstractController implements ControllerInterface{

        public function index(){
          
           $townManager = new TownManager();


            return [
                "view" => VIEW_DIR."town/listTowns.php",
                "data" => [
                    "towns" => $townManager->findAll(["name", "ASC"])
                ]
            ];
        
        }





    
        

    }
