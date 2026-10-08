<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once "conexão.php";

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = $_POST["Nome"];
    $senha = $_POST["Senha"];
    
    // Procura o usuário pelo nome
    $sql = "SELECT id_usuarios, nome, senha, tipo FROM Usuarios WHERE nome = ?";

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
            } 
            
        else{
          header("Location: dashboard.php");
            }
          exit;

        } else {
        header("Location: login.html?erro=senha");


        } 
        
        } else {

        header("Location: login.html?erro=usuario");
    }

    $stmt->close();
    $conexao->close();
}

?>

 <?php if (!empty($mensagem)): ?>
    <p><?php echo htmlspecialchars($mensagem); ?></p>
<?php endif; ?>