<?php
require_once "conexão.php";

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

        $nome = bin2hex(random_bytes(16)) . '.' . $permitidos[$mime];
        $destino = __DIR__ . '/uploads/'.$nome;

        if (!move_uploaded_file($arquivo['tmp_name'], $destino)) {
            die ('Erro ao enviar imagem');
        }

        return $nome;
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

    public static function editar_produto($idProduto, $nome, $preco, $descricao, $estoque) {
        global $conexao;
        $sql = "UPDATE Produtos SET nome = ?, preco = ?, descricao = ?, estoque = ? WHERE id_produtos = ?";
        $stmt = $conexao->prepare($sql);

        $stmt->bind_param("sdsii", $nome, $preco, $descricao, $estoque, $idProduto);
        $stmt->execute();
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
                "Location: produtos.php?resultado="
                . ($removido ? "sucesso" : "erro")
            );
            exit;
        }
    }
}