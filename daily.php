<?php
class UnionFind6
{
    private $parents = [];
    private $rank = [];
    private $count;

    public function __construct($size)
    {
        for ($i = 0; $i < $size; $i++) {
            $this->parents[$i] = $i;
            $this->rank[$i] = 1;
        }
        $this->count = $size;
    }

    public function getCount()
    {
        return $this->count;
    }

    public function size()
    {
        // TODO: Implement size() method.
        return sizeof($this->parents);
    }

    public function isConnected($p, $q)
    {
        // TODO: Implement isConnected() method.
        return $this->find($p) == $this->find($q);
    }

    public function union($p, $q)
    {
        // TODO: Implement union() method.
        $pRoot = $this->find($p);
        $qRoot = $this->find($q);
        if ($pRoot == $qRoot)
            return;

        if ($this->rank[$pRoot] > $this->rank[$qRoot]) {
            $this->parents[$qRoot] = $pRoot;
        } else if ($this->rank[$pRoot] < $this->rank[$qRoot]) {
            $this->parents[$pRoot] = $qRoot;
        } else {
            $this->parents[$qRoot] = $pRoot;
            $this->rank[$pRoot] += 1;
        }
        $this->count--; //融合一对，朋友圈减1
    }

    protected function find($p)
    {
        if ($p < 0 || $p >= $this->size()) {
            throw new Exception("下标越界");
        }

        if ($this->parents[$p] != $p) {
            $this->parents[$p] = $this->find($this->parents[$p]);
        }

        return $this->parents[$p];
    }
}
class Solution
{
    /**
     * @param integer [] $stones
     * @return integer 
     */
    function stoneGameVII($stones)
    {
        $n = count($stones);
        $presum = array_fill(0, $n, 0);
        $presum[0] = $stones[0];
        for ($i = 1; $i < $n; ++$i) {
            $presum[$i] = $presum[$i - 1] + $stones[$i];
        }
        $presum[-1] = 0;
        $dp = array_fill(0, $n, array_fill(0, $n, 0));
        for ($i = $n - 2; $i >= 0; $i--) {
            for ($j = $i + 1; $j < $n; ++$j) {
                $l = $presum[$j] - $presum[$i];
                $r = $presum[$j - 1] - $presum[$i - 1];
                $dp[$i][$j] = max($l - $dp[$i + 1][$j], $r - $dp[$i][$j - 1]);
            }
        }
        return $dp[0][$n - 1];
    }
    /**
     * @param integer [] $nums
     * @return integer []
     */
    function sortedSquares($nums)
    {
        $n = count($nums);
        $tmp = $nums;
        for ($i = 0; $i < $n; ++$i) {
            if ($tmp[$i] < 0) $tmp[$i] = -$tmp[$i];
        }
        $min = min($tmp);
        $ans[] = $min * $min;
        $pos = array_search($min, $tmp);
        for ($i = 0; $i < $n; ++$i) {
            $nums[$i] = $nums[$i] * $nums[$i];
        }
        $l = $pos - 1;
        $r = $pos + 1;
        while ($l >= 0 && $r < $n) {
            if ($nums[$l] > $nums[$r]) {
                $ans[] = $nums[$r];
                $r++;
                if ($r == $n) break;
            } else {
                $ans[] = $nums[$l];
                $l--;
                if ($l == -1) break;
            }
        }
        while ($l >= 0) $ans[] = $nums[$l--];
        while ($r < $n) $ans[] = $nums[$r++];
        return $ans;
    }
    /**
     * @param String $pattern
     * @param String $s
     * @return Boolean
     */
    function wordPattern($pattern, $s)
    {
        $n = strlen($pattern);
        $map = [];
        $arr = explode(" ", $s);
        if ($n != count($arr)) return false;
        for ($i = 0; $i < $n; ++$i) {
            if (isset($map[$pattern[$i]])) {
                if ($map[$pattern[$i]] != $arr[$i]) return false;
            } else $map[$pattern[$i]] = $arr[$i];
        }
        return count(array_unique(array_values($map))) == count(array_keys($map));
    }
    /**
     * @param integer [] $count
     * @return Float[]
     */
    function sampleStats($count)
    {
        $sum = $l = 0;
        $r = 255;
        $cnt = array_sum($count);

        for ($i = 0; $i < 256; ++$i) {
            if ($count[$i] != 0) {
                $min = $i;
                break;
            }
        }
        for ($i = 255; $i >= 0; --$i) {
            if ($count[$i] != 0) {
                $max = $i;
                break;
            }
        }
        for ($i = 0; $i < 256; ++$i) {
            $sum += $i * $count[$i];
        }
        $avg = $sum / $cnt;
        $sumL = $count[0];
        $sumR = $count[255];
        while ($l < $r) {
            if ($sumL < $sumR) {
                $l++;
                $sumL += $count[$l];
            } elseif ($sumL == $sumR) {
                $r--;
                $l++;
                $sumR += $count[$r];
                $sumL += $count[$l];
            } else {
                $r--;
                $sumR += $count[$r];
            }
        }
        if ($cnt % 2 == 0) $mid = ($l + $r) / 2;
        else $mid = $sumL > $sumR ? $l : $r;
        $mode = array_search(max($count), $count);
        return [$min, $max, $avg, $mid, $mode];
    }
    /**
     * @param integer [] $prices
     * @param integer  $fee
     * @return integer 
     */
    function maxProfit($prices, $fee)
    {
        $n = count($prices);
        $dp = array_fill(0, $n, []);
        $dp[0][0] = 0;
        $dp[0][1] = -$prices[0];
        for ($i = 1; $i < $n; ++$i) {
            $dp[$i][0] = max($dp[$i - 1][0], $dp[$i - 1][1] + $prices[$i] - $fee);
            $dp[$i][1] = max($dp[$i - 1][0] - $prices[$i], $dp[$i - 1][1]);
        }
        return $dp[$n - 1][0];
    }
    /**
     * @param integer [] $nums
     * @return integer 
     */
    function findMin($nums)
    {
        $n = count($nums);
        $left = 0;
        $right = $n - 1;
        while ($left < $right) {
            $mid = ($left + $right) >> 1;
            if ($nums[$mid] < $nums[$right]) {
                $right = $mid;
            } else {
                $left = $mid + 1;
            }
        }
        return $nums[$left];
    }
    /**
     * @param integer [] $A
     * @param integer [] $B
     * @param integer [] $C
     * @param integer [] $D
     * @return integer 
     */
    function fourSumCount($A, $B, $C, $D)
    {
        $ans = 0;
        foreach ($A as $a) {
            foreach ($B as $b) {
                if (isset($cnt[$a + $b])) $cnt[$a + $b]++;
                else $cnt[$a + $b] = 1;
            }
        }
        foreach ($C as $c) {
            foreach ($D as $d) {
                if (isset($cnt[-$c - $d])) {
                    $ans += $cnt[-$c - $d];
                }
            }
        }
        return $ans;
    }
    /**
     * @param String $s
     * @param String $t
     * @return String
     */
    function findTheDifference($s, $t)
    {
        $freq1 = count_chars($s, 1);
        $freq2 = count_chars($t, 1);
        foreach ($freq1 as $char => $cnt) {
            if ($freq2[$char] != $cnt)
                return chr($char);
            else unset($freq2[$char]);
        }
        return chr(array_keys($freq2)[0]);
    }
    /**
     * @param integer [] $nums
     * @return Boolean
     */
    function increasingTriplet($nums)
    {
        $n = count($nums);
        if ($n < 3) return false;
        $small = $mid = PHP_INT_MAX;
        foreach ($nums as $num) {
            if ($num <= $small)
                $small = $num;
            elseif ($num <= $mid)
                $mid = $num;
            elseif ($num > $mid)
                return true;
        }
        return false;
    }
    /**
     * @param String $number
     * @return String
     */
    function reformatNumber($number)
    {
        $ans = "";
        for ($i = 0; $i < strlen($number); ++$i) {
            if ($number[$i] == '-' || $number[$i] == ' ') continue;
            else $ans .= $number[$i];
        }
        $len = strlen($ans);
        if ($len <= 3) return $ans;
        if ($len == 4) return substr($ans, 0, 2) . '-' . substr($ans, 2);
        $i = 0;
        $ret = "";
        while ($i < $len - 4) {
            $ret .= substr($ans, $i, 3) . '-';
            $i += 3;
        }
        if ($i == $len - 4) {
            return $ret  . substr($ans, $i, 2) . '-' . substr($ans, $i + 2);
        } else return $ret  . substr($ans, $i);
    }

