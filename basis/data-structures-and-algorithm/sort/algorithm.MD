* [冒泡排序](#冒泡排序)
* [插入排序](#插入排序)
* [选择排序](#选择排序)
* [快速排序](#快速排序)
* [归并排序](#归并排序)
* [桶排序](#桶排序)
* [计数排序](#计数排序)
* [基数排序](#基数排序)
   
# 冒泡排序 #
```
/**
 * 比较相邻元素
 */
function bubbleSort($nums) {
    $len = count($nums);
    if($len <= 1) {
        return $nums;
    }
    for($i = 0; $i < $len - 1; $i++) {
        for($j = 0; $j < $len - 1 - $i; $j++) {
            if($nums[$j] > $nums[$j + 1]) {
                list($nums[$j], $nums[$j + 1]) = [$nums[$j + 1], $nums[$j]];
            }
        }
    }
    return $nums;
}
```
# 插入排序 #
```
/**
 * 向有序集合中添加一个元素
 */
function insertSort($nums) {
    $len = count($nums);
    if($len <= 1) {
        return $nums;
    }
    for($i = 0; $i < $len; $i++) {
        $tmp = $nums[$i];
        for($j = $i - 1; $j >= 0 && $nums[$j] > $tmp; $j--) {
            $nums[$j + 1] = $nums[$j];
        }
        $nums[$j + 1] = $tmp;
    }
    return $nums;
}
```
# 选择排序 #
```
/**
 * 从未排序集合中选择一个元素
 */
function selectSort($nums) {
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
# 快速排序 #
```
/**
 * 选择一个基准值，比它小的放左边，比它大的放右边
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
    $base = $nums[$start];
    $left = $start;
    $right = $end;
    while($left < $right) {
        while($left < $right && $nums[$right] >= $base) {
            $right--;
        }
        while($left < $right && $nums[$left] <= $base) {
            $left++;
        }
        if($left < $right) {
            list($nums[$left], $nums[$right]) = [$nums[$right], $nums[$left]];
        }
    }
    $nums[$start] = $nums[$left];
    $nums[$left] = $base;
    quickSort($nums, $start, $left -1);
    quickSort($nums, $left + 1, $end);
}
```
# 归并排序 #
```
/**
 * 合并两个有序集合
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
    $i = $start;
    $j = $mid + 1;
    while($i <= $mid && $j <= $end) {
        if($nums[$i] < $nums[$j]) {
            $tmp[] = $nums[$i++];
        } else {
            $tmp[] = $nums[$j++];
        }
    }
    while($i <= $mid) {
        $tmp[] = $nums[$i++];
    }
    while($j <= $end) {
        $tmp[] = $nums[$j++];
    }
    $k = 0;
    while($start <= $end) {
        $nums[$start++] = $tmp[$k++];
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

    $bucket = 3;
    $res = [];
    for($i = 0; $i < $bucket; $i++) {
        $res[] = [];
    }

    $min = min($nums);
    $max = max($nums);
    $range = ceil(($max - $min + 1) / $bucket);
    for($i = 0; $i < $len; $i++) {
        $index = intval(($nums[$i] - $min) / $range);
        $j = count($res[$index]) - 1;
        while($j >= 0 && $res[$index][$j] > $nums[$i]) {
            $res[$index][$j + 1] = $res[$index][$j];
            $j--;
        }
        $res[$index][$j + 1] = $nums[$i];
    }
    $k = 0;
    for($i = 0; $i < $bucket; $i++) {
        while($res[$i]) {
            $nums[$k++] = array_shift($res[$i]);
        }
    }
    return $nums;
}
```
# 计数排序 #
```
function countSort($nums) {
    $len = count($nums);
    if($len <= 1) {
        return $nums;
    }
    $min = min($nums);
    $max = max($nums);
    $offset = $max - $min;
    $res = [];
    for($i = 0; $i <= $offset; $i++) {
        $res[] = 0;
    }
    for($i = 0; $i < $len; $i++) {
        $res[$nums[$i] - $min]++;
    }
    $k = 0;
    for($i = 0; $i <= $offset; $i++) {
        while($res[$i]) {
            $nums[$k++] = $min + $i;
            $res[$i]--;
        }
    }
    return $nums;
}
```
# 基数排序 #
```
function radixSort($nums) {
    $len = count($nums);
    if($len <= 1) {
        return $nums;
    }
    $res = [];
    for($i = 0; $i < 10; $i++) {
        $res[] = [];
    }
    $digit = strlen(max($nums));
    $d = 0;
    $n = 1;
    while($d < $digit) {
        for($i = 0; $i < $len; $i++) {
            $index = floor($nums[$i] / $n) % 10;
            $res[$index][] = $nums[$i];
        }
        $k = 0;
        for($i = 0; $i < 10; $i++) {
            while($res[$i]) {
               $nums[$k++] = array_shift($res[$i]);
            }
        }
        $d++;
        $n *= 10;
    }
    return $nums;
}
```
