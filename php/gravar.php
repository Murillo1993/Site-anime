<?php
include 'conexao.php'; 

mysqli_report(MYSQLI_REPORT_OFF);

$mensagem_criptografada = $_POST['mensagem_criptografada'];


$chave_aes_criptografada = $_POST['chave_criptografada'];

$conteudo_chave = file_get_contents('chaves/privada.pem'); 



$chave_privada = openssl_pkey_get_private($conteudo_chave); 

$chave_criptografada_binaria = base64_decode($chave_aes_criptografada);

openssl_private_decrypt(
    $chave_criptografada_binaria, 
    $pacote_chave_json, 
    $chave_privada
);

$pacote_chave = json_decode($pacote_chave_json, true);

$chave_aes = hex2bin($pacote_chave['key']);

$iv = hex2bin($pacote_chave['iv']);

$mensagem_binaria = base64_decode($mensagem_criptografada);

$valores_json = openssl_decrypt(
    $mensagem_binaria,      
    'aes-256-cbc',          
    $chave_aes,             
    OPENSSL_RAW_DATA,       
    $iv                     
);

$valores = json_decode($valores_json, true);

$nome = $valores["nome"];
$email = $valores["email"];
$senha = $valores["senha"];
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

if (empty($nome) || empty($email) || empty($senha)) {
    $retorno["status"] = "n";
    $retorno["mensagem"] = "Preencha todos os campos!";
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
        $retorno["mensagem"] = "Usuário cadastrado com sucesso!";
    } else {
        $error_message = mysqli_error($con);
        if (str_contains($error_message, 'Duplicate entry')) {
            $retorno["status"] = "n";
            $retorno["mensagem"] = "Este email já está cadastrado.";
        } else {
            $retorno["status"] = "n";
            $retorno["mensagem"] = "Erro ao cadastrar: " . $error_message;
        }
    }
} else {
    $retorno["status"] = "n";
    $retorno["mensagem"] = "Erro na preparação da query.";
}

mysqli_stmt_close($stmt);
mysqli_close($con);

echo json_encode($retorno);
?>