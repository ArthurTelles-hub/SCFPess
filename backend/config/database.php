<?php
class Database {
    private $host = "localhost";           // Endereço do servidor
    private $db_name = "financeiro";       // Nome do banco de dados 
    private $username = "financeiro_user"; // Usuário do banco
    private $password = "senha123";        // Senha do usuário
    public $conn;                          // Variável pública que armazena a conexao PDO

    // Função que cria e retorna a conexão
    public function getConnection() {
        $this->conn = null;
        try {
            // Tenta criar uma conexão PDO com o MySQL
            $this->conn = new PDO(
                "mysql:host=" . $this->host . "db_name=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->exec("set name utf8");
        } catch (PDOException $exception) {
            // Caso ocorra um erro na conexão retorna uma mensagem de erro
            echo "Erro na conexão: " . $exception->getMessage();
        }
        // Retorna o objeto de conexão (ou null se falhou)
        return $this->conn;
    }
}