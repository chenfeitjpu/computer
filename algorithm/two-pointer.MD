# 双指针 #

## 定义 ##
两个指针指向不同的元素，从而协同完成任务  
两个指针遍历方向相同且不会相交，称为滑动窗口

## 应用 ##
### LEETCODE ###
#### 167.两数之和 II - 输入有序数组 ####
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 双指针-前后
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
 * 双指针-两个数组
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
 * 双指针-快慢
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

#### 76.最小覆盖子串 ####
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 滑动窗口
 */
function minWindow($s, $t) {
    $sl = strlen($s);
    $tl = strlen($t);
    if ($tl > $sl) {
        return '';
    }
    $map = [];
    for ($i = 0; $i < $tl; $i++) {
        if(!isset($map[$t[$i]])) {
            $map[$t[$i]] = 0;
        }
        $map[$t[$i]]++;
    }
    $start = $cnt = 0;
    $minStart = 0;
    $minSize = PHP_INT_MAX;
    for ($end = 0; $end < $sl; $end++) {
        if (!isset($map[$s[$end]])) {
            continue;
        }
        if ($map[$s[$end]]-- > 0) {
            $cnt++;
        }
        while ($cnt == $tl) {
            $size = $end - $start + 1;
            if($size < $minSize) {
                list($minStart, $minSize) = [$start, $size];
            }
            if (isset($map[$s[$start]]) && $map[$s[$start]]++ == 0) {
                $cnt--;
            }
            $start++;
        }
    }
    return $minSize < PHP_INT_MAX ? substr($s, $minStart, $minSize) : '';
}
</code>
</pre>
</details>

#### 633.平方数之和 ####
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 双指针-前后
 */
function judgeSquareSum($c) {
    $low = 0;
    $hight = ceil(sqrt($c));
    while ($low <= $hight) {
        $sum = $low * $low + $hight * $hight;
        if ($sum > $c) {
            $hight--;
        } else if ($sum < $c) {
            $low++;
        } else {
            return true;
        }
    }
    return false;
}
</code>
</pre>
</details>

#### 680.验证回文字符串 Ⅱ ####
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 双指针-前后
 */
function validPalindrome($s) {
    $len = strlen($s);
    if ($len <= 1) {
        return true;
    }
    $l = 0;
    $r = strlen($s) - 1;
    while ($l < $r) {
        if ($s[$l] != $s[$r]) {
            $left = substr($s, $l, $r - $l);
            $right = substr($s, $l + 1, $r - $l);
            return $left == strrev($left) || $right == strrev($right);
        }
        $l++;
        $r--;
    }
    return true;
}
</code>
</pre>
</details>

#### 524.通过删除字母匹配到字典里最长单词 ####
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 双指针-两个数组
 */
function findLongestWord($s, $d) {
    $sl = strlen($s);
    if ($sl < 1) {
        return '';
    }
    $max = '';
    foreach ($d as $w) {
        $wl = strlen($w);
        $i = $j = 0;
        while ($i < $sl && $j < $wl) {
            if ($s[$i] == $w[$j]) {
                $j++;
            }
            $i++;
        }
        if ($j == $wl && (strlen($max) < $wl || (strlen($max) == $wl && $max > $w))) {
            $max = $w;
        }
    }
    return $max;
}
</code>
</pre>
</details>

#### 340.至多包含 K 个不同字符的最长子串 ####
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 滑动窗口
 */
function lengthOfLongestSubstringKDistinct($s, $k) {
    $sl = strlen($s);
    if ($sl < 1 || $sl < $k) {
        return 0;
    }
    list($max, $map, $cnt) = [0, [], 0];
    for ($start = 0, $end = 0; $end < $sl; $end++) {
        if ($cnt <= $k) {
            if (!isset($map[$s[$end]])) {
                $map[$s[$end]] = 0;
                $cnt++;
            }
            $map[$s[$end]]++;
        }
        if ($cnt > $k) {
            $max = max($max, $end - $start);
        }
        while ($cnt > $k) {
            if(--$map[$s[$start]] == 0) {
                unset($map[$s[$start]]);
                $cnt--;
            }
            $start++;
        }
    }
    if ($cnt == $k) {
        $max = max($max, $end - $start);
    }
    return $max;
}
</code>
</pre>
</details>
