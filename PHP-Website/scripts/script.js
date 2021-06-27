var hamburger = document.getElementById("hamburger");
var menu_options = document.getElementById("menu_options");

hamburger.addEventListener("click", () => {
    menu_options.classList.toggle("show");
});

