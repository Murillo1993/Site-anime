var listaAnimes = [
    { titulo: 'A Sign of Affection', imagem: '../image_romance/a_sign_of_affection.webp' },
    { titulo: 'Kaguya-sama: Love Is War', imagem: '../image_romance/kaguya_sama.jpg' },
    { titulo: 'Mahoutsukai no Yome', imagem: '../image_romance/mahoutsukai-no-yome.webp' },
    { titulo: 'My Dress-Up Darling', imagem: '../image_romance/my_dress_up_darling.jpg' },
    { titulo: 'Nisekoi', imagem: '../image_romance/nisekoi.jpg' },
    { titulo: 'Tomo-chan Is a Girl!', imagem: '../image_romance/tomo_chan_is_a_girl.jpg' },
    { titulo: 'Tonikawa: Over the Moon for You', imagem: '../image_romance/tonikawa.webp' },
    { titulo: 'BEASTARS', imagem: '../image_romance/BEASTARS.jpg' }
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

document.querySelector(".anime-romance").innerHTML += lista;