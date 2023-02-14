树

# 定义 #
一个节点对应多个子节点

# 特点 #
一对多

# 应用 #
## 堆 ##
堆是一棵完全二叉树  
- 大顶堆 任意节点不小于左右子节点
- 小顶堆 任意节点不大与左右子节点

## LEETCODE ##
### 104.二叉树的最大深度 ###
<details>
<summary>代码</summary>
<pre>
<code>
class TreeNode {
    public $val = null;
    public $left = null;
    public $right = null;
    function __construct($val = 0, $left = null, $right = null) {
        $this->val = $val;
        $this->left = $left;
        $this->right = $right;
    }
}
function maxDepth($root) {
    if (!$root) {
        return 0;
    }
    return max(maxDepth($root->left), maxDepth($root->right)) + 1;
}
</code>
</pre>
</details>

### 110.平衡二叉树 ###
<details>
<summary>代码</summary>
<pre>
<code>
class TreeNode {
    public $val = null;
    public $left = null;
    public $right = null;
    function __construct($val = 0, $left = null, $right = null) {
        $this->val = $val;
        $this->left = $left;
        $this->right = $right;
    }
}
function isBalanced($root) {
    return height($root) != -1;
}
function height($root) {
    if (!$root) {
        return 0;
    }
    $left = height($root->left);
    if ($left == -1) {
        return -1;
    }
    $right = height($root->right);
    if ($right == -1) {
        return -1;
    }
    if (abs($left - $right) > 1) {
        return -1;
    }
    return max($left, $right) + 1;
}
</code>
</pre>
</details>

### 543.二叉树的直径 ###
<details>
<summary>代码</summary>
<pre>
<code>
class TreeNode {
    public $val = null;
    public $left = null;
    public $right = null;
    function __construct($val = 0, $left = null, $right = null) {
        $this->val = $val;
        $this->left = $left;
        $this->right = $right;
    }
}
function diameterOfBinaryTree($root) {
    $ans = 0;
    height($root, $ans);
    return $ans - 1;
}
function height($root, &$ans) {
    if (!$root) {
        return 0;
    }
    $left = height($root->left, $ans);
    $right = height($root->right, $ans);
    $nodes = $left + $right + 1;
    if ($nodes> $ans) {
        $ans = $nodes;
    }
    return max($left, $right) + 1;
}
</code>
</pre>
</details>

#### 437.路径总和III ####
<details>
<summary>代码</summary>
<pre>
<code>
</code>
</pre>
</details>

#### 101.对称二叉树III ####
<details>
<summary>代码</summary>
<pre>
<code>
</code>
</pre>
</details>

#### 1110.删点成林 ####
<details>
<summary>代码</summary>
<pre>
<code>
</code>
</pre>
</details>

#### 637.二叉树的层平均值 ####
<details>
<summary>代码</summary>
<pre>
<code>
</code>
</pre>
</details>

#### 105.从前序与中序遍历序列构造二叉树 ####
<details>
<summary>代码</summary>
<pre>
<code>
</code>
</pre>
</details>

#### 144.二叉树的前序遍历 ####
<details>
<summary>代码</summary>
<pre>
<code>
</code>
</pre>
</details>

#### 99.恢复二叉搜索树 ####
<details>
<summary>代码</summary>
<pre>
<code>
</code>
</pre>
</details>

#### 669.修剪二叉搜索树 ####
<details>
<summary>代码</summary>
<pre>
<code>
</code>
</pre>
</details>

#### 208.实现Trie(前缀树) ####
<details>
<summary>代码</summary>
<pre>
<code>
</code>
</pre>
</details>
