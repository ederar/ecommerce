window.addEventListener("load", function () {
  let showPassIcon = document.querySelector(".show-pass");
  showPassIcon.addEventListener("mouseover", moseOver);
  showPassIcon.addEventListener("mouseout", moseOut);
});

function moseOver() {
    let passField = document.querySelector(".pass");
    passField.setAttribute("type", "text");
};

function moseOut() {
    let passField = document.querySelector(".pass");
    passField.setAttribute("type", "password");
}


function confirmDelete() {
    let deleteBtn = document.querySelector(".confirm");
    deleteBtn.addEventListener("click", confirmDelete);
    confirm("Are You Sure ?");
}


