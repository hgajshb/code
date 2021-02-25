<?php
class UnionSet
{
    private $rank;
    private $parent;
    private $size;
    private $groups;
    /**
     * @param int $n
     * @return null
     */
    function __construct($n = -1)
    {
        if ($n == -1) return;
        $this->n = $n;
        $this->rank = array_fill(0, $n, 1);
        $this->size = array_fill(0, $n, 1);
        for ($i = 0; $i < $n; ++$i) {
            $this->parent[$i] = $i;
        }
        $this->groups = $n;
    }

    function getGroups()
    {
        return $this->groups;
    }
    /**
     * @param int $x
     * @return int
     */
    function find($x)
    {
        if (!isset($this->parent[$x])) {
            $this->parent[$x] = $x;
            $this->rank[$x] = 1;
            $this->size[$x] = 1;
        }
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
        $this->groups--;
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
    function removeStones($stones)
    {
        $n = count($stones);
        $dsu = new UnionSet();
        for ($i = 0; $i < $n; ++$i) {
            $dsu->union($stones[$i][0], $stones[$i][1] + 10001);
        }
        return $n - $dsu->getGroups($n);
    }

    /**
     * @param String[] $equations
     * @return Boolean
     */
    function equationsPossible($equations)
    {
        $dsu = new UnionSet;
        $eq = $uneq = [];
        foreach ($equations as $e) {
            if ($e[1] == '!') $uneq[] = $e;
            else $eq[] = $e;
        }
        foreach ($eq as $e) {
            $dsu->union($e[0], $e[3]);
        }

        foreach ($uneq as $u) {
            if ($dsu->find($u[0]) === $dsu->find($u[3])) return false;
        }
        return true;
    }

    /**
     * @param String[][] $accounts
     * @return String[][]
     */
    function accountsMerge($accounts)
    {
        $e2n = $ef = $ans = [];
        foreach ($accounts as $a) {
            for ($i = 1; $i < count($a); ++$i) {
                $e2n[$a[$i]] = $a[0];
                $ef[$a[$i]] = isset($ef[$a[$i]]) ? $ef[$a[$i]] + 1 : 1;
            }
        }
        //echo json_encode($ef);
        foreach ($ef as $e => $cnt) {
            if ($cnt == 1) $ans[] = [$e2n[$e], $e];
        }
        echo json_encode($ans);
    }
    /**
     * @param int[][] $points
     * @return Integer
     */
    function minCostConnectPoints($points)
    {
        // $edges = [];
        // $n = count($points);
        // for ($i = 0; $i < $n; ++$i) {
        //     for ($j = $i + 1; $j < $n; ++$j) {
        //         $edges[] = [abs($points[$i][0] - $points[$j][0]) +
        //             abs($points[$i][1] - $points[$j][1]), $i, $j];
        //     }
        // }
        // sort($edges);
        // $ans = $cnt = 0;
        // $dsu = new UnionSet($n);
        // foreach ($edges as list($e, $x, $y)) {
        //     if ($dsu->find($x) != $dsu->find($y)) {
        //         $dsu->union($x, $y);
        //         $ans += $e;
        //         $cnt++;
        //         if ($n == $cnt) break;
        //     }
        // }
        // return $ans;
        $tmp = $points[0];
        unset($points[0]);
        $num = 0;
        $list = [];
        while ($points) {
            $min = -1;
            foreach ($points as $kk => $vv) {
                $len = abs($tmp[0] - $vv[0]) + abs($tmp[1] - $vv[1]);
                $list[$kk] = isset($list[$kk]) ? min($list[$kk], $len) : $len;
                $min = $min < 0 ? $list[$kk] : min($min, $list[$kk]);
                if ($min == $list[$kk]) $key = $kk;
            }
            $tmp  = $points[$key];
            unset($points[$key]);
            $num += $min;
        }
        return $num;
    }
    /**
     * @param Integer $n
     * @param Integer[][] $edges
     * @return Integer[][]
     */
    function findCriticalAndPseudoCriticalEdges($n, $edges)
    {
        $len = count($edges);
        for ($i = 0; $i < $len; ++$i) {
            $edges[$i][] = $i;
        }
        $dsu = new UnionSet($n);
        usort($edges, function ($a, $b) {
            return $a[2] - $b[2];
        });
        $least = 0;
        for ($i = 0; $i < $len; ++$i) {
            if ($dsu->find($edges[$i][0]) != $dsu->find($edges[$i][1])) {
                $dsu->union($edges[$i][0], $edges[$i][1]);
                $least += $edges[$i][2];
            }
        }

        $ans = [[], []];
        for ($i = 0; $i < $len; ++$i) {
            $cost = 0;
            $dsu = new UnionSet($n);
            for ($j = 0; $j < $len; ++$j) {
                if ($i != $j && $dsu->find($edges[$j][0]) != $dsu->find($edges[$j][1])) {
                    $dsu->union($edges[$j][0], $edges[$j][1]);
                    $cost += $edges[$j][2];
                }
            }
            if ($dsu->getGroups() != 1 || ($dsu->getGroups() == 1 && $cost > $least)) {
                $ans[0][] = $edges[$i][3];
                continue;
            }
            $dsu = new UnionSet($n);
            $dsu->union($edges[$i][0], $edges[$i][1]);
            $cost = $edges[$i][2];
            for ($j = 0; $j < $len; ++$j) {
                if ($i != $j && $dsu->find($edges[$j][0]) != $dsu->find($edges[$j][1])) {
                    $dsu->union($edges[$j][0], $edges[$j][1]);
                    $cost += $edges[$j][2];
                }
            }
            if ($cost == $least) $ans[1][] = $edges[$i][3];
        }
        return $ans;
    }

    /**
     * @param String[] $grid
     * @return Integer
     */
    function regionsBySlashes($grid)
    {
        $N = count($grid);
        $size = 4 * $N * $N;

        $unionFind = new UnionSet($size);
        for ($i = 0; $i < $N; $i++) {
            $row = $grid[$i];
            for ($j = 0; $j < $N; $j++) {
                // 二维网格转换为一维表格
                $index = 4 * ($i * $N + $j);
                $c = $row[$j];
                // 单元格内合并
                if ($c == '/') {
                    // 合并 0、3，合并 1、2
                    $unionFind->union($index, $index + 3);
                    $unionFind->union($index + 1, $index + 2);
                } else if ($c == '\\') {
                    // 合并 0、1，合并 2、3
                    $unionFind->union($index, $index + 1);
                    $unionFind->union($index + 2, $index + 3);
                } else {
                    $unionFind->union($index, $index + 1);
                    $unionFind->union($index + 1, $index + 2);
                    $unionFind->union($index + 2, $index + 3);
                }

                // 单元格间合并
                // 向右合并：1（当前）、3（右一列）
                if ($j + 1 < $N) {
                    $unionFind->union($index + 1, 4 * ($i * $N + $j + 1) + 3);
                }
                // 向下合并：2（当前）、0（下一行）
                if ($i + 1 < $N) {
                    $unionFind->union($index + 2, 4 * (($i + 1) * $N + $j));
                }
            }
        }
        return $unionFind->getGroups();
    }
    /**
     * @param Integer[][] $grid
     * @return Integer
     */
    function swimInWater($grid)
    {
        $n = count($grid);
        $map = array_fill(0, $n * $n, 0);
        for ($x = 0; $x < $n; ++$x)
            for ($y = 0; $y < $n; ++$y)
                $map[$x * $n + $y] = $grid[$x][$y];
        $map = array_flip($map);
        $dsu = new UnionSet($n * $n);
        $directions = [[1, 0], [0, 1], [-1, 0], [0, -1]];
        for ($t = 0; $t < $n * $n; ++$t) {
            $x = (int)($map[$t] / $n);
            $y = $map[$t] % $n;
            foreach ($directions as list($dx, $dy)) {
                $nx = $x + $dx;
                $ny = $y + $dy;
                if ($nx >= 0 && $nx < $n && $ny >= 0 && $ny < $n && $grid[$nx][$ny] <= $t) {
                    $dsu->union($x * $n + $y, $nx * $n + $ny);
                }
            }
            if ($dsu->find(0) == $dsu->find($n * $n - 1)) return $t;
        }
        return -1;
    }
    /**
     * @param String[] $strs
     * @return Integer
     */
    function numSimilarGroups($strs)
    {
        $n = count($strs);
        $strlen = strlen($strs[0]);
        $dsu = new UnionSet($n);
        for ($i = 0; $i < $n - 1; ++$i) {
            for ($j = $i + 1; $j < $n; ++$j) {
                $diff = 0;
                for ($k = 0; $k < $strlen; ++$k)
                    if ($strs[$i][$k] !== $strs[$j][$k]) $diff++;
                if ($diff == 0 || $diff == 2)
                    $dsu->union($i, $j);
            }
        }
        return $dsu->getGroups();
    }

    /**
     * @param Integer[][] $graph
     * @return Boolean
     */
    function isBipartite($graph)
    {
        $n = count($graph);
        $dsu = new UnionSet($n);
        for ($i = 0; $i < $n; ++$i) {
            foreach ($graph[$i] as $g)
                if ($dsu->find($g) == $dsu->find($i))
                    return false;
            for ($j = 0; $j + 1 < count($graph[$i]); ++$j)
                $dsu->union($graph[$i][$j], $graph[$i][$j + 1]);
        }
        return true;
    }
}


$graph = [[1, 2, 3], [0, 2], [0, 1, 3], [0, 2]];
$graph = [[1, 3], [0, 2], [1, 3], [0, 2]];
$graph = [[1], [0, 3], [3], [1, 2]];
$ns = new Solution;
echo json_encode($ns->isBipartite($graph)), "\n";
