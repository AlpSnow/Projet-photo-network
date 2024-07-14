<?php 

    namespace Model\Entities;
    
    use App\Entity;

    final class Town extends Entity{

        private int $_id;
        private string $_name;
        private string $_postalCode;
        private string $_country;
        private string $_image;
        private $_description;
       

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

        public function getName()
        {
            return $this->_name;
        }

        public function setName($name)
        {
            $this->_name = $name;
        }

        public function getPostalCode()
        {
            return $this->_postalCode;
        }

        public function setPostalCode($postalCode)
        {
            $this->_postalCode = $postalCode;
        }

        public function getCountry()
        {
            return $this->_country;
        }

        public function setCountry($country)
        {
            $this->_country = $country;
        }

        public function getImage()
        {
            return $this->_image;
        }

        public function setImage($image)
        {
            $this->_image = $image;
        }

        public function getDescription()
        {
            return $this->_description;
        }

        public function setDescription($description)
        {
            $this->_description = $description;
        }


        public function __toString()
        {
            return $this->_name;
        }

    }


?>