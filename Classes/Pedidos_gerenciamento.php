<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    header("Location: ../Views/login.php");
    exit;
}

require_once "../Conexao/conexao.php";
require_once "Carrinho_gerenciamento.php";
require_once "Produtos_gerenciamento.php";

class Pedidos_gerenciamento
{
    public static function consultar_itens_pedido(){
        global $conexao;

        $id_usuario = $_SESSION['id'];

        $sql = "
        SELECT it.id_produtos, it.quantidade, Produtos.preco as 'preco_unit', (Produtos.preco * it.quantidade) as 'subtotal' 
        FROM item_carrinho as it
        JOIN Carrinho ON Carrinho.id_carrinho = it.id_carrinho
        JOIN Usuarios ON Carrinho.id_usuarios = Usuarios.id_usuarios
        JOIN Produtos ON it.id_produtos = Produtos.id_produtos
        WHERE Carrinho.id_usuarios = ?;
        ";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $id_usuario);

        if(!$stmt->execute()){
            throw new Exception("Erro ao consultar carrinho");
        }

        return $stmt->get_result();
    }

    public static function finalizarPedido($frete){
        global $conexao;

        $itens = self::consultar_itens_pedido();
        if ($itens->num_rows === 0) {
            throw new Exception("O carrinho está vazio.");
        }

        $conexao->begin_transaction();

        try {
            $id_pedido = self::criar_pedido($frete);

            self::adicionar_itens_pedido($id_pedido, $itens);

            Carrinho_gerenciamento::limpar_carrinho();

            $conexao->commit();
            return $id_pedido;

        } catch (Exception $e) {
            $conexao->rollback();
            throw $e;
        }
    }

    public static function get_total(){
        global $conexao;

        $id_usuario = $_SESSION['id'];

        $sql = "
        SELECT sum(Produtos.preco * it.quantidade) as 'total' 
        FROM item_carrinho as it
        JOIN Carrinho ON Carrinho.id_carrinho = it.id_carrinho
        JOIN Usuarios ON Carrinho.id_usuarios = Usuarios.id_usuarios
        JOIN Produtos ON it.id_produtos = Produtos.id_produtos
        WHERE Carrinho.id_usuarios = ?
        GROUP BY Carrinho.id_carrinho;
        ";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $id_usuario);

        if(!$stmt->execute()){
            throw new Exception("Erro ao consultar total");
        }

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public static function adicionar_itens_pedido($id_pedido, $carrinho){
        global $conexao;

        $sql = "INSERT INTO Item_pedidos (id_produtos, id_pedidos, quantidade, subtotal, preco_unitario) VALUES(?, ?, ?, ?, ?)";
        $stmt = $conexao->prepare($sql);

        while($produto = $carrinho->fetch_assoc()){
            $stmt->bind_param(
                'iiidd',
                $produto['id_produtos'],
                $id_pedido,
                $produto['quantidade'],
                $produto['subtotal'],
                $produto['preco_unit']
            );

            if(!$stmt->execute()){
                throw new Exception("Erro ao registrar item do pedido");
            }

            Produtos_gerenciamento::atualizar_estoque($produto['id_produtos'], $produto['quantidade']);
        }
    }

    public static function criar_pedido($frete){
        global $conexao;

        $id_usuario = $_SESSION['id'];
        $total = self::get_total();
        $total = $total["total"];
        $total += $frete;

        $sql = "INSERT INTO Pedidos (id_usuarios, statusPed, valor, data_pedido) VALUES (?, 'andamento', ?, NOW())";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("id", $id_usuario, $total);

        if(!$stmt->execute()){
            throw new Exception("Erro ao criar pedido");
        }

        return $conexao->insert_id;
    }

    public static function get_ultimo_pedido(){
        global $conexao;

        $id_usuario = $_SESSION['id'];

        $sql = "SELECT id_pedidos FROM Pedidos WHERE id_usuarios = ? ORDER BY id_pedidos DESC LIMIT 1";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $id_usuario);

        if(!$stmt->execute()){
            throw new Exception("Erro ao consultar pedido");
        }

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
