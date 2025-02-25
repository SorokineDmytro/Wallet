<?php
    namespace App\Model;
    use App\Model\EntityManager;
    class Epargne {

        private $id;
        private $client_id;
        private $montant_initial;
        private $contributions;
        private $periode_contributions;
        private $taux_interet;
        private $periode_interet;
        private $nombre_annees;
        

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
         * Get the value of contributions
         */ 
        public function getContributions()
        {
                return $this->contributions;
        }

        /**
         * Set the value of contributions
         *
         * @return  self
         */ 
        public function setContributions($contributions)
        {
                $this->contributions = $contributions;

                return $this;
        }

        /**
         * Get the value of periode_contributions
         */ 
        public function getPeriode_contributions()
        {
                return $this->periode_contributions;
        }

        /**
         * Set the value of periode_contributions
         *
         * @return  self
         */ 
        public function setPeriode_contributions($periode_contributions)
        {
                $this->periode_contributions = $periode_contributions;

                return $this;
        }

        /**
         * Get the value of taux_interet
         */ 
        public function getTaux_interet()
        {
                return $this->taux_interet;
        }

        /**
         * Set the value of taux_interet
         *
         * @return  self
         */ 
        public function setTaux_interet($taux_interet)
        {
                $this->taux_interet = $taux_interet;

                return $this;
        }

        /**
         * Get the value of periode_interet
         */ 
        public function getPeriode_interet()
        {
                return $this->periode_interet;
        }

        /**
         * Set the value of periode_interet
         *
         * @return  self
         */ 
        public function setPeriode_interet($periode_interet)
        {
                $this->periode_interet = $periode_interet;

                return $this;
        }

        /**
         * Get the value of nombre_annees
         */ 
        public function getNombre_annees()
        {
                return $this->nombre_annees;
        }

        /**
         * Set the value of nombre_annees
         *
         * @return  self
         */ 
        public function setNombre_annees($nombre_annees)
        {
                $this->nombre_annees = $nombre_annees;

                return $this;
        }
    }