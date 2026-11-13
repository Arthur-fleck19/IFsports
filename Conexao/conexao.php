<?php
$servername = "127.0.0.1";
$username = "root";
$password = "K9#vP2!mZ8*qL5&x";
$dbname = "IFsports";

$conexao = new mysqli($servername, $username, $password, $dbname);
if ($conexao->connect_error) {
    die("Falha de conexão: " . $conexao->connect_error);
}