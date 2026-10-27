<?php
require_once "../Conexao/conexao.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    header("Location: ../Views/login.php");
    exit;
}

class Carrinho_gerenciamento
{
    public static function verificar_carrinho(){
        //consultar se já existe algum carrinho associoado ao id da sessão do usuário, se não, retorna false, se sim, retorna true
        global $conexao;

        $sql = "SELECT * FROM Carrinho WHERE id_usuarios = ? LIMIT 1";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $_SESSION["id"]);
        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows == 1){
            return $result->fetch_assoc();
        }

        return false;
    }

    public static function verificar_estoque($id_produto){
        global $conexao;

        $sql = "SELECT estoque FROM Produtos WHERE id_produtos = ? LIMIT 1";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $id_produto);
        if($stmt->execute()){
            $result = $stmt->get_result();

            if($result->num_rows == 1){
                $produto = $result->fetch_assoc();
                return $produto['estoque'];
            }
            return false;
        }
        throw new Exception("Erro ao carregar a quantidade do produto no carrinho");
    }

    public static function criar_carrinho(){
        //cria um novo carrinho com o id do usuario logado associado à ele
        global $conexao;

        $sql = "INSERT INTO Carrinho (id_usuarios, data_criacao) VALUES (?, ?)";

        $stmt = $conexao->prepare($sql);

        $data = date("Y-m-d");
        $id = $_SESSION['id'];

        $stmt->bind_param("is", $id, $data);

        if(!$stmt->execute()){
            throw new Exception("Erro ao criar carrinho");
        }

        return $conexao->insert_id;
    }

    public static function verificar_produto($id_produto, $id_carrinho){
        global $conexao;

        $sql = "SELECT quantidade FROM item_carrinho WHERE id_produtos = ? AND id_carrinho = ? LIMIT 1";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ii", $id_produto, $id_carrinho);
        if($stmt->execute()){
            $result = $stmt->get_result();

            if($result->num_rows == 1){
                $carrinho = $result->fetch_assoc();
                return $carrinho['quantidade'];
            }
            return false;
        }
        throw new Exception("Erro ao consultar estoque do produto");
    }

    public static function atualizar_carrinho($id_produto, $quantidade){
        //se a função "verificar_carrinho()" retornar false, chama a função criar carrinho
        global $conexao;

        $estoque = self::verificar_estoque($id_produto);
        if ($estoque === false) {
            throw new Exception("Produto não encontrado");
        }

        $quantidade = filter_var($quantidade, FILTER_VALIDATE_INT);
        if($quantidade === false||$quantidade <= 0){
            throw new Exception("Quantidade de produtos inválida");
        }

        $carrinho = self::verificar_carrinho();

        if(!$carrinho){
            $id_carrinho = self::criar_carrinho();
        }else{
            $id_carrinho = $carrinho["id_carrinho"];
        }

        if (empty($id_carrinho)) {
            throw new Exception("Erro crítico: ID do carrinho não foi identificado.");
        }

        $quant_anterior = self::verificar_produto($id_produto, $id_carrinho);
        $quantidade_final = $quantidade + ($quant_anterior === false ? 0 : $quant_anterior);

        if($quantidade_final > $estoque){
            throw new Exception("Quantidade de produtos inválida");
        }

        $sql = "INSERT INTO item_carrinho (id_carrinho, id_produtos, quantidade)
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE quantidade = quantidade + VALUES(quantidade)";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("iii", $id_carrinho, $id_produto, $quantidade);

        if(!$stmt->execute()){
            throw new Exception("Erro ao atualizar carrinho");
        }
    }

    public static function consultar_carrinho($id_usuario){
        global $conexao;

        $sql = "
            SELECT u.nome as nome_usuario, p.nome as nome_produto, it.quantidade as quantidade FROM item_carrinho as it
            JOIN Carrinho as c ON it.id_carrinho = c.id_carrinho
            JOIN Usuarios as u ON c.id_usuarios = u.id_usuarios
            JOIN Produtos as p ON it.id_produtos = p.id_produtos
            WHERE u.id_usuarios = ?;
        ";

        $stmt = $conexao->prepare($sql);

        $stmt->bind_param("i", $id_usuario);

        if(!$stmt->execute()){
            throw new Exception("Erro ao consultar carrinho");
        }
        $result = $stmt->get_result();

        return $result;
}
}