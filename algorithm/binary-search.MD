# 二分查询 #

## 定义 ##
每次查找将待查区间分为两部分，只取一部分继续查找

## 常见问题 ##

### leetcode ###

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

####  ####
<details>
<summary>代码</summary>
<pre>
<code>
</code>
</pre>
</details>
