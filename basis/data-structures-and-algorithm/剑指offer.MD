* [二维数组中的查找(1)](#二维数组中的查找1)
* [旋转数组的最小数字(6)](#旋转数组的最小数字6)
* [调整数组顺序使奇数位于偶数前面(13)](#调整数组顺序使奇数位于偶数前面13)
* [数组中出现次数超过一半的数字(28)](#数组中出现次数超过一半的数字28)
* [连续子数组的最大和(30)](#连续子数组的最大和30)
* [把数组排成最小的数(32)](#把数组排成最小的数32)
* [数组中的逆序对(35)](#数组中的逆序对35)
* [数字在排序数组中出现的次数(37)](#数字在排序数组中出现的次数37)
* [数组中只出现一次的数字(40)](#数组中只出现一次的数字40)
* [数组中重复的数字(50)](#数组中重复的数字50)
* [构建乘积数组(51)](#构建乘积数组51)

# 二维数组中的查找(1) #
```
/**
 * 暴力破解-枚举
 * 时间复杂度O(m*n)
 * 空间负责度O(1)
 */
function find($array, $target) {
    $rowLen = count($array);
    if(!$rowLen) return false;
    $colLen = count($array[0]);
    for($i = 0; $i < $rowLen; $i++) {
        for($j = 0; $j < $colLen; $j++) {
            if($array[$i][$j] == $target) {
                return true;
            }
        }
    }
    return false;
}
```
```
/**
 * 分治法-利用数据的深度有序性
 * 时间复杂度O(max(m,n))
 * 空间负责度O(1)
 */
function find1($array, $target) {
    $rowLen = count($array);
    if(!$rowLen) return false;
    $colLen = count($array[0]);
    $i = 0;
    $j = $colLen - 1;
    while (0 <= $i && $i <= $rowLen -1 && 0 <= $j && $j <= $colLen-1) {
        $cur = $array[$i][$j];
        if($cur < $target) {
            $i++;
        } else if($cur > $target) {
            $j--;
        } else {
            return true;
        }
    }
    return false;
}
```
```
/**
 * 二分法-利用数据的广度有序性
 * 时间复杂度O(log(max(m,n)))
 * 空间负责度O(1)
 */
function find2($array, $target) {
    $rowLen = count($array);
    if(!$rowLen) return false;
    $colLen = count($array[0]);
    //二分查找定位行列范围
    $row = $col = 0;
    $left = 0;
    $right = $rowLen - 1;
    while ($left <= $right) {
        $mid = floor(($left + $right) / 2);
        $row = $left;
        $col = $colLen - $rowLen + $row;
        $col = $col >= 0 ? $col : 0;
        $cur = $array[$row][$col];
        if($cur < $target) {
            $left = $mid + 1;
        } else if($cur > $target) {
            $right = $mid -1;
        } else {
            return true;
        }
    }

    //从行里面二分查找目标元素
    $left = 0;
    $right = $col - 1;
    while ($left <= $right) {
        $mid = floor(($left + $right) / 2);
        $cur = $array[$row][$mid];
        if($cur < $target) {
            $left = $mid + 1;
        } else if($cur > $target) {
            $right = $mid -1;
        } else {
            return true;
        }
    }

    //从列里面二分查找目标元素
    $left = 0;
    $right = $row - 1;
    while ($left <= $right) {
        $mid = floor(($left + $right) / 2);
        $cur = $array[$mid][$col];
        if($cur < $target) {
            $left = $mid + 1;
        } else if($cur > $target) {
            $right = $mid -1;
        } else {
            return true;
        }
    }

    return false;
}
```
# 旋转数组的最小数字(6) #
```
/**
 * 遍历
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function minNumberInRotateArray($array) {
    $len = count($array);
    if(!$len) {
        return 0;
    }
    for($i = 0; $i < $len - 1; $i++) {
        if($array[$i] > $array[$i+1]) {
            return $array[$i+1];
        }
    }
    return $array[0];
}
```
```
/**
 * 二分法-利用数据的有序性
 * 时间复杂度O(log n)
 * 空间复杂度O(1)
 */
function minNumberInRotateArray1($array) {
    $len = count($array);
    if(!$len) {
        return 0;
    }
    $left = 0;
    $right = $len - 2;
    while ($left <= $right) {
        $mid = floor(($left + $right) / 2);
        if($array[$mid] <= $array[$mid+1]) {
            if($array[0] <= $array[$mid]) {
                $left = $mid + 1;
            } else {
                $right = $mid - 1;
            }
        } else {
            return $array[$mid+1];
        }
    }
    return $array[0];
}
```
# 调整数组顺序使奇数位于偶数前面(13) #
```
/**
 * 冒泡法
 * 时间复杂度O(n²)
 * 空间复杂度O(1)
 */
function reOrderArray($array) {
    $len = count($array);
    if($len <= 1) return $array;
    for($i = 0; $i < $len - 1; $i++) {
        for($j = 0; $j < $len - $i -1; $j++) {
            if(($array[$j] & 1) == 0 && ($array[$j+1] & 1) == 1) {
                $tmp = $array[$j];
                $array[$j] = $array[$j+1];
                $array[$j+1] = $tmp;
            }
        }
    }
    return $array;
}
```
```

/**
 * 拆成奇偶两个数组再合并
 * 时间复杂度O(n)
 * 空间复杂度O(n)
 */
function reOrderArray1($array) {
    $len = count($array);
    if($len <= 1) return $array;
    $odd = $even = [];
    for($i = 0; $i < $len; $i++) {
        if($array[$i] & 1) {
            $odd[] = $array[$i];
        } else {
            $even[] = $array[$i];
        }
    }
    $oddLen = count($odd);
    for($i = 0; $i < $oddLen; $i++) {
        $array[$i] = $odd[$i];
    }
    $evenLen = count($even);
    for($i = 0; $i < $evenLen; $i++) {
        $array[$oddLen + $i] = $even[$i];
    }
    return $array;
}
```
# 数组中出现次数超过一半的数字(28) #
```
/**
 * 遍历
 * 时间复杂度O(n)
 * 空间复杂度O(n)
 */
function moreThanHalfNumSolution($array) {
    $len = count($array);
    if(!$len) return 0;
    if($len ==1 ) return current($array);
    $map = [];
    for($i = 0; $i < $len; $i++) {
        $value = $array[$i];
        if(isset($map[$value])) {
            $map[$value]++;
        } else {
            $map[$value] = 1;
        }
    }
    foreach($map as $key => $value) {
        if($value > floor($len / 2)) {
            return $key;
        }
    }
    return 0;
}
```
```
/**
 * 排序
 * 时间复杂度O(nlog n)
 * 空间复杂度O(1)
 */
function moreThanHalfNumSolution1($array) {
    $len = count($array);
    if(!$len) return 0;
    if($len ==1 ) return current($array);
    sort($array);
    return $array[floor($len / 2 - 1)];
}
```
```
/**
 * 计数
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function moreThanHalfNumSolution2($array) {
    $len = count($array);
    if(!$len) return 0;
    if($len ==1 ) return current($array);
    $count = 0;
    $num = 0;
    for($i = 0; $i < $len; $i++) {
        $value = $array[$i];
        if($count == 0) {
            $num = $value;
        }
        $count += ($num == $value) ? 1 : -1;
    }
    $count = 0;
    for($i = 0; $i < $len; $i++) {
        if($num == $array[$i]) {
            $count++;
        }
    }
    return $count > floor($len / 2) ? $num : 0;
}
```
# 连续子数组的最大和(30) #
```
/**
 * 暴力法
 * 时间复杂度O(n²)
 * 空间复杂度O(1)
 */
function findGreatestSumOfSubArray($array) {
    $len = count($array);
    if(!$len) return 0;
    $max = 0;
    for($i = 0; $i < $len; $i++) {
        $sum = 0;
        for($j = $i; $j < $len; $j++) {
            $sum += $array[$j];
            if($max < $sum) {
                $max = $sum;
            }
        }
    }
    return $max;
}
```
```
/**
 * 迭代
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function findGreatestSumOfSubArray($array) {
    $len = count($array);
    if(!$len) return 0;
    $max = 0;
    $sum = 0;
    for($i = 0; $i < $len; $i++) {
        if($sum < 0) {
            $sum = $array[$i];
        } else {
            $sum += $array[$i];
        }
        if($max < $sum) {
            $max = $sum;
        }
    }
    return $max;
}
```
```
/**
 * 动态规划
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function findGreatestSumOfSubArray($array) {
    $max = 0;
    findGreatestSum($array, count($array)-1, $max);
    return $max;
}
function findGreatestSum($array, $n, &$max) {
    if($n == 0) {
        $max = $array[$n];
        return $array[$n];
    }
    $sum = findGreatestSum($array, $n - 1, $max);
    if($sum > 0) {
        $sum += $array[$n];
    } else {
        $sum = $array[$n];
    }
    if($max < $sum) {
        $max = $sum;
    }
    return $sum;
}
```
# 把数组排成最小的数(32) #
```
/**
 * 全排列
 * 时间复杂度O(n!)
 * 空间复杂度O(n!)
 */
function printMinNumber($array) {
    $min = PHP_INT_MAX;
    $list = permute($array);
    foreach ($list as $value) {
        if($min > $value) {
            $min = $value;
        }
    }
    return $min;
}
function permute($array) {
    $len = count($array);
    $res = [];
    if($len == 1) {
        $res[] = current($array);
    } else {
        for($i = 0; $i < $len; $i++) {
            $cur = $array[$i];
            $list = permute(array_merge(array_slice($array, 0, $i), array_slice($array, $i + 1, $len)));
            for($j = 0; $j < $len - 1; $j++) {
                $res[] = $cur . $list[$j];
            }
        }
    }
    return $res;
}
```
```
/**
 * 排序
 * 时间复杂度O(nlog n)
 * 空间复杂度O(1)
 */
function printMinNumber2($array) {
    usort($array, function ($a, $b) {
        return $a . $b > $b . $a;
    });
    return implode('', $array);
}
```
# 数组中的逆序对(35) #
```
/**
 * 暴力法
 * 时间复杂度O(n²)
 * 空间复杂度O(1)
 */
function inversePairs($array) {
    $len = count($array);
    if($len <= 1) return 0;
    $count = 0;
    for($i = 0; $i < $len; $i++) {
        for($j = $i + 1; $j < $len; $j++) {
            if($array[$i] > $array[$j]) {
                $count++;
            }
        }
    }
    return $count;
}
```
```
/**
 * 排序
 * 时间复杂度O(nlog n)
 * 空间复杂度O(n)
 */
function inversePairs2($array) {
    $len = count($array);
    if($len <= 1) return 0;
    return mergeSort($array, 0, $len - 1);
}
function mergeSort(&$array, $start, $end) {
    if($start >= $end) return 0;
    $mid = intval(($start + $end) / 2);
    $count = mergeSort($array, $start, $mid);
    $count += mergeSort($array, $mid + 1, $end);
    $count += merge($array, $start, $mid, $end);
    return $count;
}
function merge(&$array, $start, $mid, $end) {
    $count = 0;
    $i = $start;
    $j = $mid + 1;
    $tmp = [];
    while($i <= $mid && $j <= $end) {
        if($array[$i] < $array[$j]) {
            $tmp[] = $array[$i++];
        } else {
            $count += $mid - $i + 1;
            $tmp[] = $array[$j++];
        }
    }
    while ($i <= $mid) {
        $tmp[] = $array[$i++];
    }
    while ($j <= $end) {
        $tmp[] = $array[$j++];
    }
    $k = 0;
    $len = count($tmp);
    while ($k < $len) {
        $array[$start + $k] = $tmp[$k];
        $k++;
    }
    return $count;
}
```
# 数字在排序数组中出现的次数(37) #
```
/**
 * 暴力法
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function getNumberOfK($array, $value) {
    $len = count($array);
    $count = 0;
    if($len < 1) return $count;
    for($i = 0; $i < $len; $i++) {
        if($array[$i] == $value) {
            $count++;
        }
    }
    return $count;
}
```
```
/**
 * 二分法
 * 时间复杂度O(log n)
 * 空间复杂度O(1)
 */
function getNumberOfK2($array, $value) {
    $len = count($array);
    if(!$len) return 0;
    $first = getIndexIndex($array, $value, 'first');
    $last = getIndexIndex($array, $value, 'last');
    return $first > -1 ? ($last - $first + 1) : 0;
}
function getIndexIndex($array, $value, $type) {
    $len = count($array);
    $left = 0;
    $right = $len - 1;
    $index = -1;
    while ($left <= $right) {
        $mid = intval(($left + $right) / 2);
        $cur = $array[$mid];
        if($cur < $value) {
            $left = $mid + 1;
        } else if($cur > $value){
            $right = $mid - 1;
        } else {
            if($type == 'first') {
                if($mid > 0 && $array[$mid - 1] == $value) {
                    $right = $mid - 1;
                } else {
                    return $mid;
                }
            } else {
                if($mid < $len - 1 && $array[$mid + 1] == $value) {
                    $left = $mid + 1;
                } else {
                    return $mid;
                }
            }
        }
    }
    return $index;
}
```
# 数组中只出现一次的数字(40) #
```
/**
 * 暴力法
 * 时间复杂度O(n * n)
 * 空间复杂度O(1)
 */
function findNumsAppearOnce($array) {
    $len = count($array);
    $res = [];
    for($i = 0; $i < $len; $i++) {
        $flag = true;
        for($j = 0; $j < $len; $j++) {
            if($i != $j && $array[$i] == $array[$j]) {
                $flag = false;
                break;
            }
        }
        if($flag) {
            $res[] = $array[$i];
        }
    }
    return $res;
}
```
```
/**
 * 暴力法
 * 时间复杂度O(n)
 * 空间复杂度O(n)
 */
function findNumsAppearOnce1($array) {
    $len = count($array);
    $map = [];
    for($i = 0; $i < $len; $i++) {
        $cur = $array[$i];
        if(isset($map[$cur])) {
            $map[$cur]++;
        } else {
            $map[$cur] = 1;
        }
    }
    $res = [];
    foreach($map as $key => $value) {
        if($value == 1) {
            $res[] = $key;
        }
    }
    return $res;
}
```
```
/**
 * 异或
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function findNumsAppearOnce2($array) {
    $len = count($array);
    $num = 0;
    for($i = 0; $i < $len; $i++) {
        $num ^=  $array[$i];    
    }
    $tmp = $num & -$num;
    $num1 = $num2 = 0;
    for($i = 0; $i < $len; $i++) {
        $cur = $array[$i];
        if(($cur & $tmp) == $tmp) {
            $num1 ^= $cur;
        } else {
            $num2 ^= $cur;
í        }
    }
    return [$num1, $num2];
}
```
# 数组中重复的数字(50) #
```
/**
 * 计数
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function duplicate($array) {
    $len = count($array);
    if($len <= 1) return -1;
    for($i = 0; $i < $len; $i++) {
        while($i != $array[$i]) {
            $cur = $array[$i];
            if($array[$cur] == $cur) {
                return $cur;
            } else {
                $tmp = $array[$cur];
                $array[$cur] = $cur;
                $array[$i] = $tmp;
            }
        }
    }
}
```
# 构建乘积数组(51) #
```
/**
 * 计数
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function multiply($array) {
    $len = count($array);
    $res = [];
    for($i = 0, $tmp = 1; $i < $len; $i++) {
        $res[$i] = $tmp;
        $tmp *= $array[$i];
    }
    for($i = $len - 1, $tmp = 1; $i >= 0; $i--) {
        $res[$i] *= $tmp;
        $tmp *= $array[$i];
    }
    return $res;
}
```