<?php
    namespace App\Model;
    use App\Model\EntityManager;
    class TypeCompte {

        private $id;
        private $designation;

        public function __construct($data = []) { // for exemple $data = ['id' => 1, 'numProduit' => 'BB0001' ... ]
            if ($data) { // test if $data is different from empty '[]'
                foreach ($data as $key => $value) {
                    $setter = "set".ucfirst($key); // for exemple if $key = 'designation' then $set = 'setDesignation'
                    if (method_exists($this, $setter)) {
                        $this -> $setter($value);
                    }
                }
            }
        }

        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of designation
         */ 
        public function getDesignation()
        {
                return $this->designation;
        }

        /**
         * Set the value of designation
         *
         * @return  self
         */ 
        public function setDesignation($designation)
        {
                $this->designation = $designation;

                return $this;
        }
    }