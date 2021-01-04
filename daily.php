<?php
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
        return join($stack);
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
        $str = join(array_merge(
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
     * @param integer [] $apples
     * @param integer [] $days
     * @return integer 
     */
    function eatenApples($apples, $days)
    {
        $n = count($apples);
        $ans = $last = 0;
        for ($i = 0; $i < $n; ++$i) {
            if ($apples[$i] > $days[$i]) {
                $t = min($apples[$i], $days[$i]);
                $m = max($t, $last);
            } elseif ($apples[$i] < $days[$i]) {
                $t = min($apples[$i], $days[$i]);
                $m = min($days[$i], $t + $last);
            } else {
                $m = max($last, $apples[$i]);
            }
            if ($m > 0) {
                $ans++;
                $last = $m - 1;
            } else $last = 0;
        }
        $ans += $m - 1;
        return $ans;
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
}

//data
//$deliciousness = [1, 3, 5, 7, 9];
//$deliciousness = [1, 1, 1, 3, 3, 3, 7];
$deliciousness = [149, 107, 1, 63, 0, 1, 6867, 1325, 5611, 2581, 39, 89, 46, 18, 12, 20, 22, 234];

$ns = new Solution;
echo json_encode($ns->countPairs($deliciousness));
