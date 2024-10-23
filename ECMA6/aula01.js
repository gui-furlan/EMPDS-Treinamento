// // isso é pra ES5
// x = 5;
// y = 7;

// // var soma = x + y;

// // console.log(soma);
// // //Para ES6
// // //let e const

// // const PI = 3.14;
// // console.log(PI);

// // var array = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

// // for (let index = 0; index < array.length; index++) {
// //   const element = array[index];
// //   console.log(element);
// // }

// //aula03

// console.log(x + y + " x + y");
// console.log(x ** y + " x ** y"); //exponenciação
// console.log((x % y) + " x % y"); //módulo
// console.log(++x + " ++ x");
// console.log(x + " x++");
// console.log(x + " x");
// console.log(--y + "-- y");
// console.log(y-- + " y--");
// console.log(y + " y");

// //aula 06
// //operadores de atribuição
// var x = 100;
// var y = 5;

// console.log(x);
// x += y;
// console.log(x);
// x /= y;
// console.log(x);
// console.log(-x);

// for in
var pessoa = {
  nome: "lucas",
  idade: 20,
  sexo: "M",
};
var cep = {
  endereco: "Rua Dr.Getúlio Vargas",
  bairro: "Bela Vista",
  cep: "89140-000",
};
// //i é a key
// for (const i in pessoa) {
//   if (pessoa.hasOwnProperty(i)) {
//     const element = pessoa[i];
//     console.log(element);
//   }
// }

//for of
var map = new Map();
map.set("a", 1);
map.set("b", 2);
map.set("c", 3);
map.set("d", 4);

for (const [key, value] of map) {
  console.log(key, value);
}