    /**
     * @param String $s
     * @return String
     */
    function removeDuplicateLetters($s)
    {
        $n = strlen($s);
        $last = $stack = [];
        for ($i = 0; $i < $n; ++$i) {
            $last[$s[$i]] = $i;
        }
        $i = 0;
        while ($i < $n) {
            if (in_array($s[$i], $stack)) {
                $i++;
                continue;
            }
            while ($stack && end($stack) > $s[$i] && $last[end($stack)] > $i)
                array_pop($stack);
            $stack[] = $s[$i];
            $i++;
        }
        return join("", $stack);
    }
    /**
     * @param String $S
     * @param integer  $K
     * @return String
     */
    function decodeAtIndex($S, $K)
    {
        $size = 0;
        $N = strlen($S);

        // Find size = length of decoded string
        for ($i = 0; $i < $N; ++$i) {
            if ($S[$i] >= '2' && $S[$i] <= '9')
                $size *= $S[$i] - '0';
            else
                $size++;
        }

        for ($i = $N - 1; $i >= 0; --$i) {
            $K %= $size;
            if ($K == 0 && ($S[$i] >= 'a' && $S[$i] <= 'z'))
                return $S[$i];

            if ($S[$i] >= '2' && $S[$i] <= '9')
                $size = (int)($size / ($S[$i] - '0'));
            else
                $size--;
        }
        return "";
    }
    /**
     * @param integer [] $cost
     * @return integer 
     */
    function minCostClimbingStairs($cost)
    {
        $n  = count($cost);
        $dp[0] = $cost[0];
        $dp[1] = $cost[1];
        $cost[$n] = 0;
        for ($i = 2; $i <= $n; ++$i) {
            $dp[$i] = min($dp[$i - 1], $dp[$i - 2]) + $cost[$i];
        }
        return $dp[$n];
    }
    /**
     * @param integer [] $nums
     * @return integer 
     */
    function maximumUniqueSubarray($nums)
    {
        // $n = count($nums);
        // $i = $max = $start = $sum = 0;
        // $map = [];
        // while ($i < $n) {
        //     if (!isset($map[$nums[$i]])) {
        //         $map[$nums[$i]] = 1;
        //         $sum += $nums[$i];
        //         $max = max($max, $sum);
        //     } else {
        //         while ($nums[$start] != $nums[$i]) {
        //             $sum -= $nums[$start];
        //             unset($map[$nums[start]]);
        //             $start++;
        //         }
        //         $start++;
        //     }
        //     $i++;
        // }
        // return $max;
        $map = [];
        $ans = $sum = $start = 0;
        for ($i = 0; $i < count($nums); $i++) {
            if (!isset($map[$nums[$i]])) {
                $map[$nums[$i]] = 1;
                $sum += $nums[$i];
                $ans = max($sum, $ans);
            } else {
                while ($nums[$i] != $nums[$start]) {
                    $sum -= $nums[$start];
                    unset($map[$nums[$start]]);
                    $start++;
                }
                $start++;
            }
        }
        return $ans;
    }
    /**
     * @param integer [] $A
     * @param integer  $K
     * @return integer 
     */
    function smallestRangeII($A, $K)
    {
        $n = count($A);
        sort($A);
        $ans = $A[$n - 1] - $A[0];
        for ($i = 0; $i < $n - 1; ++$i) {
            $a = $A[$i];
            $b = $A[$i + 1];
            $high = max($A[$n - 1] - $K, $a + $K);
            $low = min($A[0] + $K, $b - $K);
            $ans = min($ans, $high - $low);
        }
        return $ans;
    }
    /**
     * @param integer [] $nums
     * @param integer  $k
     * @return integer 
     */
    function maxResult($nums, $k)
    {
        $n = count($nums);
        $tt = -1;
        $hh = 0;
        $h = [];
        $f = array_fill(0, $n, PHP_INT_MIN);

        $f[0] = $nums[0];
        for ($i = 0; $i < $n; $i++) {
            while ($tt >= $hh && $i - $h[$hh] > $k) $hh++;
            if ($tt >= $hh) $f[$i] = max($f[$i], $f[$h[$hh]] + $nums[$i]);
            while ($tt >= $hh && $f[$h[$tt]] <= $f[$i]) $tt--;
            $h[++$tt] = $i;
        }
        return $f[$n - 1];
    }
    /**
     * @param String $s
     * @return integer 
     */
    function firstUniqChar($s)
    {
        $freq = count_chars($s, 1);
        for ($i = 0; $i < strlen($s); ++$i) {
            if ($freq[ord($s[$i])] == 1) return $i;
        }
        return -1;
    }
    /**
     * @param String[] $queries
     * @param String $pattern
     * @return Boolean[]
     */
    function camelMatch($queries, $pattern)
    {
        $ans = [];
        foreach ($queries as $q)
            $ans[] = $this->match($q, $pattern);
        return $ans;
    }
    function match($word, $pattern)
    {
        $tmp1 = $tmp2 = [];
        for ($i = 0; $i < strlen($word); ++$i) {
            if ($word[$i] >= 'A' && $word[$i] <= 'Z')
                $tmp1[] = $word[$i];
        }
        for ($i = 0; $i < strlen($pattern); ++$i) {
            if ($pattern[$i] >= 'A' && $pattern[$i] <= 'Z')
                $tmp2[] = $pattern[$i];
        }
        $j = 0;
        for ($i = 0; $i < strlen($pattern); ++$i) {
            if ($pattern[$i] == $word[$j]) {
                $j++;
                if ($j == strlen($word)) return false;
            } else
                while ($pattern[$i] != $word[$j]) {
                    $j++;
                    if ($j == strlen($word)) return false;
                }
        }
        return ($i == strlen($pattern)) && ($tmp1 == $tmp2);
    }
    /**
     * @param integer  $n
     * @return integer 
     */
    function nextGreaterElement($n)
    {
        $arr = str_split($n);
        $n = count($arr);
        for ($i = $n - 1; $i > 0; $i--) {
            if ($arr[$i] > $arr[$i - 1]) {
                $j = $i;
                while ($j < $n && $arr[$j] > $arr[$i - 1]) {
                    $j++;
                }
                $tmp = $arr[$i - 1];
                $arr[$i - 1] = $arr[$j - 1];
                $arr[$j - 1] = $tmp;
                break;
            }
        }
        if ($i == 0) return -1;
        $str = join("", array_merge(
            array_slice($arr, 0, $i),
            array_reverse(array_slice($arr, $i))
        ));
        return $str > pow(2, 31) - 1 ? -1 : (int)($str);
    }
    /**
     * @param integer [] $ratings
     * @return integer 
     */
    function candy($ratings)
    {
        $n = count($ratings);
        $left[0] = 1;
        for ($i = 1; $i < $n; ++$i) {
            if ($ratings[$i] > $ratings[$i - 1]) {
                $left[$i] = $left[$i - 1] + 1;
            } else $left[$i] = 1;
        }
        $ret = $right = 0;
        //$right = 1;
        //$ret += max(1, $left[$n - 1]);
        for ($i = $n - 1; $i >= 0; --$i) {
            if ($i < $n - 1 && $ratings[$i] > $ratings[$i + 1]) {
                $right++;
            } else $right = 1;
            $ret += max($right, $left[$i]);
        }
        return $ret;
    }
    /**
     * @param integer [] $satisfaction
     * @return integer 
     */
    function maxSatisfaction($satisfaction)
    {
        sort($satisfaction);
        $n = count($satisfaction);
        $sufSum = array_fill(0, $n + 1, 0);
        for ($i = $n - 1; $i >= 0; --$i) {
            $sufSum[$i] += $sufSum[$i + 1] + $satisfaction[$i];
        }
        $ans = 0;
        for ($i = 0; $i < $n; ++$i) {
            if ($sufSum[$i] > 0)
                $ans += $sufSum[$i];
        }
        return $ans;
    }
    /**
     * @param integer [] $g
     * @param integer [] $s
     * @return integer 
     */
    function findContentChildren($g, $s)
    {
        sort($g);
        sort($s);
        $i = $j = $ans = 0;
        while ($i < count($g) && $j < count($s)) {
            if ($s[$j] >= $g[$i]) {
                $ans++;
                $i++;
            }
            $j++;
        }
        return $ans;
    }
    /**
     * @param String[][] $orders
     * @return String[][]
     */
    function displayTable($orders)
    {
        // $food = $tables = $map = $ans = [];
        // foreach ($orders as $order) {
        //     if (!in_array($order[2], $food)) $food[] = $order[2];
        //     if (!in_array($order[1], $tables)) $tables[] = $order[1];
        // }
        // foreach ($tables as $table) {
        //     foreach ($food as $f) {
        //         $map[$table][$f] = 0;
        //     }
        // }
        // foreach ($orders as $order) {
        //     $map[$order[1]][$order[2]]++;
        // }
        // sort($food);
        // sort($tables);
        // $row0[] = "Table";
        // foreach ($food as $f)  $row0[] = $f;
        // $ans[] = $row0;
        // foreach ($tables as $table) {
        //     $tmp[] = $table;
        //     foreach ($food as $f) {
        //         $tmp[] = (string)($map[$table][$f]);
        //     }
        //     $ans[] = $tmp;
        //     $tmp = [];
        // }
        // return $ans;
        $map = $rs = [];
        foreach ($orders as $order) {
            $map[$order[2]][$order[1]] = isset($map[$order[2]][$order[1]]) ? $map[$order[2]][$order[1]] + 1 : 1;
        }
        ksort($map);
        $init = array_fill(0, count($map) + 1, '0');
        $index = 1;
        $rs[] = array_merge(['Table'], array_keys($map));
        foreach ($map as $food) {
            foreach ($food as $table => $item) {
                if (!isset($rs[$table])) {
                    $rs[$table] = $init;
                    $rs[$table][0] = (string)$table;
                }
                $rs[$table][$index] = (string)$item;
            }
            $index++;
        }
        ksort($rs);
        return array_values($rs);
    }
    /**
     * @param integer [][] $matrix
     * @return integer []
     */
    function findDiagonalOrder($matrix)
    {
        $m = count($matrix);
        if ($m == 0) return $matrix;
        $n = count($matrix[0]);
        if ($n == 0) return $matrix;
        $flag = true;
        $result = [];
        for ($i = 0; $i < ($m + $n); $i++) {
            $pm = $flag ? $m : $n;
            $pn = $flag ? $n : $m;
            $x = ($i < $pm) ? $i : $pm - 1;
            $y = $i - $x;
            while ($x >= 0 && $y < $pn) {
                $result[] = $flag ? $matrix[$x][$y] : $matrix[$y][$x];
                $x--;
                $y++;
            }
            $flag = !$flag;
        }
        return $result;
    }
    /**
     * @param String $s
     * @return integer 
     */
    function numDecodings($s)
    {
        $n = strlen($s);
        $dp = array_fill(0, $n, 0);

        if ($s[0] == '0') return 0;
        $dp[0] = 1; //一个有效数只有一种解法
        for ($i = 1; $i < $n; $i++) {
            if ($s[$i] != '0') $dp[$i] = $dp[$i - 1];
            if ($s[$i - 1] == '1' || ($s[$i - 1] == '2' && $s[$i] <= '6')) {
                // 有效范围内
                if ($i - 2 >= 0) {
                    $dp[$i] = $dp[$i] + $dp[$i - 2];
                } else {
                    $dp[$i] = $dp[$i] + 1;
                }
            }
        }

        return $dp[$n - 1];
    }
    /**
     * @param integer [] $students
     * @param integer [] $sandwiches
     * @return integer 
     */
    function countStudents($students, $sandwiches)
    {
        while ($students) {
            if ($students[0] == $sandwiches[0]) {
                array_shift($sandwiches);
                array_shift($students);
            } else {
                if ($sandwiches[0] == 0 && array_sum($students) == count($students))
                    return count($students);
                if ($sandwiches[0] == 1 && array_sum($students) == 0)
                    return count($students);
                $students[] = array_shift($students);
            }
        }
        return 0;
    }
    /**
     * @param integer [][] $customers
     * @return Float
     */
    function averageWaitingTime($customers)
    {
        $tot = 0;
        $prep = $customers[0][0];
        $n = count($customers);
        for ($i = 0; $i < $n; ++$i) {
            $prep = max($prep, $customers[$i][0]);
            $fin = $prep + $customers[$i][1];
            $tot += max($fin - $customers[$i][0], 0);
            $prep = $fin;
        }
        return $tot / $n;
    }

