<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;

    class UserManager extends Manager{

        protected $className = "Model\Entities\User";
        protected $tableName = "user";


        public function __construct(){
            parent::connect();
        }


        // trouver si un pseudonyme existe avec pour argument un pseudonyme :

        public function findIfPseudoExist($pseudo){

            $sql = "SELECT pseudonym
            FROM ".$this->tableName."
            WHERE pseudonym = :pseudo
            ";

            return $this->getOneOrNullResult(
                DAO::select($sql, ['pseudo' => $pseudo]), 
                $this->className
            );

        }

        // trouver si un e-mail existe avec pour argument un email :

        public function findIfMailExist($email){

            $sql = "SELECT email
            FROM ".$this->tableName."
            WHERE email = :email
            ";

            return $this->getOneOrNullResult(
                DAO::select($sql, ['email' => $email]), 
                $this->className
            );

        }

        // cherche si l'utilisateur possède déjà une image avec pour argument un id :

        // public function findIfImageExist($id){

        //     $sql = "SELECT *
        //     FROM ".$this->tableName."
        //     WHERE id_".$this->tableName." = :id
        //     ";

        //     return $this->getMultipleResults(
        //         DAO::select($sql, ['id' => $id], true), 
        //         $this->className
        //     );

        // }


        // Obtenir mot de passe via l'email :

        public function findOneByEmail($email){

            $sql = "SELECT email, password
            FROM ".$this->tableName."
            WHERE email = :email
            ";

            return $this->getMultipleResults(
                DAO::select($sql, ['email' => $email], true), 
                $this->className
            );

        }

        // Fonction que l'on met en session avec les informations de l'utilisateur :

        public function findUserInformations($email){

            $sql = "SELECT id_user, email, pseudonym, signupDate, status, roles 
            FROM ".$this->tableName."
            WHERE email = :email
            ";

            return $this->getMultipleResults(
                DAO::select($sql, ['email' => $email], true), 
                $this->className
            );

        }


        // Fonction pour le systeme de suivie (follow) :

        public function confirmFollowUnfollow($id){

            // $sql = "SELECT z.pseudonym, z.id_user, f.userSource_id, f.userTarget_id, u.pseudonym, u.id_user
            $sql = "SELECT u.id_user
            FROM ".$this->tableName." u
            INNER JOIN follow f ON f.userTarget_id = u.id_user
            INNER JOIN user z ON f.userSource_id = z.id_user
            WHERE z.id_user = :id
            ";

            return $this->getMultipleResults(
                DAO::select($sql, ['id' => $id], true), 
                $this->className
            );

        }

        public function seeFollowedUsers($id){

            $sql = "SELECT u.id_user, u.image, u.pseudonym
            FROM ".$this->tableName." u
            INNER JOIN follow f ON f.userTarget_id = u.id_user
            INNER JOIN user z ON f.userSource_id = z.id_user
            WHERE z.id_user = :id
            ";

            return $this->getMultipleResults(
                DAO::select($sql, ['id' => $id], true), 
                $this->className
            );

        }


        // Fonction pour les administrateurs :


        public function findListAdmins(){

            $sql = "SELECT id_user, email, pseudonym, signupDate, status, roles
            FROM ".$this->tableName."
            ORDER BY pseudonym ASC
            ";

            return $this->getMultipleResults(
                DAO::select($sql), 
                $this->className
            );

        }



    }

