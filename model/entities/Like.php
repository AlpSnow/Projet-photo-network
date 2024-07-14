<?php 

    namespace Model\Entities;
    
    use App\Entity;

    final class Like extends Entity{

        private User $_user;
        private Photo $_photo; 
       

        public function __construct($data)
        {
            $this->hydrate($data);
        }

        public function getPhoto()
        {
            return $this->_photo;
        }

        public function setPhoto($photo)
        {
            $this->_photo = $photo;
        }

        public function getUser()
        {
            return $this->_user;
        }

        public function setUser($user)
        {
            $this->_user = $user;
        }


    }


?>