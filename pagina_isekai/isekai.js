var listaAnimes = [
    { titulo: 'Arifureta Shokugyou', imagem: '../image_isekai/arifureta_shokugyou.jpg' },
    { titulo: 'Drifters', imagem: '../image_isekai/drifters.jpg' },
    { titulo: 'Gate: Jieitai', imagem: '../image_isekai/gate_jietai.webp' },
    { titulo: 'KonoSuba', imagem: '../image_isekai/konosuba.jpg' },
    { titulo: 'Mushoku Tensei', imagem: '../image_isekai/mushoku_tensei.jpg' },
    { titulo: 'Overlord', imagem: '../image_isekai/overlord.jpg' },
    { titulo: 'Tate no Yuusha', imagem: '../image_isekai/tate_no_yuusha.jpg' },
    { titulo: 'Tensei Shitara Slime Datta Ken', imagem: '../image_isekai/tensei_shitara_no_slime_datta_ken.webp' }
];

var lista = ""; 


for (var i = 0; i < listaAnimes.length; i++) {
    var anime = listaAnimes[i]; 

    lista += `
        <div class="item-anime">
            <div class="capa-anime">
                <img class="anime-imagem" src="${anime.imagem}" alt="${anime.titulo}">
            </div>
            <p class="titulo-anime">${anime.titulo}</p>
        </div>
    `;
}

document.querySelector(".anime-isekai").innerHTML += lista;