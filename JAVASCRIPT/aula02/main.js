
const names = ['Felipe','João', 'Lucas', 10, false];
names.pop();
names.pop();


const joao = names[1];


console.log(joao);
console.log(names);
names.push("Rayzer");
console.log(names);
//adiciona o 20 no inicio, shift remove do inicio, pop remove
names.unshift(20);
console.log(names);



names[1] = 'Guigas';
console.log(names);

const namesArray = Array.isArray(names);

const indexOfLucas = names.indexOf('Lucas');

const sortedNames = names.sort()
console.log(sortedNames)
console.log(namesArray);
