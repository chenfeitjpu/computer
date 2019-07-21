* [剑指offer题解](#剑指offer题解)
  * [替换空格(2)](#替换空格2)
  * [字符串的排列(27)](#字符串的排列27)
      
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