    /**
     * @param String $s
     * @return Boolean
     */
    function halvesAreAlike($s)
    {
        $vowls = ['a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U'];
        $n = strlen($s);
        $cntA = $cntB = 0;
        $a = substr($s, 0, $n / 2);
        $b = substr($s, $n / 2);
        for ($i = 0; $i < $n / 2; ++$i) {
            if (in_array($a[$i], $vowls)) $cntA++;
        }
        for ($i = 0; $i < $n / 2; ++$i) {
            if (in_array($b[$i], $vowls)) $cntB++;
        }
        return $cntA == $cntB;
    }

    /**
     * @param String $s
     * @param String $t
     * @return Boolean
     */
    function isIsomorphic($s, $t)
    {
        // $m1 = $m2 = [];
        // $n = strlen($s);
        // for ($i = 0; $i < $n; ++$i) {
        //     if (isset($m1[$s[$i]])) {
        //         if ($m1[$s[$i]] != $t[$i]) return false;
        //     } else $m1[$s[$i]] = $t[$i];
        // }
        // for ($i = 0; $i < $n; ++$i) {
        //     if (isset($m2[$t[$i]])) {
        //         if ($m2[$t[$i]] != $s[$i]) return false;
        //     } else $m2[$t[$i]] = $s[$i];
        // }
        // return true;
        $n = strlen($s);
        for ($i = 0; $i < $n; ++$i)
            if (strpos($s, $s[$i]) != strpos($t, $t[$i])) return false;
        return true;
    }
    /**
     * @param integer  $k
     * @param integer [] $prices
     * @return integer 
     */
    function maxProfit2($k, $prices)
    {
        $n = count($prices);
        $k = min($k, (int)($n / 2));
        $b = $s = array_fill(0, $k + 1, PHP_INT_MIN);
        $b[0] = -$prices[0];
        $s[0] = 0;
        for ($i = 1; $i < $n; ++$i) {
            $b[0] = max($b[0], $s[0] - $prices[$i]);
            for ($j = 1; $j <= $k; ++$j) {
                $b[$j] = max($b[$j], $s[$j] - $prices[$i]);
                $s[$j] = max($s[$j], $b[$j - 1] + $prices[$i]);
            }
        }
        return max($s);
    }
    /**
     * @param String $binary
     * @return String
     */
    function maximumBinaryString($binary)
    {
        if (($pos = strpos($binary, '0')) === false) return $binary;
        $ones = array_sum(str_split(substr($binary, $pos)));
        return str_repeat('1', strlen($binary) - $ones - 1) . '0' . str_repeat('1', $ones);
    }

