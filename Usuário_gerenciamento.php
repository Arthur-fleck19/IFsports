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
            if(session_status() === PHP_SESSION_NONE){
                session_start();
            }
            session_regenerate_id(true);
            $sql = "SELECT id_usuarios FROM Usuarios WHERE nome = ? LIMIT 1";

            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("s", $nome);
            $stmt->execute();
            $result = $stmt->get_result();

            $_SESSION['id'] = $result->fetch_assoc()["id_usuarios"];
            $_SESSION['nome'] = $nome;
            $_SESSION['tipo'] = 'comum';
        }else{
            throw new Exception("Erro ao cadastrar informações");
        }
    }

    public static function excluir($idUsuario) {
        global $conexao;
        $sql = "DELETE FROM Usuarios WHERE id_usuarios = ? AND tipo = 'comum'";
        $stmt = $conexao->prepare($sql);

        $stmt->bind_param("i", $idUsuario);

        if($stmt->execute()) {
            return "Usuário deletado com sucesso.";
        } else {
            throw new Exception("Erro ao deletar o usuário.");
        }
    }

    public static function get_usuarios(){
        global $conexao;

        $sql = "SELECT id_usuarios, nome, email FROM Usuarios";

        $resultado = $conexao->query($sql);

        return $resultado;
    }

    public static function editar_usuario($idUsuario, $nome, $email, $senha){
        global $conexao;

        if(empty($senha)){
            $sql = "UPDATE Usuarios SET nome = ?, email = ? WHERE id_usuarios = ?";

            $stmt = $conexao->prepare($sql);

            $stmt->bind_param("ssi", $nome, $email, $idUsuario);
        }else{
            $sql = "UPDATE Usuarios SET nome = ?, email = ?, senha = ? WHERE id_usuarios = ?";

            $senha = password_hash($senha, PASSWORD_DEFAULT);

            $stmt = $conexao->prepare($sql);

            $stmt->bind_param("sssi", $nome, $email, $senha, $idUsuario);
        }

        $stmt->execute();

    }

    public static function login($nome, $senha){
        global $conexao;

        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        session_start();

        $mensagem = "";

        
            
            // Procura o usuário pelo nome
            $sql = "SELECT id_usuarios, nome, senha, tipo FROM Usuarios WHERE nome = ? LIMIT 1";

            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("s", $nome);
            $stmt->execute();

            $resultado = $stmt->get_result();
            
            if ($resultado->num_rows === 1) {

                $usuario = $resultado->fetch_assoc();

                // Verifica a senha digitada contra o hash do banco
                if (password_verify($senha, $usuario["senha"])) {

                    $_SESSION["id"] = $usuario["id_usuarios"];
                    $_SESSION["nome"] = $usuario["nome"];
                    $_SESSION["tipo"] = $usuario["tipo"];

                    if($_SESSION["tipo"]== "admin"){
                        header("Location:gerenciamento_usuarios.php");
                        exit;
                    } 
                    
                else{
                header("Location: dashboard.php");
                    }
                exit;

                } else {
                header("Location: login.html?erro=senha");
                exit;

                } 
                
                } else {

                header("Location: login.html?erro=usuario");
                exit;
            }

            $stmt->close();
            $conexao->close();
        }
    

    public static function logout(){
        session_unset();
        session_destroy();
        header("Location: login.html");
        exit;
    }

    public static function perfil(){
        global $conexao;

        $sql = "SELECT * FROM Usuarios WHERE id_usuarios = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $_SESSION['id']);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows == 1){
            $row = $result->fetch_assoc();
        }

        return $row;
    }
}