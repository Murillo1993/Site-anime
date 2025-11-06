async function Gravar() {
    try {
        const resposta_chave_publica = await fetch('../php/get_public_key.php');

        if (!resposta_chave_publica.ok) {


            throw new Error('Falha ao buscar a chave pública.');
        }
        const chave_publica = await resposta_chave_publica.text(); 

        var form = document.getElementById("cadastro-form");

        var dados_form = new FormData(form);

        var valores = {};
        dados_form.forEach((value, key) => {


            valores[key] = value;
        });
        
        const valores_string = JSON.stringify(valores);

        const chave_aes = CryptoJS.lib.WordArray.random(32); 


        const iv = CryptoJS.lib.WordArray.random(16); 

        const mensagem_criptografada = CryptoJS.AES.encrypt(valores_string, chave_aes, {
            iv: iv,
            mode: CryptoJS.mode.CBC,
            padding: CryptoJS.pad.Pkcs7
        }).toString();

        var criptografia_rsa = new JSEncrypt(); 

        criptografia_rsa.setPublicKey(chave_publica);

        const chave_aes_hex = CryptoJS.enc.Hex.stringify(chave_aes);

        const iv_hex = CryptoJS.enc.Hex.stringify(iv);

        const pacote_chave_json = JSON.stringify({ key: chave_aes_hex, iv: iv_hex });
        
        const chave_aes_criptografada = criptografia_rsa.encrypt(pacote_chave_json);

        var envio_final = new FormData();

        envio_final.append('mensagem_criptografada', mensagem_criptografada);
        
        envio_final.append('chave_criptografada', chave_aes_criptografada);

        var resposta = await fetch("../php/gravar.php", {
            method: "POST",
            body: envio_final 
        });

        var retorno_php = await resposta.json();

        alert(retorno_php.mensagem);

        if (retorno_php.status == "s") {
            window.location.href = "/Site-anime/Site-anime/Login/login.html"; 
        }

    } catch (error) {
        console.error("Erro no cadastro:", error);
        alert("Ocorreu um erro grave no cadastro: " + error.message);
    }
}