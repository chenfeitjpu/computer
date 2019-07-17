* [剑指offer](#剑指offer)
  * [二维数组中的查找(1)](#二维数组中的查找1)
  * [旋转数组的最小数字(6)](#旋转数组的最小数字6)
* [k数之和](#k数之和)
* [删除重复元素](#删除重复元素)
* [删除目标元素](#删除目标元素)
* [搜索插入位置](#搜索插入位置)
* [最大子序和](#最大子序和)
* [加1](#加1)
* [合并有序数组](#合并有序数组)
* [求众数](#求众数)

# 剑指offer #
## 二维数组中的查找(1) ##
```
/**
 * 暴力破解-枚举
 * 时间复杂度O(m*n)
 * 空间负责度O(1)
 */
function find($array, $target) {
    $rowLen = count($array);
    if(!$rowLen) return false;
    $colLen = count($array[0]);
    for($i = 0; $i < $rowLen; $i++) {
        for($j = 0; $j < $colLen; $j++) {
            if($array[$i][$j] == $target) {
                return true;
            }
        }
    }
    return false;
}
```
```
/**
 * 分治法-利用数据的深度有序性
 * 时间复杂度O(max(m,n))
 * 空间负责度O(1)
 */
function find1($array, $target) {
    $rowLen = count($array);
    if(!$rowLen) return false;
    $colLen = count($array[0]);
    $i = 0;
    $j = $colLen - 1;
    while (0 <= $i && $i <= $rowLen -1 && 0 <= $j && $j <= $colLen-1) {
        $cur = $array[$i][$j];
        if($cur < $target) {
            $i++;
        } else if($cur > $target) {
            $j--;
        } else {
            return true;
        }
    }
    return false;
}
```
```
/**
 * 二分法-利用数据的广度有序性
 * 时间复杂度O(log(max(m,n)))
 * 空间负责度O(1)
 */
function find2($array, $target) {
    $rowLen = count($array);
    if(!$rowLen) return false;
    $colLen = count($array[0]);
    //二分查找定位行列范围
    $row = $col = 0;
    $left = 0;
    $right = $rowLen - 1;
    while ($left <= $right) {
        $mid = floor(($left + $right) / 2);
        $row = $left;
        $col = $colLen - $rowLen + $row;
        $col = $col >= 0 ? $col : 0;
        $cur = $array[$row][$col];
        if($cur < $target) {
            $left = $mid + 1;
        } else if($cur > $target) {
            $right = $mid -1;
        } else {
            return true;
        }
    }

    //从行里面二分查找目标元素
    $left = 0;
    $right = $col - 1;
    while ($left <= $right) {
        $mid = floor(($left + $right) / 2);
        $cur = $array[$row][$mid];
        if($cur < $target) {
            $left = $mid + 1;
        } else if($cur > $target) {
            $right = $mid -1;
        } else {
            return true;
        }
    }

    //从列里面二分查找目标元素
    $left = 0;
    $right = $row - 1;
    while ($left <= $right) {
        $mid = floor(($left + $right) / 2);
        $cur = $array[$mid][$col];
        if($cur < $target) {
            $left = $mid + 1;
        } else if($cur > $target) {
            $right = $mid -1;
        } else {
            return true;
        }
    }

    return false;
}
```
## 旋转数组的最小数字(6) ##
```
/**
 * 遍历
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function minNumberInRotateArray($array) {
    $len = count($array);
    if(!$len) {
        return 0;
    }
    for($i = 0; $i < $len - 1; $i++) {
        if($array[$i] > $array[$i+1]) {
            return $array[$i+1];
        }
    }
    return $array[0];
}
```
```
/**
 * 二分法-利用数据的有序性
 * 时间复杂度O(log n)
 * 空间复杂度O(1)
 */
function minNumberInRotateArray1($array) {
    $len = count($array);
    if(!$len) {
        return 0;
    }
    $left = 0;
    $right = $len - 2;
    while ($left <= $right) {
        $mid = floor(($left + $right) / 2);
        if($array[$mid] <= $array[$mid+1]) {
            if($array[0] <= $array[$mid]) {
                $left = $mid + 1;
            } else {
                $right = $mid - 1;
            }
        } else {
            return $array[$mid+1];
        }
    }
    return $array[0];
}
```



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
# 删除重复元素 #
```
/**
 * 双指针－慢指针存放最终值，快指针用来比较重复元素
 */
function removeDuplicates(array &nums) {
	$len = count($nums);
	if($len == 0) return 0;
	$i = 0;
	for($j = 1; $j < $len; $j++) {
		if($nums[$j] != $nums[$i]) {
			$i++;
			if($i != $j) {
				$nums[$i] = $nums[$j];
			}
		}
	}
	return $i+1;
}
```
# 删除目标元素 #
```
/**
 * 双指针－慢指针存放最终值，快指针用来比较目标值
 */
function removeElement(array $nums, int $val) {
	$len = count($nums);
	if($len == 0) return 0;
	$i = 0;
	for($j = 0; $j < $len; $j++) {
		if($nums[$j] != $val) {
			$nums[$i] = $nums[$j];
			$i++;
		}
	}
	return $i;
}
```
# 搜索插入位置 #
```
/**
 * 二分查找
 */
function searchIndex(array $nums, int $target) {
	$len = count($nums);
	if($len == 0) return 0;
	if($num[0] > $target) return 0;
	$left = 0;
	$right = $len - 1;
	while ($left <= $right) {
		$mid = floor(($left  + $right) / 2);
		if($nums[$mid] == $target) {
			return $mid;
		} else if($nums[$mid] < $target) {
			$left = $mid + 1;
		} else {
			$right = $mid - 1;
		}
	} 
	return $left;
}
```
# 最大子序和 #
```
/**
 * 动态规划
 */
function maxSubArray(array $nums, int $target) {
	$len = count($nums);
	if($len == 0) return null;
	$max = $nums[0];
	$sum = 0;
	for($i = 0; $i < $len; $i++) {
		if($sum) {
			$sum += $nums[$i];
		} else {
			$sum = $nums[$i];
		}
		$max= max($max, $sum);
	}
	return $max;
}
```
# 加1 #
```
/**
 * 循环进位
 */
function plusOne(array $nums) {
	$len = count($nums);
	if($len == 0) return null;
	for($i = $len - 1; $i >= 0; $i--) {
		$nums[$i]++;
		$nums[$i] = $nums[$i] % 10;
		if($nums[$i] > 0) return $nums; 
	}
	array_unshift($nums, 1);
	return $nums;
}
```
# 合并有序数组 #
```
/**
 * 双指针逆序进行比较
 */
public function merge(array $nums1, int $m, array $nums2, int $n) {
	for ($k = $m + $n - 1, $i = $m -1, $j = $n - 1; $k >= 0; $k--) {
		if($i < 0) {
			$nums1[$k] = $nums2[$j--];
			continue;
		}
		if($j < 0) {
			$nums1[$k] = $nums1[$i--];
			continue;
		}
		if($nums1[$i] > $nums2[$j]) {
			$nums1[$k] = $nums1[$i--];
		} else {
			$nums1[$k] = $nums2[$j--];
		}
	}
}
```
# 求众数 #
```
/**
 * 众数加1，其它数-1
 */
function majorityElement($nums) {
	$count = 0;
	$res = null;
	foreach($nums as $num) {
		if($count == 0) {
			$res = $num;
		}
		$count += ($num == $res ? 1 : -1);
	}
	return $res;
}
```
