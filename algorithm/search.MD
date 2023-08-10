**搜索**
- [定义](#定义)
- [使用](#使用)
  - [二分搜索](#二分搜索)
  - [DFS](#dfs)
  - [BFS](#bfs)

# 定义 #

# 使用 #
## 二分搜索 ##
**模版**
<details>
<summary>代码</summary>
<pre>
<code>      
func BinarySearch(nums []int, target int) int {
	left, right := 0, len(nums)-1
	for left <= right {
		mid := left + (right-left)/2
		if nums[mid] == target {
			return mid
		} else if nums[mid] < target {
			left = mid + 1
		} else if nums[mid] > target {
			right = mid - 1
		}
	}
	return -1
}                   
</code>
</pre>
</details>

**应用**  
*LeetCode* 
- 875.爱吃香蕉的珂珂
- 1011.在D天内送达包裹的能力
- 410.分割数组的最大值

## DFS ##
**应用**  
*LeetCode*  
- 200.岛屿数量
- 1254.统计封闭岛屿的数目
- 1020.飞地的数量
- 1905.统计子岛屿
- 694.不同的岛屿数量

## BFS ##
**应用**  
*LeetCode*  
- 111.二叉树的最小深度
- 102.二叉树的层序遍历
- 752.打开转盘锁
- 773.滑动谜题
