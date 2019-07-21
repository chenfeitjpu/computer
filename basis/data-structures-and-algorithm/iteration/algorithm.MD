* [剑指offer题解](#剑指offer题解)
  * [斐波那契数列(7)](#斐波那契数列7)
  * [跳台阶(8)](#跳台阶8)
  * [变态跳台阶(9)](#变态跳台阶9)
  * [矩形覆盖(10)](#矩形覆盖10)

# 剑指offer题解 #
## 斐波那契数列(7) ##
```
/**
 * 迭代
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function fibonacci($n) {
	if($n == 0 || $n == 1) return $n;
	$first = 0;
	$second = 1;
	$third = 0;
	for($i = 2; $i <= $n; $i++) {
		$third = $first + $second;
		$first = $second;
		$second = $third;
		
	}
	return $third;
}
```
## 跳台阶(8) ##
```
/**
 * 迭代
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function jumpFloor($n) {
	if($n == 1 || $n == 2) return $n;
	$one = 1;
	$two = 2;
	$res = 0;
	for($i = 3; $i <= $n; $i++) {
		$res = $one + $two;
		$one = $two;
		$two = $res;
	}
	return $res;
}
```
## 变态跳台阶(9) ##
```
/**
 * 迭代
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function jumpFloor($n) {
	if($n == 1) return $n;
	for($i = 2, $res = 1; $i <= $n; $i++) {
		$res *= 2;
	}
	return $res;
}
```
## 矩形覆盖(10) ##
```
/**
 * 迭代
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function rectCover($n) {
	if($n == 1 || $n == 2) return $n;
	$one = 1;
	$two = 2;
	$res = 0;
	for($i = 3; $i <= $n; $i++) {
		$res = $one + $two;
		$one = $two;
		$two = $res;
	}
	return $res;
}
```
