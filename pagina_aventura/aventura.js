
var listaAnimes = [
    { titulo: 'Ajin', imagem: '../image_aventura/ajin.jpg' },
    { titulo: 'Angels of Death', imagem: '../image_aventura/angels_of_death.jpg' },
    { titulo: 'Cowboy Bebop', imagem: '../image_aventura/cowboy-bebop.jpg' },
    { titulo: 'Dr. Stone', imagem: '../image_aventura/Dr_stone_.jpg' },
    { titulo: 'Full Metal Alchemist', imagem: '../image_aventura/full_metal_alchemist.webp' },
    { titulo: 'Kill la Kill', imagem: '../image_aventura/killlakill.jpg' },
    { titulo: 'One Piece', imagem: '../image_aventura/one_piece.jpg' },
    { titulo: 'Parasyte', imagem: '../image_aventura/parasyte.jpg' }
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

document.querySelector(".anime-aventura").innerHTML += lista;