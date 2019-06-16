* [k数之和](#k数之和)

# k数之和 #
两数之和
```
/**
* 双指针找两个数
*/
function twoSum(array $nums, int $target) {
	$res = [];
	$len = count($nums);
	if($len < 2) return $res;
	sort($nums);
	//最小值判断
	if($nums[0] + $nums[1] > $target) return $res;
	$left = 0;
	$right = $len -1;
	while($left < $right) {
		$sum = $nums[$left] + $nums[$right];
		if($sum == $target) {
			$res[] = [$nums[$left], $nums[$right]];
			//左边去重
			while($left < $right && $nums[$left] == $nums[$left+1]) {
				$left++;
			}
			//右边去重
			while($left < $right && $nums[$right] == $nums[$right-1]) {
				$right--;
			}
			$left++;
			$right--;
		} else if ($sum < $target) {
			//左边去重
			while($left < $right && $nums[$left] == $nums[$left+1]) {
				$left++;
			}
			$left++;
		} else {
			//右边去重
			while($left < $right && $nums[$right] == $nums[$right-1]) {
				$right--;
			}
			$right--;
		}
	}
	return $res;
}
```
三数之和
```
/**
 *循环固定一个数，双指针找两个数
 */
function threeSum(array $nums, int $target) {
	$res = [];
	$len = count($nums);
	if($len < 3) return $res;
	sort($nums);
	for($i = 0; $i < $len-2; $i++) {
		if($i > 0 && $nums[$i] == $nums[$i-1]) continue;
		if($nums[$i] + $nums[$i+1] + $nums[$i+2] > $target) break;
		if($nums[$i] + $nums[$len-2] + $nums[$len - 1] < $target) continue;
		$left = $i + 1;
		$right = $len - 1;
		while($left < $right) {
			$sum = $nums[$i] + $nums[$left] + $nums[$right];
			if($sum == $target) {
				$res[] = [$nums[$i], $nums[$left], $nums[$right]];
				//左边去重
				while($left < $right && $nums[$left] == $nums[$left+1]) {
					$left++;
				}
				//右边去重
				while($left < $right && $nums[$right] == $nums[$right-1]) {
					$right--;
				}
				$left++;
				$right--;
			} else if ($sum < $target) {
				//左边去重
				while($left < $right && $nums[$left] == $nums[$left+1]) {
					$left++;
				}
				$left++;
			} else {
				//右边去重
				while($left < $right && $nums[$right] == $nums[$right-1]) {
					$right--;
				}
				$right--;
			}
		}
	}
	return $res;
}
```
四数之和
```
/**
 * 循环固定两个数，双指针找两个数
 */
function fourSum(array $nums, int $target) {
	$res = [];
	$len = count($nums);
	if($len < 4) return $res;
	sort($nums);
	for($i = 0; $i < $len-3; $i++) {
		//相同元素判断
		if($i > 0 && $nums[$i] == $nums[$i - 1]) continue;
		//最小值判断
		if($nums[$i] + $nums[$i+1] + $nums[$i+2] + $nums[$i+3] > $target) break;
		//最大值判断
		if($nums[$i] + $nums[$len-3] + $nums[$len-2] + $nums[$len-1] < $target) continue;
		for($j = $i+1; $j < $len-2; $j++) {
			//相同元素判断
			if($j > $i+1 && $nums[$j] == $nums[$j - 1]) continue;
			//最小值判断
			if($nums[$i] + $nums[$j] + $nums[$j+1] + $nums[$i+2] > $target) break;
			//最大值判断
			if($nums[$i] + $nums[$j] + $nums[$len-2] + $nums[$len-1] < $target) continue;
			$left = $j+1;
			$right = $len - 1;
			while($left < $right) {
				$sum = $nums[$i] + $nums[$j] + $nums[$left] + $nums[$right];
				if($sum == $target) {
;					$res[] = [$nums[$i], $nums[$j], $nums[$left], $nums[$right]];
					//左边去重
					while($left < $right && $nums[$left] == $nums[$left+1]) {
						$left++;
					}
					//右边去重
					while($left < $right && $nums[$right] == $nums[$right-1]) {
						$right--;
					}
					$left++;
					$right--;
				} else if ($sum < $target) {
					//左边去重
					while($left < $right && $nums[$left] == $nums[$left+1]) {
						$left++;
					}
					$left++;
				} else {
					//右边去重
					while($left < $right && $nums[$right] == $nums[$right-1]) {
						$right--;
					}
					$right--;
				}
			}
		}
	}
	return $res;
}
```