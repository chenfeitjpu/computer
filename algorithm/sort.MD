**排序**
- [简介](#简介)
- [使用](#使用)

## 简介
```
对集合进行排序
```

## 使用
<details open>
<summary>LeetCode</summary>

```
LeetCode
- 215.数组中的第K个最大元素
- 347.前K个高频元素
- 406.根据身高重建队列
- 253.会议室II
- 148.排序链表
- 56.合并区间
- 451.根据字符出现频率排序 
- 75.颜色分类
```
</details>

<details>
<summary>冒泡</summary>
<pre>
<code>

```
func bubble(nums []int) []int {
	for i := len(nums) - 1; i > 0; i-- {
		for j := 0; j < i; j++ {
			if nums[j] > nums[j+1] {
				nums[j], nums[j+1] = nums[j+1], nums[j]
			}
		}
	}
	return nums
}
```
</code>
</pre>
</details>

<details>
<summary>选择</summary>
<pre>
<code>

```
func select(nums []int) []int {
	for i := len(nums) - 1; i > 0; i-- {
		max := 0
		for j := 1; j <= i; j++ {
			if nums[j] > nums[max] {
				max = j
			}
		}
		nums[max], nums[i] = nums[i], nums[max]
	}
	return nums
}
```
</code>
</pre>
</details>

<details>
<summary>插入</summary>
<pre>
<code>

```
func insert(nums []int) []int {
	for i, length := 1, len(nums); i < length; i++ {
		num, j := nums[i], i-1
		for ; j >= 0; j-- {
			if nums[j] < num {
				break
			}
			nums[j+1] = nums[j]
		}
		nums[j+1] = num
	}
	return nums
}
```
</code>
</pre>
</details>

<details>
<summary>快排</summary>
<pre>
<code>

```
func quick(nums []int) []int {
	quickSort(nums, 0, len(nums)-1)
	return nums
}
func quickSort(nums []int, start, end int) {
	if start >= end {
		return
	}
	partition := getPartition(nums, start, end)
	quickSort(nums, start, partition-1)
	quickSort(nums, partition+1, end)
}
func getPartition(nums []int, start, end int) int {
	pivot, i, j := nums[start], start+1, end
	for i <= j {
		for i <= end && nums[i] <= pivot {
			i++
		}
		for j > start && nums[j] > pivot {
			j--
		}
		if i >= j {
			break
		}
		nums[i], nums[j] = nums[j], nums[i]
	}
	nums[start], nums[j] = nums[j], nums[start]
	return j
}
```
</code>
</pre>
</details>

<details>
<summary>归并</summary>
<pre>
<code>

```
func merge(nums []int) []int {
	mergeSort(nums, 0, len(nums)-1)
	return nums
}

func mergeSort(nums []int, start, end int) {
	if start >= end {
		return
	}
	mid := start + (end-start)/2
	mergeSort(nums, start, mid)
	mergeSort(nums, mid+1, end)
	mergeSortArray(nums, start, mid, end)
}

func mergeSortArray(nums []int, start, mid, end int) {
	tmp := make([]int, end-start+1)
	for i := start; i <= end; i++ {
		tmp[i-start] = nums[i]
	}
	for p, i, j := start, start, mid+1; p <= end; p++ {
		if i == mid+1 {
			nums[p] = tmp[j-start]
			j++
			continue
		}
		if j == end+1 {
			nums[p] = tmp[i-start]
			i++
			continue
		}
		if tmp[i-start] <= tmp[j-start] {
			nums[p] = tmp[i-start]
			i++
		} else {
			nums[p] = tmp[j-start]
			j++
		}
	}
}
```
</code>
</pre>
</details>

<details>
<summary>堆</summary>
<pre>
<code>

```
func heapSort(nums []int) []int {
	length := len(nums)
	initHeap(nums, length-1)
	for i := length - 1; i >= 1; {
		nums[0], nums[i] = nums[i], nums[0]
		i--
		buildHeap(nums, 0, i)
	}
	return nums
}

func initHeap(nums []int, end int) {
	for i := end / 2; i >= 0; i-- {
		buildHeap(nums, i, end)
	}
}

func buildHeap(nums []int, i, end int) {
	l, r, large := 2*i+1, 2*i+2, i
	if l <= end && nums[l] > nums[large] {
		large = l
	}
	if r <= end && nums[r] > nums[large] {
		large = r
	}
	if large != i {
		nums[i], nums[large] = nums[large], nums[i]
		buildHeap(nums, large, end)
	}
}
```
</code>
</pre>
</details>

<details>
<summary>计数</summary>
<pre>
<code>

```
func count(nums []int) []int {
	min, max := getMinAndMax(nums)
	countArr := make([][]int, max-min+1)
	for _, num := range nums {
		index := num - min
		if len(countArr[index]) == 0 {
			countArr[index] = []int{num}
		} else {
			countArr[index] = append(countArr[index], num)
		}
	}
	i := 0
	for _, arr := range countArr {
		for _, num := range arr {
			nums[i] = num
			i++
		}
	}
	return nums
}

func getMinAndMax(nums []int) (int, int) {
	min, max := math.MaxInt, math.MinInt
	for _, num := range nums {
		if num < min {
			min = num
		}
		if num > max {
			max = num
		}
	}
	return min, max
}
```
</code>
</pre>
</details>

<details>
<summary>基数</summary>
<pre>
<code>

```
func radix(nums []int) []int {
	max := getMax(nums)
	d := len(strconv.Itoa(max))
	base := 1
	for i := 0; i < d; i++ {
		radixArr := make([][]int, 10)
		for _, num := range nums {
			index := (num / base) % 10
			if len(radixArr[index]) == 0 {
				radixArr[index] = []int{num}
			} else {
				radixArr[index] = append(radixArr[index], num)
			}
		}
		base *= 10
		j := 0
		for _, arr := range radixArr {
			for _, num := range arr {
				nums[j] = num
				j++
			}
		}
	}
	return nums
}

func getMax(nums []int) int {
	max := math.MinInt
	for _, num := range nums {
		if num > max {
			max = num
		}
	}
	return max
}
```
</code>
</pre>
</details>

<details>
<summary>桶</summary>
<pre>
<code>

```
func bucket(nums []int) []int {
	min, max := getMinAndMax(nums)
	var (
		bucket  = 3
		buckets = make([][]int, bucket)
		radix   = int(math.Ceil(float64(max-min+1) / float64(bucket)))
	)
	for _, num := range nums {
		index := (num - min) / radix
		if len(buckets[index]) == 0 {
			buckets[index] = []int{num}
		} else {
			buckets[index] = append(buckets[index], num)
			i := len(buckets[index]) - 2
			for ; i >= 0; i-- {
				if buckets[index][i] < num {
					break
				}
				buckets[index][i+1] = buckets[index][i]
			}
			buckets[index][i+1] = num
		}
	}
	i := 0
	for _, arr := range buckets {
		for _, num := range arr {
			nums[i] = num
			i++
		}
	}
	return nums
}

func getMinAndMax(nums []int) (int, int) {
	min, max := math.MaxInt, math.MinInt
	for _, num := range nums {
		if num < min {
			min = num
		}
		if num > max {
			max = num
		}
	}
	return min, max
}
```
</code>
</pre>
</details>
