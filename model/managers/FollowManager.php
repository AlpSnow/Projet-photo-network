<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;

    class FollowManager extends Manager{

        protected $className = "Model\Entities\Follow";
        protected $tableName = "follow";


        public function __construct(){
            parent::connect();
        }


        // Suppression d'un follow. Les deux clés sont nécessaires :

        public function deleteFollow($idUs, $idUser){

            $sql = "DELETE FROM ".$this->tableName."
            WHERE userSource_id = :idUs
            AND userTarget_id = :idUser
            ";

            return DAO::delete($sql, ['idUs' => $idUs, 'idUser' => $idUser]); 

        }

        // Suppression de tout nos follows : 

        public function deleteAllFollow($idUs){

            $sql = "DELETE FROM ".$this->tableName."
            WHERE userSource_id = :idUs
            ";

            return DAO::delete($sql, ['idUs' => $idUs]); 
        }

        // Suppression de notre compte chez les gens qui nous follows :

        public function deletePeopleFollowedUs($idUs){

            $sql = "DELETE FROM ".$this->tableName."
            WHERE userTarget_id = :idUs
            ";

            return DAO::delete($sql, ['idUs' => $idUs]); 
        }



    }