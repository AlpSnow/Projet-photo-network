<?php 

    namespace Model\Entities;
    
    use App\Entity;
    use DateTime;

    final class User extends Entity{

        private int $_id;
        private string $_email;
        private string $_password;
        private string $_pseudonym;
        // Sans : use DateTime  -> on met un antislash (afin que le logiciel ne confonde pas avec une class)
        // private \DateTime $_signupDate;
        private DateTime $_signupDate;
        private bool $_status;
        private $_image;
        private array $_roles;

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

        public function getEmail()
        {
            return $this->_email;
        }

        public function setEmail($email)
        {
            $this->_email = $email;
        }

        public function getPassword()
        {
            return $this->_password;
        }

        public function setPassword($password)
        {
            $this->_password = $password;
        }

        public function getPseudonym()
        {
            return $this->_pseudonym;
        }

        public function setPseudonym($pseudo)
        {
            $this->_pseudonym = $pseudo;
        }

        public function getSignupDate()
        {
            return $this->_signupDate->format("d/m/Y, H:i:s");
        }

        public function setSignupDate($date)
        {
            $this->_signupDate = new \DateTime($date);
        }

        public function getStatus()
        {
            return $this->_status ? "actif" : "banni";
        }

        public function setStatus($status)
        {
            $this->_status = $status;
        }

        public function getImage()
        {
            return $this->_image;
        }

        public function setImage($image)
        {
            $this->_image = $image;
        }

        public function getRoles()
        {
            return $this->_roles;
        }

        public function setRoles($roles)
        {
            $this->_roles = json_decode($roles);

            if (empty($this->_roles)){
                return $this->_roles[] = "ROLE_USER";
            }
        }

        public function hasRole($roles)
        {
            return in_array($roles, $this->getRoles());
        }

        public function __toString()
        {
            return $this->_pseudonym;
        }

    }


?>