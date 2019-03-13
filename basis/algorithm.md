* [编程思想](#编程思想)
  * [递归](#递归)
* [性能分析](#性能分析)
  * [时间复杂度](#时间复杂度)
  * [空间复杂度](#空间复杂度)
* [查询算法](#查询算法)
  * [二分查找](#二分查找)
* [排序算法](#排序算法)
  * [选择排序](#选择排序)

# 编程思想 #
## 递归 ##
自身调用自身
```
public function factorial($num) {
	if($num == 1) {
		return $num;
	} else {
		return $num * $this->factorial($num-1);
	}
}
```

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