* [剑指offer题解](#剑指offer题解)
  * [重建二叉树(4)](#重建二叉树4)
  * [树的子结构(17)](#树的子结构17)
  * [二叉树的镜像(18)](#二叉树的镜像18)
  * [从上往下打印二叉树(22)](#从上往下打印二叉树22)
* [LeeCode题解](#leecode题解)
  * [验证二叉搜索树(98)](#验证二叉搜索树98)
  * [二叉搜索树的最近公共祖先(235)](#二叉搜索树的最近公共祖先235)
  * [二叉树的最近公共祖先(236)](#二叉树的最近公共祖先236)
  * [二叉树的层次遍历(102)](#二叉树的层次遍历102)
  * [二叉树的最大深度(104)](#二叉树的最大深度104)
  * [二叉树的最小深度(111)](#二叉树的最小深度111)

# 剑指offer题解 #
```
class TreeNode {

    public $val;
    
    public $left;
    
    public $right;

    public function __construct($val) {
        $this->val = $val;
    }

}
```
## 重建二叉树(4) ##
```
/**
 * 递归
 * 时间复杂度O(n)
 * 空间复杂度O(n)
 */
function reConstructBinaryTree($pre, $vin) {
    $len = count($pre);
    if(!$len || $len != count($vin)) return null;
    $rootValue = $pre[0];
    $root = new TreeNode($rootValue);
    $rootIndex  = null;
    for($i = 0; $i < $len; $i++) {
        if($vin[$i] == $rootValue) {
            $rootIndex = $i;
        }
    }
    $leftPre = $leftVin = [];
    for($i = 0; $i < $rootIndex; $i++) {
        $leftPre[] = $pre[$i + 1];
        $leftVin[] = $vin[$i];
    }
    $rightPre = $rightVin = [];
    for($i = $rootIndex + 1; $i < $len; $i++) {
        $rightPre[] = $pre[$i];
        $rightVin[] = $vin[$i];
    }
    if($leftPre) {
        $root->left = reConstructBinaryTree($leftPre, $leftVin);
    }
    if($rightPre) {
        $root->right = reConstructBinaryTree($rightPre, $rightVin);
    }
    return $root;
}
```
## 树的子结构(17) ##
```
/**
 * 递归
 * 时间复杂度O(n²)
 * 空间复杂度O(1)
 */
function hasSubtree($t1, $t2) {
    if(!$t1 || !$t2 ) {
        return false;
    }
    $result = false;
    if($t1->val == $t2->val) {
        $result = parentHasChild($t1, $t2);
    }
    if(!$result) {
        return hasSubtree($t1->left, $t2) || hasSubtree($t1->right, $t2);
    }
    return $result;
}
function parentHasChild($p, $c) {
    if(!$c) {
        return true;
    } else if(!$p) {
        return false;
    }
    if($p->val == $c->val) {
        return parentHasChild($p->left, $c->left) && parentHasChild($p->right, $c->right);
    } else {
        return false;
    }
}
```
## 二叉树的镜像(18) ##
```
/**
 * 遍历
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function mirror(&$root) {
    if(!$root) {
        return $root;
    }
    $tmp = $root->left;
    $root->left = $root->right;
    $root->right = $tmp;
    mirror($root->left);
    mirror($root->right);
}
```
## 从上往下打印二叉树(22) ##
```
/**
 * 队列
 * 时间复杂度O(n)
 * 空间复杂度O(n)
 */
function printFromTopToBottom($root) {
    if(!$root) {
        return $root;
    }
    $stack = $res = [];
    array_push($stack, $root);
    while ($stack) {
        $node = array_shift($stack);
        $res[] = $node->val;
        if($node->left) {
            array_push($stack, $node->left);
        }
        if($node->right) {
            array_push($stack, $node->right);
        }
    }
    return $res;
}
```
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