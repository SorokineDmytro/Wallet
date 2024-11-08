<?php
    namespace App\Model;
    use App\Model\EntityManager;
    class SousCategorie {

        private $id;
        private $categorie_id;
        private $description;
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
         * Get the value of categorie_id
         */ 
        public function getCategorie_id()
        {
                return $this->categorie_id;
        }

        /**
         * Set the value of categorie_id
         *
         * @return  self
         */ 
        public function setCategorie_id($categorie_id)
        {
                $this->categorie_id = $categorie_id;

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