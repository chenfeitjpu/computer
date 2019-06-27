# 验证二叉搜索树 #
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