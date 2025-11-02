async function Gravar() {
 
    var form = document.getElementById("cadastro-form");
    var dados = new FormData(form);

    var resposta = await fetch("../php/gravar.php", {
        method: "POST",
        body: dados
    });

    var dados_retorno = await resposta.json();

    alert(dados_retorno.mensagem);

   
    if (dados_retorno.status == "s") {
        window.location.href = "../Login/login.html";
    }
}