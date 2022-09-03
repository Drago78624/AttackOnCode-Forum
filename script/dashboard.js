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
const commentUpdateModal = document.getElementById("commentUpdateModal");
const categoryAddModal = document.getElementById("categoryAddModal");
const commentAddModal = document.getElementById("commentAddModal");
const addCatBtn = document.querySelector(".add-cat-btn");
const addComBtn = document.querySelector(".add-com-btn");

window.onclick = function (event) {
  if (event.target == categoryUpdateModal) {
    categoryUpdateModal.style.display = "none";
  }else if(event.target == categoryAddModal){
    categoryAddModal.style.display = "none";
  }
  if (event.target == commentUpdateModal) {
    commentUpdateModal.style.display = "none";
  }else if(event.target == commentAddModal){
    commentAddModal.style.display = "none";
  }
};

addCatBtn.addEventListener("click", ()=>{
  categoryAddModal.style.display = "flex"
})

addComBtn.addEventListener("click", ()=>{
  commentAddModal.style.display = "flex"
})

const editBtns = document.querySelectorAll(".dashboard-edit-btn");
const catId = document.querySelector(".cat-id");
const catName = document.querySelector(".cat-name");
const catDesc = document.querySelector(".cat-desc");
const catIconUrl = document.querySelector(".cat-icon-url");
const comId = document.querySelector(".com-id");
const comContent = document.querySelector(".com-content");
const comCode = document.querySelector(".com-code");
const comThreadId = document.querySelector(".com-thread-id");
const comUserId = document.querySelector(".com-user-id");

Array.from(editBtns).forEach((editBtn) => {
  editBtn.addEventListener("click", (e) => {
    const tr = e.currentTarget.parentElement.parentElement;
    if(tr.classList.contains("category-row")){
      categoryUpdateModal.style.display = "flex";
      const cat_id = tr.querySelector(".cat_id");
      const cat_name = tr.querySelector(".cat_name");
      const cat_desc = tr.querySelector(".cat_desc");
      const cat_icon_url = tr.querySelector(".cat_icon_url");
      catId.value = cat_id.innerText;
      catName.value = cat_name.innerText;
      catDesc.value = cat_desc.innerText;
      catIconUrl.value = cat_icon_url.innerText;
    }else if(tr.classList.contains("comment-row")){
      commentUpdateModal.style.display = "flex";
      const com_id = tr.querySelector(".com_id");
      const com_content = tr.querySelector(".com_content");
      const com_code = tr.querySelector(".com_code");
      const com_thread_id = tr.querySelector(".com_thread_id");
      const com_user_id = tr.querySelector(".com_user_id");
      comId.value = com_id.innerText;
      comContent.value = com_content.innerText;
      comCode.value = com_code.innerText;
      comThreadId.value = com_thread_id.innerText;
      comUserId.value = com_user_id.innerText;
    }
  });
});
