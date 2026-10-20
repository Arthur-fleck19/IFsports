<?php

class Carrinho_gerenciamento
{
    public static function verificar_carrinho(){
        //consultar se já existe algum carrinho associoado ao id da sessão do usuário, se não, retorna false, se sim, retorna true
    }

    public static function criar_carrinho(){
        //cria um novo carrinho com o id do usuario logado associado à ele
    }

    public static function atualizar_carrinho(){
        //se a função "verificar_carrinho()" retornar false, chama a função criar carrinho
    }


}