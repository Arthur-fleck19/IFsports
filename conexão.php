<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "IFSports";

$conexao = new mysqli($servername, $username, $password, $dbname);

if ($conexao->connect_error) {
    die("Falha de conexão: " . $conexao->connect_error);
}