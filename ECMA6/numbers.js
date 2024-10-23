var x = 4;
var y = new Number("7");

console.log(
  Number.MAX_SAFE_INTEGER,
  Number.MIN_SAFE_INTEGER,
  Number.NaN,
  isNaN(5.6),
  isNaN("asd")
);
var w = 15.1241241;
console.log(
  x.toExponential(4),
  //passa pra string e pega x casas depois da vírgula
  w.toFixed(3),
  //quantas casas pega, seja anets ou depois da vírgula
  w.toPrecision(2)
);
