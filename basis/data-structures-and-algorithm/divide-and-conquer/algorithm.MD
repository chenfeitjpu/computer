* [幂函数(50)](#幂函数50)
* [求众数(169)](#求众数169)
# 幂函数(50) #
```
function fastPow($x, $n) {
    if($n == 1) {
        return $x;
    }
    $value = fastPow($x, floor($n / 2));
    if($n % 2 == 0) {
        return $value * $value;
    } else {
        return $value * $value * $x;
    }
}
function myPow($x, $n) {
    if($n == 0) return 1;
    if($n < 0) {
        $x = 1 / $x;
        $n = -$n;
    }
    return fastPow($x, $n);
}
```
# 求众数(169) #
```
function majorityCount($nums, $num, $lower, $hight) {
    $count = 0;
    for($i = $lower; $i <= $hight; $i++) {
        if($nums[$i] == $num) {
            $count++;
        }
    }
    return $count;
}
function majority($nums, $lower, $hight) {
    if($lower == $hight) {
        return $nums[$lower];
    }
    $mid = floor(($hight - $lower) / 2) + $lower;
    $left = majority($nums, $lower, $mid);
    $right = majority($nums, $mid + 1, $hight);
    if($left == $right) {
        return $left;
    }
    $leftCount = majorityCount($nums, $left, $lower, $hight);
    $rightCount = majorityCount($nums, $right, $lower, $hight);
    return $leftCount > $rightCount ? $left : $right;
}
function majorityElement($nums) {
    $len = count($nums);
    if($len == 0) return null;
    if($len == 1) return current($nums);
    return majority($nums, 0, $len-1);
}
```