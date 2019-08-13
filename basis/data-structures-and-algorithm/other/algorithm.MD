* [剑指offer题解](#剑指offer题解)
  * [顺时针打印矩阵(19)](#顺时针打印矩阵19)
  * [整数中1出现的次数(31)](#整数中1出现的次数31)

# 剑指offer题解 #
## 顺时针打印矩阵(19) ##
```
/**
 * 遍历
 * 时间复杂度O(n)
 * 空间复杂度O(n)
 */
function spiralOrder($matrix) {
    $res = [];
    $row = count($matrix);
    if(!$row) return $res;
    $col = count($matrix[0]);

    $visit = [];
    $r = $c = $d = 0;
    $step = [
        [0, 1],
        [1, 0],
        [0, -1],
        [-1, 0],
    ];
    $count = $row * $col;
    for($i = 0; $i < $count; $i++) {
        $res[] = $matrix[$r][$c];
        $visit[$r][$c] = true;
        $tr = $r + $step[$d][0];
        $tc = $c + $step[$d][1];
        if(0 <= $tr && $tr < $row && 0 <= $tc && $tc < $col && !isset($visit[$tr][$tc])) {
            $r = $tr;
            $c = $tc;
        } else {
            $d = ($d + 1) % 4;
            $r += $step[$d][0];
            $c += $step[$d][1];
        }
    }
    return $res;
}
```
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