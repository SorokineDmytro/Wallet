<?php
    namespace App\Model;
    use App\Model\EntityManager;
    class Client {

        private $id;
        private $nomclient;
        private $prenomclient;
        private $email;
        private $mot_de_passe;
        private $date_creation;
        private $password_reset_token;
        private $token_expiration;
        private $photo;


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

        /**
         * Get the value of password_reset_token
         */ 
        public function getPassword_reset_token()
        {
                return $this->password_reset_token;
        }

        /**
         * Set the value of password_reset_token
         *
         * @return  self
         */ 
        public function setPassword_reset_token($password_reset_token)
        {
                $this->password_reset_token = $password_reset_token;

                return $this;
        }

        /**
         * Get the value of token_expiration
         */ 
        public function getToken_expiration()
        {
                return $this->token_expiration;
        }

        /**
         * Set the value of token_expiration
         *
         * @return  self
         */ 
        public function setToken_expiration($token_expiration)
        {
                $this->token_expiration = $token_expiration;

                return $this;
        }

        /**
         * Get the value of photo
         */ 
        public function getPhoto()
        {
                return $this->photo;
        }

        /**
         * Set the value of photo
         *
         * @return  self
         */ 
        public function setPhoto($photo)
        {
                $this->photo = $photo;

                return $this;
        }
    }