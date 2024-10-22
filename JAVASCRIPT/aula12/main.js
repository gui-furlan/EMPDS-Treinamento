//SELECIONANDO UM ELEMENTO

/*
//a referencia do elemento
const addUserText = document.getElementById("add-user");
console.log(addUserText);
//vai aparecer no console <h1 id="add-user">Add user</h1>

//alterar o elemento 'Add User para Adicionar usuário'
addUserText.innerText = "Adicionar usuário";
*/

//seleciona o elemento em si | mais atual | por id usa #
const addUserText = document.querySelector("#add-user");
console.log(addUserText);
//console: h1#add-user

//alterar o elemento 'Add User para Adicionar usuário'
addUserText.textContent = "Adicionar usuário";

//dentro do formulário
//pegar id my form dentro da classe container
const myForm = document.querySelector("#my-form");
console.log(myForm);

//SELECIONA UM ELEMENTO - 1 ITEM
//const myForm = document.querySelector(".item");

//SELECIONAR MÚLTIPLOS ELEMENTOS

/*
const allItems = document.querySelectorAll(".item");
//console.log(allItems);
*/

//seleciona o item na posição 1
//console.log(allItems[1]);

/*
//ou
const allItems = document.querySelectorAll(".tems .item");
console.log(allItems);
*/

//deletando
const items = document.querySelector(".items");

//items.remove(items);

//items.firstElementChild.remove();

// items.children[1].textContent = "item TEste";
//injeção de html pelo js
// items.lastElementChild.innerHTML = "<h1>Alou</h1>";

//consigo alterar css por aqui também
const button = document.querySelector(".btn");

button.style.background = "red";

//evento aula 14

const submitBtn = document.querySelector("#submit-button");
const submitName = document.querySelector("#name");
const submitEmail = document.querySelector("#email");

submitBtn.addEventListener("click", function click(e) {
  //impedir comportamento padrão, que é enviar o submit e atualizar a página, posso usar pra teste
  e.preventDefault();
  const valorNome = submitName.value;
  const valorEmail = submitEmail.value;

  if (valorNome === "" || valorEmail === "") {
    alert("Preencha todos os campos!");
  }
  if (valorNome !== "" && valorEmail !== "") {
    items.children[0].textContent = valorNome;
    items.children[1].textContent = valorEmail;
  }
  console.log(valorNome);
  console.log(valorEmail);
  myForm.style.background = "lightBlue";
});
