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

  const LastName = submitLastName.value;

  const email = submitEmail.value;

  const message = submitMessage.value;

  if (FirstName !== "" && LastName !== "" && email !== "" && message !== "") {
    errorMsg.textContent = "";
    console.log(FirstName);
    console.log(LastName);
    console.log(email);
    console.log(message);
  } else {
    errorMsg.textContent = "Por favor, preencha todos os campos!";
    errorMsg.classList = "error";
  }
});
