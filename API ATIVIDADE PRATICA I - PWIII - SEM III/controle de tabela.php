<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'Database.php';
include_once 'Usuario.php';
include_once 'UsuarioRepository.php';
include_once 'UsuarioService.php';

$database = new Database();
$db = $database->getConnection();
$usuarioService = new UsuarioService($db);

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents("php://input"));

switch($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // Buscar usuário por ID
            $usuario = $usuarioService->buscarUsuarioPorId($_GET['id']);
            if ($usuario !== null) {
                http_response_code(200);
                echo json_encode($usuario->toArray());
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "Usuário não encontrado."));
            }
        } else if (isset($_GET['email'])) {
            // Buscar usuário por email
            $usuario = $usuarioService->buscarUsuarioPorEmail($_GET['email']);
            if ($usuario !== null) {
                http_response_code(200);
                echo json_encode($usuario->toArray());
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "Usuário não encontrado."));
            }
        } else {
            // Listar todos os usuários
            $usuarios = $usuarioService->listarTodosUsuarios();
            $usuarios_arr = array();
            foreach ($usuarios as $usuario) {
                $usuarios_arr[] = $usuario->toArray();
            }
            http_response_code(200);
            echo json_encode($usuarios_arr);
        }
        break;
        
    case 'POST':
        if (isset($input->email) && isset($input->senha)) {
            try {
                $usuario = new Usuario(null, $input->email, $input->senha);
                $result = $usuarioService->criarUsuario($usuario);
                
                if ($result !== false) {
                    http_response_code(201);
                    echo json_encode(array(
                        "message" => "Usuário criado com sucesso.",
                        "usuario" => $result->toArray()
                    ));
                }
            } catch (Exception $e) {
                http_response_code(400);
                echo json_encode(array("message" => $e->getMessage()));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Dados incompletos."));
        }
        break;
        
    case 'PUT':
        if (isset($input->id) && isset($input->email) && isset($input->senha)) {
            try {
                $usuario = new Usuario($input->id, $input->email, $input->senha);
                $result = $usuarioService->atualizarUsuario($input->id, $usuario);
                
                if ($result !== false) {
                    http_response_code(200);
                    echo json_encode(array("message" => "Usuário atualizado com sucesso."));
                }
            } catch (Exception $e) {
                http_response_code(400);
                echo json_encode(array("message" => $e->getMessage()));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Dados incompletos."));
        }
        break;
        
    case 'DELETE':
        if (isset($input->id)) {
            $result = $usuarioService->excluirUsuario($input->id);
            if ($result) {
                http_response_code(200);
                echo json_encode(array("message" => "Usuário excluído com sucesso."));
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "Usuário não encontrado."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "ID não fornecido."));
        }
        break;
        
    default:
        http_response_code(405);
        echo json_encode(array("message" => "Método não permitido."));
        break;
}
?>