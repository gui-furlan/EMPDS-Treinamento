const submitBtn = document.querySelector("#submit-button");
const submitFirstName = document.querySelector("#first-name");
const submitLastName = document.querySelector("#last-name");
const submitEmail = document.querySelector("#e-mail");
const submitMessage = document.querySelector("#message");
const myForm = document.querySelector("#my-form");
const errorMsg = document.querySelector(".error-msg");

submitBtn.addEventListener("click", (e) => {
  e.preventDefault();

  const FirstName = submitFirstName.value;
  console.log(FirstName);
  const LastName = submitLastName.value;
  console.log(LastName);
  const email = submitEmail.value;
  console.log(email);
  const message = submitMessage.value;
  console.log(message);

  if (FirstName === "" || LastName === "" || email === "" || message === "") {
    errorMsg.textContent = "Por favor, preencha todos os campos!";
    errorMsg.classList = "error";
  } else errorMsg.textContent = "";
});
