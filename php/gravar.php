<?php

header("Content-Type: application/json; charset=UTF-8");
include 'conexao.php';


$retorno = ["status" => "n", "mensagem" => "Ocorreu um erro inesperado."];

try {
   
    if (!isset($_POST['dados_criptografados']) || !isset($_POST['chave_criptografada'])) {

        throw new Exception("Erro: Dados ou chave não recebidos.");
    }

    $dados_criptografados_base64 = $_POST['dados_criptografados'];
    $chave_criptografada = $_POST['chave_criptografada'];

    $conteudo_chave_privada = file_get_contents('chaves/privada.pem');


    if ($conteudo_chave_privada === false) {

        throw new Exception("Erro: Não foi possível ler a chave privada.");
    }

    $chave_privada = openssl_pkey_get_private($conteudo_chave_privada);


    if ($chave_privada === false) {

        throw new Exception("Erro: Chave privada inválida.");
    }

    $sucesso_rsa = openssl_private_decrypt(
        base64_decode($chave_criptografada),
        $chaveE_IV_json,
        $chave_privada
    );

    if (!$sucesso_rsa) {
        throw new Exception("Erro: Falha ao descriptografar a chave simétrica (RSA).");
    }

    $chaveSimetrica_e_IV = json_decode($chaveE_IV_json, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Erro: O JSON da chave simétrica está corrompido.");
    }

    $chaveSimetrica = hex2bin($chaveSimetrica_e_IV['key']);
    $iv = hex2bin($chaveSimetrica_e_IV['iv']);

    $dados_criptografados_binarios = base64_decode($dados_criptografados_base64);

    $dados_json = openssl_decrypt(
        $dados_criptografados_binarios, 'aes-256-cbc', $chaveSimetrica, OPENSSL_RAW_DATA, $iv
    );

    if ($dados_json === false) {
        throw new Exception("Erro: Falha ao descriptografar os dados (AES).");
    }

    $dados = json_decode($dados_json, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Erro: Os dados do formulário estão corrompidos.");
    }

    $nome = $dados["nome"] ?? null;
    $email = $dados["email"] ?? null;
    $senha = $dados["senha"] ?? null;

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    if (empty($nome) || empty($email) || empty($senha)) {
        $retorno["mensagem"] = "Preencha todos os campos!";
        echo json_encode($retorno);
        exit;
    }

    $stmt = mysqli_stmt_init($con);
    $query = "INSERT INTO usuarios (nome, email, senha_hash) VALUES (?, ?, ?)";

    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, 'sss', $nome, $email, $senha_hash);
        
        try {
            $resultado = mysqli_stmt_execute($stmt);

            if ($resultado) {
                $retorno["status"] = "s";
                $retorno["mensagem"] = "Usuário cadastrado com sucesso!";
            } else {
                $retorno["mensagem"] = "Erro desconhecido ao cadastrar.";
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) { $retorno["status"] = "n"; $retorno["mensagem"] = "Este email já está cadastrado. Tente outro.";
            } else {
                
                $retorno["mensagem"] = "Erro de banco de dados: " . $e->getMessage();
            }
        }
        

    } else {
        $retorno["mensagem"] = "Erro na preparação da query.";
    }

    mysqli_stmt_close($stmt);

} catch (Exception $e) {
    $retorno["status"] = "n";
    $retorno["mensagem"] = $e->getMessage();
}

mysqli_close($con);
echo json_encode($retorno);
?>