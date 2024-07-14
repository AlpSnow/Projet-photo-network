<?php 

    namespace Model\Entities;
    
    use App\Entity;
    use DateTime;

    final class Comment extends Entity{

        private int $_id;
        private string $_content;
        private DateTime $_creationDate;
        private $_modifiedDate;
        private Photo $_photo;
        private $_user; 
       

        public function __construct($data)
        {
            $this->hydrate($data);
        }

        public function getId()
        {
            return $this->_id;
        }

        public function setId($id)
        {
            $this->_id = $id;
        }

        public function getContent()
        {
            return $this->_content;
        }

        public function setContent($content)
        {
            $this->_content = $content;
        }

        public function getCreationDate()
        {
            // return $this->_creationDate->format('%d/%m/%Y, %H:%M');
            return $this->_creationDate->format("d/m/Y à H:i:s");
        }

        public function setCreationDate($creationDate)
        {
            $this->_creationDate = new \DateTime($creationDate);
        }

        public function getModifiedDate()
        {
            return $this->_modifiedDate;
        }

        public function setModifiedDate($modifiedDate)
        {
            $this->_modifiedDate = $modifiedDate;
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


        public function __toString()
        {
            return $this->_content;
        }

    }


?>