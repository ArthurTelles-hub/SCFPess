<?php
// Importa o arquivo de conexão com o banco de dados
require_once __DIR__ . '/../config/database.php';

class Transacao {
    // Propriedade que guarda a conexão PDO
    private $conn;

    // Nome da tabela no banco de dados
    private $table_name = "transacoes";

    // Atributos da transação
    public $id;
    public $descricao;
    public $valor;

    // Construtor que recebe a conexão e armazena em $conn
    public function __construct($db) {
        $this->conn = $db;
    }

    // Função para listar as todas as transações
    public function listar() {
        $query = "SELECT * FROM" . $this->table_name . " ORDER BY data_criacao DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Função para criar uma nova transação
    public function criar() {
        $query = "INSERT INTO " . $this->table_name . " (descrição, valor, tipo, data_criacao) VALUES (:descricao, :valor, :tipo, NOW())";
        $stmt = $this->conn->prepare($query);

        // Sanitiza os dados 
        $this->descricao = htmlspecialchars(strip_tags($this->descricao));
        $this->valor = htmlspecialchars(strip_tags($this->valor));
        $this->tipo = htmlspecialchars(strip_tags($this->tipo));

        // Faz o bind dos parâmetros
        $stmt->bindParam(":descricao", $this->descricao);
        $stmt->bindParam(":valor", $this->valor);
        $stmt->bindParam(":tipo", $this->tipo);

        // Executa o comando SQL e retorna true se der certo
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}