    /**
     * @param integer  $target
     * @return integer 
     */
    function reachNumber($target)
    {
        $target = abs($target);
        $k = 0;
        while ($target > 0) {
            $k += 1;
            $target -= $k;
        }
        return $target % 2 == 0 ? $k : $k + 1 + $k % 2;
    }

    /**
     * @param integer [] $nums
     * @param integer  $n
     * @return integer 
     */
    function minPatches($nums, $n)
    {
        $cnt = $index = 0;
        $tot = 1;
        while ($tot <= $n) {
            if ($index < count($nums) && $nums[$index] <= $tot)
                $tot += $nums[$index++];
            else {
                $tot <<= 1;
                $cnt++;
            }
        }
        return $cnt;
    }

    /**
     * @param integer [] $nums
     * @param integer  $n
     * @param integer  $left
     * @param integer  $right
     * @return integer 
     */
    function rangeSum($nums, $n, $left, $right)
    {
        $ans = [];
        for ($i = 0; $i < $n; ++$i) {
            $preSum = 0;
            for ($j = $i; $j < $n; ++$j) {
                $preSum += $nums[$j];
                $ans[] = $preSum;
            }
        }
        sort($ans);
        return array_sum(array_slice($ans, $left - 1, $right - $left + 1)) % (1e9 + 7);
    }

    /**
     * @param integer [][] $intervals
     * @return integer 
     */
    function eraseOverlapIntervals($intervals)
    {
        $n = count($intervals);
        if ($n == 1) return 0;
        usort($intervals, function ($a, $b) {
            return $a[1] - $b[1];
        });
        $keep = 1;
        $right = $intervals[0][1];
        for ($i = 1; $i < $n; ++$i) {
            if ($intervals[$i][0] >= $right) {
                $keep++;
                $right = $intervals[$i][1];
            }
        }
        return $n - $keep;
    }

    /**
     * @param integer [] $heights
     * @return integer 
     */
    function largestRectangleArea($heights)
    {
        $n = count($heights);
        $left = array_fill(0, $n, 0);
        $right = array_fill(0, $n, $n);
        $stk = [];
        for ($i = 0; $i < $n; ++$i) {
            while (!empty($stk) && $heights[end($stk)] >= $heights[$i]) {
                $right[end($stk)] = $i;
                array_pop($stk);
            }
            $left[$i] = empty($stk) ? -1 : end($stk);
            $stk[] = $i;
        }
        $ans = 0;
        for ($i = 0; $i < $n; ++$i)
            $ans = max($ans, ($right[$i] - $left[$i] - 1) * $heights[$i]);
        return $ans;
    }

    /**
     * @param integer [] $arr
     * @return Boolean
     */
    function uniqueOccurrences($arr)
    {
        $freq = array_count_values($arr);
        $freq = array_values($freq);
        return count($freq) == count(array_unique($freq));
    }

    /**
     * @param integer [] $arr
     * @param integer [][] $pieces
     * @return Boolean
     */
    function canFormArray($arr, $pieces)
    {
        $head = [];
        foreach ($pieces as $p) $head[$p[0]] = $p;
        $n = count($arr);
        for ($i = 0; $i < $n;) {
            if (!in_array($arr[$i], array_keys($head))) return false;
            $len = count($head[$arr[$i]]);
            if (array_slice($arr, $i, $len) != $head[$arr[$i]]) return false;
            $i += $len;
        }
        return true;
    }

    /**
     * @param integer [] $nums
     * @param integer  $k
     * @return integer []
     */
    function maxSlidingWindow($nums, $k)
    {
        // $pq = new SplPriorityQueue;
        // $pq->setExtractFlags(SplPriorityQueue::EXTR_BOTH);
        // for ($i = 0; $i < $k; ++$i) $pq->insert($i, $nums[$i]);
        // $ans = [$pq->top()['priority']];
        // for ($i = $k; $i < count($nums); ++$i) {
        //     $pq->insert($i, $nums[$i]);
        //     while ($pq->top()['data'] <= $i - $k) $pq->extract();
        //     $ans[] = $pq->top()['priority'];
        // }
        // return $ans;
        $count = count($nums);
        $deque = new SplQueue();
        $ret = [];

        for ($i = 0; $i < $k; $i++) {
            while (!$deque->isEmpty() && $deque->top() < $nums[$i]) {
                $deque->pop();
            }
            $deque->enqueue($nums[$i]);
        }
        $ret[] = $deque->bottom();
        for ($i = $k; $i < $count; $i++) {
            if ($nums[$i - $k] == $deque->bottom()) {
                $deque->dequeue();
            }
            while (!$deque->isEmpty() && $deque->top() < $nums[$i]) {
                $deque->pop();
            }
            $deque->enqueue($nums[$i]);
            $ret[] = $deque->bottom();
        }
        return $ret;
    }

    /**
     * @param int[][] $boxTypes
     * @param int $truckSize
     * @return int
     */
    function maximumUnits($boxTypes, $truckSize)
    {
        usort($boxTypes, function ($a, $b) {
            return $b[1] - $a[1];
        });
        $n = count($boxTypes);
        $units = $boxes = $i = 0;
        while ($i < $n && $boxes < $truckSize) {
            $boxes += $boxTypes[$i][0];
            $units += $boxTypes[$i][0] * $boxTypes[$i][1];
            $i++;
        }
        if ($boxes > $truckSize) $units -= ($boxes - $truckSize) * $boxTypes[--$i][1];
        return $units;
    }

    /**
     * @param int[] $deliciousness
     * @return int
     */
    function countPairs($deliciousness)
    {
        $map = [];
        $ans = 0;
        foreach ($deliciousness as $d) {
            for ($i = 0; $i < 22; ++$i) {
                if (isset($map[(1 << $i) - $d])) {
                    $ans += $map[(1 << $i) - $d];
                }
            }
            $map[$d] = isset($map[$d]) ? $map[$d] + 1 : 1;
        }
        return $ans % (1e9 + 7);
    }



