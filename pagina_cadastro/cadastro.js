async function Gravar() {
    try {
        const responseChave = await fetch('../php/get_public_key.php');
        if (!responseChave.ok) {
            throw new Error('Falha ao buscar a chave pública.');
        }
        const publicKey = await responseChave.text();

        var form = document.getElementById("cadastro-form");
        var dados = new FormData(form);

        var dadosObjeto = {};
        dados.forEach((value, key) => {
            dadosObjeto[key] = value;
        });
        
        const dadosString = JSON.stringify(dadosObjeto);

        const chaveSimetrica = CryptoJS.lib.WordArray.random(32); 
        const iv = CryptoJS.lib.WordArray.random(16); 

        const dadosCriptografados = CryptoJS.AES.encrypt(dadosString, chaveSimetrica, {
            iv: iv, mode: CryptoJS.mode.CBC, padding: CryptoJS.pad.Pkcs7
        }).toString();

        const encryptRSA = new JSEncrypt();
        encryptRSA.setPublicKey(publicKey);

        const chaveSimetricaHex = CryptoJS.enc.Hex.stringify(chaveSimetrica);
        const ivHex = CryptoJS.enc.Hex.stringify(iv);
        const chaveE_IV = JSON.stringify({ key: chaveSimetricaHex, iv: ivHex });
        
        const chaveCriptografada = encryptRSA.encrypt(chaveE_IV);
        if (chaveCriptografada === false) {
            throw new Error('Falha ao criptografar a chave simétrica com RSA.');
        }

        var formDataFinal = new FormData();
        formDataFinal.append('dados_criptografados', dadosCriptografados);
        formDataFinal.append('chave_criptografada', chaveCriptografada);

        var resposta = await fetch("../php/gravar.php", {
            method: "POST",
            body: formDataFinal
        });

        var dados_retorno = await resposta.json();

        alert(dados_retorno.mensagem);

        if (dados_retorno.status == "s") {
      
            window.location.href = "../Login/login.html";
        }

    } catch (error) {
        console.error("Erro no processo de cadastro:", error);
        alert("Ocorreu um erro grave no cadastro: " + error.message);
    }
}