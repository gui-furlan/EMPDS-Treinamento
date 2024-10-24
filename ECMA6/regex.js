var cepPattern = /[0-9]{5}-[0-9]{3}/g;
//para pegar todos uso o "g", para global
//para configuração de regex posso passar assim:
//
// /[num-num][letraminuscula-letraminuscula][LETRA-LETRA][letras][LETRAS]/
// \d é de digito \D é para não numérico \w é para texto, vem de word (a-z, A-Z, _, 0-9), todos os não caracteres \W
var texto =
  "Meu texto tem cep: 12343-999 e finaliza <b>aqui</b>! Novo cep: 98765-321";

console.log(
  //ver se tem cep nesse texto
  cepPattern.test(texto),
  //mesma coisa que o debaixo, mas pra texto
  texto.match(cepPattern),
  //expressão regular, então busca e vê se tem na expressão regular
  cepPattern.exec(texto)
);
