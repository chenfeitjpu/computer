# 字符串 #

## 定义 ##
一串字符

## 应用 ##
### LEETCODE ###
#### 242.有效的字母异位词 ####
<details>
<summary>代码</summary>
<pre>
<code>
function isAnagram($s, $t) {
    $sL = strlen($s);
    $tL = strlen($t);
    if ($sL != $tL) {
        return false;
    }
    $map = [];
    for ($i = 0; $i < $sL; $i++) {
        if (!isset($map[$s[$i]])) {
            $map[$s[$i]] = 0;
        }
        $map[$s[$i]]++;
    }
    for ($j = 0; $j < $tL; $j++) {
        if (!isset($map[$t[$j]]) || $map[$t[$j]] <= 0) {
            return false;
        }
        $map[$t[$j]]--;
    }
    return true;
}
</code>
</pre>
</details>

#### 205.同构字符串 ####
<details>
<summary>代码</summary>
<pre>
<code>
function isIsomorphic($s, $t) {
    $sL = strlen($s);
    $map = [];
    for ($i = 0; $i < $sL; $i++) {
        if (isset($map[$s[$i]])) {
            if ($map[$s[$i]] != $t[$i]) {
                return false;
            }
        } else {
            if (in_array($t[$i], $map)) {
                return false;
            }
            $map[$s[$i]] = $t[$i];
        }
    }
    return true;
}
</code>
</pre>
</details>

#### 647.回文子串 ####
<details>
<summary>代码</summary>
<pre>
<code>
function countSubstrings($s) {
    $count = 0;
    $len = strlen($s);
    if ($len <= 0) {
        return $count;
    }
    $dp = [];
    for ($end = 0; $end < $len; $end++) {
        for ($start = 0; $start <= $end; $start++) {
            if ($s[$start] == $s[$end] && ($end - $start < 2 || $dp[$start + 1][$end - 1])) {
                $dp[$start][$end] = true;
                $count++;
                continue;
            }
        }
    }
    return $count;
}
</code>
</pre>
</details>

#### 696.计数二进制子串 ####
<details>
<summary>代码</summary>
<pre>
<code>
</code>
</pre>
</details>

#### 227.基本计算器II ####
<details>
<summary>代码</summary>
<pre>
<code>
</code>
</pre>
</details>

#### 28.实现strStr() ####
<details>
<summary>代码</summary>
<pre>
<code>
</code>
</pre>
</details>

#### 409.最长回文串 ####
<details>
<summary>代码</summary>
<pre>
<code>
</code>
</pre>
</details>

#### 3.无重复字符的最长子串 ####
<details>
<summary>代码</summary>
<pre>
<code>
</code>
</pre>
</details>

#### 772.基本计算器III ####
<details>
<summary>代码</summary>
<pre>
<code>
</code>
</pre>
</details>

#### 5.最长回文子串 ####
<details>
<summary>代码</summary>
<pre>
<code>
</code>
</pre>
</details>
