**数组**

- [定义](#定义)
- [特点](#特点)
- [算法](#算法)
  - [前缀和](#前缀和)
  - [差分数组](#差分数组)
  - [双指针](#双指针)
- [应用](#应用)
  - [LEETCODE](#leetcode)
    - [448.找到所有数组中消失的数字](#448找到所有数组中消失的数字)
    - [48.旋转图像](#48旋转图像)
    - [240.搜索二维矩阵II](#240搜索二维矩阵ii)
    - [769.最多能完成排序的块](#769最多能完成排序的块)

# 定义 #
顺序存储元素

# 特点 #
查询快O(1)，增删慢O(n)

# 算法 #
## 前缀和 ##
前缀和的适用场景是原始数组不会被修改的情况下，频繁查询某个区间的累加和

## 差分数组 ##
差分数组的适用场景是频繁对原始数组的某个区间的元素进行增减

## 双指针 ##

# 应用 #
## LEETCODE ##
### 448.找到所有数组中消失的数字 ###
<details>
<summary>代码</summary>
<pre>
<code>
function findDisappearedNumbers($nums) {
    $n = count($nums);
    foreach ($nums as $num) {
        $index = ($num - 1) % $n;
        $nums[$index] += $n;
    }
    $res = [];
    for ($i = 0; $i < $n; $i++) {
        if ($nums[$i] <= $n) {
            array_push($res, $i + 1);
        }
    }
    return $res;
}
</code>
</pre>
</details>

### 48.旋转图像 ###
<details>
<summary>代码</summary>
<pre>
<code>
function rotate(&$matrix) {
    $m = count($matrix);
    $n = count($matrix[0]);
    for ($i = 0; $i < floor($m / 2); $i++) {
        for ($j = 0; $j < $n; $j++) {
            list($matrix[$i][$j], $matrix[$m - 1 - $i][$j]) = [$matrix[$m - 1 - $i][$j], $matrix[$i][$j]];
        }
    }
    for ($i = 0; $i < $m; $i++) {
        for ($j = 0; $j < $i; $j++) {
            list($matrix[$i][$j], $matrix[$j][$i]) = [$matrix[$j][$i], $matrix[$i][$j]];
        }
    }
}
</code>
</pre>
</details>

### 240.搜索二维矩阵II ###
<details>
<summary>代码</summary>
<pre>
<code>
function searchMatrix($matrix, $target) {
    $m = count($matrix);
    $n = count($matrix[0]);
    list($row, $col) = [$m - 1, 0];
    while ($row >= 0 && $col < $n) {
        if ($matrix[$row][$col] > $target) {
            $row--;
        } else if ($matrix[$row][$col] < $target) {
            $col++;
        } else {
            return true;
        }
    }
    return false;
}
</code>
</pre>
</details>

### 769.最多能完成排序的块 ###
<details>
<summary>代码</summary>
<pre>
<code>
function maxChunksToSorted($arr) {
    $len = count($arr);
    $sum = 0;
    $max = 0;
    for ($i = 0; $i < $len; $i++) {
        $max = max($max, $arr[$i]);
        if ($max == $i) {
            $sum++;
        }
    }
    return $sum;
}
</code>
</pre>
</details>