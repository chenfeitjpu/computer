* [剑指offer题解](#剑指offer题解)
  * [顺时针打印矩阵(19)](#顺时针打印矩阵19)
  * [整数中1出现的次数(31)](#整数中1出现的次数31)

# 剑指offer题解 #
## 整数中1出现的次数(31) ##
```
/**
 * 暴力遍历
 * 时间复杂度O(n㏒n)
 * 空间复杂度O(1)
 */
function numberOf1Between1AndN($n) {
    $res = 0;
    for($i = 1; $i <= $n; $i++) {
        $res += numberOf1($i);
    }
    return $res;
}
function numberOf1($n) {
    $count = 0;
    while ($n) {
        if($n % 10 == 1) {
            $count++;
        }
        $n = intval($n / 10);
    }
    return $count;
}
```
```
/**
 * 按位统计
 * 时间复杂度O(㏒n)
 * 空间复杂度O(1)
 */
function numberOf1Between1AndN1($n) {
    $count = $high = $cur = $low = 0;
    $base = 1;
    while (intval($n / $base)) {
        $high = intval($n / $base / 10);
        $cur = intval($n / $base) % 10;
        $low = $n - intval($n / $base) * $base;
        if($cur > 1) {
            $count += ($high + 1) * $base;
        } else if($cur == 1) {
            if($high) {
                $count += $high * $base;
            }
            $count += $low + 1;
        } else {
            $count += $high * $base;
        }
        $base *= 10;
    }
    return $count;
}
```
## 丑数(33) ##
```
/**
 * 暴力
 * 时间复杂度
 * 空间复杂度
 */
function uglyNumber($k) {
    $n = 0;
    $count = 0;
    while ($count < $k) {
        $n++;
        if(isUglyNumber($n)) {
            $count++;
        }
    }
    return $n;
}
function isUglyNumber($n) {
    while ($n % 5 == 0) {
        $n /= 5;
    }
    while ($n % 3 == 0) {
        $n /= 3;
    }
    while ($n % 2 == 0) {
        $n /= 2;
    }
    return $n == 1;
}
```
```
/**
 * 利用已求结果
 * 时间复杂度
 * 空间复杂度
 */
function uglyNumber1($k) {
    if(!$k) return 0;
    $index = 0;
    $ugly[$index] = 1;
    $index2 = $index3 = $index5 = 0;
    while($index < $k - 1) {
        $value = min($ugly[$index2] * 2, $ugly[$index3] * 3, $ugly[$index5] * 5);
        if($value == $ugly[$index2] * 2) {
            $index2++;
        }
        if($value == $ugly[$index3] * 3) {
            $index3++;
        }
        if($value == $ugly[$index5] * 5) {
            $index5++;
        }
        $ugly[++$index] = $value;
    }
    return $ugly[$index];
}
```
## 和为S的连续正数序列(41) ##
```
/**
 * 双指针
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function findContinuousSequence($sum) {
    $res = [];
    $start = 1;
    $end = 2;
    $curSum = $start + $end;
    if($sum < $curSum) {
        return $res;
    }
    $mid = intval((1 + $sum) / 2);
    while ($start < $mid && $end < $sum) {
        if($curSum < $sum) {
            $curSum += ++$end;
        } else if($curSum > $sum) {
            $curSum -= $start++;
        } else {
            $queue = [];
            for ($i = $start; $i <= $end; $i++) {
                $queue[] = $i;
            }
            $res[] = $queue;
            $curSum += ++$end;
        }
    }
    return $res;
}

```
## 和为S的两个数字(42) ##
```
/**
 * 双指针
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function findNumbersWithSum($array, $sum) {
    if(!$array || !$sum) return [];
    $left = 0;
    $right = count($array) - 1;
    while ($left < $right) {
        $value = $array[$left] + $array[$right];
        if($value < $sum) {
            $left++;
        } else if($value > $sum) {
            $right--;
        } else {
            return [$array[$left], $array[$right]];
        }
    }
    return [];
}
```
## 扑克牌顺子(45) ##
```
/**
 * 遍历
 * 时间复杂度O(1)
 * 空间复杂度O(1)
 */
function isContinuous($numbers) {
    $count = count($numbers);
    if($count != 5) {
        return false;
    }
    sort($numbers);
    $flag = 0;
    $min = PHP_INT_MAX;
    $max = PHP_INT_MIN;
    for($i = 0; $i < $count; $i++) {
        $num = $numbers[$i];
        //范围判断
        if($num < 0 || $num > 13) {
            return false;
        } else if($num == 0) {
            continue;
        }
        //是否重复
        if(($flag >> $num) & 1) {
            return false;
        } else {
            $flag |= 1 << $num;
        }
        //差值判断
        if($num < $min) {
            $min = $num;
        } else if($num > $max) {
            $max = $num;
        }
        if($max - $min > 4) {
            return false;
        }
    }
    return true;
}
```