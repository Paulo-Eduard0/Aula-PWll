<?php
class UsuarioRepository {
    private $conn;
    private $table_name = "usuarios";
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
   
    
    public function findAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $usuarios = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $usuario = new Usuario();
            $usuario->setId($row['id']);
            $usuario->setEmail($row['email']);
            $usuario->setSenha($row['senha']);
            $usuarios[] = $usuario;
        }
        
        return $usuarios;
    }
    
    public function findById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $usuario = new Usuario();
            $usuario->setId($row['id']);
            $usuario->setEmail($row['email']);
            $usuario->setSenha($row['senha']);
            return $usuario;
        }
        
        return null;
    }
    
    public function findByEmail($email) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $email);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $usuario = new Usuario();
            $usuario->setId($row['id']);
            $usuario->setEmail($row['email']);
            $usuario->setSenha($row['senha']);
            return $usuario;
        }
        
        return null;
    }
    
    public function save($usuario) {
        if ($usuario->constructor()) {
            if ($usuario->getId() === null) {
                // Criar novo usuário
                return $this->create($usuario);
            } else {
                // Atualizar usuário existente
                return $this->update($usuario);
            }
        }
        throw new Exception("Dados do usuário inválidos");
    }
    
    private function create($usuario) {
        $query = "INSERT INTO " . $this->table_name . " SET email=:email, senha=:senha";
        $stmt = $this->conn->prepare($query);
        
        // Limpar dados
        $email = htmlspecialchars(strip_tags($usuario->getEmail()));
        $senha = htmlspecialchars(strip_tags($usuario->getSenha()));
        
        // Bind parameters
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":senha", $senha);
        
        if ($stmt->execute()) {
            $usuario->setId($this->conn->lastInsertId());
            return $usuario;
        }
        
        return false;
    }
    
    private function update($usuario) {
        $query = "UPDATE " . $this->table_name . " SET email=:email, senha=:senha WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        
        // Limpar dados
        $email = htmlspecialchars(strip_tags($usuario->getEmail()));
        $senha = htmlspecialchars(strip_tags($usuario->getSenha()));
        $id = $usuario->getId();
        
        // Bind parameters
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":senha", $senha);
        $stmt->bindParam(":id", $id);
        
        return $stmt->execute();
    }
    
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        
        return $stmt->execute();
    }
    
    public function authenticate($email, $senha) {
        $usuario = $this->findByEmail($email);
        if ($usuario !== null) {
            return $usuario->checkPass($usuario, $senha);
        }
        return false;
    }
}
?>