**LFU**
- [定义](#定义)
- [实现 ＃](#实现-)
- [应用](#应用)

# 定义 #
最不经常使用

# 实现 ＃
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
	this.Delete(this.Tail)
}

func (this *DoubleLinked) Len() int {
	return this.Size
}

type LinkedHash struct {
	Linked *DoubleLinked
	Cache  map[int]*Node
}

func NewLinkedHash() *LinkedHash {
	return &LinkedHash{
		Linked: NewDoubleLinked(),
		Cache:  make(map[int]*Node),
	}
}

func (this *LinkedHash) Contain(key int) bool {
	_, ok := this.Cache[key]
	return ok
}

func (this *LinkedHash) Get(key int) int {
	node, ok := this.Cache[key]
	if !ok {
		return -1
	}
	this.Linked.Delete(node)
	this.Linked.InsertFirst(node)
	return node.Value
}

func (this *LinkedHash) Put(key, value int) {
	node, ok := this.Cache[key]
	if !ok {
		node = &Node{Key: key, Value: value}
		this.Cache[key] = node
	} else {
		node.Value = value
		this.Linked.Delete(node)
	}
	this.Linked.InsertFirst(node)
}

func (this *LinkedHash) Delete(key int) {
	node, ok := this.Cache[key]
	if !ok {
		return
	}
	delete(this.Cache, key)
	this.Linked.Delete(node)

}

func (this *LinkedHash) Len() int {
	return len(this.Cache)
}

func (this *LinkedHash) GetLastKey() int {
	return this.Linked.Tail.Prev.Key
}

type LFUCache struct {
	kv       map[int]*Node
	kf       map[int]int
	fk       map[int]*LinkedHash
	capacity int
	minFreq  int
}

func Constructor(capacity int) LFUCache {
	return LFUCache{
		kv:       make(map[int]*Node),
		kf:       make(map[int]int),
		fk:       make(map[int]*LinkedHash),
		capacity: capacity,
	}
}

func (this *LFUCache) Get(key int) int {
	node, ok := this.kv[key]
	if !ok {
		return -1
	}
	this.increFreq(key, node.Value)
	return node.Value
}

func (this *LFUCache) Put(key int, value int) {
	node, ok := this.kv[key]
	if !ok {
		if len(this.kv) == this.capacity {
			this.removeMinFreq()
		}
		node := &Node{Key: key, Value: value}
		this.kv[key] = node
		this.increFreq(key, value)
		this.minFreq = 1
	} else {
		node.Value = value
		this.kv[key] = node
		this.increFreq(key, value)
	}
}

func (this *LFUCache) increFreq(key, value int) {
	oldFreq := this.kf[key]
	newFreq := oldFreq + 1

	this.kf[key] = newFreq

	newFreqList, ok := this.fk[newFreq]
	if !ok {
		newFreqList = NewLinkedHash()
	}
	newFreqList.Put(key, value)
	this.fk[newFreq] = newFreqList

	if oldFreq > 0 {
		oldFreqList := this.fk[oldFreq]
		oldFreqList.Delete(key)
		if oldFreqList.Len() == 0 && oldFreq == this.minFreq {
			this.minFreq++
		}
		this.fk[oldFreq] = oldFreqList
	}
}

func (this *LFUCache) removeMinFreq() {
	nodes := this.fk[this.minFreq]
	lastKey := nodes.GetLastKey()

	delete(this.kv, lastKey)
	delete(this.kf, lastKey)
	nodes.Delete(lastKey)
	if nodes.Len() == 0 {
		delete(this.fk, this.minFreq)
		this.minFreq++
	}
}
</code>
</pre>
</details>

# 应用 #
*LeetCode*
- 460.LFU缓存
