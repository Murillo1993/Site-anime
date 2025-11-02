async function Entrar() {
    
    var form = document.getElementById("login-form"); 
    var dados = new FormData(form);

    var resposta = await fetch("../php/login.php", {
        method: "POST",
        body: dados
    });

    var dados_retorno = await resposta.json();

    alert(dados_retorno.mensagem);

    
    if (dados_retorno.status == "s") { 
        alert("Bem-vindo, " + dados_retorno.nome );
        
        window.location.href = "../pagina_principal/index.html"; 
    }
}