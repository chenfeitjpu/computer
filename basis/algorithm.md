* [编程思想](#编程思想)
  * [递归](#递归)
  * [分而治之](#分而治之)
* [性能分析](#性能分析)
  * [时间复杂度](#时间复杂度)
  * [空间复杂度](#空间复杂度)
* [查询算法](#查询算法)
  * [二分查找](#二分查找)
* [排序算法](#排序算法)
  * [选择排序](#选择排序)
  * [快速排序](#快速排序)
* [搜索算法](#搜索算法)
  * [广度优先搜索](#广度优先搜索)

# 编程思想 #
## 递归 ##
自身调用自身
 - 确定基线条件
 - 确定递归条件
```
public function factorial($num) {
	if($num == 1) {
		return $num;
	} else {
		return $num * $this->factorial($num-1);
	}
}
```
## 分而治之 ##
不断分解问题
  - 确定基线条件
  - 缩小问题规模  

# 性能分析 #
## 时间复杂度 ##
大O表示法: 指出算法需要执行的操作数
  - O(㏒ n)
  - O(n)
  - O(n * ㏒ n)
  - O(n²)
  - O(n!)
## 空间复杂度 ##

# 查询算法 #
## 二分查找 ##
```
public function binarySearch($list, $item) {
    $min = 0;    
	$max = count($list) - 1;  
	while ($min <= $max) {    
		$mid = intval(($min + $max) / 2);
		$value = $list[$mid];
		if($value == $item) {
			return $mid;
		} else if($value < $item) {
			$min = $mid + 1;
		} else {    
			$max = $mid - 1;    
		}    
	}    
	return - 1;    
}    
```

# 排序算法 #
## 选择排序 ##
```
public function findSmallest($list) {
	$index = 0;
	$smallest = current($list);
	for($i = 1, $length = count($list); $i < $length; $i++) {
		if($list[$i] < $smallest) {
			$index = $i;
			$smallest = $list[$i];
		}
	}
	return $index;
}

public function selectionSort($list) {
	$res = [];
	for($i = 0, $length = count($list); $i < $length; $i++) {
		$index = $this->findSmallest($list);
		array_push($res, current(array_splice($list, $index, 1)));
	}
	return $res;
}
```
## 快速排序 ##
```
public function quickSort($list) {
	$length = count($list);
	if($length <= 1) {
		return $list;
	} else {
		$pivot = array_shift($list);
		$less = $great = [];
		foreach($list as $v) {
			$v <= $pivot ? $less[] = $v : $great[] = $v;
		}
		return array_merge($this->quickSort($less), [$pivot], $this->quickSort($great));
	}
}
```

# 搜索算法 #
## 广度优先搜索 ##
