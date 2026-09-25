<?php
require_once 'conexão.php';
class Usuário_gerenciamento
{
    public static function cadastrar($nome, $email, $senha){
        global $conexao;

        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";

        $stmt = $conexao->prepare($sql);

        $stmt->bind_param("sss", $nome, $email, $senha);

        $stmt->execute();
    }
}