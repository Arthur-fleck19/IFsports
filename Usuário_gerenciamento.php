<?php
require_once 'conexão.php';
class Usuário_gerenciamento
{
    public static function cadastrar($nome, $email, $senha){
        global $conexao;

        $sql = "INSERT INTO Usuarios (nome, email, tipo, senha) VALUES (?, ?, 'comum', ?)";

        $stmt = $conexao->prepare($sql);

        $senha = password_hash($senha, PASSWORD_DEFAULT);

        $stmt->bind_param("sss", $nome, $email, $senha);

        if($stmt->execute()){
            return("Cadastro efetuado com sucesso");
        }else{
            throw new Exception("Erro ao cadastrar informações");
        }
    }

    public static function get_usuarios(){
        global $conexao;

        $sql = "SELECT id_usuarios, nome, email FROM usuarios";

        $resultado = $conexao->query($sql);

        return $resultado;
    }
}