<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;

    class PhotoManager extends Manager{

        protected $className = "Model\Entities\Photo";
        protected $tableName = "photo";


        public function __construct(){
            parent::connect();
        }

        // trouve les 50 dernières photos : 

        public function findLastPhotos(){

            $sql = "SELECT *
            FROM ".$this->tableName."
            ORDER BY releaseDate DESC
            LIMIT 50
            ";

            return $this->getMultipleResults(
                DAO::select($sql), 
                $this->className
            );

        }


        // trouver les photos pour une ville avec pour argument l'id de la ville :

        public function findPhotosByTown($id){

            $sql = "SELECT *
            FROM ".$this->tableName."
            WHERE town_id = :id
            ORDER BY releaseDate DESC
            ";

            return $this->getMultipleResults(
                DAO::select($sql, ['id' => $id], true), 
                $this->className
            );

        }



        // trouver les photos posté par un utilisateur avec pour argument l'id de l'utilisateur :

        public function findPhotosByUser($id){

            $sql = "SELECT *
            FROM ".$this->tableName."
            WHERE user_id = :id
            ORDER BY releaseDate DESC
            ";

            return $this->getMultipleResults(
                DAO::select($sql, ['id' => $id], true), 
                $this->className
            );

        }


    }