    /**
     * @param integer [] $apples
     * @param integer [] $days
     * @return integer 
     */
    function eatenApples($apples, $days)
    {
        $queue = new splPriorityQueue;
        $queue->setExtractFlags(SplPriorityQueue::EXTR_BOTH);
        $eatNum = 0;
        for ($i = 0; $i < count($apples) || !$queue->isEmpty(); $i++) {
            while (!$queue->isEmpty() && $queue->top()['priority'] == $i) {
                $queue->extract();
            }
            if ($i < count($apples) && $apples[$i] > 0) {
                $queue->insert($apples[$i], $days[$i] + $i);
            }
            if (!$queue->isEmpty()) {
                $tmp = $queue->extract();
                echo json_encode($tmp), "\n";
                $eatNum++;
                $tmp['data'] -= 1;
                if ($tmp['data'])
                    $queue->insert($tmp['data'], $tmp['priority']);
            }
        }
        return $eatNum;
    }

    /**
     * @param String $s
     * @return Integer[][]
     */
    function largeGroupPositions($s)
    {
        $n = strlen($s);
        $i = 0;
        $ans = [];
        while ($i < $n) {
            $c = $s[$i];
            $j = $i;
            while ($j < $n && $c == $s[$j]) $j++;
            if ($j - $i >= 3) $ans[] = [$i, $j - 1];
            $i = $j;
        }
        return $ans;
    }

    /**
     * @param Integer[][] $grid
     * @return Integer[]
     */
    function findBall($grid)
    {
        $rows = count($grid);
        $cols = count($grid[0]);
        for ($i = 0; $i < $rows; ++$i) {
            for ($j = 0; $j < $cols; ++$j) {
                //if()
            }
        }
    }

    /**
     * @param String[][] $equations
     * @param Float[] $values
     * @param String[][] $queries
     * @return Float[]
     */
    function calcEquation($equations, $values, $queries)
    {
        $nvars = 0;
        $variables = $edges = $ret = [];
        $n = count($equations);
        for ($i = 0; $i < $n; $i++) {
            if (!isset($variables[$equations[$i][0]])) {
                $variables[$equations[$i][0]] = $nvars++;
            }
            if (!isset($variables[$equations[$i][1]])) {
                $variables[$equations[$i][1]] = $nvars++;
            }
        }
        for ($i = 0; $i < $n; $i++) {
            $va = $variables[$equations[$i][0]];
            $vb = $variables[$equations[$i][1]];
            $edges[$va][] = [$vb, $values[$i]];
            $edges[$vb][] = [$va, 1.0 / $values[$i]];
        }
        foreach ($queries as $q) {
            $result = -1.0;
            if (isset($variables[$q[0]]) && isset($variables[$q[1]])) {
                $ia = $variables[$q[0]];
                $ib = $variables[$q[1]];
                if ($ia == $ib) $result = 1.0;
                else {
                    $points = [];
                    $points[] = $ia;
                    $ratios = array_fill(0, $nvars, -1.0);
                    $ratios[$ia] = 1.0;
                    while (!empty($points) && $ratios[$ib] < 0) {
                        $x = array_pop($points);
                        foreach ($edges[$x] as list($y, $val)) {
                            if ($ratios[$y] < 0) {
                                $ratios[$y] = $ratios[$x] * $val;
                                $points[] = $y;
                            }
                        }
                    }
                    $result = $ratios[$ib];
                }
            }
            $ret[] = $result;
        }
        return $ret;
    }
    /**
     * @param String[] $strs
     * @return String
     */
    function longestCommonPrefix($strs)
    {
        $n = count($strs);
        if ($n == 0) return "";
        $ans = "";
        for ($i = 0; $i < strlen($strs[0]); ++$i) {
            for ($j = 1; $j < $n; ++$j) {
                if (!isset($strs[$j][$i])) return $ans;
                if ($strs[$j][$i] != $strs[0][$i]) return $ans;
            }
            $ans .= $strs[0][$i];
        }
        return $ans;
    }

    /**
     * @param int $n
     * @param int $k
     * @return int
     */
    function paintingPlan($n, $k)
    {
        if ($n * $n == $k) return 1;
        $ans = 0;
        for ($i = 0; $i <= $n; ++$i) {
            for ($j = 0; $j <= $n; ++$j) {
                if (($i + $j) * $n - $i * $j == $k) {
                    $ans += $this->C($n, $i) * $this->C($n, $j);
                }
            }
        }
        return $ans;
    }
    function C($n, $m)
    {
        if ($n == $m) return 1;
        if ($n == 0) return 0;
        return $this->C($n - 1, $m) + $this->C($n - 1, $m - 1);
    }
    /**
     * @param Integer[] $arr
     * @param Integer $k
     * @return Integer
     */
    function findKthPositive($arr, $k)
    {
        $start = $i = $cnt = 0;
        while ($cnt < $k) {
            if ($i < count($arr) && $arr[$i] == $start + 1) $i++;
            else $cnt++;
            $start++;
        }
        return $start;
    }

    /**
     * @param Integer[][] $isConnected
     * @return Integer
     */
    function findCircleNum($isConnected)
    {
        $len = count($isConnected);
        $ans = 0;
        $visited = [];
        for ($i = 0; $i < $len; ++$i) {
            if (!isset($visited[$i])) {
                $this->dfs($i, $isConnected, $visited, $len);
                $ans++;
            }
        }
        return $ans;
    }
    function dfs($n, $isConnected, &$visited, $len)
    {
        for ($i = 0; $i < $len; ++$i) {
            if ($isConnected[$n][$i] && !isset($visited[$i])) {
                $visited[$i] = 1;
                $this->dfs($i, $isConnected, $visited, $len);
            }
        }
    }

    /**
     * @param String $s
     * @return Integer
     */
    function lengthOfLongestSubstring($s)
    {
        $left = $right = $cnt = 0;
        $pos = [];
        for ($i = 0; $i < strlen($s); ++$i) {
            if (isset($pos[$s[$i]]) && $pos[$s[$i]] >= $left) {
                $left = $pos[$s[$i]] + 1;
            }
            $pos[$s[$i]] = $i;
            //echo substr($s, $left, $i - $left + 1), "\n";
            $cnt = max($cnt, $i - $left + 1);
        }
        return $cnt;
    }
    /**
     * @param String $s
     * @param Integer $n
     * @return String
     */
    function reverseLeftWords($s, $n)
    {
        return substr($s, 0, $n) . substr($s, $n);
    }
    /**
     * @param integer[] $nums
     * @return integer
     */
    function waysToSplit($nums)
    {
        // $n = count($nums);
        // $pS[0] = $nums[0];
        // for ($i = 1; $i < $n; $i++)
        //     $pS[$i] = $pS[$i - 1] + $nums[$i];
        // $ret = 0;
        // for ($i = 0; $i < $n - 1; $i++) {
        //     if ($pS[$i] * 3 > $pS[$n - 1]) break;
        //     $l = $i + 1;
        //     $r = $n - 2;
        //     while ($l <= $r) {
        //         $m = (int)(($l + $r) / 2);
        //         if ($pS[$n - 1] - $pS[$m] >= $pS[$m] - $pS[$i])
        //             $l = $m + 1;
        //         else $r = $m - 1;
        //     }
        //     $ll = $i + 1;
        //     $rr = $n - 1;
        //     while ($ll <= $rr) {
        //         $m = (int)(($ll + $rr) / 2);
        //         if ($pS[$m] - $pS[$i] >= $pS[$i]) $rr = $m - 1;
        //         else $ll = $m + 1;
        //     }
        //     $ret += $r - $ll + 1;
        // }
        // return $ret % (1e9 + 7);
        $n = count($nums);
        $MOD = 1e9 + 7;
        $s[0] = $nums[0];
        for ($i = 1; $i < $n; ++$i)
            $s[$i] = $s[$i - 1] + $nums[$i];
        $ans = 0;
        $l = $r = 1;
        for ($m = 1; $m < $n - 1; ++$m) {
            $l = max($l, $m);
            $r = max($r, $m);
            while (
                $r < $n  &&
                $s[$n - 1] - $s[$r] >= $s[$r] - $s[$m]
            )
                $r++;
            while ($l < $n && $s[$l] - $s[$m] < $s[$m])
                $l++;
            if (
                $r < $n  &&
                $l <= $r &&
                $s[$l] - $s[$m - 1] >= $s[$m] &&
                $s[$n - 1] - $s[$r] >= $s[$r] - $s[$m]
            )
                $ans += $r - $l + 1;
        }
        return $ans % $MOD;
    }
    /**
     * @param String[] $word1
     * @param String[] $word2
     * @return Boolean
     */
    function arrayStringsAreEqual($word1, $word2)
    {
        return array_reduce($word1, function ($a, $b) {
            return $a . $b;
        }) === array_reduce($word2, function ($a, $b) {
            return $a . $b;
        });
    }
    /**
     * @param int $n
     * @param int $start
     * @return Integer
     */
    function xorOperation($n, $start)
    {
        $ans = $i = 0;
        while ($i < $n) {
            $ans ^= $start;
            $i++;
            $start += 2;
        }
        return $ans;
    }
    /**
     * @param int[] $prices
     * @return Integer
     */
    function maxProfit1($prices)
    {
        $n = count($prices);
        $buy1 = -$prices[0];
        $sell1 = 0;
        $buy2 = -$prices[0];
        $sell2 = 0;
        for ($i = 1; $i < $n; ++$i) {
            $buy1 = max($buy1, -$prices[$i]);
            $sell1 = max($sell1, $buy1 + $prices[$i]);
            $buy2 = max($buy2, $sell1 - $prices[$i]);
            $sell2 = max($sell2, $buy2 + $prices[$i]);
        }
        return $sell2;
    }

