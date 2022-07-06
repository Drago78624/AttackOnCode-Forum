const hamburger = document.querySelector(".navbar__hamburger");
const sideMenu = document.querySelector(".navbar__dropdown-items");
const navbar = document.querySelector(".navbar");
const navbarForm = document.querySelector(".navbar__form");
const searchIcon = document.querySelector(".navbar__search-icon");
const heroBtn = document.querySelector(".hero-btn");
const closeIcon = document.querySelector(".close-icon");
const alertBox = document.querySelector(".alert-box");
const like = document.querySelector(".like");
const dislike = document.querySelector(".dislike");

hamburger.addEventListener("click", () => {
  navbar.classList.toggle("side-menu-active");
  hamburger.classList.toggle("showmenu");
});



searchIcon.addEventListener("click", ()=>{
  navbarForm.submit()
  console.log("submitted");
})

// setTimeout(() => {
//   alertBox.remove()
// }, 3000);

closeIcon.addEventListener("click", ()=>{
  alertBox.remove();
})


heroBtn.addEventListener("mouseover", (e) => {
  const x = e.pageX - heroBtn.offsetLeft;
  const y = e.pageY - heroBtn.offsetTop;
  console.log(x, y);

  heroBtn.style.setProperty("--posX", x + "px");
  heroBtn.style.setProperty("--posY", y + "px");
});
