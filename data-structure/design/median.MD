
**中位数**
- [定义](#定义)
- [实现](#实现)
- [使用](#使用)

# 定义 #
```
获取数据流的中位数
```

# 实现 #
<details>
<summary>代码</summary>
<pre>
<code>

```
type intSmallHeap []int

func (h intSmallHeap) Less(i, j int) bool {
	return h[i] <= h[j]
}

func (h intSmallHeap) Swap(i, j int) {
	h[i], h[j] = h[j], h[i]
}

func (h intSmallHeap) Len() int {
	return len(h)
}

func (h *intSmallHeap) Push(x interface{}) {
	*h = append(*h, x.(int))
}

func (h *intSmallHeap) Pop() interface{} {
	old := *h
	length := len(old)
	*h = old[:length-1]
	return old[length-1]
}

func (h *intSmallHeap) Top() interface{} {
	data := *h
	return data[0]
}

type intLargeHeap []int

func (h intLargeHeap) Less(i, j int) bool {
	return h[i] >= h[j]
}

func (h intLargeHeap) Swap(i, j int) {
	h[i], h[j] = h[j], h[i]
}

func (h intLargeHeap) Len() int {
	return len(h)
}

func (h *intLargeHeap) Push(x interface{}) {
	*h = append(*h, x.(int))
}

func (h *intLargeHeap) Pop() interface{} {
	old := *h
	length := len(old)
	*h = old[:length-1]
	return old[length-1]
}

func (h *intLargeHeap) Top() interface{} {
	data := *h
	return data[0]
}

type MedianFinder struct {
	small *intSmallHeap
	large *intLargeHeap
}

func Constructor() MedianFinder {
	small := &intSmallHeap{}
	heap.Init(small)
	large := &intLargeHeap{}
	heap.Init(large)
	return MedianFinder{
		small: small,
		large: large,
	}
}

func (m *MedianFinder) AddNum(num int) {
	if m.large.Len() < m.small.Len() {
		heap.Push(m.small, num)
		heap.Push(m.large, heap.Pop(m.small))
	} else {
		heap.Push(m.large, num)
		heap.Push(m.small, heap.Pop(m.large))
	}
}

func (m *MedianFinder) FindMedian() float64 {
	if m.large.Len() < m.small.Len() {
		return float64(m.small.Top().(int))
	}
	return (float64(m.large.Top().(int)) + float64(m.small.Top().(int))) / 2
}
```
</code>
</pre>
</details>

# 使用 #
```
应用
- LeetCode
  - 295.数据流的中位数
```
