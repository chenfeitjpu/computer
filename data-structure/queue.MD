**队列**
- [定义](#定义)
- [特点](#特点)
- [应用](#应用)
  - [单调队列](#单调队列)
  - [优先级队列](#优先级队列)
  
# 定义 #
只能在尾部添加数据、首部删除数据

# 特点 #
先进先出

# 应用 #
## 单调队列 ##
**简介**  
队列内元素保持单调性

**应用**  
LeetCode
- 239.滑动窗口最大值（困难）
  
## 优先级队列 ##
**简介**  
按元素优先级出队

**模版**  
<details>
<summary>代码</summary>
<pre>
<code>
type ListNode struct {
    Val  int
    Next *ListNode
}

type HeapListNode []*ListNode

func (h HeapListNode) Len() int {
    return len(h)
}

func (h HeapListNode) Swap(i, j int) {
    h[i], h[j] = h[j], h[i]
}

func (h HeapListNode) Less(i, j int) bool {
    return h[i].Val < h[j].Val
}

func (h *HeapListNode) Push(value interface{}) {
    *h = append(*h, value.(*ListNode))
}

func (h *HeapListNode) Pop() interface{} {
    old := *h
    n := len(old)
    *h = old[:n-1]
    return old[n-1]
}
</code>
</pre>
</details>

**应用**  
LeetCode
- 23.合并K个升序链表（困难）
- 870.优势洗牌