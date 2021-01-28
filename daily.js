function addStrings(num1, num2) {
    var i = num1.length - 1;
    var j = num2.length - 1;
    var carry = 0, sum;
    var ans = [];
    while (i >= 0 || j >= 0) {
        sum = (i >= 0 ? num1[i] : 0) + (j >= 0 ? num2[j] : 0) + carry;
        if (sum >= 10) {
            sum -= 10;
            carry = 1;
        }
        else
            carry = 0;
        ans.push(sum);
        i--;
        j--;
    }
    if (carry)
        ans.push("1");
    return ans.reverse().join("");
}
;
function sayHello() {
    return "Hello\n";
}
/**
 * @param {number} n
 * @return {number}
 */
var concatenatedBinary = function (n) {
    let shift = 0, ans = 0n;
    for (let i = 1; i <= n; ++i) {
        if (((i & (i - 1)) >>> 0) === 0) shift++;
        ans = (((ans << shift) >>> 0) + i) % 1000000007;
    }
    return ans;
};

/**
 * @param {number[]} nums
 * @return {number}
 */
function pivotIndex(nums) {
    let tot = nums.reduce((a, b) => a + b, 0);
    let tmp = 0
    for (let i = 0; i < nums.length; ++i) {
        if (2 * tmp + nums[i] == tot) return i;
        tmp += nums[i];
    }
    return -1;
};

/**
 * @param {string} a
 * @param {string} b
 * @return {number}
 */
var minCharacters = function (a, b) {
    const fA = new Array(26).fill(0);
    const fB = new Array(26).fill(0);
    const fC = new Array(26).fill(0);
    for (let i = 0; i < a.length; ++i)
        fA[a[i].charCodeAt(0) - 97]++;
    for (let i = 0; i < b.length; ++i)
        fB[b[i].charCodeAt(0) - 97]++;
    const c = a + b;
    for (let i = 0; i < c.length; ++i)
        fC[c[i].charCodeAt(0) - 97]++;
    let ans = fC.reduce((a, b) => a + b, 0) - Math.max(...fC);
    for (let i = 1; i < 26; ++i) {
        ans = Math.min(ans, fA.slice(0, i).reduce((a, b) => a + b, 0) + fB.slice(i).reduce((a, b) => a + b, 0));
        ans = Math.min(ans, fB.slice(0, i).reduce((a, b) => a + b, 0) + fA.slice(i).reduce((a, b) => a + b, 0));
    }
    return ans;
};
let nums = [-1, -1, -1, -1, -1, 0];
console.log(minCharacters("dabadd", "cda"));


