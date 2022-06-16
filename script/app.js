// document.querySelector(".navbar").style.setProperty("--navbar__boxshadow", "0 2px 10px black")

const hamburger = document.querySelector(".navbar__hamburger");
const sideMenu = document.querySelector(".navbar__dropdown-items");
const navbar = document.querySelector(".navbar");

hamburger.addEventListener("click", () => {
  navbar.classList.toggle("side-menu-active");
  hamburger.classList.toggle("showmenu");
});
