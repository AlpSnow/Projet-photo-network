<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;

    class TownManager extends Manager{

        protected $className = "Model\Entities\Town";
        protected $tableName = "town";


        public function __construct(){
            parent::connect();
        }

        // Trouver la ville la plus populaire, affiche les 5 villes ayant le plus de photos :

        public function findMostPopularTown(){

            $sql = "SELECT t.name, t.id_town, t.postalCode, t.country, t.image, t.description, COUNT(p.id_photo) AS nb_photo
            FROM ".$this->tableName." t
            INNER JOIN photo p ON p.town_id = t.id_town
            GROUP BY t.name, t.id_town, t.postalCode, t.country, t.image, t.description
            ORDER BY nb_photo DESC
            LIMIT 5
            ";

            return $this->getMultipleResults(
                DAO::select($sql), 
                $this->className
            );

        }



        // SELECT t.name, COUNT(p.id_photo) AS nb_photo
        // FROM town t
        // INNER JOIN photo p ON p.town_id = t.id_town
        // GROUP BY t.name
        // ORDER BY nb_photo DESC


    }