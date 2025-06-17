export function showPassword() {
  const buttonShowPassword = document.querySelector(".button-show-password");
  const input = buttonShowPassword.previousElementSibling;

  buttonShowPassword.addEventListener("click", () => {
    if (input.type == "password") {
      input.type = 'text';
    } else {
      input.type = "password";
    }
  })
}

