* [验证二叉搜索树(98)](#验证二叉搜索树98)
* [二叉搜索树的最近公共祖先(235)](#二叉搜索树的最近公共祖先235)
* [二叉树的最近公共祖先(236)](#二叉树的最近公共祖先236)

# 验证二叉搜索树(98) #
```
function isValidBST($root) {
    return valid($root, PHP_INT_MIN, PHP_INT_MAX);
}
function valid($root, $min, $max) {
    if(!$root) {
        return true;
    }
    if($root->val > $min && $root->val < $max) {
        return valid($root->left, $min, $root->val) && valid($root->right, $root->val, $max);
    } else {
        return false;
    }
}
```
# 二叉搜索树的最近公共祖先(235) #
```
function lowestCommonAncestor($root, $p, $q) {
    while (($root->val - $p->val) * ($root->val - $q->val) > 0) {
        $root = lowestCommonAncestor($root->val > $p->val ? $root->left : $root->right , $p, $q);
    }
    return $root;
}
```
# 二叉树的最近公共祖先(236) #
```
function lowestCommonAncestor($root, $p, $q) {
    if($root == $p || $root == $q || !$root) return $root;
    $left = lowestCommonAncestor($root->left, $p, $q);
    $right = lowestCommonAncestor($root->right, $p, $q);
    if(!$left && !$right) {
        return null;
    } else if($left && !$right) {
        return $left;
    } else if(!$left && $right) {
        return $right;
    }
    return $root;
}
```