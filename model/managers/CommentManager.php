<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;

    class CommentManager extends Manager{

        protected $className = "Model\Entities\Comment";
        protected $tableName = "comment";


        public function __construct(){
            parent::connect();
        }

        // trouver les commentaires pour une photo avec pour argument l'id de la photo : 


        // public function findCommentsByPhoto($id){

        //     $sql = "SELECT c.id_comment, c.content, c.creationDate, c.modifiedDate, c.user_id
        //     FROM ".$this->tableName." c
        //     INNER JOIN photo p ON p.id_photo = c.photo_id
        //     WHERE photo_id = :id
        //     ORDER BY c.creationDate DESC
        //     ";

        //     return $this->getMultipleResults(
        //         DAO::select($sql, ['id' => $id], true), 
        //         $this->className
        //     );

        // }


        // trouver les commentaires pour une photo avec pour argument l'id de la photo : 
        // (les variables start et numberCommentsPerPage servent au système de pagination)
        
        public function seeCommentsByPhoto($id, $start, $numberCommentsPerPage){

            $sql = "SELECT c.id_comment, c.content, c.creationDate, c.modifiedDate, c.user_id
            FROM ".$this->tableName." c
            INNER JOIN photo p ON p.id_photo = c.photo_id
            WHERE photo_id = :id
            ORDER BY c.creationDate DESC
            LIMIT ".$start.",".$numberCommentsPerPage."
            ";

            return $this->getMultipleResults(
                DAO::select($sql, ['id' => $id], true), 
                $this->className
            );

        }


        public function findCommentsIdByPhoto($id){

            $sql = "SELECT c.id_comment
            FROM ".$this->tableName." c
            INNER JOIN photo p ON p.id_photo = c.photo_id
            WHERE photo_id = :id
            ORDER BY c.creationDate DESC
            ";

            return $this->getMultipleResults(
                DAO::select($sql, ['id' => $id], true), 
                $this->className
            );

        }


        public function deleteAllCommentsByPhotoId($id){
            $sql = "DELETE FROM ".$this->tableName."
                    WHERE photo_id = :id
                    ";

            return DAO::delete($sql, ['id' => $id]); 
        }


    }