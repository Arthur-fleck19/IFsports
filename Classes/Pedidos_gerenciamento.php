<?php
session_start();
require_once "../Conexao/conexao.php";
class Pedidos_gerenciamento
{

    public static function consultar_itens_pedido(){
        global $conexao;

        $id_usuario = $_SESSION['id'];

        $sql = "
        SELECT it.id_produtos, it.quantidade, Produtos.preco, (Produtos.preco * it.quantidade) as 'valor' FROM item_carrinho as it
        JOIN Carrinho
        ON Carrinho.id_carrinho = it.id_carrinho
        JOIN Usuarios
        ON Carrinho.id_usuarios = Usuarios.id_usuarios
        JOIN Produtos
        ON it.id_produtos = Produtos.id_produtos
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

        //criar um novo pedido ligado ao usuario

        //inserir as informações desse carrinho na tabela itens_pedido e ligar a nova tabela criada

    }

    public static function get_total(){
        global $conexao;

        $id_usuario = $_SESSION['id'];

        $sql = "
        SELECT sum(Produtos.preco * it.quantidade) as 'total' FROM item_carrinho as it
        JOIN Carrinho
        ON Carrinho.id_carrinho = it.id_carrinho
        JOIN Usuarios
        ON Carrinho.id_usuarios = Usuarios.id_usuarios
        JOIN Produtos
        ON it.id_produtos = Produtos.id_produtos
        WHERE Carrinho.id_usuarios = ?
        group by Carrinho.id_carrinho;
        ";

        $stmt = $conexao->prepare($sql);

        $stmt->bind_param("i", $id_usuario);

        if(!$stmt->execute()){
            throw new Exception("Erro ao consultar total");
        }

        return $stmt->get_result();
    }

    public static function adicionar_itens_pedido(){
        global $conexao;

        $id_usuario = $_SESSION['id'];
        $carrinho = Pedidos_gerenciamento::consultar_itens_pedido();

        while($item = mysqli_fetch_assoc($carrinho)){
            //fazer o insert dos dados um por um no banco
        }


    }

    public static function criar_pedido(){
        global $conexao;
    }
}