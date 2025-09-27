<?php
class Usuario {
    private $id;
    private $email;
    private $senha;
    
    
    public function __construct($id = null, $email = null, $senha = null) {
        $this->id = $id;
        $this->email = $email;
        $this->senha = $senha;
    }
    
 
    public function getId() {
        return $this->id;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function getSenha() {
        return $this->senha;
    }
    
    // Setters
    public function setId($id) {
        $this->id = $id;
    }
    
    public function setEmail($email) {
        $this->email = $email;
    }
    
    public function setSenha($senha) {
        $this->senha = $senha;
    }
    
  
    public function constructor() {
       
        if (empty($this->email) || empty($this->senha)) {
            return false;
        }
        
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        
        
        if (strlen($this->senha) < 6) {
            return false;
        }
        
        return true;
    }
    
    public function checkUser($user) {
        if ($user === null) {
            return false;
        }
        
        
        return $this->email === $user->getEmail();
    }
    
    public function checkPass($user, $pass) {
        if ($user === null || $pass === null) {
            return false;
        }
        
       
        return $user->getSenha() === $pass;
    }
    
    public function toArray() {
        return [
            'id' => $this->id,
            'email' => $this->email
        ];
    }
}
?>