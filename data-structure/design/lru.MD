**LRU**
- [定义](#定义)
- [实现](#实现)
- [应用](#应用)

# 定义 #
最近最少使用

# 实现 #
<details>
<summary>代码</summary>

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
	linkedList *DoubleLinkedList
	data       map[int]*LinkedListNode
}

func ConstructorHashLinkedList() *HashLinkedList {
	head, tail := &LinkedListNode{}, &LinkedListNode{}
	head.next = tail
	tail.prev = head
	return &HashLinkedList{
		linkedList: &DoubleLinkedList{
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
	h.Put(h.linkedList.head.next, node)
}

func (h *HashLinkedList) DeleteTail() {
	if h.Len() == 0 {
		return
	}
	node := h.linkedList.tail.prev
	h.Delete(node)
}

func (h *HashLinkedList) Len() int {
	return len(h.data)
}

type LRUCache struct {
	hashLinkedList *HashLinkedList
	capacity       int
}

func Constructor(capacity int) LRUCache {
	return LRUCache{
		hashLinkedList: ConstructorHashLinkedList(),
		capacity:       capacity,
	}
}

func (l *LRUCache) Get(key int) int {
	node := l.hashLinkedList.Get(key)
	if node == nil {
		return -1
	}
	l.hashLinkedList.Delete(node)
	l.hashLinkedList.PutHead(node)
	return node.value
}

func (l *LRUCache) Put(key int, value int) {
	node := l.hashLinkedList.Get(key)
	if node != nil {
		node.value = value
		l.hashLinkedList.Delete(node)
	} else {
		if l.capacity == l.hashLinkedList.Len() {
			l.hashLinkedList.DeleteTail()
		}
		node = &LinkedListNode{
			key:   key,
			value: value,
		}
	}
	l.hashLinkedList.PutHead(node)
}

</details>

# 应用 #
**LeetCode**  
- 146.LRU缓存 
