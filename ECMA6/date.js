var d1 = new Date();
var d2 = new Date(2024, 9, 24);
//comm hora
var d3 = new Date(2024, 9, 24, 3, 39, 5);
//passando string
var d4 = new Date("2024-09-01T15:43:00.000z");
console.log(
  d1.getFullYear(),
  d1.getDate(),
  d1.getDay(),
  d1.getMonth(),
  d1.getHours(),
  d1.getMinutes(),
  d1.getSeconds()
);
console.log(d2);
console.log(d3);
console.log(d4);

console.log(
  d1.toLocaleDateString(),
  d1.toDateString(),
  d1.toTimeString(),
  d1.toLocaleTimeString()
);
