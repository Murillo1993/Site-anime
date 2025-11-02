<?php

include 'conexao.php'; 

$nome = $_POST ["nome"];
$email = $_POST ["email"];
$senha = $_POST ["senha"];

$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

if (empty($nome) || empty($email) || empty($senha)) {
    $retorno["status"] = "n";
    $retorno["mensagem"] = "Preencha todos os campos"; 
    echo json_encode($retorno); 
    exit;
}

$stmt = mysqli_stmt_init($con);
$query = "INSERT INTO usuarios (nome, email, senha_hash) VALUES (?, ?, ?)";

if (mysqli_stmt_prepare($stmt, $query)) {
    mysqli_stmt_bind_param($stmt, 'sss', $nome, $email, $senha_hash);

    $resultado = mysqli_stmt_execute($stmt);

    if ($resultado) {
        $retorno["status"] = "s";
        $retorno["mensagem"] = "Usuário cadastrado com sucesso";
    } else {
        $retorno["status"] = "n";
        $retorno["mensagem"] = "Erro ao cadastrar: " . mysqli_error($con);
    }

} else {
    $retorno["status"] = "n";
    $retorno["mensagem"] = "Erro na preparação da query.";
}

mysqli_stmt_close($stmt);
mysqli_close($con);

echo json_encode($retorno);

?>