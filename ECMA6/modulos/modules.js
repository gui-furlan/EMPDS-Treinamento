export const PI = math.PI;

export function soma(...params) {
  let s = 0;
  for (let i = 0; i < params.length; i++) {
    s += params[i];
  }
  return s;
}

export function sub(x, y) {
  return x - y;
}

export function msg(msg) {
  console.log(msg);
}
export function infoMgs(msg) {
  console.info(msg);
}
