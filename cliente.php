<?php
  class Cliente{
     
    private int $id;
    private String $nome;
    private String $email;

    public function getId(){
        return $this->modelo;
    }

    public function getNome(){
        return $this->nome;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getId($i){
         $this->id = $i;
    }

    public function getNome($n){
         $this->nome = $n;
    }

    public function getEmail($e){
         $this->email = $e;
    }
    
  }
   ?>

