<?php

session_start();

include 'conexao.php'; 

$email = $_POST["email"];
$senha = $_POST["senha"];
$stmt = mysqli_stmt_init($con);
$query = "SELECT id, nome, senha_hash FROM usuarios WHERE email = ?";

if (mysqli_stmt_prepare($stmt, $query)) {
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);

    $resultado_query = mysqli_stmt_get_result($stmt);
    $usuario = mysqli_fetch_assoc($resultado_query);

    if ($usuario && password_verify($senha, $usuario["senha_hash"])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];

        $retorno["status"] = "s";
        $retorno["mensagem"] = "Login realizado com sucesso";
        $retorno["nome"] = $usuario['nome'];

    } else {
        $retorno["status"] = "n";
        $retorno["mensagem"] = "Email ou senha inválidos.";
    }

} else {
    $retorno["status"] = "n";
    $retorno["mensagem"] = "Erro na preparação da query."; 
}

mysqli_stmt_close($stmt);
mysqli_close($con);
echo json_encode($retorno);

?>