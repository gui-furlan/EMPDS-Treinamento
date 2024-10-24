// for (let index = 0; index < 100; index++) {
//   const element = index;
//   console.log(element);
// }
// //quando executar o de createImageBitmap, vai pegar e esperar 1 segundo para imprimir o "terminou"

// var timeout = setTimeout(function () {
//   console.log("terminou");
// }, 1000);

// setTimeout(function () {
//   clearTimeout(timeout);
// }, 2 * 1000);

//relogio

var interval = setInterval(() => {
  console.log(new Date());
}, 1 * 1000);

//para não ficar em loop infinito
setTimeout(() => clearInterval(interval), 10 * 1000);
