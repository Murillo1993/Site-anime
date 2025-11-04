<?php

    header('Content-type: text/plain');

    $publickey =  file_get_contents('chaves/publica.pem');

    if($publickey === false){

        header("HTTP/1.1 500 Internal Server Error");
        echo "Erro: Não foi possível ler a chave pública";
    }else{

        echo $publickey;
    }


?>