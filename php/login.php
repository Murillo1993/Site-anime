<?php
session_start();
include 'conexao.php';

$dados_criptografados_base64 = $_POST['dados_criptografados'];
$chave_criptografada = $_POST['chave_criptografada'];

$conteudo_chave_privada = file_get_contents('chaves/privada.pem');


if ($conteudo_chave_privada === false) {


    echo json_encode(["status" => "n", "mensagem" => "Erro: Não foi possível ler a chave privada."]);
    exit;

}

$chave_privada = openssl_pkey_get_private($conteudo_chave_privada);



if ($chave_privada === false) {


    echo json_encode(["status" => "n", "mensagem" => "Erro: Chave privada inválida."]);
    exit;

}

$sucesso_rsa = openssl_private_decrypt(
    base64_decode($chave_criptografada), $chaveE_IV_json, $chave_privada

);

if (!$sucesso_rsa) {
    echo json_encode(["status" => "n", "mensagem" => "Erro: Falha ao descriptografar a chave simétrica (RSA)."]);
    exit;
}

$chaveSimetrica_e_IV = json_decode($chaveE_IV_json, true);


if (json_last_error() !== JSON_ERROR_NONE) {


    echo json_encode(["status" => "n", "mensagem" => "Erro: O JSON da chave simétrica está corrompido."]);
    exit;

}

$chaveSimetrica = hex2bin($chaveSimetrica_e_IV['key']);
$iv = hex2bin($chaveSimetrica_e_IV['iv']);

$dados_criptografados_binarios = base64_decode($dados_criptografados_base64);

$dados_json = openssl_decrypt( $dados_criptografados_binarios,'aes-256-cbc', $chaveSimetrica, OPENSSL_RAW_DATA, $iv);


if ($dados_json === false) {

    echo json_encode(["status" => "n", "mensagem" => "Erro: Falha ao descriptografar os dados (AES)."]);
    exit;
}

$dados = json_decode($dados_json, true);

if (json_last_error() !== JSON_ERROR_NONE) {

    
    echo json_encode(["status" => "n", "mensagem" => "Erro: Os dados do formulário estão corrompidos."]);
    exit;
}

$email = $dados["email"];
$senha_pura = $dados["senha"];

$stmt = mysqli_stmt_init($con);
$query = "SELECT id, nome, senha_hash FROM usuarios WHERE email = ?";

if (mysqli_stmt_prepare($stmt, $query)) {
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);

    $resultado_query = mysqli_stmt_get_result($stmt);
    $usuario = mysqli_fetch_assoc($resultado_query);

    if ($usuario && password_verify($senha_pura, $usuario['senha_hash'])) {
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