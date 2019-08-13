* [剑指offer题解](#剑指offer题解)
  * [二进制中1的个数(11)](#二进制中1的个数11)
  * [值的整数次方(12)](#值的整数次方12)
* [LeeCode题解](#leecode题解)

# 剑指offer题解 #
## 二进制中1的个数(11) ##
```
/**
 * 利用移位操作
 * 时间复杂度O(1)
 * 空间复杂度O(1)
 */
function numberOf1($n) {
    if(!$n) return 0;
    $count = 0;
    $flag = 1;
    while ($flag) {
        if($n & $flag) {
            $count++;
        }
        $flag = $flag << 1;
    }
    return $count;
}
```
```
/**
* 利用&操作
* 时间复杂度O(1)
* 空间复杂度O(1)
*/
function numberOf11($n) {
    $count = 0;
    if(!$n) return $count;
    while ($n) {
        $count++;
        if($n == PHP_INT_MIN) {
            break;
        }
        $n &= $n - 1;
    }
    return $count;
}
```
## 值的整数次方(12) ##
```
/**
 * 移位
 * 时间复杂度O(1)
 * 空间复杂度O(1)
 */
function power($base, $exponent) {
    if(!$base) {
        return 0;
    }
    if(!$exponent) {
        return 1;
    }
    if($exponent < 0) {
        $base = 1 / $base;
        $exponent = -$exponent;
    }
    $res = 1;
    $tmp = $base;
    while ($exponent) {
        if($exponent & 1) {
            $res *= $tmp;
        }
        $tmp *= $tmp;
        $exponent = $exponent >> 1;
    }
    return $res;
}
```
# LeeCode题解 #
##  ##
```
```