window.addEventListener("load", function(){
    let noche = document.getElementById("noche");
    let luna = document.getElementById("luna");
    let montanas = document.getElementById("montanas");
    let carretera = document.getElementById("carretera");
    let header = document.getElementById("header");
    
    window.addEventListener("scroll", function(){
        var scrollY = window.scrollY
        noche.style.top = scrollY * 0.5 + "px";
        luna.style.left = -scrollY * 0.5 + "px";
        montanas.style.top = -scrollY * 0.15 + "px";
        carretera.style.top = scrollY * 0.15 + "px";
        header.style.top = scrollY * 1.2 + "px";
    });
    
});
