<?php
class BIT
{
    private $n;
    private $tree;
    function __construct($n)
    {
        $this->n = $n;
        $this->tree = array_fill(0, $n + 1, 0);
    }

    function lowbit($x)
    {
        return $x & (-$x);
    }

    function update($x)
    {
        while ($x <= $this->n) {
            ++$this->tree[$x];
            $x += $this->lowbit($x);
        }
    }

    function query($x)
    {
        $ans = 0;
        while ($x) {
            $ans += $this->tree[$x];
            $x -= $this->lowbit($x);
        }
        return $ans;
    }
}

class Solution
{
    /**
     * @param int[] $instructions
     * @return Integer
     */
    function createSortedArray($instructions)
    {
        $bit = new BIT(max($instructions));
        $ans = 0;
        for ($i = 0; $i < count($instructions); ++$i) {
            $x = $instructions[$i];
            $smaller = $bit->query($x - 1);
            $larger = $i - $bit->query($x);
            $ans += min($smaller, $larger);
            $bit->update($x);
        }
        return $ans % 1000000007;
    }
}

$a = $b = array_fill(0, 4, 5);
$ns = new Solution;
//echo json_encode($ns->createSortedArray($instructions));
$b[2] = 999;
echo json_encode($a);
