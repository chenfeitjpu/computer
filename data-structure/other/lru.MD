**LRU**
- [简介](#简介)
- [实现](#实现)
- [使用](#使用)

## 简介
```
定义
最近最少使用
```

## 实现
<details open>
<summary>Struct</summary>

```
import "fmt"

type DoubleListNode struct {
	key  int
	val  int
	prev *DoubleListNode
	next *DoubleListNode
}

type DoubleList struct {
	head *DoubleListNode
	tail *DoubleListNode
}

func ConstructorDoubleList() *DoubleList {
	head, tail := &DoubleListNode{}, &DoubleListNode{}
	head.next = tail
	tail.prev = head
	return &DoubleList{
		head: head,
		tail: tail,
	}
}

type LRUCache struct {
	capacity int
	data     map[int]*DoubleListNode
	lru      *DoubleList
}

func (this *DoubleList) delete(node *DoubleListNode) {
	node.prev.next = node.next
	node.next.prev = node.prev
}

func (this *DoubleList) insertHead(node *DoubleListNode) {
	this.head.next.prev = node
	node.next = this.head.next
	node.prev = this.head
	this.head.next = node
}

func Constructor(capacity int) LRUCache {
	return LRUCache{
		capacity: capacity,
		data:     make(map[int]*DoubleListNode, capacity),
		lru:      ConstructorDoubleList(),
	}
}

func (this *LRUCache) Get(key int) int {
	node, ok := this.data[key]
	if !ok {
		return -1
	}
	this.lru.delete(node)
	this.lru.insertHead(node)
	return node.val
}

func (this *LRUCache) Put(key int, value int) {
	node, ok := this.data[key]
	if !ok {
		if len(this.data) == this.capacity {
			tail := this.lru.tail.prev
			this.lru.delete(tail)
			delete(this.data, tail.key)
		}
		node = &DoubleListNode{
			key: key,
			val: value,
		}
		this.data[key] = node
	} else {
		node.val = value
		this.lru.delete(node)
	}
	this.lru.insertHead(node)
}
```
</details>

## 使用
<details open>
<summary>LeetCode</summary>

```   
- 146.LRU缓存 
```
</details>

