async function Gravar(){
    var form = document.getElementById("cadastro-form");

    var dados = new FormData(form);

    var resposta = await fetch("php/gravar.php",{
        method: "POST",
        body : dados
    });

    var dados_retorno = await resposta.json();

    console.log(dados_retorno);
    
}