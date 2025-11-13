<?php
// Permite a conexão do front-end (CORS)
header("Access-Control-Allow-Origin: *");
header("COntent-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Importa dependências
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/TransacaoCOntroller.php';

// Cria a conexão com o banco
$database = new Database();
$db = $database->getConnection();

// Istancia o controlador
$controller = new TransacaoController($db);

// Analisar a URL e decide qual função chamar 
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Define as rotas
if ($uri == '/api/transacoes' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller->listar();
} elseif ($uri == '/api/transacoes' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->criar();
} else {
    http_response_code(404);
    echo json_encode(["message" => "Rota não encontrada."]);
}