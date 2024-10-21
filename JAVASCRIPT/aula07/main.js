// for (let index = 0; index <= 10; index++) {
//   console.log(index);
// }

const cars = ["ferrari", "mercedes", "GM"];

// for (let index = 0; index < cars.length; index++) {
//   console.log(cars[index]);
// }

// for (let car of cars) {
//   console.log(car);
// }

cars.forEach(function name(car, index) {
  console.log(index);
  console.log(car);
});

let index = 1;

while (index < 10) {
  console.log("index menor q 10");
  index++;
}

const pessoa = {
  nome: "jame",
  idade: 23,
};
//aqui ele lê cada uma das propriedades, execução 1 pega e lê o
for (prop in pessoa) {
  console.log(pessoa[prop]);
}
const sum = 1 + 1;
//operador ternários
// Aqui eu uso ? como se fosse um condicional
let number = sum === 2 ? 2 : 4;

//mesma coisa
if (sum === 2) {
  console.log("numero é 2!");
} else if (sum === 4) {
  console.log("numero é 4!");
}
console.log(number);
