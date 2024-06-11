**Trie**
- [定义](#定义)
- [实现](#实现)
- [使用](#使用)

# 定义 #
```
字典树(前缀树)
```

# 实现 #
<details>
<summary>代码</summary>
<pre>
<code>

```
type Trie struct {
	isEnd    bool
	children [26]*Trie
}

func Constructor() Trie {
	return Trie{}
}

func (this *Trie) Insert(word string) {
	node := this
	for _, char := range word {
		char -= 'a'
		if node.children[char] == nil {
			node.children[char] = &Trie{}
		}
		node = node.children[char]
	}
	node.isEnd = true
}

func (this *Trie) SearchPrefix(prefix string) *Trie {
	node := this
	for _, char := range prefix {
		char -= 'a'
		if node.children[char] == nil {
			return nil
		}
		node = node.children[char]
	}
	return node
}

func (this *Trie) Search(word string) bool {
	node := this.SearchPrefix(word)
	return node != nil && node.isEnd
}

func (this *Trie) StartsWith(prefix string) bool {
	return this.SearchPrefix(prefix) != nil
}
```
</code>
</pre>
</details>

# 使用 #
```
应用
- LeetCode
  - 208.实现Trie(前缀树)
```

