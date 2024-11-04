exports.soma = (x, y) => {
  let verificaNumNeg = () => {
    return x < 0 || y < 0;
  };

  //função de if else
  var p = new Promise(function (resolve, reject) {
    if (verificaNumNeg()) {
      reject(Error("não permitido números negativos."));
    }
    resolve(x + y);
  });
  return p;
};
