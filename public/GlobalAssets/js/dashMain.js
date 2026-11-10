import { Suggester } from "./Components/Suggester/Suggester.js";

// Inicializamos el ML de Suggester 
export const sugInstiator = new Suggester();
sugInstiator.init(document.querySelectorAll("span[data-text]")); 

// Añadimos comportamiento al menú lateral
const hamburgerIcon = document.getElementById("openMenu");
const crossIcon = document.getElementById("closeMenu");
const nav = document.getElementById("leftNav");

hamburgerIcon.addEventListener("click", () => {

            crossIcon.style.display = "block";
            hamburgerIcon.style.visibility = "hidden";
            nav.classList.add("open");
            document.body.style.overflowX = "hidden";

});

crossIcon.addEventListener("click", () => {

            crossIcon.style.display = "none";
            hamburgerIcon.style.visibility = "visible";
            nav.classList.remove("open");
            document.body.style.overflowX = "visible";
});