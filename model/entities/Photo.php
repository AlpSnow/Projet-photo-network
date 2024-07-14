<?php 

    namespace Model\Entities;
    
    use App\Entity;
    use DateTime;

    final class Photo extends Entity{

        private int $_id;
        private string $_fileName;
        private DateTime $_releaseDate;
        private $_description;
        private bool $_status;
        private Town $_town;
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

        public function getFileName()
        {
            return $this->_fileName;
        }

        public function setFileName($fileName)
        {
            $this->_fileName = $fileName;
        }

        public function getReleaseDate()
        {
            // return $this->_creationDate->format('%d/%m/%Y, %H:%M');
            return $this->_releaseDate->format("d/m/Y, H:i:s");
        }

        public function setReleaseDate($releaseDate)
        {
            $this->_releaseDate = new \DateTime($releaseDate);
        }

        public function getDescription()
        {
            return $this->_description;
        }

        public function setDescription($description)
        {
            $this->_description = $description;
        }

        public function getStatus()
        {
            return $this->_status;
        }

        public function setStatus($status)
        {
            $this->_status = $status;
        }

        public function getTown()
        {
            return $this->_town;
        }

        public function setTown($town)
        {
            $this->_town = $town;
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
            return $this->_fileName;
        }

    }


?>