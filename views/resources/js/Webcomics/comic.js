window.onload = function () {
    let titre = document.getElementById("title").getAttribute("value");
    console.log(titre);

    var taille = titre.length*12+40;

    document.getElementById("title").style.width = taille + "px";
}