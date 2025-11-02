<?php

$servidor = "localhost:3306";
$usuario_db = "root";
$senha_db = "Logan197#";
$banco = "anime_primos"; 

$con = mysqli_connect($servidor, $usuario_db, $senha_db, $banco);

if (!$con) {
    $retorno["status"] = "n";
    $retorno["mensagem"] = "Erro de conexão: " . mysqli_connect_error(); 
    echo json_encode($retorno);
    exit;
}

header('Content-Type: application/json; charset=utf-8');

?>