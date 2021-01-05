
import _ from "lodash";
import { MinPriorityQueue, MaxPriorityQueue } from '@datastructures-js/priority-queue';

/**
 * @param {number[]} coins
 * @return {number}
 */
var minCount = function (coins) {
    // ans = 0;
    // for (const coin of coins) {
    //     ans += parseInt(coin / 2) + coin % 2;
    // }
    // return ans;
    return coins.reduce((acc, cur) => acc += Math.ceil(cur / 2));
    //return coins.map(item => Math.ceil(item / 2)).reduce((a, b) => a + b);
    //var arr = coins.map(item => Math.ceil(item / 2));
    //arr.reduce()
    //return arr;
};
/**
 * @param {character[][]} matrix
 * @return {number}
 */
var maximalRectangle = function (matrix) {
    const row = matrix.length;
    if (row === 0) return 0;
    const col = matrix[0].length;
    //const left = new Array(row).fill(Array(col).fill(0));
    const left = new Array(row).fill(0).map(() => new Array(col).fill(0));
    for (let i = 0; i < row; i++) {
        for (let j = 0; j < col; j++) {
            if (matrix[i][j] === "1")
                left[i][j] = (j === 0 ? 0 : left[i][j - 1]) + 1;
        }
    }
    let ans = 0;
    for (let i = 0; i < row; ++i) {
        for (let j = 0; j < col; ++j) {
            if (matrix[i][j] === "0") continue;
            let width = left[i][j];
            let area = width;
            for (let k = i - 1; k >= 0; --k) {
                width = Math.min(width, left[k][j]);
                area = Math.max(area, (i - k + 1) * width);
            }
            ans = Math.max(ans, area);
        }
    }
    return ans;
};
/**
 * @param {string} s
 * @return {number}
 */
var numDecodings = function (s) {
    let n = s.length;
    if (s[0] === "0" || n === 0) return 0;
    let dp = new Array(n).fill(0);
    dp[0] = 1;
    for (let i = 1; i < n; ++i) {
    }
};
/**
 * @param {string} s
 * @param {string} t
 * @return {boolean}
 */
var isIsomorphic = function (s, t) {
    // for (let i = 0; i < s.length; i++)
    //     if (s.indexOf(s[i]) !== t.indexOf(t[i])) return false
    // return true
    const s2t = {};
    const t2s = {};
    const n = s.length;
    for (let i = 0; i < n; ++i) {
        let x = s[i], y = t[i];
        if (s2t[x] && s2t[x] !== y || t2s[y] && t2s[y] !== x) return false;
        s2t[x] = y;
        t2s[y] = x;
    }
    return true;
};

/**
 * @param {number} k
 * @param {number[]} prices
 * @return {number}
 */
var maxProfit = function (k, prices) {
    const n = prices.length;
    k = Math.min(k, parseInt(n / 2));
    const b = new Array(k + 1).fill(-Number.MAX_VALUE);
    const s = new Array(k + 1).fill(-Number.MAX_VALUE);
    b[0] = -prices[0]; s[0] = 0;
    for (let i = 1; i < n; ++i) {
        b[0] = Math.max(b[0], s[0] - prices[i]);
        for (let j = 1; j <= k; ++j) {
            b[j] = Math.max(b[j], s[j] - prices[i]);
            s[j] = Math.max(s[j], b[j - 1] + prices[i]);
        }
    }
    return Math.max(...s);
};

/**
 * @param {string} binary
 * @return {string}
 */
var maximumBinaryString = function (binary) {
    const pos = binary.indexOf('0');
    if (pos == -1) return binary;
    const ones = binary.substring(pos).split("").reduce((a, b) => a += b == 1, 0);
    return '1'.repeat(binary.length - ones - 1) + '0' + '1'.repeat(ones);
};

/**
 * @param {number[]} nums
 * @param {number} n
 * @return {number}
 */
var minPatches = function (nums, n) {
    let index = 0, cnt = 0, tot = 1;
    while (tot <= n) {
        if (index < nums.length && nums[index] <= tot)
            tot += nums[index++];
        else {
            tot >>= 2;
            cnt++;
        }
    }
    return cnt;
};

/**
 * @param {number[]} nums
 * @param {number} n
 * @param {number} left
 * @param {number} right
 * @return {number}
 */
var rangeSum = function (nums, n, left, right) {
    const ans = [];
    for (let i = 0; i < n; ++i) {
        preSum = 0;
        for (let j = i; j < n; ++j) {
            preSum += nums[j];
            ans.push(preSum);
        }
    }
    ans.sort((a, b) => a - b);
    return ans.slice(left - 1, right).reduce((a, b) => a + b) % (1e9 + 7);
};

/**
 * @param {number} n
 * @return {number} 
 */
var cardPermutation = function (n) {
    let ans = 0;
    const cards = new Array(2 * n).fill(0);
    const dfs = (num) => {
        if (num == n + 1) {
            ans++;
            return;
        }
        for (let i = 0; i + num + 1 < n * 2; ++i) {
            if (!cards[i] && !cards[i + num + 1]) {
                cards[i] = cards[i + num + 1] = num;
                dfs(num + 1);
                cards[i] = cards[i + num + 1] = 0;
            }
        }
    }
    dfs(1);
    return ans;
}

