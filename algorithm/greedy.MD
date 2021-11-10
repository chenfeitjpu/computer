贪心算法

# 定义 #
通过局部最优得到全局最优

# 应用 #
## LEETCODE ##
### 455.分发饼干 ###
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 贪心-给满足孩子需求最小尺寸的饼干
 */
function findContentChildren($g, $s) {
    sort($g);
    sort($s);
    for ($i = 0, $j = 0, $sl = count($s), $gl = count($g); $i < $sl && $j < $gl; $i++) {
        if ($s[$i] >= $g[$j]) {
            $j++;
        }
    }
    return $j;
}
</code>
</pre>
</details>

### 135.分发糖果 ###
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 贪心-一次比较一个方向
 */
function candy($ratings) {
    $len = count($ratings);
    $res = array_fill(0, $len, 1);
    for ($i = 0; $i < $len - 1; $i++) {
        if ($ratings[$i]  < $ratings[$i + 1]) {
            $res[$i + 1] = $res[$i] + 1;
        }
    }
    for ($j = $len - 1; $j > 0; $j--) {
        if ($ratings[$j - 1] > $ratings[$j]) {
            $res[$j - 1] = max($res[$j - 1], $res[$j] + 1);
        }
    }
    return array_sum($res);
}
</code>
</pre>
</details>

### 435.无重叠区间 ###
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 贪心-重叠区间保留终点较小的
 */
function eraseOverlapIntervals($intervals) {
    $len = count($intervals);
    if ($len <= 1) {
        return 0;
    }
    array_multisort(array_column($intervals, 1), SORT_ASC, $intervals);
    $end = $intervals[0][1];
    $total = 0;
    for ($i = 1; $i < $len; $i++) {
        if ($intervals[$i][0] < $end) {
            $total++;
        } else {
            $end = $intervals[$i][1];
        }
    }
    return $total;
}
</code>
</pre>
</details>

### 605.种花问题 ###
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 贪心-有空位就种
 */
function canPlaceFlowers($flowerbed, $n) {
    if ($n < 1) {
        return true;
    }
    $len = count($flowerbed);
    if ($len < 1) {
        return false;
    }
    $total = 0;
    for ($i = 0; $i < $len; $i++) {
        if ($flowerbed[$i] == 1
            || $i < $len - 1 && $flowerbed[$i + 1] == 1
            || $i > 0 && $flowerbed[$i - 1] == 1
        ) {
            continue;
        }
        $flowerbed[$i] = 1;
        $total++;
        if ($total >= $n) {
            return true;
        }
    }
    return false;
}
</code>
</pre>
</details>

### 452.用最少数量的箭引爆气球 ###
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 贪心-保留区间的终点位置
 */
function findMinArrowShots($points) {
    $len = count($points);
    if ($len <= 1) {
        return $len;
    }
    array_multisort(array_column($points, 1), SORT_ASC, $points);
    $total = 1;
    $end = $points[0][1];
    for ($i = 1; $i < $len; $i++) {
        if ($points[$i][0] > $end) {
            $total++;
            $end = $points[$i][1];
        }
    }
    return $total;
}
</code>
</pre>
</details>

#### 763.划分字母区间 ####
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 贪心-保留字母的最后一个位置
 */
function partitionLabels($s) {
    $len = strlen($s);
    if ($len < 1) {
        return [];
    }
    $map = [];
    for ($i = 0; $i < $len; $i++) {
        $map[$s[$i]] = $i;
    }
    list($start, $end) = [0, $map[$s[0]]];
    $res = [];
    for ($j = 1; $j < $len; $j++) {
        if ($j > $end) {
            $res[] = $end - $start + 1;
            $start = $j;
            $end = $map[$s[$j]];
        } else {
            $end = max($end, $map[$s[$j]]);
        }
    }
    $res[] = $end - $start + 1;
    return $res;
}
</code>
</pre>
</details>

#### 122.买卖股票的最佳时机 II ####
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 贪心-盈利就卖
 */
function maxProfit($prices) {
    $len = count($prices);
    if ($len < 1) {
        return 0;
    }
    $total = 0;
    for ($i = 1; $i < $len; $i++) {
        $profit = $prices[$i] - $prices[$i -1];
        if ($profit > 0) {
            $total += $profit;
        }
    }
    return $total;
}
</code>
</pre>
</details>

#### 406.根据身高重建队列 ####
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 贪心-先放高的
 */
function reconstructQueue($people) {
    $len = count($people);
    if ($len < 1) {
        return $people;
    }
    array_multisort(array_column($people, 0), SORT_DESC, $people);
    $res = [];
    for ($i = 0; $i < $len; $i++) {
        array_splice($res, $people[$i][1], 0, [$people[$i]]);
    }
    return $res;
}
</code>
</pre>
</details>

#### 665.非递减数列 ####
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 贪心-考虑前中后三个元素
 */
function checkPossibility($nums) {
    $len = count($nums);
    if ($len < 1) {
        return true;
    }
    $cnt = 0;
    for ($i = 0; $i < $len - 1; $i++) {
        if ($nums[$i] > $nums[$i + 1]) {
            if ($cnt >= 1) {
                return false;
            }
            if ($i == 0 || $nums[$i + 1] >= $nums[$i - 1) {
                $nums[$i] = $nums[$i + 1];
                $cnt++;
            } else {
                $nums[$i + 1] = $nums[$i];
                $cnt++;
            }
        }
    }
    return true;
}
</code>
</pre>
</details>


