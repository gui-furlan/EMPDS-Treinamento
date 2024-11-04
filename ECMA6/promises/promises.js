var calc = require("./soma");

console.log("Executa Soma");
calc
  .soma(89, 213)
  .then(function (res) {
    console.log("soma é " + res);
  })
  .catch(function (err) {
    console.error(err);
  });
