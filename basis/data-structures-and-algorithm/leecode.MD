* [两数之和(1)](#两数之和1)
* [三数之和(15)](#三数之和15)
* [四数之和(18)](#四数之和18)
* [删除排序数组中的重复项(26)](#删除排序数组中的重复项26)
* [移除元素(27)](#移除元素27)
* [搜索插入位置(35)](#搜索插入位置35)
* [最大子序和(53)](#最大子序和53)
* [加1(66)](#加166)
* [合并有序数组(88)](#合并有序数组88)
* [求众数(169)](#求众数169)

# 两数之和(1) #
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
# 三数之和(15) #
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
# 四数之和(18) #
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
## 两两交换链表中的节点(24) ##
```
/**
 * 循环
 */
function swapPairs($head) {
    $dummy = new ListNode(-1);
    $dummy->next = $head;
    $pre = $dummy;
    while ($pre->next && $pre->next->next) {
        $start = $pre->next;
        $end = $pre->next->next;
        $pre->next = $end;
        $start->next = $end->next;
        $end->next = $start;
        $pre = $start;
    }
    return $dummy->next;
}
```
```
/**
 * 递归
 */
function swapPairs($head) {
    if(!$head || !$head->next) return $head;
    $next = $head->next;
    $head->next = swapPairs($next->next);
    $next->next = $head;
    return $next;
}
```
## K个一组翻转链表(25) ##
```
/**
 * 循环+尾插入
 */
function reverseKGroup($head, $k) {
    $dummy = new ListNode(-1);
    $dummy->next = $head;
    $pre = $tail = $dummy;
    while (true) {
        $count = $k;
        while ($count && $tail) {
            $tail = $tail->next;
            $count--;
        }
        if(!$tail) break;
        $head = $pre->next;
        while ($pre->next != $tail) {
            $cur = $pre->next;
            $pre->next = $cur->next;
            $cur->next = $tail->next;
            $tail->next = $cur;
        }
        $pre = $tail = $head;
    }
    return $dummy->next;
}
```
```
/**
 * 递归
 */
function reverseKGroup2($head, $k) {
    $cur = $head;
    $count = 0;
    while ($cur && $count != $k) {
        $cur = $cur->next;
        $count++;
    }
    if($count == $k) {
        $cur = reverseKGroup2($cur, $k);
        while ($count) {
            $tmp = $head->next;
            $head->next = $cur;
            $cur = $head;
            $head = $tmp;
            $count--;
        }
        $head = $cur;
    }
    return $head;
```
# 删除排序数组中的重复项(26) #
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
# 移除元素(27) #
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
# 搜索插入位置(35) #
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
# 幂函数(50) #
```
function fastPow($x, $n) {
    if($n == 1) {
        return $x;
    }
    $value = fastPow($x, floor($n / 2));
    if($n % 2 == 0) {
        return $value * $value;
    } else {
        return $value * $value * $x;
    }
}
function myPow($x, $n) {
    if($n == 0) return 1;
    if($n < 0) {
        $x = 1 / $x;
        $n = -$n;
    }
    return fastPow($x, $n);
}
```
# 最大子序和(53) #
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
# 加1(66) #
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
# 合并有序数组(88) #
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
## 反转链表II(92) ##
```
/**
 * 拼接法
 */
function reverseBetween($head, $m, $n) {
    $dummy = new ListNode(-1);
    $dummy->next = $head;
    $pre = $dummy;
    for($i = 0; $i < $m - 1; $i++) {
        $pre = $pre->next;
    }
    $node = null;
    $cur = $pre->next;
    for($i = 0; $i < $n - $m + 1; $i++) {
        $tmp = $cur->next;
        $cur->next = $node;
        $node = $cur;
        $cur = $tmp;
    }
    $pre->next->next = $cur;
    $pre->next = $node;
    return $dummy->next;
}
```
```
/**
 * 插入法
 */
function reverseBetween2($head, $m, $n) {
    $dummy = new ListNode(-1);
    $dummy->next = $head;
    $pre = $dummy;
    for($i = 0; $i < $m - 1; $i++) {
        $pre = $pre->next;
    }
    $start = $pre->next;
    $tail = $start->next;
    for($i = 0; $i < $n - $m; $i++) {
        $start->next = $tail->next;
        $tail->next = $pre->next;
        $pre->next = $tail;
        $tail = $start->next;
    }
    return $dummy->next;
}
```
# 买卖股票的最佳时机(122) #
```
function maxProfit($prices) {
    $len = count($prices);
    if($len <= 2) return 0;
    $profit = 0;
    for($i = 1; $i < $len; $i++) {
        if($prices[$i] > $prices[$i -1]) {
            $profit += $prices[$i] - $prices[$i - 1];
        }
    }
    return $profit;
}
```
# 求众数(169) #
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
```
function majorityCount($nums, $num, $lower, $hight) {
    $count = 0;
    for($i = $lower; $i <= $hight; $i++) {
        if($nums[$i] == $num) {
            $count++;
        }
    }
    return $count;
}
function majority($nums, $lower, $hight) {
    if($lower == $hight) {
        return $nums[$lower];
    }
    $mid = floor(($hight - $lower) / 2) + $lower;
    $left = majority($nums, $lower, $mid);
    $right = majority($nums, $mid + 1, $hight);
    if($left == $right) {
        return $left;
    }
    $leftCount = majorityCount($nums, $left, $lower, $hight);
    $rightCount = majorityCount($nums, $right, $lower, $hight);
    return $leftCount > $rightCount ? $left : $right;
}
function majorityElement($nums) {
    $len = count($nums);
    if($len == 0) return null;
    if($len == 1) return current($nums);
    return majority($nums, 0, $len-1);
}
```
## 反转链表(206) ##
```
/**
 * 把当前元素的指针指向前一个元素(从前向后遍历)
 */
function reverseList($head) {
    $pre = null;
    $cur = $head;
    while ($cur) {
        $tmp = $cur->next;
        $cur->next = $pre;
        $pre = $cur;
        $cur = $tmp;
    }
    return $pre;
}
```
```
/**
 * 把后一个元素的指针指向当前元素(从后向前遍历)
 */
function reverseList2($head) {
    if(!$head->next) return $head;
    $p = reverseList2($head->next);
    $head->next->next = $head;
    $head->next = null;
    return $p;
}
```
# 滑动窗口最大值(239) #
```
function slidingWindow($nums, $k) {
    $len = count($nums);
    if(!$len) return [];
    $window = $res = [];
    for($i = 0; $i < $len; $i++) {
        while($i >= $k && $window && $window[0] <= $i - $k) {
            array_shift($window);
        }
        while($window && $nums[$window[count($window)-1]] <= $nums[$i]) {
            array_pop($window);
        }
        array_push($window, $i);
        if($i >= $k-1) {
            $res[] = $nums[$window[0]];
        }
    }
    if($len < $k) {
        $res[] = $nums[$window[0]];
    }
    return $res;
}
```
# 有效的字母异位词(242) #
```
function isAnagram($s, $t) {
    $slen = strlen($s);
    $tlen = strlen($t);
    if($slen != $tlen) return false;
    $map = [];
    for($i = 0; $i < $slen; $i++) {
        isset($map[$s[$i]]) ? $map[$s[$i]]++ : $map[$s[$i]] = 1;
        isset($map[$t[$i]]) ? $map[$t[$i]]-- : $map[$t[$i]] = -1;
    }
    foreach ($map as $k => $v) {
        if($v) {
            return false;
        }
    }
    return true;
}
```