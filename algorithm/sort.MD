# 排序算法 #

## 定义 ##
对元素进行排序

## 常见排序 ##
<details>
<summary>冒泡</summary>
<pre>
<code>
/**
 * 两两比较
 */
function bubble($nums) {
    $len = count($nums);
    if ($len <= 1) {
        return $nums;
    }
    for ($i = 0; $i < $len - 1; $i++) {
        for ($j = 0; $j < $len - $i - 1; $j++) {
            if ($nums[$j] > $nums[$j + 1]) {
                list($nums[$j], $nums[$j + 1]) = [$nums[$j + 1], $nums[$j]];
            }
        }
    }
    return $nums;
}
</code>
</pre>
</details>

<details>
<summary>选择</summary>
<pre>
<code>
/**
 * 从待排序里选择一个
 */
function select($nums) {
    $len = count($nums);
    if ($len <= 1) {
        return $nums;
    }
    for ($i = 0; $i < $len - 1; $i++) {
        $min = $i;
        for ($j = $i + 1; $j < $len; $j++) {
            if ($nums[$j] < $nums[$min]) {
                $min = $j;
            }
        }
        list($nums[$i], $nums[$min]) = [$nums[$min], $nums[$i]];
    }
    return $nums;
}
</code>
</pre>
</details>

<details>
<summary>插入</summary>
<pre>
<code>
/**
 * 向有序数组中插入一个
 */
function insert($nums) {
    $len = count($nums);
    if($len <= 1) {
        return $nums;
    }
    for ($i = 1; $i < $len; $i++) {
        $radix = $nums[$i];
        for ($j = $i - 1; $j >= 0; $j--) {
            if ($nums[$j] > $radix) {
                $nums[$j + 1] = $nums[$j];
            } else {
                break;
            }
        }
        $nums[$j + 1] = $radix;
    }
    return $nums;
}
</code>
</pre>
</details>

<details>
<summary>代码</summary>
<pre>
<code>
</code>
</pre>
</details>

## 常见问题 ##

### leetcode ###

#### 455.分发饼干 ####