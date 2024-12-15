const lines = document.querySelector(".lines");
const navMenu = document.querySelector(".nav-menu");

lines.addEventListener("click", mobileMenu);

function mobileMenu() {
    lines.classList.toggle("active");
    navMenu.classList.toggle("active");
}
const navLink = document.querySelectorAll(".nav-link");

navLink.forEach(n => n.addEventListener("click", closeMenu));

function closeMenu() {
    lines.classList.remove("active");
    navMenu.classList.remove("active");
}