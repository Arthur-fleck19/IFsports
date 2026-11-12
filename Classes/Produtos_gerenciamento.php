<?php
require_once "../Conexao/conexao.php";

class Produtos_gerenciamento
{
    public static function add_produto($nome, $preco, $descricao, $estoque, $img, $tipo){
        global $conexao;

        $sql = "INSERT INTO Produtos (nome, preco, descricao, estoque, imagem, tipo) VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conexao->prepare($sql);

        $stmt->bind_param('sdsiss', $nome, $preco, $descricao, $estoque, $img, $tipo);
        $stmt->execute();
    }

    public static function salvar_imagem($arquivo){

        if ($arquivo['error'] !== UPLOAD_ERR_OK) {
            die('Erro no upload.');
        }

        if ($arquivo['size'] > 5 * 1024 * 1024) {
            die('Arquivo muito grande.');
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($arquivo['tmp_name']);
        $permitidos = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp',
        ];

        if (!isset($permitidos[$mime])) {
            die('Tipo de arquivo não permitido.');
        }

        $diretorio = __DIR__ . '/../uploads/';

        if(!is_dir($diretorio)) {
            mkdir($diretorio, 0777, true);
        }

        $nome = bin2hex(random_bytes(16)) . '.' . $permitidos[$mime];
        $destino = $diretorio.$nome;

        if (!move_uploaded_file($arquivo['tmp_name'], $destino)) {
            die ('Erro ao enviar imagem');
        }

        return $nome;
    }

    public static function get_imagem_produto($idProduto) {
        global $conexao;
        $sql = "SELECT imagem FROM Produtos WHERE id_produtos = ?";
        $stmt = $conexao->prepare($sql);

        $stmt->bind_param('i', $idProduto);
        $stmt->execute();

        $resultado = $stmt->get_result();
        $produto = $resultado->fetch_assoc();
        
        $stmt->close();

        return $produto ? $produto['imagem'] : null;
    }

    public static function deletar_imagem_produto($imagem) {
        $caminho = __DIR__ . "../uploads/" . $imagem;

        if(file_exists($caminho) && is_file($caminho)) {
            return unlink($caminho);
        }

        return false;
    }

    public static function get_produtos(){
        global $conexao;
        $sql = "SELECT * FROM Produtos";
        $resultado = $conexao->query($sql);

        return $resultado;
    }

    public static function get_detalhes_produto($id){
        global $conexao;
        $sql = "SELECT * FROM Produtos WHERE id_produtos = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $resultado = $stmt->get_result();

        return $resultado->fetch_assoc();
    }

    public static function editar_produto($idProduto, $imagem, $nome, $tipo, $preco, $descricao, $estoque) {
        global $conexao;
        $sql = "UPDATE Produtos SET imagem = ?, nome = ?, tipo = ?, preco = ?, descricao = ?, estoque = ? WHERE id_produtos = ?";
        $stmt = $conexao->prepare($sql);

        $stmt->bind_param("sssdsii", $imagem, $nome, $tipo, $preco, $descricao, $estoque, $idProduto);

        $resultado = $stmt->execute();

        return $resultado;
    }

    public static function excluir($id){
        global $conexao;

        $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

        if ($id && $id > 0) {
            $sql = "DELETE FROM Produtos WHERE id_produtos = ?";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();

            $removido = $stmt->affected_rows > 0;
            $stmt->close();

            header(
                "Location: ../Views/produtos.php?resultado="
                . ($removido ? "sucesso" : "erro")
            );
            exit;
        }
    }

    public static function atualizar_estoque($id_produto, $quantidade){
        global $conexao;

        $sql = "SELECT quantidade FROM item_carrinho WHERE id_produtos = ?";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $id_produto);
        if (!$stmt->execute()) {
            throw new Exception('Erro ao consultar estoque');
        }

        $estoque_antigo = $stmt->get_result()->fetch_assoc();

        $sql = "UPDATE Produtos SET estoque = ? WHERE id_produtos = ?";

        $stmt = $conexao->prepare($sql);

        $estoque = $estoque_antigo['quantidade'] - $quantidade;

        $stmt->bind_param("ii", $estoque, $id);

        if(!$stmt->execute()){
            throw new Exception("Erro ao atualizar estoque");
        }
    }
}