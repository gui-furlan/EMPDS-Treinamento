// Situação de Encadeamento -> Callback from HELL

fazAlgo1(function (primeiroResulto) {
  fazAlgo2(
    primeiroResulto,
    function (segundoResultado) {
      fazAlgo3(
        segundoResultado,
        function (terceiroResultado) {
          console.log("Ufa chegou no fim: " + terceiroResultado);
        },
        erroCallback
      );
    },
    erroCallback
  );
}, erroCallback);

// melhor escrito no ES6
fazAlgo1()
  .then(function (primeiroResulto) {
    return fazAlgo2(primeiroResulto);
  })
  .then(function (segundoResultado) {
    return fazAlgo3(segundoResultado);
  })
  .then(function (terceiroResultado) {
    console.log("Ufa chegou no fim:" + "terceiroResultado");
  });
//ainda posso reduzir
fazAlgo1()
  .then((primeiroResulto) => fazAlgo2(primeiroResulto))
  .then((segundoResultado) => fazAlgo3(segundoResultado))
  .then((terceiroResultado) => {
    console.log("Acabou" + terceiroResultado);
  })
  .catch(erroCallback);
