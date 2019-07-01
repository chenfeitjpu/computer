* [冒泡排序](#冒泡排序)
* [插入排序](#插入排序)
* [选择排序](#选择排序)
* [归并排序](#归并排序)
* [快速排序](#快速排序)
   
# 冒泡排序 #
```
/**
 * 比较相邻元素，找出最值
 */
function bubbleSort($nums) {
    $len = count($nums);
    if($len == 0) return $nums;
    for($i = 0; $i < $len - 1; $i++) {
        for($j = 0; $j < $len - $i - 1; $j++) {
            if($nums[$j] > $nums[$j+1]) {
                $tmp = $nums[$j+1];
                $nums[$j+1] = $nums[$j];
                $nums[$j] = $tmp;
            }
        }
    }
    return $nums;
}
```
# 插入排序 #
```
/**
 * 把未排序的数据依次添加到有序集合中
 */
function insertSort($nums) {
    $len = count($nums);
    if($len == 0) return $nums;
    for($i = 1; $i < $len; $i++) {
        $value = $nums[$i];
        for($j = $i-1; $j >=0; $j--) {
            if($nums[$j] > $value) {
                $nums[$j+1] = $nums[$j];
            } else {
                break;
            }
        }
        $nums[$j+1] = $value;
    }
    return $nums;
}
```
# 选择排序 #
```
/**
 * 从未排序数据中选择最值放到已排序集合尾部
 */
function selectionSort($nums) {
    $len = count($nums);
    if($len == 0) return $nums;
    for($i = 0; $i < $len - 1; $i++) {
        $index = $i;
        for($j = $i+1; $j < $len; $j++) {
            if($nums[$j] < $nums[$index]) {
                $index = $j;
            }
        }
        $tmp = $nums[$i];
        $nums[$i] = $nums[$index];
        $nums[$index] = $tmp;
    }
    return $nums;
}
```
# 归并排序 #
```
/**
 * 合并两个有序序列
 */
function mergeSort(&$nums, $start, $end) {
    if($start == $end) return $nums;
    $mid = floor(($start + $end) /2);
    mergeSort($nums, $start, $mid);
    mergeSort($nums, $mid+1, $end);
    merge($nums, $start, $mid, $end);
}
function merge(&$nums, $start, $mid, $end) {
    $tmp = [];
    $i = $start;
    $j = $mid+1;
    while ($i <= $mid && $j <= $end) {
        if($nums[$i] <= $nums[$j]) {
            $tmp[] = $nums[$i++];
        } else {
            $tmp[] = $nums[$j++];
        }
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
```
# 快速排序 #
```
/**
 * 选择一个基准值，比它小的放左边，比它大的放右边
 */
function quickSort(&$nums, $start, $end) {
    //结束
    if($start >= $end) return;
    //基值
    $base = $nums[$start];
    $left = $start;
    $right = $end;
    while ($left < $right) {
        //从尾部开始左移
        while ($left < $right && $nums[$right] >= $base) $right--;
        //从头部开始右移
        while ($left < $right && $nums[$left] <= $base) $left++;
        //交换
        if($left < $right) {
            $tmp = $nums[$left];
            $nums[$left] = $nums[$right];
            $nums[$right] = $tmp;
        }
    }
    //交换基值
    $nums[$start] = $nums[$left];
    $nums[$left] = $base;
    //左边排序
    quickSort($nums, $start, $left-1);
    //右边排序
    quickSort($nums, $left+1, $end);
}
```
