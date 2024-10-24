// var p = {};

// p.nome = "Lucas";
// p.idade = 20;
// p.sexo = "M";

// console.log(p);

var pessoa = {
  nome: "Lucas",
  idade: 20,
  sexo: "M",
};

//passa para texto
console.log(JSON.stringify(pessoa));
//String para ojeto JSON
var p = JSON.parse('{"nome":"Lucas","idade":20,"sexo":"M"}');
console.log(p);
// console.log(pessoa);
// //só serie true se var p= pessoa;
// console.log(pessoa === p);
// //assign pode fazer uma cópia mesmo
// var p = Object.assign({}, pessoa);

// delete pessoa.idade;
// console.log(pessoa);

// var pessoa = {
//   nome: "Teste",
//   idade: 12,
//   sexo: "M",
//   showPessoa: () => {
//     console.log(`${pessoa.nome}, ${pessoa.idade}`);
//   },
//   soma: (x, y) => {
//     console.log(x + y);
//   },
//   mat: {
//     primeiro: "1",
//     segundo: "2",
//   },
// };
// pessoa.showPessoa();
// pessoa.soma(5, 6);
