* [剑指offer题解](#剑指offer题解)
* [LeeCode题解](#leecode题解)
  * [验证二叉搜索树(98)](#验证二叉搜索树98)
  * [二叉搜索树的最近公共祖先(235)](#二叉搜索树的最近公共祖先235)
  * [二叉树的最近公共祖先(236)](#二叉树的最近公共祖先236)
  * [二叉树的层次遍历(102)](#二叉树的层次遍历102)
  * [二叉树的最大深度(104)](#二叉树的最大深度104)
  * [二叉树的最小深度(111)](#二叉树的最小深度111)

# 剑指offer题解 #

# LeeCode题解 #
## 验证二叉搜索树(98) ##
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
## 二叉搜索树的最近公共祖先(235) ##
```
function lowestCommonAncestor($root, $p, $q) {
    while (($root->val - $p->val) * ($root->val - $q->val) > 0) {
        $root = lowestCommonAncestor($root->val > $p->val ? $root->left : $root->right , $p, $q);
    }
    return $root;
}
```
## 二叉树的最近公共祖先(236) ##
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
## 二叉树的层次遍历(102) ##
```
/**
 * 递归
 */
function level($node, $level, &$res) {
    if(!$node) {
        return;
    }
    if(!isset($res[$level])) {
        $res[$level] = [];
    }
    $res[$level][] = $node->val;
    if($node->left) {
        level($node->left, $level + 1, $res);
    }
    if($node->right) {
        level($node->right, $level + 1, $res);
    }
}
function levelOrder($root) {
    $res = [];
    level($root, 0, $res);
    return $res;
}
```
```
/**
 * 迭代
 */
function levelOrder($root) {
    $res = [];
    if(!$root) {
        return $res;
    }
    $list = [];
    $level = 0;
    array_push($list, $root);
    while ($list) {
        $res[$level] = [];
        $count = count($list);
        for($i = 0; $i < $count; $i++) {
            $node = array_shift($list);
            $res[$level][] = $node->val;
            if($node->left) {
                array_push($list, $node->left);
            }
            if($node->right) {
                array_push($list, $node->right);
            }
        }
        $level++;
    }
    return $res;
}
```
## 二叉树的最大深度(104) ##
```
/**
 * 递归
 */
function maxDepth($root) {
    if(!$root) {
        return 0;
    }
    return max(maxDepth($root->left), maxDepth($root->right)) + 1;
}
```
```
/**
 * 迭代
 */
function maxDepth1($root) {
    if(!$root) {
        return 0;
    }
    $depth = 0;
    $nodeQueue = [];
    $levelQueue = [];
    array_push($nodeQueue, $root);
    array_push($levelQueue, 1);
    while ($nodeQueue) {
        $node = array_shift($nodeQueue);
        $level = array_shift($levelQueue);
        $depth = max($depth, $level);
        if($node->left) {
            array_push($nodeQueue, $node->left);
            array_push($levelQueue, $level + 1);
        }
        if($node->right) {
            array_push($nodeQueue, $node->right);
            array_push($levelQueue, $level + 1);
        }
    }
    return $depth;
}
```
## 二叉树的最小深度(111) ##
```
/**
 * 递归
 */
function minDepth($root) {
    if(!$root) {
        return 0;
    }
    if(!$root->left) {
        return minDepth($root->right) + 1;
    }
    if(!$root->right) {
        return minDepth($root->left) + 1;
    }
    return min(minDepth($root->left), minDepth($root->right)) + 1;
}
```
```
/**
 * 迭代
 */
function minDepth1($root) {
    if(!$root) {
        return 0;
    }
    $level = 1;
    $nodeQueue = [];
    $levelQueue = [];
    array_push($nodeQueue, $root);
    array_push($levelQueue, $level);
    while ($nodeQueue) {
        $node = array_shift($nodeQueue);
        $level = array_shift($levelQueue);
        if(!$node->left && $node->right) {
            array_push($nodeQueue, $node->right);
            array_push($levelQueue, $level+1);
        } else if(!$node->right && $node->left) {
            array_push($nodeQueue, $node->left);
            array_push($levelQueue, $level+1);
        } else if($node->left && $node->right) {
            array_push($nodeQueue, $node->left, $node->right);
            array_push($levelQueue, $level+1, $level+1);
        } else {
            break;
        }
    }
    return $level;
}
```