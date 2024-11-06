<?php
    namespace App\Model;
    use App\Model\EntityManager;
    class Operation {

        private $id;
        private $compte_id;
        private $compte_destinataire_id;
        private $timestamp;
        private $montant;
        private $type_id;
        private $categorie_id;
        private $souscategorie_id;

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
         * Get the value of compte_id
         */ 
        public function getCompte_id()
        {
                return $this->compte_id;
        }

        /**
         * Set the value of compte_id
         *
         * @return  self
         */ 
        public function setCompte_id($compte_id)
        {
                $this->compte_id = $compte_id;

                return $this;
        }

        /**
         * Get the value of compte_destinataire_id
         */ 
        public function getCompte_destinataire_id()
        {
                return $this->compte_destinataire_id;
        }

        /**
         * Set the value of compte_destinataire_id
         *
         * @return  self
         */ 
        public function setCompte_destinataire_id($compte_destinataire_id)
        {
                $this->compte_destinataire_id = $compte_destinataire_id;

                return $this;
        }

        /**
         * Get the value of timestamp
         */ 
        public function getTimestamp()
        {
                return $this->timestamp;
        }

        /**
         * Set the value of timestamp
         *
         * @return  self
         */ 
        public function setTimestamp($timestamp)
        {
                $this->timestamp = $timestamp;

                return $this;
        }

        /**
         * Get the value of montant
         */ 
        public function getMontant()
        {
                return $this->montant;
        }

        /**
         * Set the value of montant
         *
         * @return  self
         */ 
        public function setMontant($montant)
        {
                $this->montant = $montant;

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
         * Get the value of souscategorie_id
         */ 
        public function getSouscategorie_id()
        {
                return $this->souscategorie_id;
        }

        /**
         * Set the value of souscategorie_id
         *
         * @return  self
         */ 
        public function setSouscategorie_id($souscategorie_id)
        {
                $this->souscategorie_id = $souscategorie_id;

                return $this;
        }

        
    }