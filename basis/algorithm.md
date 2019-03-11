* [性能分析](#性能分析)
  * [运行时间](#运行时间)
  * [占用空间](#占用空间)
* [查询算法](#查询算法)
  * [二分查找](#二分查找)
* [排序算法](#排序算法)

# 性能分析 #
## 运行时间 ##
大O表示法: 指出算法需要执行的操作数
  - O(㏒ n)
  - O(n)
  - O(n * ㏒ n)
  - O(n²)
  - O(n!)
## 占用空间 ##
# 查询算法 #
## 二分查找 ##
`
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
`	
# 排序算法 #