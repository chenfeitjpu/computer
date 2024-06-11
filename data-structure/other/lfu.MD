**LFU**
- [定义](#定义)
- [实现](#实现)
- [使用](#使用)

# 定义 #
```
最不经常使用
```

# 实现 #
<details>
<summary>代码</summary>
<pre>
<code>

```
type LinkedListNode struct {
	key   int
	value int
	prev  *LinkedListNode
	next  *LinkedListNode
}

type DoubleLinkedList struct {
	head *LinkedListNode
	tail *LinkedListNode
}

type HashLinkedList struct {
	doubleLinkedList *DoubleLinkedList
	data             map[int]*LinkedListNode
}

func ConstructorHashLinkedList() *HashLinkedList {
	head, tail := &LinkedListNode{}, &LinkedListNode{}
	head.next = tail
	tail.prev = head
	return &HashLinkedList{
		doubleLinkedList: &DoubleLinkedList{
			head: head,
			tail: tail,
		},
		data: make(map[int]*LinkedListNode),
	}
}

func (h *HashLinkedList) Get(key int) *LinkedListNode {
	return h.data[key]
}

func (h *HashLinkedList) Put(cur, node *LinkedListNode) {
	h.data[node.key] = node
	node.prev = cur.prev
	node.next = cur
	cur.prev.next = node
	cur.prev = node
}

func (h *HashLinkedList) Delete(node *LinkedListNode) {
	if node == nil {
		return
	}
	delete(h.data, node.key)
	node.prev.next = node.next
	node.next.prev = node.prev
}

func (h *HashLinkedList) PutHead(node *LinkedListNode) {
	h.Put(h.doubleLinkedList.head.next, node)
}

func (h *HashLinkedList) DeleteTail() {
	if h.Len() == 0 {
		return
	}
	h.Delete(h.GetTail())
}

func (h *HashLinkedList) GetTail() *LinkedListNode {
	return h.doubleLinkedList.tail.prev
}

func (h *HashLinkedList) Len() int {
	return len(h.data)
}

type LFUCache struct {
	kv       map[int]*LinkedListNode
	kf       map[int]int
	fk       map[int]*HashLinkedList
	capacity int
	minFreq  int
}

func Constructor(capacity int) LFUCache {
	return LFUCache{
		kv:       make(map[int]*LinkedListNode),
		kf:       make(map[int]int),
		fk:       make(map[int]*HashLinkedList),
		capacity: capacity,
	}
}

func (l *LFUCache) Get(key int) int {
	node := l.kv[key]
	if node == nil {
		return -1
	}
	l.UpdateFreq(node)
	return node.value
}

func (l *LFUCache) Put(key int, value int) {
	node := l.kv[key]
	if node != nil {
		node.value = value
		l.kv[key] = node
		l.UpdateFreq(node)
	} else {
		if l.capacity == len(l.kv) {
			l.DeleteLast()
		}
		node = &LinkedListNode{
			key:   key,
			value: value,
		}
		l.kv[key] = node
		l.UpdateFreq(node)
		l.minFreq = 1
	}
}

func (l *LFUCache) UpdateFreq(node *LinkedListNode) {
	freq := l.kf[node.key]
	if freq > 0 {
		oldHashLinkedList := l.fk[freq]
		oldHashLinkedList.Delete(node)
		if oldHashLinkedList.Len() == 0 && freq == l.minFreq {
			l.minFreq++
		}
	}

	freq++
	l.kf[node.key] = freq
	newHashLinkedList := l.fk[freq]
	if newHashLinkedList == nil {
		newHashLinkedList = ConstructorHashLinkedList()
		l.fk[freq] = newHashLinkedList
	}
	newHashLinkedList.PutHead(node)
}

func (l *LFUCache) DeleteLast() {
	hashLinkedList := l.fk[l.minFreq]
	tail := hashLinkedList.GetTail()
	delete(l.kv, tail.key)
	delete(l.kf, tail.key)
	hashLinkedList.Delete(tail)
}
```
</code>
</pre>
</details>

# 使用 #
```
- 应用  
  - LeetCode  
    - 460.LFU缓存
```
