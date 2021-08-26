数组

# 定义 #
顺序存储元素

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
</code>
</pre>
</details>