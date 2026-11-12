<?php
$servername = "127.0.0.1";
$username = "root";
$password = "K9#vP2!mZ8*qL5&x"; //Tira essa senha depois, Josué.
$dbname = "IFsports";

$conexao = new mysqli($servername, $username, $password, $dbname, 3306); //Tira a porta depois, Josué.

if ($conexao->connect_error) {
    die("Falha de conexão: " . $conexao->connect_error);
}