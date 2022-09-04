$(document).ready(function () {
  $(".myTable").DataTable();
});

const sidebar = document.querySelector(".sidebar")

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
  sidebar.classList.remove("active")
}

const categoryUpdateModal = document.getElementById("categoryUpdateModal");
const commentUpdateModal = document.getElementById("commentUpdateModal");
const threadUpdateModal = document.getElementById("threadUpdateModal");
const userUpdateModal = document.getElementById("userUpdateModal");
const categoryAddModal = document.getElementById("categoryAddModal");
const commentAddModal = document.getElementById("commentAddModal");
const userAddModal = document.getElementById("userAddModal");
const addCatBtn = document.querySelector(".add-cat-btn");
const addComBtn = document.querySelector(".add-com-btn");
const addThreadBtn = document.querySelector(".add-thread-btn");
const addUserBtn = document.querySelector(".add-user-btn");

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
  if (event.target == threadUpdateModal) {
    threadUpdateModal.style.display = "none";
  }else if(event.target == threadAddModal){
    threadAddModal.style.display = "none";
  }
  if (event.target == userUpdateModal) {
    userUpdateModal.style.display = "none";
  }else if(event.target == userAddModal){
    userAddModal.style.display = "none";
  }
};

addCatBtn.addEventListener("click", ()=>{
  categoryAddModal.style.display = "flex"
})

addComBtn.addEventListener("click", ()=>{
  commentAddModal.style.display = "flex"
})

addThreadBtn.addEventListener("click", ()=>{
  threadAddModal.style.display = "flex"
})

addUserBtn.addEventListener("click", ()=>{
  userAddModal.style.display = "flex"
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
const threadId = document.querySelector(".thread-id");
const threadTitle = document.querySelector(".thread-title");
const threadDesc = document.querySelector(".thread-desc");
const threadCode = document.querySelector(".thread-code");
const threadCategoryId = document.querySelector(".thread-category-id");
const threadUserId = document.querySelector(".thread-user-id");
const userId = document.querySelector(".user-id");
const userName = document.querySelector(".user-name");
const userEmail = document.querySelector(".user-email");
const userStatus = document.querySelector(".user-status");
const userType = document.querySelector(".user-type");


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
    }else if(tr.classList.contains("thread-row")){
      threadUpdateModal.style.display = "flex";
      const thread_id = tr.querySelector(".thread_id");
      const thread_title = tr.querySelector(".thread_title");
      const thread_desc = tr.querySelector(".thread_desc");
      const thread_code = tr.querySelector(".thread_code");
      const thread_category_id = tr.querySelector(".thread_category_id");
      const thread_user_id = tr.querySelector(".thread_user_id");
      threadId.value = thread_id.innerText;
      threadTitle.value = thread_title.innerText;
      threadDesc.value = thread_desc.innerText;
      threadCode.value = thread_code.innerText;
      threadCategoryId.value = thread_category_id.innerText;
      threadUserId.value = thread_user_id.innerText;
    }else if(tr.classList.contains("user-row")){
      userUpdateModal.style.display = "flex";
      const user_id = tr.querySelector(".user_id");
      const user_name = tr.querySelector(".user_name");
      const user_email = tr.querySelector(".user_email");
      const user_status = tr.querySelector(".user_status");
      const user_type = tr.querySelector(".user_type");
      userId.value = user_id.innerText;
      userName.value = user_name.innerText;
      userEmail.value = user_email.innerText;
      userStatus.value = user_status.innerText;
      userType.value = user_type.innerText;
    }
  });
});

const sidebarBtn = document.querySelector(".sidebar-btn")


sidebarBtn.addEventListener("click", ()=>{
  sidebar.classList.toggle("active")
})
