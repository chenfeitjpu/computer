**LRU**
- [定义](#定义)
- [实现](#实现)
- [应用](#应用)

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

type DoubleLinked struct {
	Head *Node
	Tail *Node
	Size int
}

func NewDoubleLinked() *DoubleLinked {
	head := &Node{}
	tail := &Node{}
	head.Next = tail
	tail.Prev = head
	return &DoubleLinked{
		Head: head,
		Tail: tail,
	}
}

func (this *DoubleLinked) Insert(node *Node, prev *Node) {
	next := prev.Next
	node.Next = next
	next.Prev = node
	prev.Next = node
	node.Prev = prev
	this.Size++
}

func (this *DoubleLinked) Delete(node *Node) {
	node.Prev.Next = node.Next
	node.Next.Prev = node.Prev
	this.Size--
}

func (this *DoubleLinked) Len() int {
	return this.Size
}

type LinkedHash struct {
	Linked *DoubleLinked
	Data   map[int]*Node
}

func NewLinkedHash() *LinkedHash {
	return &LinkedHash{
		Linked: NewDoubleLinked(),
		Data:   make(map[int]*Node),
	}
}

func (this *LinkedHash) Contain(key int) bool {
	_, ok := this.Data[key]
	return ok
}

func (this *LinkedHash) Get(key int) int {
	node, ok := this.Data[key]
	if !ok {
		return -1
	}
	this.Linked.Delete(node)
	this.Linked.Insert(node, this.Linked.Head)
	return node.Value
}

func (this *LinkedHash) Put(key, value int) {
	node, ok := this.Data[key]
	if !ok {
		node = &Node{Key: key, Value: value}
		this.Data[key] = node
	} else {
		node.Value = value
		this.Linked.Delete(node)
	}
	this.Linked.Insert(node, this.Linked.Head)
}

func (this *LinkedHash) Delete(key int) {
	node, ok := this.Data[key]
	if !ok {
		return
	}
	delete(this.Data, key)
	this.Linked.Delete(node)

}

func (this *LinkedHash) Len() int {
	return len(this.Data)
}

func (this *LinkedHash) DeleteLast() {
	last := this.Linked.Tail.Prev
	this.Delete(last.Key)
}

type LRUCache struct {
	capacity   int
	linkedHash *LinkedHash
}

func Constructor(capacity int) LRUCache {
	return LRUCache{
		capacity:   capacity,
		linkedHash: NewLinkedHash(),
	}
}

func (this *LRUCache) Get(key int) int {
	return this.linkedHash.Get(key)
}

func (this *LRUCache) Put(key int, value int) {
	if !this.linkedHash.Contain(key) {
		if this.linkedHash.Len() == this.capacity {
			this.linkedHash.DeleteLast()
		}
	}
	this.linkedHash.Put(key, value)
}
</code>
</pre>
</details>

# 应用 #
*LEETCODE*
- 146.LRU缓存 
