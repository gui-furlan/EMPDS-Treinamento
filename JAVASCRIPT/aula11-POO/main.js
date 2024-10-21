class Pessoa {
  constructor(nome, sobrenome, idade) {
    this.nome = nome;
    this.sobrenome = sobrenome;
    this.idade = idade;
  }
  getNomeCompleto() {
    console.log(`${this.nome} ${this.sobrenome}`);
  }
  static fala() {
    console.log("Aoba");
  }
}

const pessoa1 = new Pessoa("Lucas", "Rayzer", 20);

pessoa1.getNomeCompleto();
//para chamar staticos, tenho que chamar minha classe, pois não adiciona mais ao objeto, não tenho acesso aos dados de uma pessoa(this.smth)
Pessoa.fala();

//herança
class Animal {
  constructor(nome) {
    this.nome = nome;
  }

  speak() {
    console.log(`${this.nome} faz barulho!`);
  }
}
class Gato extends Animal {
  constructor(nome) {
    super(nome);
  }
  speak() {
    console.log(`${this.nome} mia!`);
  }
}
const animal = new Animal("Miminha");
const mimao = new Gato("Mimao");

console.log(animal);
animal.speak();

mimao.speak();
