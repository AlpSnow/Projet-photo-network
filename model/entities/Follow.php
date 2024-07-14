<?php 

    namespace Model\Entities;
    
    use App\Entity;

    final class Follow extends Entity{

        private User $_userSource;
        private User $_userTarget; 
       

        public function __construct($data)
        {
            $this->hydrate($data);
        }

        public function getUserSource()
        {
            return $this->_userSource;
        }

        public function setUserSource($userSource)
        {
            $this->_userSource = $userSource;
        }

        public function getUserTarget()
        {
            return $this->_userTarget;
        }

        public function setUserTarget($userTarget)
        {
            $this->_userTarget = $userTarget;
        }


    }


?>