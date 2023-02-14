# LRU #

LRU

# 定义 #
最近最少使用

# 实现 #
<details>
<summary>代码</summary>
<pre>
<code>
type Node struct {
	Key   int
	Value int
	Prev  *Node
	Next  *Node
}

type DoubleList struct {
	Head *Node
	Tail *Node
	Size int
}

func ConstructorDoubleList() *DoubleList {
	head := &Node{}
	tail := &Node{}
	head.Next = tail
	tail.Prev = head
	return &DoubleList{
		Head: head,
		Tail: tail,
	}
}

func (this *DoubleList) insertFirst(node *Node) {
	next := this.Head.Next
	node.Next = next
	next.Prev = node
	this.Head.Next = node
	node.Prev = this.Head
	this.Size++
}

func (this *DoubleList) delete(node *Node) {
	node.Prev.Next = node.Next
	node.Next.Prev = node.Prev
	this.Size--
}

func (this *DoubleList) len() int {
	return this.Size
}

type LRUCache struct {
	capacity   int
	data       map[int]*Node
	doubleList *DoubleList
}

func Constructor(capacity int) LRUCache {
	return LRUCache{
		capacity:   capacity,
		data:       make(map[int]*Node),
		doubleList: ConstructorDoubleList(),
	}
}

func (this *LRUCache) Get(key int) int {
	node, ok := this.data[key]
	if !ok {
		return -1
	}
	this.doubleList.delete(node)
	this.doubleList.insertFirst(node)
	return node.Value
}

func (this *LRUCache) Put(key int, value int) {
	node, ok := this.data[key]
	if !ok {

		if this.capacity == this.doubleList.len() {
			last := this.doubleList.Tail.Prev
			this.doubleList.delete(last)
			delete(this.data, last.Key)
		}
		node = &Node{Key: key, Value: value}
		this.data[key] = node
	} else {
		node.Value = value
		this.doubleList.delete(node)
	}
	this.doubleList.insertFirst(node)
}
</code>
</pre>
</details>

# 应用 #
*LEETCODE*
- 146.LRU缓存 
