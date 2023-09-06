**随机算法**
- [实现](#实现)
- [使用](#使用)

# 实现 #
<details>
<summary>代码</summary>
<pre>
<code>

```
type RandomizedSet struct {
	vi   map[int]int
	nums []int
}

func Constructor() RandomizedSet {
	return RandomizedSet{
		vi:   make(map[int]int),
		nums: make([]int, 0),
	}
}

func (r *RandomizedSet) Insert(val int) bool {
	if _, ok := r.vi[val]; ok {
		return false
	}
	length := len(r.nums)
	r.vi[val] = length
	r.nums = append(r.nums, val)
	return true
}

func (r *RandomizedSet) Remove(val int) bool {
	index, ok := r.vi[val]
	if !ok {
		return false
	}
	length := len(r.nums)
	r.nums[index], r.nums[length-1] = r.nums[length-1], r.nums[index]
	r.vi[r.nums[index]] = index
	r.nums = r.nums[:length-1]
	delete(r.vi, val)
	return true
}

func (r *RandomizedSet) GetRandom() int {
	index := rand.Intn(len(r.nums))
	return r.nums[index]
}
```
</code>
</pre>
</details>

<details>
<summary>代码</summary>
<pre>
<code>

```
type Solution struct {
	n        int
	blackMap map[int]int
}

func Constructor(n int, blacklist []int) Solution {
	size := len(blacklist)
	blackMap := make(map[int]int)
	for _, black := range blacklist {
		if black >= n-size {
			blackMap[black] = black
		}
	}

	last := n - 1
	for _, black := range blacklist {
		if black >= n-size {
			continue
		}
		for {
			if _, ok := blackMap[last]; ok {
				last--
			} else {
				break
			}
		}
		blackMap[black] = last
		last--
	}
	return Solution{
		n:        n,
		blackMap: blackMap,
	}
}

func (s *Solution) Pick() int {
	index := rand.Intn(s.n - len(s.blackMap))
	if value, ok := s.blackMap[index]; ok {
		return value
	}
	return index
}
```
</code>
</pre>
</details>

# 使用 #
```
应用
LeetCode
- 380.O(1)时间插入、删除和获取随机元素
- 710.黑名单中的随机数
```