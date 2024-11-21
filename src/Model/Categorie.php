<?php
    namespace App\Model;
    use App\Model\EntityManager;
    class Categorie {

        private $id;
        private $type_id;
        private $description;
        private $color;
        private $icone;

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
         * Get the value of type_id
         */ 
        public function getType_id()
        {
                return $this->type_id;
        }

        /**
         * Set the value of type_id
         *
         * @return  self
         */ 
        public function setType_id($type_id)
        {
                $this->type_id = $type_id;

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

        /**
         * Get the value of color
         */ 
        public function getColor()
        {
                return $this->color;
        }

        /**
         * Set the value of color
         *
         * @return  self
         */ 
        public function setColor($color)
        {
                $this->color = $color;

                return $this;
        }

        /**
         * Get the value of icone
         */ 
        public function getIcone()
        {
                return $this->icone;
        }

        /**
         * Set the value of icone
         *
         * @return  self
         */ 
        public function setIcone($icone)
        {
                $this->icone = $icone;

                return $this;
        }
    }