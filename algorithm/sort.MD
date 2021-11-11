排序

# 定义 #
对集合进行排序

# 应用 #
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
    for ($i = $len - 1; $i > 0; $i--) {
        for ($j = 0; $j < $i; $j++) {
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
    for ($i = $len - 1; $i > 0; $i--) {
        $radix = 0;
        for ($j = 1; $j <= $i; $j++) {
            if ($nums[$j] > $nums[$radix]) {
                $radix = $j;
            }
            list($nums[$radix], $nums[$i]) = [$nums[$i], $nums[$radix]];
        }
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
    if ($len <= 1) {
        return $nums;
    }
    for ($i = 1; $i < $len; $i++) {
        $radix = $nums[$i];
        for ($j = $i - 1; $j >= 0; $j--) {
            if ($nums[$j] <= $radix) {
                break;
            }
            $nums[$j + 1] = $nums[$j];
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
/**
 * 对集合进行分类
 */
 function quick($nums) {
    $len = count($nums);
    if ($len <= 1) {
        return $nums;
    }
    quickSort($nums, 0, $len - 1);
    return $nums;
}
function quickSort(&$nums, $start, $end) {
    if ($end <= $start) {
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
    list($nums[$radix], $nums[$right]) = [$nums[$right], $nums[$radix]];
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
/**
 * 合并两个有序集合
 */
function merge($nums) {
    $len = count($nums);
    if ($len <= 1) {
        return $nums;
    }
    mergeSort($nums, 0, $len - 1);
    return $nums;
}
function mergeSort(&$nums, $start, $end) {
    if ($end <= $start) {
        return;
    }
    $mid = $start + intval(($end - $start) / 2);
    mergeSort($nums, $start, $mid);
    mergeSort($nums, $mid + 1, $end);
    mergeSortArray($nums, $start, $mid, $end);
}
function mergeSortArray(&$nums, $start, $mid, $end) {
    if ($end <= $start) {
        return;
    }
    $tmp = [];
    list($i, $j) = [$start, $mid + 1];
    while ($i <= $mid && $j <= $end) {
        $tmp[] = $nums[$i] <= $nums[$j] ? $nums[$i++] : $nums[$j++];
    }
    while($i <= $mid) {
        $tmp[] = $nums[$i++];
    }
    while ($j <= $end) {
        $tmp[] = $nums[$j++];
    }
    for ($k = $start; $k <= $end; $k++) {
        $nums[$k] = $tmp[$k -$start];
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

#### 215.数组中的第K个最大元素 ####
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 利用快速排序
 */
function findKthLargest($nums, $k){
    $len = count($nums);
    if ($len < 1) {
        return null;
    }
    list($left, $right) = [0, $len - 1];
    while ($left <= $right) {
        $mid = quick($nums, $left, $right);
        var_dump($mid);exit;
        if ($len - $k == $mid) {
            return $nums[$mid];
        } else if ($left - $k < $mid) {
            $left = $mid + 1;
        } else {
            $right = $mid - 1;
        }
    }
}
function quick(&$nums, $start, $end) {
    if ($start > $end) {
        return;
    }
    list($left, $right) = [$start, $end];
    while ($left < $right) {
        while ($left < $right && $nums[$right] >= $nums[$start]) {
            $right--;
        }
        while ($left < $right && $nums[$left] <= $nums[$start]) {
            $left++;
        }
        if ($left < $right) {
            list($nums[$left], $nums[$right]) = [$nums[$right], $nums[$left]];
        }
    }
    list($nums[$start], $nums[$right]) = [$nums[$right], $nums[$start]];
    return $right;
}
</code>
</pre>
</details>

#### 347.前K个高频元素 ####
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 桶排序
 */
function topKFrequent($nums, $k) {
    $len = count($nums);
    $map = [];
    for ($i = 0; $i < $len; $i++) {
        if (!isset($map[$nums[$i]])) {
            $map[$nums[$i]] = 0;
        }
        $map[$nums[$i]]++;
    }
    list($min, $max) = [min($map), max($map)];
    $list = array_fill($min, $max - $min + 1, []);
    foreach ($map as $key => $value) {
        $list[$value][] = $key;
    }
    $res = [];
    for ($i = $max; $i >= $min; $i--) {
        while (count($list[$i])) {
            $res[] = array_pop($list[$i]);
            if (count($res) == $k) {
                break 2;
            }
        }
    }
    return $res;
}
</code>
</pre>
</details>

#### 451.根据字符出现频率排序 ####
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 桶排序
 */
function frequencySort($s) {
    if (!$s) {
        return $s;
    }
    $len = strlen($s);
    $map = [];
    for($i = 0; $i < $len; $i++) {
        if (!isset($map[$s[$i]])) {
            $map[$s[$i]] = 0;
        }
        $map[$s[$i]]++;
    }
    list($min, $max) = [min($map), max($map)];
    $list = array_fill($min, $max - $min + 1, []);
    foreach ($map as $key => $value) {
        $list[$value][] = $key;
    }
    $res = '';
    for ($i = $max; $i >= $min; $i--) {
        while (count($list[$i])) {
            $char = array_pop($list[$i]);
            $cnt = $i;
            while ($cnt > 0) {
                $res .= $char;
                $cnt--;
            }
        }
    }
    return $res;
}
</code>
</pre>
</details>

#### 75.颜色分类 ####
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 计数排序
 */
function sortColors(&$nums) {
    $len = count($nums);
    if ($len <= 1) {
        return;
    }
    $map = array_fill(0, 3, 0);
    for ($i = 0; $i < $len; $i++) {
        $map[$nums[$i]]++;
    }
    $j = 0;
    foreach ($map as $k => $v) {
        while ($v > 0) {
            $nums[$j++] = $k;
            $v--;
        }
    }
}
</code>
</pre>
</details>
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 选择排序
 */
function sortColors(&$nums) {
    $len = count($nums);
    if ($len <= 1) {
        return $nums;
    }
    list($l, $r, $i) = [0, $len - 1, 0];
    while ($i <= $r) {
        if ($nums[$i] == 2) {
            list($nums[$r], $nums[$i]) = [$nums[$i], $nums[$r]];
            $r--;
            continue;
        }
        if ($nums[$i] == 0) {
            list($nums[$l], $nums[$i]) = [$nums[$i], $nums[$l]];
            $l++;
        }
        $i++;
    }
}
</code>
</pre>
</details>
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 插入排序
 */
function sortColors(&$nums) {
    $len = count($nums);
    if ($len <= 1) {
        return $nums;
    }
    list($red, $white, $blue) = [-1, -1, -1];
    for ($i = 0; $i < $len; $i++) {
        switch ($nums[$i]) {
            case 0:
                $nums[++$blue] = 2;
                $nums[++$white] = 1;
                $nums[++$red] = 0;
                break;
            case 1:
                $nums[++$blue] = 2;
                $nums[++$white] = 1;
                break;
            case 2:
                $nums[++$blue] = 2;
                break;

        }
    }
}
</code>
</pre>
</details>