    /**
     * @param Integer $n
     * @return Integer
     */
    function totalMoney($n)
    {
        $week = $ans = $i = 0;
        while ($i < $n) {
            for ($j = 1; $j <= 7; ++$j) {
                $ans += $week + $j;
                $i++;
                if ($i > 0 && $i % 7 == 0) $week++;
                if ($i == $n) break;
            }
        }
        return $ans;
    }

    /**
     * @param int[] $encoded
     * @param int $first
     * @return Integer[]
     */
    function decode($encoded, $first)
    {
        $ans = [];
        $tmp = $first;
        $n = count($encoded);
        for ($i = 0; $i < $n; ++$i) {
            $ans[$i] = $first ^ $encoded[$i];
            $first = $ans[$i];
        }
        return array_merge([$tmp], $ans);
    }

    /**
     * @param Integer[] $source
     * @param Integer[] $target
     * @param Integer[][] $allowedSwaps
     * @return Integer
     */
    function minimumHammingDistance($source, $target, $allowedSwaps)
    {
        $len = sizeof($allowedSwaps);
        $uf = new UnionFind6($len);
        foreach ($allowedSwaps as $a)
            $uf->union($a[0], $a[1]);

        $ans = 0;
        for ($i = 0; $i < count($source); ++$i) {
            $pos = array_search($source[$i], $target);
            if ($pos === $i) continue;
            if ($pos === false || !$uf->isConnected($i, $pos)) $ans++;
        }
        return $ans;
    }

    /**
     * @param int[] $nums
     * @return String[]
     */
    function summaryRanges($nums)
    {
        $ans = [];
        $i = 0;
        $n = count($nums);
        while ($i < $n) {
            $cnt = 0;
            while ($i + 1 < $n && $nums[$i] + 1 == $nums[$i + 1]) {
                $i++;
                $cnt++;
            }
            if ($cnt == 0) $ans[] = (string)($nums[$i]);
            else $ans[] = $nums[$i - $cnt] . "->" . $nums[$i];
            $i++;
        }
        return $ans;
    }
    function topSort(&$deg, &$graph, &$items)
    {
        $Q = [];
        foreach ($items as $item)
            if ($deg[$item] == 0) $Q[] = $item;
        $res = [];
        while (!empty($Q)) {
            $u = array_shift($Q);
            $res[] = $u;
            foreach ($graph[$u] as $v)
                if (--$deg[$v] == 0) $Q[] = $v;
        }
        return count($res) == count($items) ? $res : [];
    }

    /**
     * @param int $n
     * @param int $m
     * @param int[] $group
     * @param int[][] $beforeItems
     * @return int[]
     */
    function sortItems($n, $m, $group, $beforeItems)
    {
    }

    /**
     * @param String $s
     * @param int $x
     * @param int $y
     * @return Integer
     */
    function maximumGain($s, $x, $y)
    {
        $res = 0;
        $big = $x > $y ? "ab" : "ba";
        $small = $big == "ab" ? "ba" : "ab";
        $str = $this->getScore($s, $big, max($x, $y), $res);
        $this->getScore($str, $small, min($x, $y), $res);
        return $res;
    }
    function getScore($s, $target, $score, &$res)
    {
        $stack = [];
        for ($i = 0; $i < strlen($s); ++$i) {
            if ($stack && end($stack) . $s[$i] == $target) {
                array_pop($stack);
                $res += $score;
            } else $stack[] = $s[$i];
        }
        return join("", $stack);
    }

    /**
     * @param int $n
     * @return Integer[]
     */
    function constructDistancedSequence($n)
    {
        $ret = array_fill(0, 2 * $n - 1, 0);
        $used = array_fill(0, 21, 0);
        $this->dfs2(0, $ret, $used, $n);
        return $ret;
    }
    function dfs2($pos, &$ret, &$used, $n)
    {
        if ($pos == 2 * $n - 1) return true;
        if ($ret[$pos] > 0)
            return $this->dfs2($pos + 1, $ret, $used, $n);
        for ($d = $n; $d > 0; --$d) {
            if ($used[$d] > 0) continue;
            if ($d > 1 && ($pos + $d >= 2 * $n - 1 || $ret[$pos + $d] > 0)) continue;
            $used[$d] = 1;
            $ret[$pos] = $d;
            if ($d > 1) $ret[$pos + $d] = $d;
            if ($this->dfs2($pos + 1, $ret, $used, $n)) return true;
            $used[$d] = 0;
            $ret[$pos] = 0;
            if ($d > 1) $ret[$pos + $d] = 0;
        }
        return false;
    }

    /**
     * @param int[] $A
     * @return Boolean[]
     */
    function prefixesDivBy5($A)
    {
        $start = 0;
        $ans = [];
        for ($i = 0; $i < count($A); ++$i) {
            $start = (2 * $start + $A[$i]) % 5;
            $ans[] = ($start == 0) ? true : false;
        }
        return $ans;
    }

