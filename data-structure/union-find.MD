并查集

# 定义 #
不相交集合的合并及查询问题

# 应用 #
## LEETCODE ##
### 684.冗余连接 ###
<details>
<summary>代码</summary>
<pre>
<code>
function findRedundantConnection($edges) {
    $len = count($edges);
    $parent = [];
    for ($i = 1; $i <= $len; $i++) {
        $parent[$i] = $i;
    }
    foreach ($edges as $edge) {
        $x = find($parent, $edge[0]);
        $y = find($parent, $edge[1]);
        if ($x != $y) {
            union($parent, $x, $y);
        } else {
            return $edge;
        }
    }
    return [];
}
function union(&$parent, $source, $target) {
    $parent[$source] = $parent[$target];
}
function find($parent, $index) {
    while ($parent[$index] != $index) {
        $index = $parent[$index];
    }
    return $parent[$index];
}
</code>
</pre>
</details>