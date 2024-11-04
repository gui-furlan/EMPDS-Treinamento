//em ES5
var Pessoa =
  //construtor
  function (nome, idade, sexo, altura) {
    //privates tem que ser nomes diferentes do que passo no constructor
    var alt = altura;

    //public
    this.nome = nome;
    this.idade = idade;
    this.sexo = sexo;

    //get set
    this.setNome = function name(name) {
      this.nome = name;
    };
    this.setIdade = (idade) => (this.idade = idade);
    this.setSexo = (sexo) => (this.sexo = sexo);
    //não uso this para private
    this.setAltura = (altura) => (alt = altura);

    this.getNome = function name(name) {
      this.nome;
    };
    this.getIdade = () => this.idade;
    this.getSexo = () => this.sexo;
    this.getAltura = () => alt;

    //methods
    this.mostrAPessoa = () => {
      return `${this.nome},${this.idade},${this.sexo}, ${alt}`;
    };
  };

var p = new Pessoa();
p.setIdade(21);
p.setNome("Lucas");
p.setSexo("M");
p.setAltura(1.7);
console.log(p.mostrAPessoa());
//Em ES6

class Triangulo {
  constructor(base, altura) {
    this.base = base;
    this.altura = altura;
  }
}

let t = new Triangulo(5, 2);
console.log(t.altura, t.base);

//expressão de classe
var trian = class {
  constructor(base, altura) {
    this.base = base;
    this.altura = altura;
  }
};
let tr = new Triangulo(5, 2);

//metódos staticos, vira método da classe
