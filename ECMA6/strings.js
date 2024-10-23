var msg = "teste";
var msg2 = "teste dois";
console.log(msg.charAt(3));
console.log(msg.replace("e", "u"));
console.log(msg.replace(/e/g, "toa"));
console.log(msg.concat(" ", msg2));

console.log(msg.toLocaleLowerCase(), msg.toLocaleUpperCase());

console.log(msg.valueOf());

console.log(msg.substring(2));
//posso editar tags html por aqui
console.log(
  msg.bold(),
  msg2.big().sub().fontcolor("red"),
  msg.startsWith("Tes"),
  msg.endsWith("is")
);
//criação de formatação de String personalizada, essa abaixo por ex, deixa a primeira letra maiuscula
String.prototype.capitalize = function () {
  return (
    this.charAt(0).toUpperCase() + this.substring(1, this.length).toLowerCase()
  );
};
var msg = "teste";
console.log(msg.capitalize());
