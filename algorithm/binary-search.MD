# 二分查询 #

## 定义 ##
每次查找将待查区间分为两部分，只取一部分继续查找

## 应用 ##
### LEETCODE ###
#### 69. x的平方根 ####
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 二分法-前后搜索
 */
function mySqrt($x) {
    if ($x <= 1) {
        return $x;
    }
    list($l, $h) = [1, ceil($x / 2)];
    while ($l <= $h) {
        $mid = $l + ceil(($h - $l) / 2);
        $sqrt = $mid * $mid;
        if ($sqrt < $x) {
            $l = $mid + 1;
        } else if ($sqrt > $x) {
            $h = $mid - 1;
        } else {
            return $mid;
        }
    }
    return $h;
}
</code>
</pre>
</details>

#### 34.在排序数组中查找元素的第一个和最后一个位置 ####
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 二分法-先找第一个、再找最后一个
 */
function searchRange($nums, $target) {
    $len = count($nums);
    $first = searchFirst($nums, $target);
    if ($first == $len || $nums[$first] != $target) {
        return [-1, -1];
    }
    $last = searchLast($nums, $target) - 1;
    return [$first , $last];
}
function searchFirst($nums, $target) {
    $len = count($nums);
    list($l, $r) = [0, $len];
    while ($l < $r) {
        $mid = $l + intval(($r - $l) / 2);
        if ($nums[$mid] >= $target) {
            $r = $mid;
        } else {
            $l = $mid + 1;
        }
    }
    return $l;
}
function searchLast($nums, $target) {
    $len = count($nums);
    list($l, $r) = [0, $len];
    while ($l < $r) {
        $mid = $l + intval(($r - $l) / 2);
        if ($nums[$mid] > $target) {
            $r = $mid;
        } else {
            $l = $mid + 1;
        }
    }
    return $l;
}
</code>
</pre>
</details>

#### 81.搜索旋转排序数组II ####
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 二分法
 */
function search($nums, $target) {
    $len = count($nums);
    if ($len < 1) {
        return false;
    }
    $l = 0;
    $r = $len - 1;
    while ($l <= $r) {
        $mid = $l + intval(($r - $l) / 2);
        //目标值
        if ($nums[$mid] == $target) {
            return true;
        }
        //相同值
        if ($nums[$mid] == $nums[$l]) {
            $l++;
        } else if ($nums[$mid] > $nums[$l]) {//左边有序
            if ($nums[$l] <= $target && $target < $nums[$mid]) {
                $r = $mid - 1;
            } else {
                $l = $mid + 1;
            }

        } else {//右边有序
            if ($nums[$mid] < $target && $target <= $nums[$r]) {
                $l = $mid +1;
            } else {
                $r = $mid - 1;
            }
        }
    }
    return false;
}
</code>
</pre>
</details>

#### 154.寻找旋转排序数组中的最小值II ####
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 二分法
 */
function findMin($nums) {
    $len = count($nums);
    $l = 0;
    $r = $len - 1;
    while ($l < $r) {
        $mid = $l + intval(($r - $l) / 2);
        if($nums[$mid] > $nums[$r]) {
            $l = $mid + 1;
        } else if ($nums[$mid] < $nums[$r] ){
            $r = $mid;
        } else {
            $r--;
        }
    }
    return $nums[$l];
}
</code>
</pre>
</details>

#### 540.有序数组中的单一元素 ####
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 二分法－通过相邻位置的数值变化进行判断
 */
function singleNonDuplicate($nums) {
    $len = count($nums);
    list($left, $right) = [0, $len - 1];
    while ($left < $right) {
        $mid = $left + intval(($right - $left) / 2);
        if ($mid & 1) {
            $mid--;
        }
        if ($nums[$mid] == $nums[$mid + 1]) {
            $left = $mid + 2;
        } else {
            $right = $mid;
        }
    }
    return $nums[$left];
}
</code>
</pre>
</details>

#### 4.寻找两个正序数组的中位数 ####
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 二分法－利用单个数组的有序性
 */
function findMedianSortedArrays($nums1, $nums2) {
    $m = count($nums1);
    $n = count($nums2);
    $left = findK($nums1, 0, $m - 1, $nums2, 0, $n - 1, intval(($m + $n + 1) / 2));
    $right = findK($nums1, 0, $m - 1, $nums2, 0, $n - 1, intval(($m + $n + 2) / 2));
    return ($left + $right) / 2;
}
function findK($nums1, $start1, $end1, $nums2, $start2, $end2, $k) {
    $m = $end1 - $start1 + 1;
    $n = $end2 - $start2 + 1;
    if ($m > $n) {
        return findK($nums2, $start2, $end2, $nums1, $start1, $end1, $k);
    }
    if ($m == 0) {
        return $nums2[$start2 + $k - 1];
    }
    if ($k == 1) {
        return min($nums1[$start1], $nums2[$start2]);
    }
    $k2 = intval($k / 2);
    $i = $start1 + min($k2, $m) - 1;
    $j = $start2 + min($k2, $n) - 1;
    if ($nums1[$i] < $nums2[$j]) {
        return findK($nums1, $i + 1, $end1, $nums2, $start2, $end2, $k - ($i - $start1 + 1));
    } else{
        return findK($nums1, $start1, $end1, $nums2, $j + 1, $end2, $k - ($j - $start2 + 1));
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
 * 二分法－利用两个数组的有序性
 */
function findMedianSortedArrays($nums1, $nums2) {
    $m = count($nums1);
    $n = count($nums2);
    if ($m > $n) {
        return findMedianSortedArrays($nums2, $nums1);
    }
    $left = 0;
    $right = 2 * $m;
    while ($left <= $right) {
        $c1 = $left + intval(($right - $left) / 2);
        $c2 = $m + $n - $c1;
        $lMax1 = $c1 == 0 ? PHP_INT_MIN : $nums1[intval(($c1 - 1) / 2)];
        $rMin1 = $c1 == 2 * $m ? PHP_INT_MAX : $nums1[intval($c1 /2)];
        $lMax2 = $c2 == 0 ? PHP_INT_MIN : $nums2[intval(($c2 - 1) / 2)];
        $rMin2 = $c2 == 2 * $n ? PHP_INT_MAX : $nums2[intval($c2 /2)];
        if ($lMax1 > $rMin2) {
            $right = $c1 - 1;
        } else if ($lMax2 > $rMin1) {
            $left = $c1 + 1;
        } else {
            break;
        }
    }
    return (max($lMax1, $lMax2) + min($rMin1, $rMin2)) / 2;
}
</code>
</pre>
</details>
