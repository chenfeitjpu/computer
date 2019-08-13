* [剑指offer题解](#剑指offer题解)
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