try {
  //executa
  let x = 5;
  let y = 0;

  if (y == 0) {
    throw "Divisão por 0";
  }
} catch (error) {
  console.log(error);
} finally {
  console.log("FIm");
}

try {
  throw new ErroM();
} catch (e) {
  console.log(e.name);
  console.log(e.message);
}

function ErroM() {
  this.name = "TExtoNAtriabsf";
  this.message = "Textoaaaaaa";
}
