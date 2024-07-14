<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;

    class LikeManager extends Manager{

        protected $className = "Model\Entities\Like";
        protected $tableName = "like";


        public function __construct(){
            parent::connect();
        }


    }