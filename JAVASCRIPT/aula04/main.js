//objetos
const pessoa = {
  name: "Lucas",
  sobreNome: "Rayzer",
  idade: "21",
  hobbies: ["assistir F1", "Jogar", "ler"],
  gato: {
    nome: "mimao",
    idade: 4,
  },
};

// const nome = pessoa.name;
// const sobreNome = pessoa.sobreNome;
// const idade = pessoa.idade;
// const hobbies = pessoa.hobbies;

//mesmo que acima, nome está sendo renomeado ali abaixo
const { name: primeiroNome, sobreNome, idade, hobbies } = pessoa;

const jogar = pessoa.hobbies[1];
console.log(jogar);
console.log(primeiroNome);
console.log(sobreNome);
console.log(idade);
console.log(hobbies);

//pessoa.gato = "mimão";

console.log(pessoa);
console.log(pessoa.gato.nome);

const toDO = [
  {
    id: 1,
    descricao: "Estudar",
    completed: false,
  },
  {
    id: 2,
    descricao: "Trabalhar",
    completed: true,
  },
  {
    id: 3,
    descricao: "Treinar",
    completed: false,
  },
];

const descricaoToDo = toDO[2].descricao;

console.log(descricaoToDo);

const toDoJSON = JSON.stringify(toDO);

console.log(toDoJSON);

const toDoList = JSON.parse(toDoJSON);

console.log(toDoList);
