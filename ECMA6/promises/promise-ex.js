var fazAlgo1 = function () {
  return new Promise(function (resolve, reject) {
    setTimeout(() => {
      resolve(Math.round(Math.random() * 100));
    }, 1000);
  });
};
var fazAlgo2 = function (numero) {
  return new Promise(function (resolve, reject) {
    setTimeout(function () {
      resolve(numero * 5);
    }, 2000);
  });
};
var fazAlgo3 = function (numero) {
  return new Promise(function (resolve, reject) {
    setTimeout(function () {
      resolve(numero * 2);
    }, 1500);
  });
};

function erroCallBAck(error) {
  console.error(`Deu ruim: ${error}`);
}

//assincrono aqui, faz o mesmo que acima
fazAlgo1()
  .then(function (n1) {
    console.log(n1);
    return fazAlgo2(n1);
  })
  .then(function (n2) {
    console.log(n2);
    return fazAlgo3(n2);
  })
  .then(function (n3) {
    console.log(n3);
  })
  .catch(erroCallBAck);
