<?php
session_start();
class Pedidos_gerenciamento
{

    public static function consultar_itens_pedido(){
        global $conexao;

        $id_usuario = $_SESSION['id'];

        $sql = "
        SELECT it.id_produtos, it.quantidade, SUM(Produtos.preco), Produtos.preco FROM item_carrinho as it
        JOIN Carrinho
        ON Carrinho.id_carrinho = it.id_carrinho
        JOIN Usuarios
        ON Carrinho.id_usuarios = Usuarios.id_usuarios
        JOIN Produtos
        ON item_carrinho.id_produtos = Produtos.id_produtos
        WHERE Carrinho.id_usuarios = ?;
        ";

        $stmt = $conexao->prepare($sql);

        $stmt->bind_param("i", $id_usuario);

        if(!$stmt->execute()){
            throw new Exception("Erro ao consultar carrinho");
        }

        return $stmt->get_result();
    }
    public static function finalizarPedido(){
        //Vai registrar o pedido no banco e limpar o carrinho associado àquele usuário, atualizar estoques

        //procurar o carrinho que está ligado ao usuario



    }

    public static function criar_pedido(){
        global $conexao;

        $id_usuario = $_SESSION['id'];
        $carrinho = Pedidos_gerenciamento::consultar_itens_pedido();

        $sql = "";


    }
}