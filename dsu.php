<?php
class UnionSet
{
    private $rank;
    private $parent;
    private $size;
    /**
     * @param int $n
     * @return null
     */
    function __construct($n)
    {
        $this->$n = $n;
        $this->rank = array_fill(0, $n, 1);
        $this->size = array_fill(0, $n, 1);
        for ($i = 0; $i < $n; ++$i) {
            $this->parent[$i] = $i;
        }
    }
    function getSize($n)
    {
        return $this->size[$this->find($n)];
    }
    /**
     * @param int $x
     * @return int
     */
    function find($x)
    {
        if ($x != $this->parent[$x]) {
            $this->parent[$x] = $this->find($this->parent[$x]);
        }
        return $this->parent[$x];
    }
    /**
     * @param int $x
     * @param int $y
     * @param int $mode
     * @return null
     * 
     */
    function union($x, $y, $mode = "rank")
    {
        $xr = $this->find($x);
        $yr = $this->find($y);
        if ($xr == $yr) return;
        if ($mode == "rank") {
            if ($this->rank[$xr] < $this->rank[$yr]) {
                $this->parent[$xr] = $yr;
            } else if ($this->rank[$xr] > $this->rank[$yr]) {
                $this->parent[$yr] = $xr;
            } else {
                $this->parent[$xr] = $yr;
                $this->rank[$yr]++;
            }
        } else {
            if ($this->size[$xr] < $this->size[$yr]) {
                [$xr, $yr] = [$yr, $xr];
            }
            $this->size[$xr] += $this->size[$yr];
            $this->parent[$yr] = $xr;
        }
    }
}
class Solution
{

    /**
     * @param String $s
     * @param Integer[][] $pairs
     * @return String
     */
    function smallestStringWithSwaps($s, $pairs)
    {
        $n = strlen($s);
        $dsu = new UnionSet($n);
        foreach ($pairs as $pair) {
            $dsu->union($pair[0], $pair[1]);
        }
        $map = array_fill(0, $n, []);
        for ($i = 0; $i < $n; ++$i) {
            $map[$dsu->find($i)][] = $s[$i];
        }
        foreach ($map as $key => $values) {
            rsort($values);
            $map[$key] = $values;
        }
        $ans = "";
        for ($i = 0; $i < $n; ++$i) {
            $ans .= array_pop($map[$dsu->find($i)]);
        }
        return $ans;
    }

    /**
     * @param Integer[] $source
     * @param Integer[] $target
     * @param Integer[][] $allowedSwaps
     * @return Integer
     */
    function minimumHammingDistance($source, $target, $allowedSwaps)
    {
        $n = count($source);
        $dsu = new UnionSet($n);
        foreach ($allowedSwaps as $a) $dsu->union($a[0], $a[1]);
        $map = [];
        for ($i = 0; $i < $n; ++$i) {
            $f = $dsu->find($i);
            $s = $source[$i];
            $map[$f][$s] = isset($map[$f][$s]) ? $map[$f][$s] + 1 : 1;
        }
        $same = 0;
        for ($i = 0; $i < $n; ++$i) {
            $f = $dsu->find($i);
            $t = $target[$i];
            if (isset($map[$f][$t]) && $map[$f][$t] > 0) {
                $same++;
                $map[$f][$t]--;
            }
        }
        return $n - $same;
    }

    /**
     * @param int[][] $edges
     * @return Integer[]
     */
    function findRedundantConnection($edges)
    {
        // $n = count($edges);
        // for ($i = $n - 1; $i >= 0; --$i) {
        //     $dsu = new UnionSet($n);
        //     for ($j = 0; $j < $n; ++$j) {
        //         if ($i == $j) continue;
        //         else $dsu->union($edges[$j][0] - 1, $edges[$j][1] - 1, "size");
        //     }
        //     if ($dsu->getSize(0) === $n) return $edges[$i];
        // }
        
    }
}
$edges = [[1, 2], [1, 3], [2, 3]];
$edges = [[1, 2], [2, 3], [3, 4], [1, 4], [1, 5]];
$ns = new Solution;
echo json_encode($ns->findRedundantConnection($edges));
