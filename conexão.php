<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ... resto do seu código de conexão abaixo ...

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "IFsports";

$conexao = new mysqli($servername, $username, $password, $dbname);

if ($conexao->connect_error) {
    die("Falha de conexão: " . $conexao->connect_error);
}