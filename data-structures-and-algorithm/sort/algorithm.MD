* [冒泡排序](#冒泡排序)
* [选择排序](#选择排序)
* [插入排序](#插入排序)
* [快速排序](#快速排序)
* [归并排序](#归并排序)
* [桶排序](#桶排序)
* [计数排序](#计数排序)
* [基数排序](#基数排序)
   
# 冒泡排序 #
```
/**
 * 比较相邻元素进行交换
 * time O(n²)
 * space O(1)
 */
function bubble($nums) {
    $len = count($nums);
    if ($len <= 1) {
        return $nums;
    }
    for ($i = 0; $i < $len - 1; $i++) {
        for ($j = 0; $j < $len - 1 - $i; $j++) {
            if($nums[$j] > $nums[$j + 1]) {
                list($nums[$j], $nums[$j + 1]) = [$nums[$j + 1], $nums[$j]];
            }
        }
    }
    return $nums;
}
```
# 选择排序 #
```
/**
 * 从未排序集合中选择一个元素
 * time O(n²)
 * space O(1)
 */
function select($nums) {
    $len = count($nums);
    if($len <= 1) {
        return $nums;
    }
    for($i = 0; $i < $len - 1; $i++) {
        $index = $i;
        for($j = $i + 1; $j < $len; $j++) {
            if($nums[$j] < $nums[$index]) {
                $index = $j;
            }
        }
        if($index != $i) {
            list($nums[$i], $nums[$index]) = [$nums[$index], $nums[$i]];
        }
    }
    return $nums;
}
```
# 插入排序 #
```
/**
 * 向有序集合中添加一个元素
 * time O(n²)
 * space O(1)
 */
function insert($nums) {
    $len = count($nums);
    if($len <= 1) {
        return $nums;
    }
    for($i = 1; $i < $len; $i++) {
        $radix = $nums[$i];
        for($j = $i - 1; $j >= 0 && $nums[$j] > $radix; $j--) {
            $nums[$j + 1] = $nums[$j];
        }
        $nums[$j + 1] = $radix;
    }
    return $nums;
}
```
# 快速排序 #
```
/**
 * 选择一个基准值，从右边开始找比它小的放左边，从左边开始找比它大的放右边，最后交换基准值
 * time O(n㏒n)
 * space O(1)
 */
function sortArray($nums) {
    $len = count($nums);
    if($len <= 1) {
        return $nums;
    }
    quickSort($nums, 0, $len - 1);
    return $nums;
}
function quickSort(&$nums, $start, $end) {
    if($start >= $end) {
        return;
    }
    $radix = $nums[$start];
    list($left, $right) = [$start, $end];
    while ($left < $right) {
        while ($left < $right && $nums[$right] >= $radix) {
            $right--;
        }
        while ($left < $right && $nums[$left] <= $radix) {
            $left++;
        }
        if($left < $right) {
            [$nums[$left], $nums[$right]] = [$nums[$right], $nums[$left]];
        }
    }
    list($nums[$start], $nums[$left]) = [$nums[$left], $nums[$start]];
    quickSort($nums, $start, $left - 1);
    quickSort($nums, $left + 1, $end);
}
```
# 归并排序 #
```
/**
 * 合并两个有序集合
 * time O(n㏒n)
 * space O(n)
 */
function sortArray($nums) {
    $len = count($nums);
    if($len <= 1) {
        return $nums;
    }
    mergeSort($nums, 0, $len -1);
    return $nums;
}
function mergeSort(&$nums, $start, $end) {
    if($start >= $end) {
        return;
    }
    $mid = intval(($start + $end) / 2);
    mergeSort($nums, $start, $mid);
    mergeSort($nums, $mid + 1, $end);
    merge($nums, $start, $mid, $end);
}
function merge(&$nums, $start, $mid, $end) {
    $tmp = [];
    list($i, $j) = [$start, $mid + 1];
    while($i <= $mid && $j <= $end) {
        $tmp[] = $nums[$i] <= $nums[$j] ? $nums[$i++] : $nums[$j++];
    }
    while($i <= $mid) {
        $tmp[] = $nums[$i++];
    }
    while($j <= $end) {
        $tmp[] = $nums[$j++];
    }
    for ($i = $start; $i <= $end; $i++) {
        $nums[$i] = $tmp[$i - $start];
    }
}
```
# 桶排序 #
```
function bucketSort($nums) {
    $len = count($nums);
    if($len <=1 ) {
        return $nums;
    }
    $size = 3;
    $buckets[] = [];
    for ($i = 0; $i < $size; $i++) {
        $buckets[] = [];
    }
    list($max, $min) = [max($nums), min($nums)];
    $range = ceil(($max - $min + 1) / $size);
    for ($i = 0; $i < $len; $i++) {
        $index = floor(($nums[$i] - $min) / $range);
        $radix = $nums[$i];
        for($j = count($buckets[$index]) - 1; $j >= 0 && $buckets[$index][$j] > $radix; $j--) {
            $buckets[$index][$j + 1] = $buckets[$index][$j];
        }
        $buckets[$index][$j + 1] = $radix;
    }
    $res = [];
    for ($i = 0; $i < $size; $i++) {
        $res = array_merge($res, $buckets[$i]);
    }
    return $res;
}
```
# 计数排序 #
```
function countSort($nums) {
    $len = count($nums);
    if($len <= 1) {
        return $nums;
    }
    list($max, $min) = [max($nums), min($nums)];
    $range = $max - $min;
    $list = [];
    for ($i = 0; $i <= $range; $i++) {
        $list[$i] = 0;
    }
    for ($i = 0; $i < $len; $i++) {
        $list[$nums[$i] - $min]++;
    }
    $res = [];
    for ($i = 0; $i <= $range; $i++) {
        while ($list[$i]--) {
            $res[] = $min + $i;
        }
    }
    return $res;
}
```
# 基数排序 #
```
function radixSort($nums) {
    $len = count($nums);
    if($len <= 1) {
        return $nums;
    }
    list($digits, $digit, $start, $end, $unit) = [strlen(max($nums)), 0, 0, 9, 1];
    while ($digit < $digits) {
        $list = [];
        for ($i = 0; $i < $len; $i++) {
            $index = floor($nums[$i] / $unit) % 10;
            $list[$index][] = $nums[$i];
        }
        for ($i = $start, $j = 0; $i <= $end; $i++) {
            if(!isset($list[$i])) {
                continue;
            }
            while($list[$i]) {
                $nums[$j++] = array_shift($list[$i]);
            }
        }
        $digit++;
        $unit *= 10;
    }
    return $nums;
}
```
