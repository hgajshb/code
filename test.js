var a = { n: 1 };
var b = a;
a.x = a = { n: 2 };
var c = { d: 6 };

//console.log(a.x);
//console.log(b.x);
console.log(c.x);