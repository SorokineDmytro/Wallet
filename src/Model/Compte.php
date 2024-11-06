<?php
    namespace App\Model;
    use App\Model\EntityManager;
    class Compte {

        private $id;
        private $client_id;
        private $numcompte;
        private $typecompte_id;
        private $montant_initial;
        private $color;

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
         * Get the value of client_id
         */ 
        public function getClient_id()
        {
                return $this->client_id;
        }

        /**
         * Set the value of client_id
         *
         * @return  self
         */ 
        public function setClient_id($client_id)
        {
                $this->client_id = $client_id;

                return $this;
        }

        /**
         * Get the value of numcompte
         */ 
        public function getNumcompte()
        {
                return $this->numcompte;
        }

        /**
         * Set the value of numcompte
         *
         * @return  self
         */ 
        public function setNumcompte($numcompte)
        {
                $this->numcompte = $numcompte;

                return $this;
        }


        /**
         * Get the value of typecompte_id
         */ 
        public function getTypecompte_id()
        {
                return $this->typecompte_id;
        }

        /**
         * Set the value of typecompte_id
         *
         * @return  self
         */ 
        public function setTypecompte_id($typecompte_id)
        {
                $this->typecompte_id = $typecompte_id;

                return $this;
        }

        /**
         * Get the value of montant_initial
         */ 
        public function getMontant_initial()
        {
                return $this->montant_initial;
        }

        /**
         * Set the value of montant_initial
         *
         * @return  self
         */ 
        public function setMontant_initial($montant_initial)
        {
                $this->montant_initial = $montant_initial;

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
    }