    /**
     * @param int[] $nums
     * @param int $x
     * @return Integer
     */
    function minOperations($nums, $x)
    {
        // $um = [];
        // $ans = PHP_INT_MAX;

        // $um[0] = -1;
        // $sum = 0;
        // for ($i = 0; $i < count($nums); $i++) {
        //     $sum += $nums[$i];
        //     $um[$sum] = $i;
        // }

        // $sum = 0;
        // if (isset($um[$x])) {
        //     $ans = min($ans, $um[$x] + 1);
        // }
        // for ($i = count($nums) - 1; $i >= 0; $i--) {
        //     $sum += $nums[$i];
        //     if (isset($um[$x - $sum])) {
        //         $cnt = count($nums) - $i + $um[$x - $sum] + 1;
        //         if ($cnt > count($nums)) continue;
        //         $ans = min($ans, $cnt);
        //     }
        // }

        // return $ans == PHP_INT_MAX ? -1 : $ans;
        $sum = array_sum($nums);
        $diff = $sum - $x;
        if ($diff < 0) return -1;
        if ($diff == 0) return count($nums);
        $step = -1;
        $s = 0;
        $left = $right = 0;
        while ($left < count($nums)) {
            if ($right < count($nums)) $s += $nums[$right++];
            while ($s > $diff && $left < count($nums))
                $s -= $nums[$left++];
            if ($s == $diff) $step = max($step, $right - $left);
            if ($right == count($nums)) $left++;
        }
        return $step == -1 ? -1 : count($nums) - $step;
    }

    /**
     * @param Integer[][] $stones
     * @return Integer
     */
    function removeStones($stones)
    {
        $n = count($stones);
        $ans = 0;
        $visited = array_fill(0, $n, 0);
        for ($i = 0; $i < $n; ++$i) {
            if ($visited[$i]) continue;
            else $ans++;
            $this->dfs3($n, $stones, $stones[$i], $visited);
        }
        return $n - $ans;
    }

    function dfs3($n, $stones, $pair, &$visited)
    {
        for ($i = 0; $i < $n; ++$i) {
            if ($visited[$i]) continue;
            if ($stones[$i][0] == $pair[0] || $stones[$i][1] == $pair[1]) {
                $visited[$i] = 1;
                $this->dfs3($n, $stones, $stones[$i], $visited);
            }
        }
    }

    /**
     * @param Integer[][] $rectangles
     * @return Integer
     */
    function countGoodRectangles($rectangles)
    {
        $ans = [];
        foreach ($rectangles as $r) {
            $ans[] = min($r);
        }
        $max = max($ans);
        return array_count_values($ans)[$max];
    }

    /**
     * @param int[] $nums
     * @return Integer
     */
    function tupleSameProduct($nums)
    {
        $n = count($nums);
        $map = [];
        for ($i = 0; $i < $n - 1; ++$i) {
            for ($j = $i + 1; $j < $n; ++$j) {
                $k = $nums[$i] * $nums[$j];
                $map[$k] = isset($map[$k]) ? $map[$k] + 1 : 1;
            }
        }
        $ans = 0;
        foreach ($map as $p => $cnt) {
            if ($cnt > 1) {
                $ans += $this->Cnm($cnt, 2) * 8;
            }
        }
        return $ans;
    }
    function Cnm($n, $m)
    {
        if ($m == 1) return $n;
        if ($n == 0) return 0;
        return $this->Cnm($n - 1, $m) + $this->Cnm($n - 1, $m - 1);
    }

    /**
     * @param String[][] $accounts
     * @return String[][]
     */
    function accountsMerge($accounts)
    {
    }

    /**
     * @param int[][] $matrix
     * @return Integer
     */
    function largestSubmatrix($matrix)
    {
        $n = count($matrix);
        $m = count($matrix[0]);
        for ($i = 1; $i < $n; ++$i)
            for ($j = 0; $j < $m; ++$j)
                if ($matrix[$i][$j])
                    $matrix[$i][$j] = $matrix[$i - 1][$j] + 1;

        $area = 0;
        for ($i = 0; $i < $n; ++$i) {
            rsort($matrix[$i]);
            for ($j = 0; $j < $m; ++$j)
                $area = max($area, ($j + 1) * $matrix[$i][$j]);
        }
        return $area;
    }

    /**
     * @param int[][] $points
     * @return Integer
     */
    function minCostConnectPoints($points)
    {
        // $pq = new SplPriorityQueue;
        // $pq->setExtractFlags(SplPriorityQueue::EXTR_BOTH);
        // $pq->insert(0, 0);
        // $ans = 0;
        // $n = count($points);
        // $vi = array_fill(0, $n, false);
        // while ($pq->count() && $n > 0) {
        //     $a = $pq->extract();
        //     $p1 = $a['data'];
        //     $dis = $a['priority'];
        //     if ($vi[$p1]) continue;
        //     $ans -= $dis;
        //     $vi[$p1] = true;
        //     $n--;
        //     for ($p2 = 0; $p2 < count($points); $p2++) {
        //         if ($vi[$p2]) continue;
        //         $d = abs($points[$p1][0] - $points[$p2][0]) +
        //             abs($points[$p1][1] - $points[$p2][1]);
        //         $pq->insert($p2, -$d);
        //     }
        // }
        // return $ans;
        $n = count($points);
        $nearest = array_fill(0, $n, PHP_INT_MAX);
        $nearest[0] = 0;
        $tmp = $points[0];
        unset($points[0]);
        while ($points) {
            $min = PHP_INT_MAX;
            foreach ($points as $k => $v) {
                $d = abs($v[0] - $tmp[0]) + abs($v[1] - $tmp[1]);
                $nearest[$k] = min($nearest[$k], $d);
                $min = min($min, $nearest[$k]);
                if ($min == $nearest[$k]) $next = $k;
            }
            $tmp = $points[$next];
            unset($points[$next]);
        }
        //array_shift($nearest);
        echo json_encode($nearest);
        return array_sum($nearest);
    }

    /**
     * @param Integer[] $nums
     * @param Integer $val
     * @return Integer
     */
    function removeElement(&$nums, $val)
    {
        $i = 0;
        for ($j = 0; $j < count($nums); $j++) {
            if ($nums[$j] != $val) {
                $nums[$i] = $nums[$j];
                $i++;
            }
        }
        return $i;
    }
    /**
     * @param String $s
     * @return String
     */
    function longestPalindrome($s)
    {
        if (strlen($s) < 2) return $s;
        $start = $end = 0;
        for ($i = 0; $i < strlen($s); ++$i) {
            [$left1, $right1] = $this->expand($s, $i, $i);
            [$left2, $right2] = $this->expand($s, $i, $i + 1);
            if ($right1 - $left1 > $end - $start) {
                $start = $left1;
                $end = $right1;
            }
            if ($right2 - $left2 > $end - $start) {
                $start = $left2;
                $end = $right2;
            }
        }
        return substr($s, $start, $end - $start + 1);
    }

    function expand($s, $left, $right)
    {
        while ($left >= 0 && $right < strlen($s) && $s[$left] == $s[$right]) {
            $left--;
            $right++;
        }
        return [$left + 1, $right - 1];
    }

