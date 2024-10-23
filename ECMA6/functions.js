function soma(x, y) {
  return x + y;
}
//soma(1, 23);
var result = soma(8, 9);
console.log(result);

//função anonima/lambda, preciso declarar em uma variável
var soma = function (x, y) {
  return x + y;
};

var button = document.getElementById("btn");
button.onclick = function (e) {
  e.preventDefault();
};

//aula 11 lambda e arrow

var showMessage = (x) => {
  console.log(x);
};
showMessage("Hello World!, Arrow Functions");
//encapsulamento
(function (x, y) {
  console.log(x, y);
})(19, 67);

//reduzindo
var somaArray = ((...params) => {
  var s = 0;
  for (let index = 0; index < params.length; index++) {
    const element = params[index];
    s += element;
  }
  return s;
})(10, 7);

console.log(somaArray);
//functions final
//função geradora

function* arcoIris() {
  yield "azul";
  yield "amarelo";
  yield "vermelho";
}
function* pgt() {
  const nome = yield "Qual seu nome?";
  const idade = yield "Qual sua idade?";
  const altura = yield "Qual su altura?";
  return `Nome: ${nome}, idade: ${idade}, altura: ${altura}`;
}

for (const iterator of pgt()) {
  console.log(iterator);
}
