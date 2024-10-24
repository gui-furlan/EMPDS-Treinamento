//lista encadeada
var vetor = [1, 2, 3, 4, 5, 6, 7];
var array = new Array(1, 2, 3, 4, 5);

console.log(typeof vetor, typeof array);
vetor.push(12);
vetor.push(14);
vetor.push(18);

console.log(vetor);

//posso ter vários tipos de variáveis dentro de um só vetor pra versão 5
// var nomes = ["lucas", 1, true, { a: "teste", b: [1, 2, 3, 4, 5] }];

for (const key in nomes) {
  if (nomes.hasOwnProperty.call(nomes, key)) {
    const element = nomes[key];
    console.log(element);
  }
}

//version 6

// var nomes = ["Lucas", "André", "João", "Guilherme", "Isabela"];
// var idades = [23, 23, 21, 24, 19];

// console.log(
//   //transofrma em string, se não passo nenhum separador de meu gosto, eu pego o separador padrão,
//   nomes.join(),
//   nomes.join("-"),
//   [1, 2, 3, 4, "adsdad"].join(",")
// );

// //juntando 2 vetores
// console.log(nomes.concat(idades), idades.concat(nomes));

// // DE onde começo, quantos itens quero remover, o que vou add
// nomes.splice(x, y, "z");

// // console.log(nomes);
// // var n = nomes.splice(2, 02, "Luiz");

// // console.log(n, nomes);

// nomes.forEach((element) => {
//   console.log(element);
// });
//passa uma função e ele tem os parametros, valor, indice e array, por exemplo se todas as idades dentro de um array forem maiores q 19, retorna true

var nomes = ["Lucas", "André", "João", "Guilherme", "Isabela"];
var idades = [23, 23, 21, 24, 19];
// var idades = idades.every(function (v, i, array) {
//   return v >= 19;
// });
// console.log(idades);

var n = idades.filter(function (v, i, array) {
  return v > 21;
});

console.log(n);
//reduce vai de 2 em 2
var p = idades.reduce(function (a, b) {
  return a - b;
});
console.log(p);

//reduceRight percorre ao contrário
var p = idades.reduceRight(function (a, b) {
  return a - b;
});
console.log(p);

var t = idades.some(function (v, i) {
  return idades < 21;
});

console.log(t);
