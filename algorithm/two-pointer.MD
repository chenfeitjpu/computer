# 双指针 #

## 定义 ##
两个指针指向不同的元素，从而协同完成任务  
两个指针遍历方向相同且不会相交，称为滑动窗口

## 常见问题 ##

### leetcode ###
#### 167.两数之和 II - 输入有序数组 ####
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 一前一后双指针
 */
function twoSum($numbers, $target) {
    $len = count($numbers);
    if ($len < 1) {
        return [];
    }
    list($left, $right) = [0, $len - 1];
    while ($left < $right) {
        $sum = $numbers[$left] + $numbers[$right];
        if ($sum < $target) {
            $left++;
        } else if ($sum > $target) {
            $right--;
        } else {
            return [$left + 1, $right + 1];
        }
    }
}
</code>
</pre>
</details>

#### 88.合并两个有序数组 ####
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 两个数组一一比较
 */
function merge(&$nums1, $m, $nums2, $n) {
    list($i, $j, $k) = [$m - 1, $n - 1, $m + $n - 1];
    while ($i >= 0 && $j >= 0) {
        $nums1[$k--] = $nums1[$i] >= $nums2[$j] ? $nums1[$i--] : $nums2[$j--];
    }
    while ($j >= 0) {
        $nums1[$k--] = $nums2[$j--];
    }
}
</code>
</pre>
</details>

#### 142.环形链表 II ####
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 一快一慢先找环，再找入口
 * @param $head
 * @return null
 */
function detectCycle($head) {
    if (!$head) {
        return null;
    }
    $slow = $fast = $head;
    $hasCycle = false;
    while ($fast && $fast->next) {
        $slow = $slow->next;
        $fast = $fast->next->next;
        if ($slow == $fast) {
            $hasCycle = true;
            break;
        }
    }
    if (!$hasCycle) {
        return null;
    }
    $slow = $head;
    while ($slow != $fast) {
        $slow = $slow->next;
        $fast = $fast->next;
    }
    return $slow;
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