/**
 * @param {number[]} stones
 * @return {number}
 */
var lastStoneWeight = function (stones) {
    // let diff, i, j;
    // while (stones.length > 1) {
    //     stones.sort((a, b) => b - a);
    //     i = stones[0];
    //     j = stones[1];
    //     stones = stones.slice(2);
    //     if (i - j) stones.push(diff);
    // }
    // return stones[0] === undefined ? 0 : stones[0];
    const pq = new MaxPriorityQueue();

    for (const stone of stones) {
        pq.enqueue('x', stone);
    }

    while (pq.size() > 1) {
        const a = pq.dequeue()['priority'];
        const b = pq.dequeue()['priority'];
        if (a > b) {
            pq.enqueue('x', a - b);
        }
    }
    return pq.isEmpty() ? 0 : pq.dequeue()['priority'];
};

/**
 * @param {number[][]} board
 * @return {void} Do not return anything, modify board in-place instead.
 */
var gameOfLife = function (board) {
    let n = board.length;
    let k = board[0].length;
    let tmp;
    let vtx = [];
    for (let i of [0, 1, -1]) {
        for (let j of [0, 1, -1]) {
            if (i === 0 && j === 0) continue;
            vtx.push([i, j]);
        }
    }
    const newb = new Array(n).fill(0).map(x => new Array(k).fill(0));
    for (let i = 0; i < n; ++i) {
        for (let j = 0; j < k; ++j) {
            tmp = [];
            for (let m of vtx) {
                if (i + m[0] < 0 || j + m[1] < 0) continue;
                if (i + m[0] >= n || j + m[1] >= k) continue;
                if (board[i + m[0]][j + m[1]] === 1)
                    tmp++;
            }
            if (board[i][j] && (tmp === 2 || tmp === 3))
                newb[i][j] = 1;
            else if (!board[i][j] && tmp === 3)
                newb[i][j] = 1;
        }
    }
    for (let i = 0; i < n; ++i) {
        for (let j = 0; j < k; ++j) {
            board[i][j] = newb[i][j];
        }
    }
};

/**
 * @param {number[][]} intervals
 * @return {number}
 */
var eraseOverlapIntervals = function (intervals) {
    intervals.sort((a, b) => a[1] - b[1]);
    let keep = 1, right = intervals[0][1], n = intervals.length;
    if (n == 0) return 0;
    for (let i = 0; i < intervals.length; ++i) {
        if (intervals[i][0] >= right) {
            keep++;
            right = intervals[i][1];
        }
    }
    return n - keep;
};

/**
 * @param {number[]} nums
 * @return {number}
 */
var lengthOfLIS = function (nums) {
    let res = 0, left, right, mid;
    const tmp = [];
    for (let num of nums) {
        left = 0;
        right = res;
        while (left < right) {
            mid = (left + right) >> 1;
            if (tmp[mid] < num)
                left = mid + 1;
            else right = mid;
        }
        tmp[left] = num;
        if (right == res) res++;
    }
    return res;
};

/**
 * @param {number[]} arr
 * @return {boolean}
 */
var uniqueOccurrences = function (arr) {
    const freq = [];
    for (let a of arr) {
        freq[a] = freq[a] ? freq[a] + 1 : 1;
    }
    let v = Object.values(freq);
    v = v.sort();
    for (let i = 0; i + 1 < v.length; ++i) {
        if (v[i] == v[i + 1]) return false;
    }
    return true;
};

/**
 * @param {number[]} arr
 * @param {number[][]} pieces
 * @return {boolean}
 */
var canFormArray = function (arr, pieces) {
};

/**
 * @param {string} s
 * @return {number}
 */
var romanToInt = function (s) {
    const hashNum = {
        "I": 1,
        "V": 5,
        "X": 10,
        "L": 50,
        "C": 100,
        "D": 500,
        "M": 1000
    }
    let result = 0;
    for (let i = 0; i < s.length; i++) {
        hashNum[s[i]] < hashNum[s[i + 1]] ? result -= hashNum[s[i]] : result += hashNum[s[i]];
    }
    return result;
};

/**
 * @param {number} n
 * @return {number}
 */
var fib = function (n) {
    if (n == 0) return 0;
    dp = Array(n).fill(0);
    dp[1] = 1;
    for (let i = 2; i <= n; ++i) {
        dp[i] = dp[i - 1] + dp[i - 2];
    }
    return dp[n];
};

/**
 * @param {string} s
 * @return {number[][]}
 */
var largeGroupPositions = function (s) {
    let i = 0;
    const ans = [];
    while (i < s.length) {
        let c = s[i];
        let j = i;
        while (j < s.length && c === s[j]) {
            j++;
        }
        if (j - i >= 3)
            ans.push([i, j - 1]);
        i = j;
    }
    return ans;
};

let s = "abbxxxxzzy";
s = "abc";
s = "abcdddeeeeaabbbcd"
//s = "aba"

console.log(largeGroupPositions(s));

