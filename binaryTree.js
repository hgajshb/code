
// Definition for a binary tree node.
class TreeNode {
    constructor(val, left, right) {
        this.val = (val === undefined ? 0 : val);
        this.left = (left === undefined ? null : left);
        this.right = (right === undefined ? null : right);
    }
}

/**
 * @param {TreeNode} root
 * @return {number}
 */
var pseudoPalindromicPaths = function (root) {
    // var ans = 0;
    // trav(root, []);
    // return ans;
    // function trav(root, map) {
    //     if (!root) return;
    //     map[root.val] = map[root.val] !== undefined ? map[root.val] + 1 : 1;
    //     if (map[root.val] == 2) map[root.val] = undefined;
    //     if (!root.left && !root.right) {
    //         if (map.length < 2) {
    //             ans++;
    //             return;
    //         }
    //     }
    //     trav(root.left, map);
    //     trav(root.right, map);
    // }
    if (root === null) return 0;

    let count = new Array(10).fill(0);
    let res = 0;
    dfs(root, count);

    return res;

    function dfs(node, count) {
        count[node.val] ^= 1;

        if (node.left === null && node.right === null) {
            res += (count.reduce((a, b) => a + b) > 1 ? 0 : 1);
        }

        if (node.left !== null) dfs(node.left, count);
        if (node.right !== null) dfs(node.right, count);

        count[node.val] ^= 1;
    }
};
