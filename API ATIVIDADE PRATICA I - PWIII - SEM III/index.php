<?php

include_once 'Database.php';
include_once 'Usuario.php';
include_once 'UsuarioRepository.php';

echo "<h1>Teste de Conexão com Localhost</h1>";

try {
 
    $database = new Database();
    $db = $database->getConnection();
    
    if ($db) {
        echo "<p style='color: green;'>✅ Conexão com o banco estabelecida com sucesso!</p>";
       

        $db->exec("
            CREATE TABLE IF NOT EXISTS usuarios (
                id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(255) NOT NULL UNIQUE,
                senha VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");
        echo "<p style='color: green;'>✅ Tabela 'usuarios' verificada/criada!</p>";
        
     
        $usuarioRepo = new UsuarioRepository($db);
        
       
        $usuarioTeste = new Usuario(null, "teste@localhost.com", "senha123");
        
        if ($usuarioTeste->constructor()) {
            echo "<p style='color: green;'>✅ Método constructor() funcionando!</p>";
            
       
            $resultado = $usuarioRepo->save($usuarioTeste);
            if ($resultado) {
                echo "<p style='color: green;'>✅ Usuário salvo no banco! ID: " . $resultado->getId() . "</p>";
            }
        }
        
        $usuarios = $usuarioRepo->findAll();
        echo "<h2>Usuários no banco:</h2>";
        echo "<ul>";
        foreach ($usuarios as $usuario) {
            echo "<li>ID: " . $usuario->getId() . " - Email: " . $usuario->getEmail() . "</li>";
        }
        echo "</ul>";
        
    } else {
        echo "<p style='color: red;'>❌ Erro na conexão com o banco</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Erro: " . $e->getMessage() . "</p>";
}
?>

<h2>Status do Servidor</h2>
<p><strong>Servidor:</strong> <?php echo $_SERVER['SERVER_SOFTWARE']; ?></p>
<p><strong>PHP Version:</strong> <?php echo phpversion(); ?></p>
<p><strong>URL Acessada:</strong> <?php echo $_SERVER['REQUEST_URI']; ?></p>

<h2>Próximos Passos:</h2>
<ol>
    <li>Verifique se o Apache e MySQL estão rodando no XAMPP/WAMP</li>
    <li>Acesse: <code>http://localhost/projeto-usuario/</code></li>
    <li>Se ainda der erro, tente: <code>http://localhost/projeto-usuario/index.php</code></li>
</ol>