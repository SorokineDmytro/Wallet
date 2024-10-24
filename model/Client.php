<?php
    class Client extends ClientManager {

        private $id;
        private $nomclient;
        private $prenomclient;
        private $email;
        private $mot_de_passe;
        private $date_creation;


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
         * Get the value of nomclient
         */ 
        public function getNomclient()
        {
                return $this->nomclient;
        }

        /**
         * Set the value of nomclient
         *
         * @return  self
         */ 
        public function setNomclient($nomclient)
        {
                $this->nomclient = $nomclient;

                return $this;
        }

        /**
         * Get the value of prenomclient
         */ 
        public function getPrenomclient()
        {
                return $this->prenomclient;
        }

        /**
         * Set the value of prenomclient
         *
         * @return  self
         */ 
        public function setPrenomclient($prenomclient)
        {
                $this->prenomclient = $prenomclient;

                return $this;
        }

        /**
         * Get the value of email
         */ 
        public function getEmail()
        {
                return $this->email;
        }

        /**
         * Set the value of email
         *
         * @return  self
         */ 
        public function setEmail($email)
        {
                $this->email = $email;

                return $this;
        }

        /**
         * Get the value of mot_de_passe
         */ 
        public function getMot_de_passe()
        {
                return $this->mot_de_passe;
        }

        /**
         * Set the value of mot_de_passe
         *
         * @return  self
         */ 
        public function setMot_de_passe($mot_de_passe)
        {
                $this->mot_de_passe = $mot_de_passe;

                return $this;
        }

        /**
         * Get the value of date_creation
         */ 
        public function getDate_creation()
        {
                return $this->date_creation;
        }

        /**
         * Set the value of date_creation
         *
         * @return  self
         */ 
        public function setDate_creation($date_creation)
        {
                $this->date_creation = $date_creation;

                return $this;
        }
    }