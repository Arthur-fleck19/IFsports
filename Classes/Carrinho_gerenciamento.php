<?php
require_once "../Conexao/conexao.php";
class Carrinho_gerenciamento
{
    public static function verificar_carrinho(){
        //consultar se já existe algum carrinho associoado ao id da sessão do usuário, se não, retorna false, se sim, retorna true
        global $conexao;

        return false;
    }

    public static function criar_carrinho(){
        //cria um novo carrinho com o id do usuario logado associado à ele
        global $conexao;

        session_start();


        $sql = "INSERT INTO Carrinho (id_usuarios, data_criacao) VALUES (?, ?)";

        $stmt = $conexao->prepare($sql);

        $data = date("Y-m-d");
        $usuario = $_SESSION['id'];

        $stmt->bind_param("is", $usuario, $data);

        if($stmt->execute()){
            header("Location: ../Views/dashboard.php");
            exit;
        }else{
            throw new Exception("Erro ao criar carrinho");
        }


    }

    public static function atualizar_carrinho($id_produto){
        //se a função "verificar_carrinho()" retornar false, chama a função criar carrinho
        if(!self::verificar_carrinho()){
            self::criar_carrinho();
        }



    }


}