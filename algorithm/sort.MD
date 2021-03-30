# 排序算法 #

## 定义 ##
对元素进行排序

## 常见排序 ##
<details>
<summary>冒泡</summary>
<pre>
<code>
/**
 * 两两比较
 */
function bubble($nums) {
    $len = count($nums);
    if ($len <= 1) {
        return $nums;
    }
    for ($i = 0; $i < $len - 1; $i++) {
        for ($j = 0; $j < $len - $i - 1; $j++) {
            if ($nums[$j] > $nums[$j + 1]) {
                list($nums[$j], $nums[$j + 1]) = [$nums[$j + 1], $nums[$j]];
            }
        }
    }
    return $nums;
}
</code>
</pre>
</details>

<details>
<summary>选择</summary>
<pre>
<code>
/**
 * 从待排序里选择一个
 */
function select($nums) {
    $len = count($nums);
    if ($len <= 1) {
        return $nums;
    }
    for ($i = 0; $i < $len - 1; $i++) {
        $min = $i;
        for ($j = $i + 1; $j < $len; $j++) {
            if ($nums[$j] < $nums[$min]) {
                $min = $j;
            }
        }
        list($nums[$i], $nums[$min]) = [$nums[$min], $nums[$i]];
    }
    return $nums;
}
</code>
</pre>
</details>

<details>
<summary>插入</summary>
<pre>
<code>
/**
 * 向有序数组中插入一个
 */
function insert($nums) {
    $len = count($nums);
    if($len <= 1) {
        return $nums;
    }
    for ($i = 1; $i < $len; $i++) {
        $radix = $nums[$i];
        for ($j = $i - 1; $j >= 0; $j--) {
            if ($nums[$j] > $radix) {
                $nums[$j + 1] = $nums[$j];
            } else {
                break;
            }
        }
        $nums[$j + 1] = $radix;
    }
    return $nums;
}
</code>
</pre>
</details>

<details>
<summary>快排</summary>
<pre>
<code>
function quick($nums) {
    $len = count($nums);
    if ($len <= 1) {
        return $nums;
    }
    quickSort($nums, 0, $len - 1);
    return $nums;
}
function quickSort(&$nums, $start, $end) {
    if ($start >= $end) {
        return;
    }
    $radix = $start;
    list($left, $right) = [$start, $end];
    while ($left < $right) {
        while ($left < $right && $nums[$right] >= $nums[$radix]) {
            $right--;
        }
        while ($left < $right && $nums[$left] <= $nums[$radix]) {
            $left++;
        }
        if ($left < $right) {
            list($nums[$left], $nums[$right]) = [$nums[$right], $nums[$left]];
        }
    }
    list($nums[$radix], $nums[$right]) = [$nums[$right], $nums[$start]];
    quickSort($nums, $start, $right - 1);
    quickSort($nums, $right + 1, $end);
}
</code>
</pre>
</details>

<details>
<summary>归并</summary>
<pre>
<code>
function merge($nums) {
    $len = count($nums);
    if ($len < 1) {
        return $nums;
    }
    mergeSort($nums, 0, $len - 1);
    return $nums;
}
function mergeSort(&$nums, $start, $end) {
    if ($start >= $end) {
        return;
    }
    $mid = $start + intval(($end - $start) / 2);
    mergeSort($nums, $start, $mid);
    mergeSort($nums, $mid + 1, $end);
    mergeSortArray($nums, $start, $mid, $end);
}
function mergeSortArray(&$nums, $start, $mid, $end) {
    if ($start >= $end) {
        return;
    }
    list($i, $j) = [$start, $mid + 1];
    $tmp = [];
    while ($i <= $mid && $j <= $end) {
        $tmp[] = $nums[$i] <= $nums[$j] ? $nums[$i++] : $nums[$j++];
    }
    while ($i <= $mid) {
        $tmp[] = $nums[$i++];
    }
    while ($j <= $end) {
        $tmp[] = $nums[$j++];
    }
    $k = 0;
    while ($start <= $end) {
        $nums[$start++] = $tmp[$k++];
    }
}
</code>
</pre>
</details>

<details>
<summary>计数</summary>
<pre>
<code>
/**
 * 计数排序
 */
function countSort($nums) {
    $len = count($nums);
    if ($len <= 1) {
        return $nums;
    }
    list($min, $max) = [min($nums), max($nums)];
    $offset = $max - $min + 1;
    $list = array_fill(0, $offset, 0);
    for ($i = 0; $i < $len; $i++) {
        $list[$nums[$i] - $min]++;
    }
    $res = [];
    for ($j = 0; $j < $offset; $j++) {
        while ($list[$j]-- > 0) {
            $res[] = $min + $j;
        }
    }
    return $res;
}
</code>
</pre>
</details>

<details>
<summary>基数</summary>
<pre>
<code>
/**
 * 基数计数
 */
function radix($nums) {
    $len = count($nums);
    if ($len <= 1) {
        return $nums;
    }
    $d = strlen(max($nums));
    $radix = 1;
    for ($i = 0; $i < $d; $i++) {
        $list = array_fill(0, 10, []);
        for ($j = 0; $j < $len; $j++) {
            $list[($nums[$j] / $radix) % 10][] = $nums[$j];
        }
        $m = 0;
        for ($k = 0; $k < 10; $k++) {
            while(count($list[$k])) {
                $nums[$m++] = array_shift($list[$k]);
            }
        }
        $radix *= 10;
    }
    return $nums;
}
</code>
</pre>
</details>

<details>
<summary>桶</summary>
<pre>
<code>
/**
 * 桶排序
 */
function bucket($nums) {
    $len = count($nums);
    if ($len <= 1) {
        return $nums;
    }
    list($min, $max, $bucket) = [min($nums), max($nums), 3];
    $cap = ceil(($max - $min + 1) / $bucket);
    $buckets = array_fill(0, $bucket, []);
    for ($i = 0; $i < $len; $i++) {
        $index = intval(($nums[$i] - $min) / $cap);
        for ($j = count($buckets[$index]) - 1; $j >= 0; $j--) {
            if ($buckets[$index][$j] <= $nums[$i]) {
               break;
            }
            $buckets[$index][$j + 1] = $buckets[$index][$j];
        }
        $buckets[$index][$j + 1] = $nums[$i];
    }
    $j = 0;
    for ($i = 0; $i < $bucket; $i++) {
        while (count($buckets[$i])) {
            $nums[$j++] = array_shift($buckets[$i]);
        }
    }
    return $nums;
}
</code>
</pre>
</details>

## 常见问题 ##

### leetcode ###

#### 455.分发饼干 ####
<details>
<summary>桶排序</summary>
<pre>
<code>
</code>
</pre>
</details>
