* [剑指offer题解](#剑指offer题解)
  * [替换空格(2)](#替换空格2)
  * [字符串的排列(27)](#字符串的排列27)
  * [第一个只出现一次的字符(34)](#第一个只出现一次的字符34)
  * [左旋转字符串(43)](#左旋转字符串43)
  * [翻转单词顺序序列(44)](#翻转单词顺序序列44)
  * [把字符串转换成整数(49)](#把字符串转换成整数49)
  * [正则表达式匹配(52)](#正则表达式匹配52)
  * [表示数值的字符串(53)](#表示数值的字符串53)
      
# 剑指offer题解 #
## 替换空格(2) ##
```
/**
 * 遍历
 * 时间复杂度O(n)
 * 空间复杂度O(n)
 */
function replaceSpace($str) {
	$len = strlen($str);
	$res = '';
	for($i = 0; $i < $len; $i++) {
		$char = $str[$i];
		if($char == ' ') {
			$res .= '%20';
		} else {
			$res .= $char;
		}
	}
	return $res;
}

```
```
/**
 * 遍历
 * 时间复杂度O(n * n)
 * 空间复杂度O(1)
 */
function replaceSpace1($str) {
	$len = strlen($str);
	for($i = $len - 1; $i >= 0; $i--) {
		if($str[$i] == ' ') {
			$len += 2;
			for($j = $len - 1; $j > $i + 2; $j--) {
				$str[$j] = $str[$j-2];
			}
			$str[$j--] = '0';
			$str[$j--] = '2';
			$str[$j--] = '%';
		}
	}
	return $str;
}
```
```
/**
 * 遍历
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function replaceSpace2($str) {
	$length = strlen($str);
	$count = 0;
	for($i = 0; $i < $length; $i++) {
		if($str[$i] == ' ') {
			$count++;
		}
	}
	$len = $length + $count * 2;
	for($i = $length - 1, $j = $len - 1; $i >= 0 && $j >= 0;) {
		if($str[$i] == ' ') {
			$str[$j--] = '0';
			$str[$j--] = '2';
			$str[$j--] = '%';
			$i--;
		} else {
			$str[$j--] = $str[$i--];
		}
	}
	return $str;
}
```
## 字符串的排列(27) ##
```
/**
 * 基于前缀
 * 时间复杂度O(n!)
 * 空间复杂度O(n!)
 */
function permutation($str) {
	$res = [];
	permutationByPrefix('', $str, $res);
	return $res;
}
function permutationByPrefix($prefix, $str, &$res) {
	$len = strlen($str);
	if($len == 0) {
		$res[] = $prefix;	
	} else {
		for($i = 0; $i < $len; $i++) {
			permutationByPrefix($prefix . $str[$i], substr($str, 0, $i) . substr($str, $i+1, $len), $res);
		}
	}
}
```
```
/**
 * 基于交换
 * 时间复杂度O(n!)
 * 空间复杂度O(n!)
 */
function permutation($str) {
	$res = [];
	permutationBySwap($str, 0, $res);
	sort($res);
	return $res;
}
function permutationBySwap($str, $begin, &$res) {
	$len = strlen($str);
	if($begin == $len - 1) {
		$res[] = $str;
	} else {
		for($i = $begin; $i < $len; $i++) {
			if(!hasDuplicate($str, $begin, $i)) {
				//交换
				swap($str, $begin,  $i);	
				permutationBySwap($str, $begin + 1, $res);	
				swap($str, $begin,  $i);
			}
		}
	}
}
function hasDuplicate($str, $begin, $end) {
	for($i = $begin; $i < $end; $i++) {
		if($str[$i] == $str[$end]) {
			return true;
		}
	}
	return false;
}
function swap(&$str, $begin, $end) {
	$tmp = $str[$begin];
	$str[$begin] = $str[$end];
	$str[$end] = $tmp;
}
```
## 第一个只出现一次的字符(34) ##
```
/**
 * 计数
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function firstNotRepeatingChar($str) {
    $len = strlen($str);
    if(!$len) return -1;
    $map = [];
    for($i = 0; $i < $len; $i++) {
        $cur = $str[$i];
        if(isset($map[$cur])) {
            $map[$cur] = -1;
        } else {
            $map[$cur] = $i;
        }
    }
    foreach($map as $key => $value) {
        if($value != -1) {
            return $value;
        }
    }
    return -1;
}
```
## 左旋转字符串(43) ##
```
/**
 * 字符串分割
 * 时间复杂度O(1)
 * 空间复杂度O(n)
 */
function leftRotateString($str, $n) {
    $len = strlen($str);
    if($len <= 1) return $str;
    $count = $n % $len;
    $left = substr($str, 0, $count);
    $right = substr($str, $count, $len);
    return $right . $left;
}
```
```
/**
 * 字符串截取
 * 时间复杂度O(1)
 * 空间复杂度O(n)
 */
function leftRotateString($str, $n) {
    $len = strlen($str);
    if($len <= 1) return $str;
    return substr($str . $str, $n % $len, $len);
}
```
```
/**
 * 对应关系
 * 时间复杂度O(n)
 * 空间复杂度O(n)
 */
function leftRotateString($str, $n) {
    $len = strlen($str);
    if($len <= 1) return $str;
    $n = $n % $len;
    $res = '';
    for($i = 0; $i < $len; $i++) {
        $res .= $str[($i + $n) % $len];
    }
    return $res;
}
```
```
/**
 * 旋转
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function leftRotateString($str, $n) {
    $len = strlen($str);
    if($len <= 1) return $str;
    $n = $n % $len;
    swap($str, 0, $n -1);
    swap($str, $n, $len -1);
    swap($str, 0, $len -1);
    return $str;
}
function swap(&$str, $beign, $end) {
    while($beign < $end) {
        $tmp = $str[$beign];
        $str[$beign] = $str[$end];
        $str[$end] = $tmp;
        $beign++;
        $end--;
    }
}
```
## 翻转单词顺序序列(44) ##
```
/**
 * 遍历
 * 时间复杂度O(n)
 * 空间复杂度O(n)
 */
function reverseSentence($str) {
    $len = strlen($str);
    if($len <= 1) return $str;
    $pre = 0;
    $arr = [];
    for($i = 0; $i < $len; $i++) {
        $cur = $str[$i];
        if($cur == ' ') {
            $arr[] = substr($str, $pre, $i - $pre);
            $arr[] = $cur;
            $pre = $i+1;
        }
    }
    $arr[] = substr($str, $pre, $len - $pre);
    $len = count($arr);
    $res = '';
    for($i = $len - 1; $i >= 0; $i--) {
        $res .= $arr[$i];
    }
    return $res;
}
```
```
/**
 * 反转
 * 时间复杂度O(n)
 * 空间复杂度O(n)
 */
function reverseSentence1($str) {
    $len = strlen($str);
    if($len <= 1) return $str;
    swap($str, 0, $len -1);
    $left = 0;
    $rigth = 0;
    while ($rigth <= $len) {
        if(($rigth == $len && $str[$rigth -1] != ' ') || $str[$rigth] == ' ') {
            swap($str, $left, $rigth - 1);
            $left = $rigth + 1;
        }
        $rigth++;
    }
    return $str;
}
function swap(&$str, $start, $end) {
    while($start < $end) {
        $tmp = $str[$start];
        $str[$start] = $str[$end];
        $str[$end] = $tmp;
        $start++;
        $end--;
    }
}
```
## 把字符串转换成整数(49) ##
```
/**
 * 遍历
 * 时间复杂度O(n)
 * 空间复杂度O(n)
 */
function strToInt($str) {
    $len = strlen($str);
    if(!$len) return 0;
    $minus = false;
    //去空
    $i = 0;
    while($str[$i] == ' ') {
        $i++;
    }
    if($str[$i] == '+') {
        $i++;
    } else if($str[$i] == '-') {
        $minus = true;
        $i++;
    }
    $value = 0;
    while($i < $len) {
        $cur = $str[$i];
        if('0' <= $cur && $cur <= '9') {
            $value *= 10;
            $value += $cur;
            $i++;
        } else {
            return 0;
        }
        if($minus && $value < PHP_INT_MIN
            || !$minus && $value > PHP_INT_MAX
        ) {
            return 0;
        }
    }
    if($i != $len) {
        return 0;
    }
    if($minus) {
        $value = -$value;
    }
    return $value;
}
```
## 正则表达式匹配(52) ##
```
/**
 * 递归
 * 时间复杂度O(2ⁿ)
 * 空间复杂度O(1)
 */
function match($s, $p) {
    if(!$p) {
        return !$s;
    }
    $sLen = strlen($s);
    $pLen = strlen($p);
    $firstMatch = $s && in_array($p[0], [$s[0], '.']);
    if($pLen >= 2 && $p[1] == '*') {
        return match($s, substr($p, 2, $pLen - 2)) || $firstMatch && match(substr($s, 1, $sLen - 1), $p);
    } else {
        return $firstMatch && match(substr($s, 1,  $sLen - 1), substr($p, 1, $pLen - 1));
    }
}
```
## 表示数值的字符串(53) ##
```
/**
 * 遍历
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function isNumeric($str) {
    $len = strlen($str);
    if(!$len) return false;
    $i = 0;
    //符号判断
    if($str[$i] == '+' || $str[$i] == '-') {
        $i++;
    }
    //扫描数字
    scanDigits($str, $i);
    if($i == $len) {
        return true;
    }
    //小数点
    if($str[$i] == '.') {
        $i++;
        //扫描数字
        if(!scanDigits($str, $i)) {
            return false;
        }
        if($i == $len) {
            return true;
        }
    }
    //科学计数法
    if($str[$i] == 'e' || $str[$i] == 'E') {
        $i++;
        if($i < $len && ($str[$i] == '+' || $str[$i] == '-')) {
            $i++;
        }
        //扫描数字
        if(!scanDigits($str, $i)) {
            return false;
        }
        if($i == $len) {
            return true;
        }
    }
}
function scanDigits($str, &$i) {
    $flag = false;
    $len = strlen($str);
    while($i < $len &&  '0' <= $str[$i] && $str[$i] <= '9') {
        $i++;
        $flag = true;
    }
    return $flag;
}
```

