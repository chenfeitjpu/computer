**数组**
- [定义](#定义)
- [特点](#特点)
- [应用](#应用)
  - [前缀和](#前缀和)
  - [差分数组](#差分数组)
  - [双指针](#双指针)
  - [滑动窗口](#滑动窗口)

# 定义 #
顺序存储元素

# 特点 #
查询快O(1)，增删慢O(n)

# 应用 #
## 前缀和 ##
**适用场景**  
原始数组不变，频繁查询某个区间的累加和  
- 求一维数组区间值
- 求二维数组区间值
- 查找指定区间值

**模版**
```
type NumArray struct {
	sumArray []int
}
func Constructor(nums []int) *NumArray {
	length := len(nums)
	sumArray := make([]int, length+1)
	for i := 1; i <= length; i++ {
		sumArray[i] = sumArray[i-1] + nums[i-1]
	}
	return &NumArray{
		sumArray: sumArray,
	}
}
func (this *NumArray) GetRange(start, end int) int {
	return this.sumArray[end+1] - this.sumArray[start]
}
```

**应用**  
LeetCode
- 303.区域和检索 - 数组不可变
- 304.二维区域和检索 - 矩阵不可变
- 560.和为K的子数组
    
## 差分数组 ##
**适用场景**  
频繁对原始数组的某个区间的元素进行增减

**模版**
<details>
<summary>代码</summary>
<pre>
<code>
type Difference struct {
	diffArray []int
}
func Constructor(nums []int) *Difference {
	length := len(nums)
	diffArray := make([]int, length)
	diffArray[0] = nums[0]
	for i := 1; i < length; i++ {
		diffArray[i] = nums[i] - nums[i-1]
	}
	return &Difference{
		diffArray: diffArray,
	}
}
func (this *Difference) Increment(start, end, value int) {
	this.diffArray[start] += value
	if end+1 < len(this.diffArray) {
		this.diffArray[end+1] -= value
	}
}
func (this *Difference) GetResult() []int {
	length := len(this.diffArray)
	res := make([]int, length)
	res[0] = this.diffArray[0]
	for i := 1; i < length; i++ {
		res[i] = res[i-1] + this.diffArray[i]
	}
	return res
}
</code>
</pre>
</details>

**应用**  
LeetCode
- 370.区间加法
- 1109.航班预订统计
- 1094.拼车

## 双指针 ##
**简介**  
- 左右指针 两个指针相向而行或者相背而行
- 快慢指针 两个指针同向而行，一快一慢

**应用**  
LeetCode
- 26.删除有序数组中的重复项
- 27.移除元素
- 283.移动零
- 167.两数之和 II - 输入有序数组

## 滑动窗口 ##
**简介**    
通过快慢指针，不停滑动搜索区间

**模版**
<details>
<summary>代码</summary>
<pre>
<code>
func SlideWindow(s string) {
	length := len(s)
	left, right := 0, 0
	for right < length {
		//扩大窗口
		right++
		//缩小窗口
		for {
			left++
		}
	}
}
</code>
</pre>
</details>

**应用**  
LeetCode
- 76.最小覆盖子串
- 567.字符串的排列
- 438.找到字符串中所有字母异位词
- 3.无重复字符的最长子串