* [算法](#算法)
* [复杂度分析](#复杂度分析)
  * [时间复杂度](#时间复杂度)
  * [空间复杂度](#空间复杂度)
  * [大O表示法](#大o表示法)
  * [分类](#分类)
* [编程思想](#编程思想)
  * [递归](#递归)
  * [分而治之](#分而治之)
* [查找算法](#查找算法)
  * [二分查找](#二分查找)
* [排序算法](#排序算法)
  * [冒泡排序](#冒泡排序)
  * [插入排序](#插入排序)
  * [选择排序](#选择排序)
  * [快速排序](#快速排序)
* [搜索算法](#搜索算法)
  * [广度优先搜索](#广度优先搜索)

# 算法 #
算法是数据的操作方法

# 复杂度分析 #
## 时间复杂度 ##
时间复杂度是算法的执行时间和数据规模之间的增长关系
## 空间复杂度 ##
空间复杂度是算法的存储空间和数据规模之间的增长关系
## 大O表示法 ##
大O表示法表明复杂度和数据规模之间的增长关系
  - O(1)
  - O(㏒ n)
  - O(n)
  - O(n * ㏒ n)
  - O(n²)
  - O(2ⁿ)
  - O(n!)
## 分类 ##
   - 最好情况时间复杂度
   - 最差情况时间复杂度
   - 平均时间复杂度
   - 均摊时间复杂度 

# 编程思想 #
## 分而治之 ##
不断分解问题
  - 确定基线条件
  - 缩小问题规模

# 编程技巧 #
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

# 查找算法 #
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
## 冒泡排序 ##
每次对相邻的两个元素进行比较,看是否满足大小关系要求。如果不满足就让它俩互换。一次冒泡会让至少一
个元素移动到它应该在的位置,重复n次,就完成了n个数据的排序工作。
```
public function bubbleSort($list) {
	$length = count($list);
	if($length <= 1) {
		return $list;
	}
	for($i = 0; $i < $length; $i++) {
		for($j = 0; $j < $length - 1 - $i; $j ++) {
			if($list[$j] > $list[$j+1]) {
				$tmp = $list[$j];
				$list[$j] = $list[$j+1];
				$list[$j+1] = $tmp;
			}	
		}
	}
}
```
## 插入排序 ##
取未排序区间中的元素,在已排序区间中找到合适的插入位置将其插入,并保证已排序区间数据一直有序。重复这个过程,直到未排序区间中元素为空,算法结束。
```
public function insertionSort($list) {
	$length = count($list);
	if($length <= 1) {
		return $list;
	}
	for($i = 1; $i < $length; $i++) {
		$value = $list[$i];
		for($j = $i - 1; $j >= 0; $j--) {	
			if($list[$j] > $value) {
				$list[$j+1] = $list[$j];
			} else {
				break;
			}
		}
		$list[$j+1] = $value;
	}
}
```
## 选择排序 ##
选择排序每次会从未排序区间中找到最小的元素,将其放到已排序区间的末尾。
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
