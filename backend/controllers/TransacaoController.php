<?php
// Importa o modelo da transação
require_once __DIR__ . '/../models/Transacao.php';

class TransacaoController {
    // Guarda a conexão com banco de dados 
    private $conn;

    // Construtor recebe a conexão e armazena
    public function __construct($db) {
        $this->conn = $db;
    }

    // Função para listar todas as transações
    public function listar() {
        $transacao = new Transacao($this->conn);
        $stmt = $transacao->listar();

        // Conta quantas transações foram retornadas
        $num = $stmt->rowCount();

        // Se encontrou alguma, monta um array com os dados
        if ($num > 0) {
            $transacoes_arr = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $transacao_item = [
                    "id" => $id,
                    "descricao" => $descricao,
                    "valor" => $valor,
                    "tipo" => $tipo,
                    "data_criacao" => $data_criacao
                ];
                $transacoes_arr[] =$transacao_item;
            }
            http_response_code(200);
            echo json_encode($transacoes_arr);
        } else {
            // Caso não haja transações
            http_response_code(404);
            echo json_encode(["message" => "Nenhuma transação encontrada."]);
        }
    }

    // Função para criar uma nova transação
    public function criar() {
        $transacao = new Transacao($this->conn);

        // Pega os dados enviados via POST(em JSON)
        $data = json_decode(file_get_contents("php://input"));

        // Verifica se os campos obrigatorios existem
        if (!empty($data->descricao) && !empty($data->valor) && !empty($data->tipo)) {
            $transacao->descricao = $data->descricao;
            $transacao->valor = $data->valor;
            $transacao->tipo = $data->tipo;

            if ($transacao->criar()) {
                http_response_code(201);
                echo json_encode(["message" => "Transação criada com sucesso."]);
            } else {
                http_response_code(503);
                echo json_encode(["message" => "Erro ao criar transação."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }
}