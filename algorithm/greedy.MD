## 定义 ##
通过局部最优得到全局最优

## 常见问题 ##

### leetcode ###

#### 455.分发饼干 ####
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 给满足孩子需求最小尺寸的饼干
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

#### 135.分发糖果 ####
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 先比较一边，再比较另一边
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

#### 435.无重叠区间 ####
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 重叠区间保留终点较小的
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

