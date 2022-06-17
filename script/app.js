const hamburger = document.querySelector(".navbar__hamburger");
const sideMenu = document.querySelector(".navbar__dropdown-items");
const navbar = document.querySelector(".navbar");
const heroBtn = document.querySelector(".hero-btn");

hamburger.addEventListener("click", () => {
  navbar.classList.toggle("side-menu-active");
  hamburger.classList.toggle("showmenu");
});

heroBtn.addEventListener("mouseover", (e) => {
  const x = e.pageX - heroBtn.offsetLeft;
  const y = e.pageY - heroBtn.offsetTop;
  console.log(x, y);

  heroBtn.style.setProperty("--posX", x + "px");
  heroBtn.style.setProperty("--posY", y + "px");
});
