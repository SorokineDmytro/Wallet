<?php
    class OperationManager extends Manager {
        
        private $table = 'operation';
        private $entity = 'Operation';

        public function find($id,$type="object"){
            $table=$this->table;
            $resultat=$this->findTable($table,$id);
            if($type=="object"){
                $resultat=new $this->entity($resultat);
            }
            return $resultat;
        }

        public function findAll($conditions=[],$type="object",$order=""){
            $table=$this->table;
            $resultats=$this->findAllTable($table,$conditions,$order);
            if($type=="object"){
                $objects=[];
                foreach($resultats as $resultat){
                    $object=new $this->entity($resultat);
                    $objects[]=$object;
                }
                $resultats=$objects;
            }
            return $resultats;
        } 

        public function findOne($conditions=[],$type="object",$order=""){
            $table=$this->table;
            $resultat=$this->findOneTable($table,$conditions,$order);
            if($type=="object"){
                $object=new $this->entity($resultat);
                $resultat=$object;
            }
            return $resultat;
        }    
             
        public function searchByCondition($columns,$mot,$conditions=[],$type="object",$orderBy="",$limit=0,$offset=0){
            $table=$this->table;
            $resultats=$this->searchTableByCondition($table,$columns,$mot,$conditions,$orderBy,$limit,$offset);
            if($type=="object"){
                $objects=[];
                foreach($resultats as $resultat){
                    $object=new $this->entity($resultat);
                    $objects[]=$object;
                }
                $resultats=$objects;
            }
            return $resultats;
        }

        public function insert($data){
            $table=$this->table;
            $this->insertTable($table,$data);
        }
        
        public function update($data){
            $table=$this->table;
            $this->updateTable($table,$data);
        }

        public function save($data){
            $id=(int) $data['id'];
            if($id==0){
                $this->insert($data);
            }else{
                $this->update($data);
            }
        }

        public function delete($id){
            $table=$this->table;
            $this->deleteTable($table,$id);
        }
        
        // function to retrieve the total amount of incomes by each account 
        public function getTotalIncomeByAccount($accountId) {
            $totalIncome = 0;
            $incomes = $this->findAll(['compte_id' => $accountId, 'type_id' => 2], 'object');
            foreach ($incomes as $income) {
                $totalIncome += $income->getMontant();
            }
            return $totalIncome;
        }

        // function to retrieve the total amount of expenses by each account 
        public function getTotalExpenseByAccount($accountId) {
            $totalExpense = 0;
            $expenses = $this->findAll(['compte_id' => $accountId, 'type_id' => 1], 'object');
            foreach ($expenses as $expense) {
                $totalExpense += $expense->getMontant();
            }
            return $totalExpense;
        }

    }