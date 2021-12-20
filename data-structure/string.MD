字符串

# 定义 #
一串字符

# 应用 #
## LEETCODE ##
### 242.有效的字母异位词 ###
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

### 205.同构字符串 ###
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

### 647.回文子串 ###
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

### 696.计数二进制子串 ###
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 中心扩展
 */
function countBinarySubstrings($s) {
    $len = strlen($s);
    $list = [];
    $cnt = 0;
    for ($i = 0; $i < $len; $i++) {
        if ($i == 0 || $s[$i] == $s[$i - 1]) {
            $cnt++;
        } else {
            array_push($list, $cnt);
            $cnt = 1;
        }
        if ($i == $len - 1) {
            array_push($list, $cnt);
        }
    }

    $ans = 0;
    $prev = array_shift($list);
    foreach ($list as $cnt) {
        $ans += min($prev, $cnt);
        $prev = $cnt;
    }
    return $ans;
}
</code>
</pre>
</details>

### 28.实现strStr() ###
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * KMP
 */
function mystrstr($haystack, $needle) {
    $nl = strlen($needle);
    if ($nl <= 0) {
        return 0;
    }

    $prev = 0;
    $next[0] = 0;
    for ($cur = 1; $cur < $nl; $cur++) {
        while ($prev > 0 && $needle[$prev] != $needle[$cur]) {
            $prev = $next[$prev - 1];
        }
        if ($needle[$prev] == $needle[$cur]) {
            $next[$cur] = ++$prev;
        } else {
            $next[$cur] = 0;
        }
    }

    for ($i = 0, $j = 0; $i < strlen($haystack); $i++) {
        while ($j > 0 && $needle[$j] != $haystack[$i]) {
            $j = $next[$j - 1];
        }
        if ($needle[$j] == $haystack[$i]) {
            $j++;
            if ($j == $nl) {
                return $i - $nl + 1;
            }
        }
    }
    return -1;
}
</code>
</pre>
</details>

### 409.最长回文串 ###
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 哈希
 */
function longestPalindrome($s) {
    $len = strlen($s);
    if ($len <= 1) {
        return $len;
    }

    $charList = [];
    for ($i = 0; $i < $len; $i++) {
        $char = $s[$i];
        if (!isset($charList[$char])) {
            $charList[$char] = 1;
            continue;
        }
        $charList[$char]++;
    }

    $ans = 0;
    foreach ($charList as $cnt) {
        $ans += intval($cnt / 2) * 2;
        if (($cnt & 1) == 1 && ($ans & 1) == 0) {
            $ans++;
        }
    }
    return $ans;
}
</code>
</pre>
</details>

### 3.无重复字符的最长子串 ###
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 哈希+滑动窗口
 */
function lengthOfLongestSubstring($s) {
    $len = strlen($s);
    if ($len <= 1) {
        return $len;
    }

    $max = 0;
    $map = [];
    $start = 0;
    for ($end = 0; $end < $len; $end++) {
        $start  = max($start, ($map[$s[$end]] ?? - 1) + 1);
        $map[$s[$end]] = $end;
        $max = max($max, $end - $start + 1);
    }
    return $max;
}
</code>
</pre>
</details>

### 5.最长回文子串 ###
<details>
<summary>代码</summary>
<pre>
<code>
/**
 * 动态规划
 */
function longestPalindrome($s) {
    $len = strlen($s);
    if ($len <= 1) {
        return $s;
    }

    $start = 0;
    $max = 0;
    $map = [];
    for ($i = $len - 1; $i >= 0; $i--) {
        $map[$i][$i] = 1;
        for ($j = $i; $j < $len; $j++) {
            $l = $j - $i + 1;
            if ($s[$i] == $s[$j] && ($l <= 3 || isset($map[$i + 1][$j - 1]))) {
                $map[$i][$j] = 1;
                if ($l > $max) {
                    $start = $i;
                    $max = $l;
                }
            }
        }
    }
    return substr($s, $start, $max);
}
</code>
</pre>
</details>
