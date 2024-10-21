//string vazias e 0, null e undefined sempre serão false
const x = "";

console.log(!!x);

const list = [];
//listas vazias e object sempre serão true
console.log(!!list);
//! sozinha inverte o booleano
console.log(!list);

//funções
function soma(a, b = 13) {
  return a + b;
}

const somaValor = soma(10);

console.log(somaValor);

//arrow function, é a mesma coisa
const somaArrow = (a, b) => {
  return a + b;
};

const valorSoma = somaArrow(10, 15);
console.log(valorSoma);
