function sucessoCallback(result) {
  console.log("Suceso: " + result);
}
function erroCallback(error) {
  console.log("Falha " + error);
}
fazAlgumaCoisa(sucessoCallback, erroCallback);

fazAlgumaCoisa(
  function (result) {
    console.log("Suceso: " + result);
  },
  function (error) {
    console.log("Falha " + error);
  }
);
// pode ser melhor escrita assim, oq está logo cima
const promise = fazAlgumaCoisa();
promise.then(sucessoCallback, erroCallback);

// ou;
fazAlgumaCoisa().then(sucessoCallback, erroCallback);
