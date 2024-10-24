//Strict mode
// "use strict";
pessoa = {
  nome: "Sabrina",
  idade: 12,
  sexo: "f",
};

function maoirIdade(i) {
  "use strict";
  let t = i >= 18;
  return t;
}

console.log(pessoa);
delete pessoa.nome;
console.log(maoirIdade(pessoa.idade));
