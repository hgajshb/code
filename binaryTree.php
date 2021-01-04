<?php

//Definition for a binary tree node.
class TreeNode
{
    public $val = null;
    public $left = null;
    public $right = null;
    function __construct($val = 0, $left = null, $right = null)
    {
        $this->val = $val;
        $this->left = $left;
        $this->right = $right;
    }
}

class Solution
{

    /**
     * @param TreeNode $root
     * @return Boolean
     */
    function isValidBST($root)
    {
        $this->arr = [];
        $this->inorder($root);
        for ($i = 0; $i < count($this->arr) - 1; ++$i) {
            if ($this->arr[$i + 1] < $this->arr[$i])
                return false;
        }
        return true;
    }
    function inorder($root)
    {
        if (!$root) return;
        $this->inorder($root->left);
        $this->arr[] = $root->val;
        $this->inorder($root->right);
    }
    /**
     * @param TreeNode $root
     * @return Integer[][]
     */
    function levelOrder($root)
    {
        if (!$root) return [];
        $queue = [$root];
        while ($n = count($queue)) {
            $tmp = [];
            for ($i = 0; $i < $n; ++$i) {
                $node = array_shift($queue);
                $tmp[] = $node->val;
                if ($node->left) $queue[] = $node->left;
                if ($node->right) $queue[] = $node->right;
            }
            $ans[] = $tmp;
        }
        return $ans;
    }
    /**
     * @param Integer[][] $grid
     * @return Integer
     */
    function cherryPickup($grid)
    {
        $m = count($grid);
        $n = count($grid[0]);

        $f = array_fill(0, $n, array_fill(0, $n, -1));
        $g = array_fill(0, $n, array_fill(0, $n, -1));
        $f[0][$n - 1] = $grid[0][0] + $grid[0][$n - 1];
        for ($i = 1; $i < $m; ++$i) {
            for ($j1 = 0; $j1 < $n; ++$j1) {
                for ($j2 = 0; $j2 < $n; ++$j2) {
                    $best = -1;
                    for ($dj1 = $j1 - 1; $dj1 <= $j1 + 1; ++$dj1) {
                        for ($dj2 = $j2 - 1; $dj2 <= $j2 + 1; ++$dj2) {
                            if ($dj1 >= 0 && $dj1 < $n && $dj2 >= 0 && $dj2 < $n && $f[$dj1][$dj2] != -1) {
                                $best = max($best, $f[$dj1][$dj2] + ($j1 == $j2 ?
                                    $grid[$i][$j1] : $grid[$i][$j1] + $grid[$i][$j2]));
                            }
                        }
                    }
                    $g[$j1][$j2] = $best;
                }
            }
            $tmp = $f;
            $f = $g;
            $g = $tmp;
        }

        $ans = 0;
        for ($j1 = 0; $j1 < $n; ++$j1) {
            for ($j2 = 0; $j2 < $n; ++$j2) {
                $ans = max($ans, $f[$j1][$j2]);
            }
        }
        return $ans;
    }
    /**
     * @param TreeNode $root
     * @return Integer[][]
     */
    function zigzagLevelOrder($root)
    {
        if (!$root) return [];
        $queue = [$root];
        $ans = [];
        while ($n = count($queue)) {
            $tmp = [];
            for ($i = 0; $i < $n; ++$i) {
                $node = array_shift($queue);
                $tmp[] = $node->val;
                if ($node->left) $queue[] = $node->left;
                if ($node->right) $queue[] = $node->right;
            }
            $ans[] = $tmp;
        }
        for ($i = 0; $i < count($ans); ++$i) {
            if ($i % 2) $ans[$i] = array_reverse($ans[$i]);
        }
        return $ans;
    }
    /**
     * @param TreeNode $root
     * @return Boolean
     */
    function isBalanced($root)
    {
        return $this->ht($root) >= 0;
    }
    function ht($root)
    {
        if (!$root) return 0;
        $l = $this->ht($root->left);
        $r = $this->ht($root->right);
        if ($l == -1 || $r == -1 || abs($l - $r) > 1) return -1;
        return max($l, $r) + 1;
    }
    /**
     * @param TreeNode $root
     * @return Boolean
     */
    function isUnivalTree($root)
    {
        return $this->isUni($root);
    }
    function isUni($root)
    {
        if (!$root) return true;
        $l = $this->isUni($root->left);
        $r = $this->isUni($root->right);
        if (!$l || !$r) return false;
        $ll = $root->left ? $root->left->val == $root->val : true;
        $rr = $root->right ? $root->right->val == $root->val : true;
        return $ll && $rr;
    }
    /**
     * @param TreeNode $root
     * @return NULL
     */
    function flatten($root)
    {
        $cur = $root;
        while ($cur) {
            if ($cur->left) {
                $pre = $tmp = $cur->left;
                while ($pre->right) {
                    $pre = $pre->right;
                }
                $pre->right = $cur->right;
                $cur->left = null;
                $cur->right = $tmp;
            }
            $cur = $cur->right;
        }
    }
    /**
     * @param ListNode $head
     * @return ListNode
     */
    function swapPairs($head)
    {
        if (!$head || !$head->next) return $head;
        $newHead = $head->next;
        $head->next = $this->swapPairs($newHead->next);
        $newHead->next = $head;
        return $newHead;
    }

    /**
     * @param TreeNode $root
     * @return Integer
     */
    function pseudoPalindromicPaths($root)
    {
        $this->ans = 0;
        $this->trav($root, []);
        return $this->ans;
    }

    function trav($root, $map)
    {
        if (!$root) return;
        $map[$root->val] = isset($map[$root->val]) ? $map[$root->val] + 1 : 1;
        if ($map[$root->val] == 2) unset($map[$root->val]);
        if (!$root->left && !$root->right) {
            if (count($map) < 2) {
                $this->ans++;
                return;
            }
        }
        $this->trav($root->left, $map);
        $this->trav($root->right, $map);
    }
}

$root = new TreeNode(2);
$root->left = new TreeNode(3);
$root->left->left = new TreeNode(3);
$root->left->right = new TreeNode(1);
$root->right = new TreeNode(1);
$root->right->right = new TreeNode(1);


$ns = new Solution;
echo json_encode($ns->pseudoPalindromicPaths($root));
