
var listaAnimes = [
    { titulo: 'Bleach', imagem: '../image_geral/bleach.webp' },
    { titulo: 'Dragon Ball Z', imagem: '../image_geral/dragon-ball-z.jpg' },
    { titulo: 'Hellsing Ultimate', imagem: '../image_geral/helssing.webp' },
    { titulo: 'Naruto', imagem: '../image_geral/naruto.jpg' },
    { titulo: 'One Punch Man', imagem: '../image_geral/one_punch_man.jpg' },
    { titulo: 'Overlord', imagem: '../image_geral/overlord_poster.jpg' },
    { titulo: 'A Sign of Affection', imagem: '../image_geral/signal_love.jpg' },
    { titulo: 'Solo Leveling', imagem: '../image_geral/solo_leveling.webp' }
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

document.querySelector(".catalogo").innerHTML += lista;