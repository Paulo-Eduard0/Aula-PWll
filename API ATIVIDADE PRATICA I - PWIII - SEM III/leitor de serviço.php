<?php
class UsuarioService {
    private $usuarioRepository;
    
    public function __construct($db) {
        $this->usuarioRepository = new UsuarioRepository($db);
    }
    
    public function listarTodosUsuarios() {
        return $this->usuarioRepository->findAll();
    }
    
    public function buscarUsuarioPorId($id) {
        return $this->usuarioRepository->findById($id);
    }
    
    public function buscarUsuarioPorEmail($email) {
        return $this->usuarioRepository->findByEmail($email);
    }
    
    public function criarUsuario($usuario) {
        
        if ($this->usuarioRepository->findByEmail($usuario->getEmail()) !== null) {
            throw new Exception("Email já cadastrado");
        }
        
        return $this->usuarioRepository->save($usuario);
    }
    
    public function atualizarUsuario($id, $usuarioAtualizado) {
        $usuarioExistente = $this->usuarioRepository->findById($id);
        if ($usuarioExistente !== null) {
            $usuarioAtualizado->setId($id);
            return $this->usuarioRepository->save($usuarioAtualizado);
        }
        throw new Exception("Usuário não encontrado");
    }
    
    public function excluirUsuario($id) {
        return $this->usuarioRepository->delete($id);
    }
    
    public function autenticarUsuario($email, $senha) {
        return $this->usuarioRepository->authenticate($email, $senha);
    }
}
?>