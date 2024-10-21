const numbers = [1, 2, 3, 4, 5];
//multiplico todos os meus números por 2

const numberMul2 = numbers.map(function firstF(number) {
  return number * 2;
});
console.log(numberMul2);

const idades = [8, 13, 25, 34, 45, 12];

// const idadesPares = idades.filter(function filter(idades) {
//   return idades % 2 === 0;
// });
// console.log(idadesPares);

// accumulator é o valor atual da soma
const somaIdades = idades.reduce(function soma(idades, accumulator) {
  return accumulator + idades;
  //retorno zerado pra começar
}, 0);

console.log(somaIdades);
