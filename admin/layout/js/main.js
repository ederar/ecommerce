let passField = document.querySelector('.pass');
let showPassIcon = document.querySelector('.show-pass');


showPassIcon.addEventListener("mouseover", function () {
    passField.setAttribute('type','text');
});

showPassIcon.addEventListener("mouseout", function () {
    passField.setAttribute('type','password');
});

