哈希表

# 定义 #
通过关键字访问元素

# 应用 #
## LEETCODE ##
### 1.两数之和 ###
<details>
<summary>代码</summary>
<pre>
<code>
function twoSum($nums, $target) {
    $len = count($nums);
    $map = [];
    for ($i = 0; $i < $len; $i++) {
        $index = $map[$target - $nums[$i]] ?? -1;
        if ($index > -1) {
            return [$index, $i];
        }
        $map[$nums[$i]] = $i;
    }
}
</code>
</pre>
</details>

### 128.最长连续序列 ###
<details>
<summary>代码</summary>
<pre>
<code>
function longestConsecutive($nums) {
    $map = [];
    foreach ($nums as $index => $num) {
        $map[$num] = $index;
    }
    $max = 0;
    foreach ($nums as $num) {
        if (isset($map[$num - 1])) {
            continue;
        }
        $cur = $num;
        $cnt = 1;
        while (isset($map[++$cur])) {
            $cnt++;
        }
        $max = max($max, $cnt);
    }
    return $max;
}
</code>
</pre>
</details>

### 149.直线上最多的点数 ###
<details>
<summary>代码</summary>
<pre>
<code>
</code>
</pre>
</details>