    /**
     * @param int[] $nums
     * @return Integer
     */
    function maximumProduct($nums)
    {
        sort($nums);
        $n = count($nums);
        return max($nums[0] * $nums[1] * end($nums), end($nums) * $nums[$n - 2] * $nums[$n - 3]);
    }
    /**
     * @param String $s
     * @param Integer $numRows
     * @return String
     */
    function convert($s, $numRows)
    {
        $n = strlen($s);
        $min = min($numRows, $n);
        $down = false;
        $str = array_fill(0, $min, "");
        $curRow = 0;
        for ($i = 0; $i < $n; ++$i) {
            $str[$curRow] .= $s[$i];
            if ($curRow == 0 || $curRow == $min - 1) $down = !$down;
            $curRow += $down ? 1 : -1;
        }
        $ans = "";
        foreach ($str as $ss) $ans .= $ss;
        return $ans;
    }
    /**
     * @param string $word1
     * @param string $word2
     * @return Boolean
     */
    function closeStrings($word1, $word2)
    {
        [$n1, $n2] = [strlen($word1), strlen($word2)];
        if ($n1 != $n2) return false;
        $word1 = str_split($word1);
        $word2 = str_split($word2);
        $c1 = array_values(array_count_values($word1));
        $c2 = array_values(array_count_values($word2));
        sort($c1);
        sort($c2);
        $s1 = array_unique($word1);
        $s2 = array_unique($word2);
        sort($s1);
        sort($s2);
        return $c1 == $c2 && $s1 == $s2;
    }
    /**
     * @param Integer[][] $mat
     * @return Integer[][]
     */
    function diagonalSort($mat)
    {
        $m = count($mat);
        $n = count($mat[0]);
        $map = [];
        for ($i = 1 - $n; $i < $m; ++$i) $map[$i] = [];
        for ($i = 0; $i < $m; ++$i) {
            for ($j = 0; $j < $n; ++$j) {
                $map[$j - $i][] = $mat[$i][$j];
            }
        }
        foreach ($map as $k => $v) {
            rsort($v);
            $map[$k] = $v;
        }
        $res = $mat;
        for ($i = 0; $i < $m; ++$i) {
            for ($j = 0; $j < $n; ++$j) {
                $res[$i][$j] = array_pop($map[$j - $i]);
            }
        }
        return $res;
    }
    /**
     * @param int[] $gain
     * @return Integer
     */
    function largestAltitude($gain)
    {
        $start = 0;
        $max = 0;
        foreach ($gain as $g) {
            $start += $g;
            $max = max($max, $start);
        }
        return $max;
    }
    /**
     * @param String $time
     * @return String
     */
    function maximumTime($time)
    {
        $h = "";
        $b = 0;
        for ($i = 50; $i >= 48; --$i) {
            for ($j = 57; $j >= 48; --$j) {
                $h = ($time[0] == '?' ? chr($i) : $time[0]) . ($time[1] == '?' ? chr($j) : $time[1]);
                if ($h <= '23') {
                    $b = 1;
                    break;
                }
            }
            if ($b) break;
        }

        $m = "";
        $b = 0;
        for ($i = 53; $i >= 48; --$i) {
            for ($j = 57; $j >= 48; --$j) {
                $m = ($time[3] == '?' ? chr($i) : $time[3]) . ($time[4] == '?' ? chr($j) : $time[4]);
                if ($m <= '59') {
                    $b = 1;
                    break;
                }
            }
            if ($b) break;
        }
        return $h . ':' . $m;
    }

    /**
     * @param int $n
     * @param int[][] $languages
     * @param int[][] $friendships
     * @return int
     */
    function minimumTeachings($n, $languages, $friendships)
    {
        $lanCnt = array_fill(0, $n, 0);
        $visited = array_fill(0, count($languages), false);
        $cnt = 0;
        foreach ($friendships as $fs) {
            $a = $fs[0] - 1;
            $b = $fs[1] - 1;
            if (array_intersect($languages[$a], $languages[$b]) == []) {
                if (!$visited[$a]) {
                    foreach ($languages[$a] as $l) {
                        $lanCnt[$l - 1]++;
                    }
                    $cnt++;
                    $visited[$a] = true;
                }
                if (!$visited[$b]) {
                    foreach ($languages[$b] as $l) {
                        $lanCnt[$l - 1]++;
                    }
                    $cnt++;
                    $visited[$b] = true;
                }
            }
        }
        return $cnt - max($lanCnt);
    }


    /**
     * @param Integer[][] $dominoes
     * @return Integer
     */
    function numEquivDominoPairs($dominoes)
    {
        $ans = 0;
        $freq = [];
        foreach ($dominoes as $d) {
            //sort($d);
            //$k = join("", $d);
            $k = min($d) . max($d);
            $freq[$k] = isset($freq[$k]) ? $freq[$k] + 1 : 1;
            $ans += $freq[$k] - 1;
        }
        return $ans;
    }

    /**
     * @param int[] $encoded
     * @return int[]
     */
    function decode2($encoded)
    {
        $n = count($encoded) + 1;
        $all = $rest = 0;
        for ($i = 1; $i <= $n; ++$i) $all ^= $i;
        for ($i = 1; $i < $n; $i += 2) $rest ^= $encoded[$i];
        $ans[0] = $all ^ $rest;
        for ($i = 1; $i < $n; ++$i) {
            $ans[$i] = $ans[$i - 1] ^ $encoded[$i - 1];
        }
        return $ans;
    }

    /**
     * @param string $num1
     * @param string $num2
     * @return String
     */
    function addStrings($num1, $num2)
    {
        $i = strlen($num1) - 1;
        $j = strlen($num2) - 1;
        $ans = "";
        $carry = 0;
        while ($i >= 0 || $j >= 0) {
            $sum = ($i >= 0 ? $num1[$i] : 0) + ($j >= 0 ? $num2[$j] : 0) + $carry;
            if ($sum >= 10) {
                $sum -= 10;
                $carry = 1;
            } else $carry = 0;
            $ans .= $sum;
            $i--;
            $j--;
        }
        if ($carry) $ans .= "1";
        return strrev($ans);
    }

    /**
     * @param String $haystack
     * @param String $needle
     * @return Integer
     */
    function strStr($haystack, $needle)
    {
        $m = strlen($needle);
        $n = strlen($haystack);
        if (!$m) return 0;
        $next = array_fill(0, $m, 0);
        $next[0] = -1;
        $j = -1;
        for ($i = 0; $i < $m - 1; $i++) {
            while ($j >= 0 && $needle[$j] != $needle[$i]) $j = $next[$j];
            $j++;
            $next[$i + 1] = $j;
        }
        $j = 0;
        for ($i = 0; $i < $n; $i++) {
            while ($j >= 0 && $haystack[$i] != $needle[$j]) $j = $next[$j];
            $j++;
            if ($j == $m) return $i - $m + 1;
        }
        return -1;
    }
    /**
     * @param int $n
     * @return Integer
     */
    function concatenatedBinary($n)
    {
        $shift = $ans = 0;
        for ($i = 1; $i < $n + 1; ++$i) {
            if (($i & ($i - 1)) == 0) $shift++;
            $ans = (($ans << $shift) + $i) % (1e9 + 7);
            echo $ans, "\n";
        }
        return $ans;
    }

    /**
     * @param String $a
     * @param String $b
     * @return Integer
     */
    function minCharacters($a, $b)
    {
        $fA = $fB = $fC = array_fill(0, 26, 0);
        for ($i = 0; $i < strlen($a); ++$i)
            $fA[ord($a[$i]) - 97]++;
        for ($i = 0; $i < strlen($b); ++$i)
            $fB[ord($b[$i]) - 97]++;
        $c = $a . $b;
        for ($i = 0; $i < strlen($c); ++$i)
            $fC[ord($c[$i]) - 97]++;
        $ans = array_sum($fC) - max($fC);
        for ($i = 1; $i < 26; ++$i) {
            $ans = min($ans, array_sum(array_slice($fA, 0, $i)) + array_sum(array_slice($fB, $i)));
            $ans = min($ans, array_sum(array_slice($fB, 0, $i)) + array_sum(array_slice($fA, $i)));
        }
        return $ans;
    }
}


//data
$ns = new Solution;
$a = "aba";
$b = "caa";
$a = "dabadd";
$b = "cda";
echo json_encode($ns->minCharacters($a, $b)), "\n";
