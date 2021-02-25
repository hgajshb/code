//import { MinPriorityQueue, MaxPriorityQueue } from '@datastructures-js/priority-queue';
//import { MinPriorityQueue, MaxPriorityQueue } from '@datastructures-js/priority-queue';
const readline = require('readline');
// * Definition for a binary tree node.
function TreeNode(val, left, right) {
    this.val = (val === undefined ? 0 : val)
    this.left = (left === undefined ? null : left)
    this.right = (right === undefined ? null : right)
}

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

/**
 * @param {TreeNode} root
 * @return {number[][]}
 */
var verticalTraversal = function (root) {
    let map = new Array(1002)
    let min = 1002;
    const trav = function (root, off, height, map) {
        if (!root) return;
        map[off][height].push(root.val);
        min = Math.min(root.val);
        trav(root.left, off - 1, height + 1, map);
        trav(root.right, off + 1, height + 1, map);
    }
    trav(root, 0, 0, map);
    for (let i = -1002; i < 1002; ++i) {
        if (map[i]) {
            for (let j = -1002; j < 1002; ++j) {
                if (map[i][j]) {
                    map[i][j].sort((a, b) => a - b);
                }
                //map[i].sort((a, b) => a - b);
            }
        }
    }
    console.log(map);
    return;
};

/**
 * @param {number[]} nums
 * @return {number}
 */
var minimumDeviation = function (nums) {
    const pq = new MaxPriorityQueue();
    let res = 1e9, val, max;
    for (let i = 0; i < nums.length; i++) {
        val = nums[i] % 2 == 0 ? nums[i] : nums[i] * 2;
        pq.enqueue(val, val);
    }
    while (res > 0 && pq.front()['priority'] % 2 == 0) {
        max = pq.dequeue()['priority'];
        pq.enqueue(max / 2, max / 2);
        res = Math.min(res, pq.front()['priority'] - pq.back()['priority']);
    }
    return res;

};

/**
 * @param {number[]} nums
 * @return {number}
 */
var maxSubArray = function (nums) {
    let pre = 0, ans = Number.MIN_SAFE_INTEGER;
    for (let i = 0; i < nums.length; ++i) {
        pre = Math.max(nums[i], pre + nums[i]);
        ans = Math.max(ans, pre);
    }
    return ans;
};

/**
 * @param {number[]} nums
 * @param {number} k
 * @return {number[]}
 */
var medianSlidingWindow = function (nums, k) {
    const ans = []
    let l = 0
    let r = 0
    const arr = []
    const isOdd = k & 1
    while (r < nums.length) {
        insert(arr, nums[r++])
        if (arr.length === k) {
            const mid = k >> 1
            if (isOdd) {
                ans.push(arr[mid])
            } else {
                ans.push((arr[mid] + arr[mid - 1]) / 2)
            }
            remove(arr, nums[l++])
        }
    }
    return ans

    function insert(arr, num) {
        const len = arr.length
        if (len === 0) {
            arr.push(num)
        } else {
            if (arr[0] > num) {
                arr.unshift(num)
            } else if (arr[len - 1] <= num) {
                arr.push(num)
            } else {
                const index = search(arr, num)
                arr.splice(index, 0, num)
            }
        }
    }

    function search(arr, num) {
        let l = 0
        let r = arr.length - 1
        while (l <= r) {
            const mid = (l + r) >> 1
            if (arr[mid] > num) {
                r = mid - 1
            } else if (arr[mid] < num) {
                l = mid + 1
            } else {
                return mid
            }
        }
        return l
    }

    function remove(arr, num) {
        const index = arr.indexOf(num)
        arr.splice(index, 1)
    }
};

/**
 * @param {string} s
 * @param {character} c
 * @return {number[]}
 */
var shortestToChar = function (s, c) {
    const left = new Array(s.length).fill(Number.MAX_SAFE_INTEGER);
    const right = new Array(s.length).fill(Number.MAX_SAFE_INTEGER);
    const ans = new Array(s.length);
    for (let i = 0; i < s.length; ++i) {
        if (s[i] == c) { left[i] = 0; right[i] = 0; }
    }
    for (let i = 0; i < s.length; ++i) {
        if (left[i] == 0) continue;
        if (i - 1 >= 0 && left[i - 1] != Number.MAX_SAFE_INTEGER)
            left[i] = left[i - 1] + 1;
    }
    for (let i = s.length - 1; i >= 0; --i) {
        if (right[i] == 0) continue;
        if (i + 1 < s.length && right[i + 1] != Number.MAX_SAFE_INTEGER)
            right[i] = right[i + 1] + 1;
    }
    for (let i = 0; i < s.length; ++i) {
        ans[i] = Math.min(left[i], right[i]);
    }
    return ans;
};

/**
 * @param {number[]} nums
 * @param {number} goal
 * @return {number}
 */
var minAbsDifference = function (nums, goal) {
    const n = nums.length;
    const lcnt = Math.floor(n / 2);
    const rcnt = n - lcnt;
    const arr1 = new Array(lcnt).fill(0);
    const arr2 = new Array(rcnt).fill(0);
    for (let i = 0; i < lcnt; ++i) {
        for (let j = 0; j < (1 << i); ++j) {
            arr1[j + (1 << i)] = arr1[j] + nums[i];
        }
    }
    for (let i = 0; i < rcnt; ++i) {
        for (let j = 0; j < (1 << i); ++j) {
            arr2[j + (1 << i)] = arr2[j] + nums[lcnt + i];
        }
    }
    let ans = Number.MAX_SAFE_INTEGER;
    for (let i of arr1) ans = Math.min(ans, Math.abs(i - goal));
    for (let i of arr2) ans = Math.min(ans, Math.abs(i - goal));
    let i = 0, j = arr2.length - 1;
    arr1.sort((a, b) => a - b);
    arr2.sort((a, b) => a - b);
    while (i < arr1.length && j >= 0) {
        ans = Math.min(ans, Math.abs(arr1[i] + arr2[j] - goal));
        if (arr1[i] + arr2[j] > goal) j--;
        else i++;
    }
    return ans;
};



let nums = [5, -7, 3, 5], goal = 6
//console.log(minAbsDifference(nums, goal));
let a = "a b c";
let bbb = a.split(" ");
console.log(bbb);
