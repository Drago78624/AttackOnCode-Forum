$(document).ready(function () {
  $(".myTable").DataTable();
});

function openTab(evt, cityName) {
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the link that opened the tab
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

const categoryUpdateModal = document.getElementById("categoryUpdateModal");
const categoryAddModal = document.getElementById("categoryAddModal");
const addCatBtn = document.querySelector(".add-cat-btn");

window.onclick = function (event) {
  if (event.target == categoryUpdateModal) {
    categoryUpdateModal.style.display = "none";
  }else if(event.target == categoryAddModal){
    categoryAddModal.style.display = "none";
  }
};

addCatBtn.addEventListener("click", ()=>{
  categoryAddModal.style.display = "flex"
})

const editBtns = document.querySelectorAll(".dashboard-edit-btn");
const catId = document.querySelector(".cat-id");
const catName = document.querySelector(".cat-name");
const catDesc = document.querySelector(".cat-desc");
const catIconUrl = document.querySelector(".cat-icon-url");

Array.from(editBtns).forEach((editBtn) => {
  editBtn.addEventListener("click", (e) => {
    categoryUpdateModal.style.display = "flex";
    const tr = e.currentTarget.parentElement.parentElement;
    const cat_id = tr.querySelector(".cat_id");
    const cat_name = tr.querySelector(".cat_name");
    const cat_desc = tr.querySelector(".cat_desc");
    const cat_icon_url = tr.querySelector(".cat_icon_url");
    catId.value = cat_id.innerText;
    catName.value = cat_name.innerText;
    catDesc.value = cat_desc.innerText;
    catIconUrl.value = cat_icon_url.innerText;
  });
});