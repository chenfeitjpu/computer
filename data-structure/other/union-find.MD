**并查集**
- [定义](#定义)
- [实现](#实现)
- [使用](#使用)


# 定义 #
```
不相交集合的合并及查询问题
```

# 实现 #
<details>
<summary>代码</summary>
<pre>
<code>

```
type UF struct {
	parent []int
}

func ConstructorUF(n int) *UF {
	parent := make([]int, n)
	for i := 0; i < n; i++ {
		parent[i] = i
	}
	return &UF{
		parent: parent,
	}
}

func (u *UF) find(x int) int {
	if u.parent[x] != x {
		u.parent[x] = u.find(u.parent[x])
	}
	return u.parent[x]
}

func (u *UF) Union(x, y int) {
	p, q := u.find(x), u.find(y)
	if p == q {
		return
	}
	u.parent[p] = q
}

func (u *UF) Connected(x, y int) bool {
	return u.find(x) == u.find(y)
}

func (u *UF) Count() int {
	return len(u.parent)
}
```
</pre>
</code>
</details>

# 使用 #
```
- 应用  
  - LeetCode  
    - 323.无向图中的连通分量数目
    - 990.等式方程的可满足性
```


