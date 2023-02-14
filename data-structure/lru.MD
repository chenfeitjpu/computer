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

func (this *DoubleLinked) InsertFirst(node *Node) {
	this.Insert(node, this.Head)
}

func (this *DoubleLinked) Delete(node *Node) {
	node.Prev.Next = node.Next
	node.Next.Prev = node.Prev
	this.Size--
}

func (this *DoubleLinked) DeleteLast() {
	this.Delete(this.Tail.Prev)
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
	this.Linked.InsertFirst(node)
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
	this.Linked.InsertFirst(node)
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

func (this *LinkedHash) GetLastKey() int {
	return this.Linked.Tail.Prev.Key
}

type LRUCache struct {
	linkedHash *LinkedHash
	capacity   int
}

func Constructor(capacity int) LRUCache {
	return LRUCache{
		linkedHash: NewLinkedHash(),
		capacity:   capacity,
	}
}

func (this *LRUCache) Get(key int) int {
	return this.linkedHash.Get(key)
}

func (this *LRUCache) Put(key int, value int) {
	if !this.linkedHash.Contain(key) && this.linkedHash.Len() == this.capacity {
		lastKey := this.linkedHash.GetLastKey()
		this.linkedHash.Delete(lastKey)
	}
	this.linkedHash.Put(key, value)
}
</code>
</pre>
</details>

# 应用 #
*LEETCODE*
- 146.LRU缓存 
