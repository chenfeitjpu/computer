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
</code>
</pre>
</details>

### 240.搜索二维矩阵II ###
<details>
<summary>代码</summary>
<pre>
<code>
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