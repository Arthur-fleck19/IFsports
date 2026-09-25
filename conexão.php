<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "IFSports";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha de conexão: " . $conn->connect_error);
}