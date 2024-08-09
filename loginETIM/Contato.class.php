<?php

/**
 * @author Fabio Claret
 * data abril/2024
 * Classe com conexao a banco de dados
 * @return boolean 
 */

class Contato{
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $pdo;


    function getId(){
        return $this-> id;
    } 

    function getNome(){
        return $this-> nome;
    }

    function getEmail(){
        return $this-> email;
    }

    function getSenha(){
        return $this-> senha;
    }

    function setNome($nome){
        $this-> nome = $nome;
    }

    function setEmail($email){
        $this-> email = $email;
    }

    function setSenha($senha){
        $this-> senha = $senha;
    }
    
   
     function __construct(){
          
        #o PDO precsia de 3 parametros
        $dsn = "mysql:dbname=etimcontato; host=localhost";
        $bdUser = "root";
        $bdPass = "";


        try {
            $this-> pdo = new PDO ($dsn, $bdUser, $bdPass);
            echo "<script>
                     alert('Conectando ao banco')
                  </script>";
    
    
    
         } catch (\Throwable $th) {
             echo "<script>
             alert('Banco indisponivel. Tente mais tarde!!')
             </script>";
    
         }
    

     } 

     
     


             
    /**
     * @author Fabio Claret
     * data abril/2024
     * Metodo de conexao ao banco de dados
     * Tirei o metodo construtor porque ele nao retorna nada e queria testar se conectou
     * @return boolean 
     */







}