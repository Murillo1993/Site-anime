
var listaAnimes = [
    { titulo: 'Attack on Titan', imagem: '../image_acao/attack on titan.jpg' },
    { titulo: 'Baki Hanma', imagem: '../image_acao/baki-hanma.jpg' },
    { titulo: 'Chainsaw Man', imagem: '../image_acao/chain_saw_man.jpg' },
    { titulo: 'Cyberpunk', imagem: '../image_acao/cyberpunk.webp' },
    { titulo: 'Evangelion', imagem: '../image_acao/evangelion.webp' },
    { titulo: 'Jujutsu Kaisen', imagem: '../image_acao/jujutsu_kaisen.jpg' },
    { titulo: 'Tokyo Ghoul', imagem: '../image_acao/tokyo_ghoul.jpg' },
    { titulo: 'Dragon Ball Z', imagem: '../image_acao/dragon_ball_z.webp' }
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

document.querySelector(".anime-acao").innerHTML += lista;