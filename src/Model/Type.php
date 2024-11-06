<?php
    namespace App\Model;
    use App\Model\EntityManager;
    class Type {

        private $id;
        private $numtype;
        private $description;

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
         * Get the value of numtype
         */ 
        public function getNumtype()
        {
                return $this->numtype;
        }

        /**
         * Set the value of numtype
         *
         * @return  self
         */ 
        public function setNumtype($numtype)
        {
                $this->numtype = $numtype;

                return $this;
        }

        /**
         * Get the value of description
         */ 
        public function getDescription()
        {
                return $this->description;
        }

        /**
         * Set the value of description
         *
         * @return  self
         */ 
        public function setDescription($description)
        {
                $this->description = $description;

                return $this;
        }
    }