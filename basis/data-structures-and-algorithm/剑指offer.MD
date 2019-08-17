* [二维数组中的查找(1)](#二维数组中的查找1)
* [替换空格(2)](#替换空格2)
* [从尾到头打印链表(3)](#从尾到头打印链表3)
* [重建二叉树(4)](#重建二叉树4)
* [用两个栈实现队列(5)](#用两个栈实现队列5)
* [旋转数组的最小数字(6)](#旋转数组的最小数字6)
* [斐波那契数列(7)](#斐波那契数列7)
* [跳台阶(8)](#跳台阶8)
* [变态跳台阶(9)](#变态跳台阶9)
* [矩形覆盖(10)](#矩形覆盖10)
* [二进制中1的个数(11)](#二进制中1的个数11)
* [值的整数次方(12)](#值的整数次方12)
* [调整数组顺序使奇数位于偶数前面(13)](#调整数组顺序使奇数位于偶数前面13)
* [链表中倒数第k个结点(14)](#链表中倒数第k个结点14)
* [反转链表(15)](#反转链表15)
* [合并两个排序的链表(16)](#合并两个排序的链表16)
* [树的子结构(17)](#树的子结构17)
* [二叉树的镜像(18)](#二叉树的镜像18)
* [顺时针打印矩阵(19)](#顺时针打印矩阵19)
* [包含min函数的栈(20)](#包含min函数的栈20)
* [栈的压入、弹出序列(21)](#栈的压入弹出序列21)
* [从上往下打印二叉树(22)](#从上往下打印二叉树22)
* [二叉搜索树的后序遍历序列(23)](#二叉搜索树的后序遍历序列23)
* [二叉树中和为某一值的路径(24)](#二叉树中和为某一值的路径24)
* [复杂链表的复制(25)](#复杂链表的复制25)
* [二叉搜索树与双向链表(26)](#二叉搜索树与双向链表26)
* [字符串的排列(27)](#字符串的排列27)
* [数组中出现次数超过一半的数字(28)](#数组中出现次数超过一半的数字28)
* [最小的K个数(29)](#最小的k个数29)
* [连续子数组的最大和(30)](#连续子数组的最大和30)
* [整数中1出现的次数(31)](#整数中1出现的次数31)
* [把数组排成最小的数(32)](#把数组排成最小的数32)
* [丑数(33)](#丑数33)
* [第一个只出现一次的字符(34)](#第一个只出现一次的字符34)
* [数组中的逆序对(35)](#数组中的逆序对35)
* [两个链表的第一个公共结点(36)](#两个链表的第一个公共结点36)
* [数字在排序数组中出现的次数(37)](#数字在排序数组中出现的次数37)
* [二叉树的深度(38)](#二叉树的深度38)
* [平衡二叉树(39)](#平衡二叉树39)
* [数组中只出现一次的数字(40)](#数组中只出现一次的数字40)
* [和为S的连续正数序列(41)](#和为s的连续正数序列41)
* [和为S的两个数字(42)](#和为s的两个数字42)
* [左旋转字符串(43)](#左旋转字符串43)
* [翻转单词顺序序列(44)](#翻转单词顺序序列44)
* [扑克牌顺子(45)](#扑克牌顺子45)
* [孩子们的游戏(46)](#孩子们的游戏46)
* [求1 2 3 … n(47)](#求123n47)
* [不用加减乘除的加法(48)](#不用加减乘除的加法48)
* [把字符串转换成整数(49)](#把字符串转换成整数49)
* [数组中重复的数字(50)](#数组中重复的数字50)
* [构建乘积数组(51)](#构建乘积数组51)
* [正则表达式匹配(52)](#正则表达式匹配52)
* [表示数值的字符串(53)](#表示数值的字符串53)
* [字符流中第一个不重复的字符(54)](#字符流中第一个不重复的字符54)
* [链表中环的入口结点(55)](#链表中环的入口结点55)
* [删除链表中重复的结点(56)](#删除链表中重复的结点56)
* [二叉树的下一个结点(57)](#二叉树的下一个结点57)
* [对称的二叉树(58)](#对称的二叉树58)
* [按之字顺序打印二叉树(59)](#按之字顺序打印二叉树59)
* [把二叉树打印成多行(60)](#把二叉树打印成多行60)
* [序列化二叉树(61)](#序列化二叉树61)
* [二叉搜索树的第k个结点(62)](#二叉搜索树的第k个结点62)
* [数据流中的中位数(63)](#数据流中的中位数63)
* [滑动窗口的最大值(64)](#滑动窗口的最大值64)
* [矩阵中的路径(65)](#矩阵中的路径65)
* [机器人的运动范围(66)](#机器人的运动范围66)

# 二维数组中的查找(1) #
```
/**
 * 暴力破解-枚举
 * 时间复杂度O(m*n)
 * 空间负责度O(1)
 */
function find($array, $target) {
    $rowLen = count($array);
    if(!$rowLen) return false;
    $colLen = count($array[0]);
    for($i = 0; $i < $rowLen; $i++) {
        for($j = 0; $j < $colLen; $j++) {
            if($array[$i][$j] == $target) {
                return true;
            }
        }
    }
    return false;
}
```
```
/**
 * 分治法-利用数据的深度有序性
 * 时间复杂度O(max(m,n))
 * 空间负责度O(1)
 */
function find1($array, $target) {
    $rowLen = count($array);
    if(!$rowLen) return false;
    $colLen = count($array[0]);
    $i = 0;
    $j = $colLen - 1;
    while (0 <= $i && $i <= $rowLen -1 && 0 <= $j && $j <= $colLen-1) {
        $cur = $array[$i][$j];
        if($cur < $target) {
            $i++;
        } else if($cur > $target) {
            $j--;
        } else {
            return true;
        }
    }
    return false;
}
```
```
/**
 * 二分法-利用数据的广度有序性
 * 时间复杂度O(log(max(m,n)))
 * 空间负责度O(1)
 */
function find2($array, $target) {
    $rowLen = count($array);
    if(!$rowLen) return false;
    $colLen = count($array[0]);
    //二分查找定位行列范围
    $row = $col = 0;
    $left = 0;
    $right = $rowLen - 1;
    while ($left <= $right) {
        $mid = floor(($left + $right) / 2);
        $row = $left;
        $col = $colLen - $rowLen + $row;
        $col = $col >= 0 ? $col : 0;
        $cur = $array[$row][$col];
        if($cur < $target) {
            $left = $mid + 1;
        } else if($cur > $target) {
            $right = $mid -1;
        } else {
            return true;
        }
    }

    //从行里面二分查找目标元素
    $left = 0;
    $right = $col - 1;
    while ($left <= $right) {
        $mid = floor(($left + $right) / 2);
        $cur = $array[$row][$mid];
        if($cur < $target) {
            $left = $mid + 1;
        } else if($cur > $target) {
            $right = $mid -1;
        } else {
            return true;
        }
    }

    //从列里面二分查找目标元素
    $left = 0;
    $right = $row - 1;
    while ($left <= $right) {
        $mid = floor(($left + $right) / 2);
        $cur = $array[$mid][$col];
        if($cur < $target) {
            $left = $mid + 1;
        } else if($cur > $target) {
            $right = $mid -1;
        } else {
            return true;
        }
    }

    return false;
}
```
# 替换空格(2) #
```
/**
 * 遍历
 * 时间复杂度O(n)
 * 空间复杂度O(n)
 */
function replaceSpace($str) {
    $len = strlen($str);
    $res = '';
    for($i = 0; $i < $len; $i++) {
        $char = $str[$i];
        if($char == ' ') {
            $res .= '%20';
        } else {
            $res .= $char;
        }
    }
    return $res;
}

```
```
/**
 * 遍历
 * 时间复杂度O(n * n)
 * 空间复杂度O(1)
 */
function replaceSpace1($str) {
    $len = strlen($str);
    for($i = $len - 1; $i >= 0; $i--) {
        if($str[$i] == ' ') {
            $len += 2;
            for($j = $len - 1; $j > $i + 2; $j--) {
                $str[$j] = $str[$j-2];
            }
            $str[$j--] = '0';
            $str[$j--] = '2';
            $str[$j--] = '%';
        }
    }
    return $str;
}
```
```
/**
 * 遍历
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function replaceSpace2($str) {
    $length = strlen($str);
    $count = 0;
    for($i = 0; $i < $length; $i++) {
        if($str[$i] == ' ') {
            $count++;
        }
    }
    $len = $length + $count * 2;
    for($i = $length - 1, $j = $len - 1; $i >= 0 && $j >= 0;) {
        if($str[$i] == ' ') {
            $str[$j--] = '0';
            $str[$j--] = '2';
            $str[$j--] = '%';
            $i--;
        } else {
            $str[$j--] = $str[$i--];
        }
    }
    return $str;
}
```
# 从尾到头打印链表(3) #
```
/**
 * 反转链表
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function printListFromTailToHead($head) {
    $pre = null;
    $cur = $head;
    while($cur) {
        $next = $cur->next;
        $cur->next = $pre;
        $pre = $cur;
        $cur = $next;
    }
    while($pre) {
        echo $pre->value . PHP_EOL;
        $pre = $pre->next;
    }
}
```
```
/**
 * 利用栈
 * 时间复杂度O(n)
 * 空间复杂度O(n)
 */
function printListFromTailToHead($head) {
    $stack = [];
    while($head) {
        array_push($stack, $head->value);
        $head = $head->next;
    }
    while($stack) {
        echo array_pop($stack) . PHP_EOL;
    }
}
```
```
/**
 * 递归
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function printListFromTailToHead($head) {
    if(!$head) return;
    printListFromTailToHead($head->next);
    echo $head->value . PHP_EOL;
}
```
# 重建二叉树(4) #
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
# 用两个栈实现队列(5) #
```
/**
 * 用数组模拟栈
 */
class Queue {


    private $in = [];

    private $out = [];

    private $capacity = 0;
    
    private $size = 0;

    public function __constuct($capacity) {
        $this->capacity = $capacity;
    }

    public function push($value) {
        if($this->size && $this->size == $this->capacity) {
            return false;
        }
        while ($this->out) {
            array_push($this->in, array_pop($this->out));
        }
        array_push($this->in, $value);
        $this->size++;
        return true;
    }

    public function pop() {
        if($this->size == 0) {
            return null;
        }
        while ($this->in) {
            array_push($this->out, array_pop($this->in));
        }
        $res = array_pop($this->out);
        $this->size--;
        return $res;
    }

    public function print() {
        if($this->in) {
            for($i = 0; $i < $this->size; $i++) {
                echo $this->in[$i] . PHP_EOL;
            }
        }
        if($this->out) {
            for($i = $this->size - 1; $i >= 0; $i--) {
                echo $this->out[$i] . PHP_EOL;
            }
        }
    }

}
```
# 旋转数组的最小数字(6) #
```
/**
 * 遍历
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function minNumberInRotateArray($array) {
    $len = count($array);
    if(!$len) {
        return 0;
    }
    for($i = 0; $i < $len - 1; $i++) {
        if($array[$i] > $array[$i+1]) {
            return $array[$i+1];
        }
    }
    return $array[0];
}
```
```
/**
 * 二分法-利用数据的有序性
 * 时间复杂度O(log n)
 * 空间复杂度O(1)
 */
function minNumberInRotateArray1($array) {
    $len = count($array);
    if(!$len) {
        return 0;
    }
    $left = 0;
    $right = $len - 2;
    while ($left <= $right) {
        $mid = floor(($left + $right) / 2);
        if($array[$mid] <= $array[$mid+1]) {
            if($array[0] <= $array[$mid]) {
                $left = $mid + 1;
            } else {
                $right = $mid - 1;
            }
        } else {
            return $array[$mid+1];
        }
    }
    return $array[0];
}
```
# 斐波那契数列(7) #
```
/**
 * 迭代
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function fibonacci($n) {
    if($n == 0 || $n == 1) return $n;
    $first = 0;
    $second = 1;
    $third = 0;
    for($i = 2; $i <= $n; $i++) {
        $third = $first + $second;
        $first = $second;
        $second = $third;
        
    }
    return $third;
}
```
# 跳台阶(8) #
```
/**
 * 迭代
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function jumpFloor($n) {
    if($n == 1 || $n == 2) return $n;
    $one = 1;
    $two = 2;
    $res = 0;
    for($i = 3; $i <= $n; $i++) {
        $res = $one + $two;
        $one = $two;
        $two = $res;
    }
    return $res;
}
```
# 变态跳台阶(9) #
```
/**
 * 迭代
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function jumpFloor($n) {
    if($n == 1) return $n;
    for($i = 2, $res = 1; $i <= $n; $i++) {
        $res *= 2;
    }
    return $res;
}
```
# 矩形覆盖(10) #
```
/**
 * 迭代
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function rectCover($n) {
    if($n == 1 || $n == 2) return $n;
    $one = 1;
    $two = 2;
    $res = 0;
    for($i = 3; $i <= $n; $i++) {
        $res = $one + $two;
        $one = $two;
        $two = $res;
    }
    return $res;
}
```
# 二进制中1的个数(11) #
```
/**
 * 利用移位操作
 * 时间复杂度O(1)
 * 空间复杂度O(1)
 */
function numberOf1($n) {
    if(!$n) return 0;
    $count = 0;
    $flag = 1;
    while ($flag) {
        if($n & $flag) {
            $count++;
        }
        $flag = $flag << 1;
    }
    return $count;
}
```
```
/**
* 利用&操作
* 时间复杂度O(1)
* 空间复杂度O(1)
*/
function numberOf11($n) {
    $count = 0;
    if(!$n) return $count;
    while ($n) {
        $count++;
        if($n == PHP_INT_MIN) {
            break;
        }
        $n &= $n - 1;
    }
    return $count;
}
```
# 值的整数次方(12) #
```
/**
 * 移位
 * 时间复杂度O(1)
 * 空间复杂度O(1)
 */
function power($base, $exponent) {
    if(!$base) {
        return 0;
    }
    if(!$exponent) {
        return 1;
    }
    if($exponent < 0) {
        $base = 1 / $base;
        $exponent = -$exponent;
    }
    $res = 1;
    $tmp = $base;
    while ($exponent) {
        if($exponent & 1) {
            $res *= $tmp;
        }
        $tmp *= $tmp;
        $exponent = $exponent >> 1;
    }
    return $res;
}
```
# 调整数组顺序使奇数位于偶数前面(13) #
```
/**
 * 冒泡法
 * 时间复杂度O(n²)
 * 空间复杂度O(1)
 */
function reOrderArray($array) {
    $len = count($array);
    if($len <= 1) return $array;
    for($i = 0; $i < $len - 1; $i++) {
        for($j = 0; $j < $len - $i -1; $j++) {
            if(($array[$j] & 1) == 0 && ($array[$j+1] & 1) == 1) {
                $tmp = $array[$j];
                $array[$j] = $array[$j+1];
                $array[$j+1] = $tmp;
            }
        }
    }
    return $array;
}
```
```
/**
 * 拆成奇偶两个数组再合并
 * 时间复杂度O(n)
 * 空间复杂度O(n)
 */
function reOrderArray1($array) {
    $len = count($array);
    if($len <= 1) return $array;
    $odd = $even = [];
    for($i = 0; $i < $len; $i++) {
        if($array[$i] & 1) {
            $odd[] = $array[$i];
        } else {
            $even[] = $array[$i];
        }
    }
    $oddLen = count($odd);
    for($i = 0; $i < $oddLen; $i++) {
        $array[$i] = $odd[$i];
    }
    $evenLen = count($even);
    for($i = 0; $i < $evenLen; $i++) {
        $array[$oddLen + $i] = $even[$i];
    }
    return $array;
}
```
# 链表中倒数第k个结点(14) #
```
/**
 * 顺序遍历
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function findKthToTail($head, $k) {
    if(!$head) return null;
    $length = 0;
    $cur = $head;
    while($cur) {
        $length++;
        $cur = $cur->next;
    }
    if($k > $length) return null;
    $i = 0;
    while ($i < $length - $k) {
        $head = $head->next;
        $i++;
    }
    return $head;
}
```
```
/**
 * 双指针
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function findKthToTail($head, $k) {
    if(!$head) return null;
    $left = $right = $head;
    $i = 0;
    while($i < $k && $right) {
        $right = $right->next;
        $i++;
    }
    while ($right) {
        $right = $right->next;
        $left = $left->next;
    }
    return $left;
}
```
# 反转链表(15) #
```
/**
 * 三指针
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function reverseList($head) {
    if(!$head) return null;
    $pre = null;
    $cur = $head;
    $next = null;
    while($cur) {
        $next = $cur->next;
        $cur->next = $pre;
        $pre = $cur;
        $cur = $next;
    }
    while($pre) {
        echo $pre->value . PHP_EOL;
        $pre = $pre->next;
    }
}
```
# 合并两个排序的链表(16) #
```
/**
 * 遍历
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function merge($head1, $head2) {
   if(!$head1) return $head2;
   if(!$head2) return $head1;
    $dummy = new Node(-1);
    $dummy->next = $head1;
    $pre = $dummy;
    while ($head1 && $head2) {
        if($head1->value > $head2->value) {
            $next = $head2->next;
            $pre->next = $head2;
            $head2->next = $head1;
            $head2 = $next;
        }
        $pre = $head1;
        $head1 = $head1->next;
    }
    if(!$head1 && $head2) {
        $pre->next = $head2;
    }
    return $dummy->next;
}
```
# 树的子结构(17) #
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
# 二叉树的镜像(18) #
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
# 顺时针打印矩阵(19) #
```
/**
 * 遍历
 * 时间复杂度O(n)
 * 空间复杂度O(n)
 */
function spiralOrder($matrix) {
    $res = [];
    $row = count($matrix);
    if(!$row) return $res;
    $col = count($matrix[0]);

    $visit = [];
    $r = $c = $d = 0;
    $step = [
        [0, 1],
        [1, 0],
        [0, -1],
        [-1, 0],
    ];
    $count = $row * $col;
    for($i = 0; $i < $count; $i++) {
        $res[] = $matrix[$r][$c];
        $visit[$r][$c] = true;
        $tr = $r + $step[$d][0];
        $tc = $c + $step[$d][1];
        if(0 <= $tr && $tr < $row && 0 <= $tc && $tc < $col && !isset($visit[$tr][$tc])) {
            $r = $tr;
            $c = $tc;
        } else {
            $d = ($d + 1) % 4;
            $r += $step[$d][0];
            $c += $step[$d][1];
        }
    }
    return $res;
}
```
# 包含min函数的栈(20) #
```
class MinStack {

    private $data = [];

    private $min = [];

    public function push($value) {
        if(!$this->min) {
            array_push($this->min, $value);
        }
        if($value < end($this->min)) {
            array_push($this->min, $value);
        }
        array_push($this->data, $value);
    }

    public function pop() {
        if(end($this->data) == end($this->min)) {
            array_pop($this->min);
        }
        return array_pop($this->data);
    }

    public function min() {
        return end($this->min);
    }

}
```
# 栈的压入、弹出序列(21) #
```
/**
 * 用数组模拟栈
 * 借助辅助栈
 * 时间复杂度O(n)
 * 空间复杂度O(n)
 */
function isPopOrder($in, $out) {
    $stack = [];
    $len = count($in);
    for($i = 0, $j = 0; $i < $len; $i++) {
        array_push($stack, $in[$i]);
        while($j < $len && end($stack) == $out[$j]) {
            array_pop($stack);
            $j++;
        }
    }
    return count($stack) == 0;
}
```
# 从上往下打印二叉树(22) #
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
# 二叉搜索树的后序遍历序列(23) #
```
/**
 * 遍历
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function verifySquenceOfBST($queue) {
    if(!$queue) {
        return false;
    }
    return verifyBST($queue, 0, count($queue) - 1);
}
function verifyBST($queue, $start, $end)  {
    if($start > $end) {
        return false;
    }
    //根节点
    $root = $queue[$end];
    for($i = $start; $i < $end; $i++) {
        if($queue[$i] > $root) {
            break;
        }
    }
    for($j = $i; $j < $end; $j++) {
        if($queue[$j] < $root) {
            return false;
        }
    }
    //左子树
    $left = true;
    if($start < $i) {
        $left = verifyBST($queue, $start, $i - 1);
    }
    //右子树
    $right = true;
    if($i < $end) {
        $right = verifyBST($queue, $i, $end - 1);
    }
    return $left && $right;
}
```
# 二叉树中和为某一值的路径(24) #
```
/**
 * 遍历
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function findPath($root, $num) {
    $res = [];
    if(!$root) {
        return $res;
    }
    $tmp = [];
    findPathRecursion($root, $num, $res, $tmp);
}

function findPathRecursion($root, $num, &$res, $tmp) {
    if(!$root) {
        return;
    }
    $tmp[] = $root->val;
    if($root->val == $num && !$root->left && !$root->right) {
        $res[] = $tmp;
        return;
    }
    findPathRecursion($root->left, $num - $root->val, $res, $tmp);
    findPathRecursion($root->right, $num - $root->val, $res, $tmp);
}
```
# 复杂链表的复制(25) #
```
/**
 * 暴力法
 * 时间复杂度O(n²)
 * 空间复杂度O(n)
 */
function myClode($head) {
    if(!$head) return null;
    $pre = null;
    $newHead = null;
    $cur = $head;
    //生成新链表
    while ($cur) {
        $node = new Node($cur->value);
        if($pre) {
            $pre->next = $node;
        } else {
            $newHead = $node;
        }
        $pre = $node;
        $cur = $cur->next;
    }
    //生成随机指针
    $cur = $head;
    $newCur = $newHead;
    while($cur) {
        $rand = $cur->rand;
        if($rand) {
            $newCur->rand = findRand($head, $newHead, $rand);
        }
        $cur = $cur->next;
        $newCur = $newCur->next;
    }
    return $newHead;
}
function findRand($head, $newHead, $rand) {
    while($head) {
        if($head == $rand) {
            return $newHead;
        }
        $head = $head->next;
        $newHead = $newHead->next;
    }
}

```
```
/**
 * hash表
 * 时间复杂度O(n)
 * 空间复杂度O(n)
 */
function myClode($head) {
    if(!$head) return null;
    $pre = null;
    $newHead = null;
    $cur = $head;
    $map = [];
    //生成新链表
    while ($cur) {
        $node = new Node($cur->value);
        $map[$cur->value] = $node;
        if($pre) {
            $pre->next = $node;
        } else {
            $newHead = $node;
        }
        $pre = $node;
        $cur = $cur->next;
    }
    //生成随机指针
    $cur = $head;
    $newCur = $newHead;
    while($cur) {
        $rand = $cur->rand;
        if($rand) {
            $newCur->rand = $map[$rand->value];
        }
        $cur = $cur->next;
        $newCur = $newCur->next;
    }
    return $newHead;
}
```
```
/**
 * 复制
 * 时间复杂度O(n)
 * 空间复杂度O(n)
 */
function myClode($head) {
    if(!$head) return null;
    $cur = $head;
    //生成新节点
    while ($cur) {
        $node = new Node($cur->value);
        $next = $cur->next;
        $node->next = $next;
        $cur->next = $node;
        $cur = $next;
    }
    //确定随机指针
    $cur = $head;
    while ($cur) {
        if($cur->rand) {
            $cur->next->rand = $cur->rand->next;
        }
        $cur = $cur->next;
    }
    //生成新链表
    $cur = $head;
    $newHead = $newCur = $head->next;
    while ($cur) {
        $cur->next = $newCur->next;
        if($newCur->next) {
            $newCur->next = $newCur->next->next;
        }
        $cur = $cur->next;
        $newCur = $newCur->next;
    }
    return $newHead;
}
```
# 二叉搜索树与双向链表(26) #
```
/**
 * 遍历
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function convert($root) {
    if(!$root) {
        return null;
    }
    $lastNode = null;
    convertNode($root, $lastNode);
    $head = $lastNode;
    while ($head->left) {
        $head = $head->left;
    }
    return $head;
}
function convertNode($root, &$lastNode) {
    if(!$root) {
        return null;
    }
    if($root->left) {
        convertNode($root->left, $lastNode);
    }
    $root->left = $lastNode;
    if($lastNode) {
        $lastNode->right = $root;
    }
    $lastNode = $root;
    if($root->right) {
        convertNode($root->right, $lastNode);
    }
}
```
# 字符串的排列(27) #
```
/**
 * 基于前缀
 * 时间复杂度O(n!)
 * 空间复杂度O(n!)
 */
function permutation($str) {
    $res = [];
    permutationByPrefix('', $str, $res);
    return $res;
}
function permutationByPrefix($prefix, $str, &$res) {
    $len = strlen($str);
    if($len == 0) {
        $res[] = $prefix;   
    } else {
        for($i = 0; $i < $len; $i++) {
            permutationByPrefix($prefix . $str[$i], substr($str, 0, $i) . substr($str, $i+1, $len), $res);
        }
    }
}
```
```
/**
 * 基于交换
 * 时间复杂度O(n!)
 * 空间复杂度O(n!)
 */
function permutation($str) {
    $res = [];
    permutationBySwap($str, 0, $res);
    sort($res);
    return $res;
}
function permutationBySwap($str, $begin, &$res) {
    $len = strlen($str);
    if($begin == $len - 1) {
        $res[] = $str;
    } else {
        for($i = $begin; $i < $len; $i++) {
            if(!hasDuplicate($str, $begin, $i)) {
                //交换
                swap($str, $begin,  $i);    
                permutationBySwap($str, $begin + 1, $res);  
                swap($str, $begin,  $i);
            }
        }
    }
}
function hasDuplicate($str, $begin, $end) {
    for($i = $begin; $i < $end; $i++) {
        if($str[$i] == $str[$end]) {
            return true;
        }
    }
    return false;
}
function swap(&$str, $begin, $end) {
    $tmp = $str[$begin];
    $str[$begin] = $str[$end];
    $str[$end] = $tmp;
}
```
# 数组中出现次数超过一半的数字(28) #
```
/**
 * 遍历
 * 时间复杂度O(n)
 * 空间复杂度O(n)
 */
function moreThanHalfNumSolution($array) {
    $len = count($array);
    if(!$len) return 0;
    if($len ==1 ) return current($array);
    $map = [];
    for($i = 0; $i < $len; $i++) {
        $value = $array[$i];
        if(isset($map[$value])) {
            $map[$value]++;
        } else {
            $map[$value] = 1;
        }
    }
    foreach($map as $key => $value) {
        if($value > floor($len / 2)) {
            return $key;
        }
    }
    return 0;
}
```
```
/**
 * 排序
 * 时间复杂度O(nlog n)
 * 空间复杂度O(1)
 */
function moreThanHalfNumSolution1($array) {
    $len = count($array);
    if(!$len) return 0;
    if($len ==1 ) return current($array);
    sort($array);
    return $array[floor($len / 2 - 1)];
}
```
```
/**
 * 计数
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function moreThanHalfNumSolution2($array) {
    $len = count($array);
    if(!$len) return 0;
    if($len ==1 ) return current($array);
    $count = 0;
    $num = 0;
    for($i = 0; $i < $len; $i++) {
        $value = $array[$i];
        if($count == 0) {
            $num = $value;
        }
        $count += ($num == $value) ? 1 : -1;
    }
    $count = 0;
    for($i = 0; $i < $len; $i++) {
        if($num == $array[$i]) {
            $count++;
        }
    }
    return $count > floor($len / 2) ? $num : 0;
}
```
# 最小的K个数(29) #
```
```
# 连续子数组的最大和(30) #
```
/**
 * 暴力法
 * 时间复杂度O(n²)
 * 空间复杂度O(1)
 */
function findGreatestSumOfSubArray($array) {
    $len = count($array);
    if(!$len) return 0;
    $max = 0;
    for($i = 0; $i < $len; $i++) {
        $sum = 0;
        for($j = $i; $j < $len; $j++) {
            $sum += $array[$j];
            if($max < $sum) {
                $max = $sum;
            }
        }
    }
    return $max;
}
```
```
/**
 * 迭代
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function findGreatestSumOfSubArray($array) {
    $len = count($array);
    if(!$len) return 0;
    $max = 0;
    $sum = 0;
    for($i = 0; $i < $len; $i++) {
        if($sum < 0) {
            $sum = $array[$i];
        } else {
            $sum += $array[$i];
        }
        if($max < $sum) {
            $max = $sum;
        }
    }
    return $max;
}
```
```
/**
 * 动态规划
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function findGreatestSumOfSubArray($array) {
    $max = 0;
    findGreatestSum($array, count($array)-1, $max);
    return $max;
}
function findGreatestSum($array, $n, &$max) {
    if($n == 0) {
        $max = $array[$n];
        return $array[$n];
    }
    $sum = findGreatestSum($array, $n - 1, $max);
    if($sum > 0) {
        $sum += $array[$n];
    } else {
        $sum = $array[$n];
    }
    if($max < $sum) {
        $max = $sum;
    }
    return $sum;
}
```
# 整数中1出现的次数(31) #
```
/**
 * 暴力遍历
 * 时间复杂度O(n㏒n)
 * 空间复杂度O(1)
 */
function numberOf1Between1AndN($n) {
    $res = 0;
    for($i = 1; $i <= $n; $i++) {
        $res += numberOf1($i);
    }
    return $res;
}
function numberOf1($n) {
    $count = 0;
    while ($n) {
        if($n % 10 == 1) {
            $count++;
        }
        $n = intval($n / 10);
    }
    return $count;
}
```
```
/**
 * 按位统计
 * 时间复杂度O(㏒n)
 * 空间复杂度O(1)
 */
function numberOf1Between1AndN1($n) {
    $count = $high = $cur = $low = 0;
    $base = 1;
    while (intval($n / $base)) {
        $high = intval($n / $base / 10);
        $cur = intval($n / $base) % 10;
        $low = $n - intval($n / $base) * $base;
        if($cur > 1) {
            $count += ($high + 1) * $base;
        } else if($cur == 1) {
            if($high) {
                $count += $high * $base;
            }
            $count += $low + 1;
        } else {
            $count += $high * $base;
        }
        $base *= 10;
    }
    return $count;
}
```
# 把数组排成最小的数(32) #
```
/**
 * 全排列
 * 时间复杂度O(n!)
 * 空间复杂度O(n!)
 */
function printMinNumber($array) {
    $min = PHP_INT_MAX;
    $list = permute($array);
    foreach ($list as $value) {
        if($min > $value) {
            $min = $value;
        }
    }
    return $min;
}
function permute($array) {
    $len = count($array);
    $res = [];
    if($len == 1) {
        $res[] = current($array);
    } else {
        for($i = 0; $i < $len; $i++) {
            $cur = $array[$i];
            $list = permute(array_merge(array_slice($array, 0, $i), array_slice($array, $i + 1, $len)));
            for($j = 0; $j < $len - 1; $j++) {
                $res[] = $cur . $list[$j];
            }
        }
    }
    return $res;
}
```
```
/**
 * 排序
 * 时间复杂度O(nlog n)
 * 空间复杂度O(1)
 */
function printMinNumber2($array) {
    usort($array, function ($a, $b) {
        return $a . $b > $b . $a;
    });
    return implode('', $array);
}
```
# 丑数(33) #
```
/**
 * 暴力
 * 时间复杂度
 * 空间复杂度
 */
function uglyNumber($k) {
    $n = 0;
    $count = 0;
    while ($count < $k) {
        $n++;
        if(isUglyNumber($n)) {
            $count++;
        }
    }
    return $n;
}
function isUglyNumber($n) {
    while ($n % 5 == 0) {
        $n /= 5;
    }
    while ($n % 3 == 0) {
        $n /= 3;
    }
    while ($n % 2 == 0) {
        $n /= 2;
    }
    return $n == 1;
}
```
```
/**
 * 利用已求结果
 * 时间复杂度
 * 空间复杂度
 */
function uglyNumber1($k) {
    if(!$k) return 0;
    $index = 0;
    $ugly[$index] = 1;
    $index2 = $index3 = $index5 = 0;
    while($index < $k - 1) {
        $value = min($ugly[$index2] * 2, $ugly[$index3] * 3, $ugly[$index5] * 5);
        if($value == $ugly[$index2] * 2) {
            $index2++;
        }
        if($value == $ugly[$index3] * 3) {
            $index3++;
        }
        if($value == $ugly[$index5] * 5) {
            $index5++;
        }
        $ugly[++$index] = $value;
    }
    return $ugly[$index];
}
```
# 第一个只出现一次的字符(34) #
```
/**
 * 计数
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function firstNotRepeatingChar($str) {
    $len = strlen($str);
    if(!$len) return -1;
    $map = [];
    for($i = 0; $i < $len; $i++) {
        $cur = $str[$i];
        if(isset($map[$cur])) {
            $map[$cur] = -1;
        } else {
            $map[$cur] = $i;
        }
    }
    foreach($map as $key => $value) {
        if($value != -1) {
            return $value;
        }
    }
    return -1;
}
```
# 数组中的逆序对(35) #
```
/**
 * 暴力法
 * 时间复杂度O(n²)
 * 空间复杂度O(1)
 */
function inversePairs($array) {
    $len = count($array);
    if($len <= 1) return 0;
    $count = 0;
    for($i = 0; $i < $len; $i++) {
        for($j = $i + 1; $j < $len; $j++) {
            if($array[$i] > $array[$j]) {
                $count++;
            }
        }
    }
    return $count;
}
```
```
/**
 * 排序
 * 时间复杂度O(nlog n)
 * 空间复杂度O(n)
 */
function inversePairs2($array) {
    $len = count($array);
    if($len <= 1) return 0;
    return mergeSort($array, 0, $len - 1);
}
function mergeSort(&$array, $start, $end) {
    if($start >= $end) return 0;
    $mid = intval(($start + $end) / 2);
    $count = mergeSort($array, $start, $mid);
    $count += mergeSort($array, $mid + 1, $end);
    $count += merge($array, $start, $mid, $end);
    return $count;
}
function merge(&$array, $start, $mid, $end) {
    $count = 0;
    $i = $start;
    $j = $mid + 1;
    $tmp = [];
    while($i <= $mid && $j <= $end) {
        if($array[$i] < $array[$j]) {
            $tmp[] = $array[$i++];
        } else {
            $count += $mid - $i + 1;
            $tmp[] = $array[$j++];
        }
    }
    while ($i <= $mid) {
        $tmp[] = $array[$i++];
    }
    while ($j <= $end) {
        $tmp[] = $array[$j++];
    }
    $k = 0;
    $len = count($tmp);
    while ($k < $len) {
        $array[$start + $k] = $tmp[$k];
        $k++;
    }
    return $count;
}
```
# 两个链表的第一个公共结点(36) #
```
/**
 * 遍历
 * 时间复杂度O(n²)
 * 空间复杂度O(1)
 */
function findFirstCommonNode($head1, $head2) {
    if(!$head1) return null;
    while ($head1) {
        $head = $head2;
        while($head) {
            if($head1->value == $head->value) {
                return $head1;
            }
            $head = $head->next;
        }
        $head1 = $head1->next;
    }
}
```
```
/**
 * 对齐(裁剪)
 * 时间复杂度O(n²)
 * 空间复杂度O(1)
 */
function findFirstCommonNode1($head1, $head2) {
    if(!$head1 || !$head2) return null;
    $len1 = getLength($head1);
    $len2 = getLength($head2);
    $len = 0;
    if($len1 > $len2) {
        $len = $len1 - $len2;
        while ($len) {
            $head1 = $head1->next;
            $len--;
        }
    } else {
        $len = $len2 - $len1;
        while ($len) {
            $head2 = $head2->next;
            $len--;
        }
    }
    while ($head1) {
        if($head1->value == $head2->value) {
            return $head1;
        }
        $head1 = $head1->next;
        $head2 = $head2->next;
    }
    return null;
}
function getLength($head) {
    $count = 0;
    while ($head) {
        $count++;
        $head = $head->next;
    }
    return $count;
}
```
```
/**
 * 对齐(拼接)
 * 时间复杂度O(n²)
 * 空间复杂度O(1)
 */
function findFirstCommonNode2($head1, $head2) {
    if(!$head1 || !$head2) return null;
    $left = $head1;
    $right = $head2;
    while ($left) {
        if($left->value == $right->value) {
            return $left;
        }
        $left = $left->next ? $left->next : $head2;
        $right = $right->next ? $right->next : $head1;
    }
    return false;
}
```
# 数字在排序数组中出现的次数(37) #
```
/**
 * 暴力法
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function getNumberOfK($array, $value) {
    $len = count($array);
    $count = 0;
    if($len < 1) return $count;
    for($i = 0; $i < $len; $i++) {
        if($array[$i] == $value) {
            $count++;
        }
    }
    return $count;
}
```
```
/**
 * 二分法
 * 时间复杂度O(log n)
 * 空间复杂度O(1)
 */
function getNumberOfK2($array, $value) {
    $len = count($array);
    if(!$len) return 0;
    $first = getIndexIndex($array, $value, 'first');
    $last = getIndexIndex($array, $value, 'last');
    return $first > -1 ? ($last - $first + 1) : 0;
}
function getIndexIndex($array, $value, $type) {
    $len = count($array);
    $left = 0;
    $right = $len - 1;
    $index = -1;
    while ($left <= $right) {
        $mid = intval(($left + $right) / 2);
        $cur = $array[$mid];
        if($cur < $value) {
            $left = $mid + 1;
        } else if($cur > $value){
            $right = $mid - 1;
        } else {
            if($type == 'first') {
                if($mid > 0 && $array[$mid - 1] == $value) {
                    $right = $mid - 1;
                } else {
                    return $mid;
                }
            } else {
                if($mid < $len - 1 && $array[$mid + 1] == $value) {
                    $left = $mid + 1;
                } else {
                    return $mid;
                }
            }
        }
    }
    return $index;
}
```
# 二叉树的深度(38) #
```
/**
 * 遍历
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function treeDepth($root) {
    if(!$root) {
        return 0;
    }
    return max(treeDepth($root->left), treeDepth($root->right)) + 1;
}
```
# 平衡二叉树(39) #
```
/**
 * 遍历
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function isBalanced($root) {
    if(!$root) {
        return true;
    }
    $depth = 0 ;
    return isBalancedTree($root, $depth);
}

function isBalancedTree($root, &$depth) {
    if(!$root) {
        $depth = 0;
        return true;
    }
    $left = $right = 0;
    if(isBalancedTree($root->left, $left) && isBalancedTree($root->right, $right)) {
        if(abs($left - $right) <= 1) {
            $depth = max($left, $right) + 1;
            return true;
        }
    } else {
        return false;
    }
}
```
# 数组中只出现一次的数字(40) #
```
/**
 * 暴力法
 * 时间复杂度O(n * n)
 * 空间复杂度O(1)
 */
function findNumsAppearOnce($array) {
    $len = count($array);
    $res = [];
    for($i = 0; $i < $len; $i++) {
        $flag = true;
        for($j = 0; $j < $len; $j++) {
            if($i != $j && $array[$i] == $array[$j]) {
                $flag = false;
                break;
            }
        }
        if($flag) {
            $res[] = $array[$i];
        }
    }
    return $res;
}
```
```
/**
 * 暴力法
 * 时间复杂度O(n)
 * 空间复杂度O(n)
 */
function findNumsAppearOnce1($array) {
    $len = count($array);
    $map = [];
    for($i = 0; $i < $len; $i++) {
        $cur = $array[$i];
        if(isset($map[$cur])) {
            $map[$cur]++;
        } else {
            $map[$cur] = 1;
        }
    }
    $res = [];
    foreach($map as $key => $value) {
        if($value == 1) {
            $res[] = $key;
        }
    }
    return $res;
}
```
```
/**
 * 异或
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function findNumsAppearOnce2($array) {
    $len = count($array);
    $num = 0;
    for($i = 0; $i < $len; $i++) {
        $num ^=  $array[$i];    
    }
    $tmp = $num & -$num;
    $num1 = $num2 = 0;
    for($i = 0; $i < $len; $i++) {
        $cur = $array[$i];
        if(($cur & $tmp) == $tmp) {
            $num1 ^= $cur;
        } else {
            $num2 ^= $cur;
í        }
    }
    return [$num1, $num2];
}
```
# 和为S的连续正数序列(41) #
```
/**
 * 双指针
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function findContinuousSequence($sum) {
    $res = [];
    $start = 1;
    $end = 2;
    $curSum = $start + $end;
    if($sum < $curSum) {
        return $res;
    }
    $mid = intval((1 + $sum) / 2);
    while ($start < $mid && $end < $sum) {
        if($curSum < $sum) {
            $curSum += ++$end;
        } else if($curSum > $sum) {
            $curSum -= $start++;
        } else {
            $queue = [];
            for ($i = $start; $i <= $end; $i++) {
                $queue[] = $i;
            }
            $res[] = $queue;
            $curSum += ++$end;
        }
    }
    return $res;
}
```
# 和为S的两个数字(42) #
```
/**
 * 双指针
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function findNumbersWithSum($array, $sum) {
    if(!$array || !$sum) return [];
    $left = 0;
    $right = count($array) - 1;
    while ($left < $right) {
        $value = $array[$left] + $array[$right];
        if($value < $sum) {
            $left++;
        } else if($value > $sum) {
            $right--;
        } else {
            return [$array[$left], $array[$right]];
        }
    }
    return [];
}
```
# 左旋转字符串(43) #
```
/**
 * 字符串分割
 * 时间复杂度O(1)
 * 空间复杂度O(n)
 */
function leftRotateString($str, $n) {
    $len = strlen($str);
    if($len <= 1) return $str;
    $count = $n % $len;
    $left = substr($str, 0, $count);
    $right = substr($str, $count, $len);
    return $right . $left;
}
```
```
/**
 * 字符串截取
 * 时间复杂度O(1)
 * 空间复杂度O(n)
 */
function leftRotateString($str, $n) {
    $len = strlen($str);
    if($len <= 1) return $str;
    return substr($str . $str, $n % $len, $len);
}
```
```
/**
 * 对应关系
 * 时间复杂度O(n)
 * 空间复杂度O(n)
 */
function leftRotateString($str, $n) {
    $len = strlen($str);
    if($len <= 1) return $str;
    $n = $n % $len;
    $res = '';
    for($i = 0; $i < $len; $i++) {
        $res .= $str[($i + $n) % $len];
    }
    return $res;
}
```
```
/**
 * 旋转
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function leftRotateString($str, $n) {
    $len = strlen($str);
    if($len <= 1) return $str;
    $n = $n % $len;
    swap($str, 0, $n -1);
    swap($str, $n, $len -1);
    swap($str, 0, $len -1);
    return $str;
}
function swap(&$str, $beign, $end) {
    while($beign < $end) {
        $tmp = $str[$beign];
        $str[$beign] = $str[$end];
        $str[$end] = $tmp;
        $beign++;
        $end--;
    }
}
```
# 翻转单词顺序序列(44) #
```
/**
 * 遍历
 * 时间复杂度O(n)
 * 空间复杂度O(n)
 */
function reverseSentence($str) {
    $len = strlen($str);
    if($len <= 1) return $str;
    $pre = 0;
    $arr = [];
    for($i = 0; $i < $len; $i++) {
        $cur = $str[$i];
        if($cur == ' ') {
            $arr[] = substr($str, $pre, $i - $pre);
            $arr[] = $cur;
            $pre = $i+1;
        }
    }
    $arr[] = substr($str, $pre, $len - $pre);
    $len = count($arr);
    $res = '';
    for($i = $len - 1; $i >= 0; $i--) {
        $res .= $arr[$i];
    }
    return $res;
}
```
```
/**
 * 反转
 * 时间复杂度O(n)
 * 空间复杂度O(n)
 */
function reverseSentence1($str) {
    $len = strlen($str);
    if($len <= 1) return $str;
    swap($str, 0, $len -1);
    $left = 0;
    $rigth = 0;
    while ($rigth <= $len) {
        if(($rigth == $len && $str[$rigth -1] != ' ') || $str[$rigth] == ' ') {
            swap($str, $left, $rigth - 1);
            $left = $rigth + 1;
        }
        $rigth++;
    }
    return $str;
}
function swap(&$str, $start, $end) {
    while($start < $end) {
        $tmp = $str[$start];
        $str[$start] = $str[$end];
        $str[$end] = $tmp;
        $start++;
        $end--;
    }
}
```
# 扑克牌顺子(45) #
```
/**
 * 遍历
 * 时间复杂度O(1)
 * 空间复杂度O(1)
 */
function isContinuous($numbers) {
    $count = count($numbers);
    if($count != 5) {
        return false;
    }
    sort($numbers);
    $flag = 0;
    $min = PHP_INT_MAX;
    $max = PHP_INT_MIN;
    for($i = 0; $i < $count; $i++) {
        $num = $numbers[$i];
        //范围判断
        if($num < 0 || $num > 13) {
            return false;
        } else if($num == 0) {
            continue;
        }
        //是否重复
        if(($flag >> $num) & 1) {
            return false;
        } else {
            $flag |= 1 << $num;
        }
        //差值判断
        if($num < $min) {
            $min = $num;
        } else if($num > $max) {
            $max = $num;
        }
        if($max - $min > 4) {
            return false;
        }
    }
    return true;
}
```
# 孩子们的游戏(46) #
```
/**
 * 数学归纳法
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function lastRemaining($n, $m) {
    if($n < 1 || $m < 1) {
        return -1;
    }
    if($n == 1) {
        return 0;
    }
    return (lastRemaining($n - 1, $m) + $m) % $n;
}
```
# 求1+2+3+…+n(47) #
```
/**
 * 递归
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function sum($n) {
    $n && $n+=sum($n-1);
    return $n;
}
```
# 不用加减乘除的加法(48) #
```
/**
 * 位运算
 * 时间复杂度O(1)
 * 空间复杂度O(1)
 */
function add($num1, $num2) {
    return $num2 ? add($num1 ^ $num2, ($num1 & $num2) << 1) : $num1;
}
```
# 把字符串转换成整数(49) #
```
/**
 * 遍历
 * 时间复杂度O(n)
 * 空间复杂度O(n)
 */
function strToInt($str) {
    $len = strlen($str);
    if(!$len) return 0;
    $minus = false;
    //去空
    $i = 0;
    while($str[$i] == ' ') {
        $i++;
    }
    if($str[$i] == '+') {
        $i++;
    } else if($str[$i] == '-') {
        $minus = true;
        $i++;
    }
    $value = 0;
    while($i < $len) {
        $cur = $str[$i];
        if('0' <= $cur && $cur <= '9') {
            $value *= 10;
            $value += $cur;
            $i++;
        } else {
            return 0;
        }
        if($minus && $value < PHP_INT_MIN
            || !$minus && $value > PHP_INT_MAX
        ) {
            return 0;
        }
    }
    if($i != $len) {
        return 0;
    }
    if($minus) {
        $value = -$value;
    }
    return $value;
}
```
# 数组中重复的数字(50) #
```
/**
 * 计数
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function duplicate($array) {
    $len = count($array);
    if($len <= 1) return -1;
    for($i = 0; $i < $len; $i++) {
        while($i != $array[$i]) {
            $cur = $array[$i];
            if($array[$cur] == $cur) {
                return $cur;
            } else {
                $tmp = $array[$cur];
                $array[$cur] = $cur;
                $array[$i] = $tmp;
            }
        }
    }
}
```
# 构建乘积数组(51) #
```
/**
 * 计数
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function multiply($array) {
    $len = count($array);
    $res = [];
    for($i = 0, $tmp = 1; $i < $len; $i++) {
        $res[$i] = $tmp;
        $tmp *= $array[$i];
    }
    for($i = $len - 1, $tmp = 1; $i >= 0; $i--) {
        $res[$i] *= $tmp;
        $tmp *= $array[$i];
    }
    return $res;
}
```
# 正则表达式匹配(52) #
```
/**
 * 递归
 * 时间复杂度O(2ⁿ)
 * 空间复杂度O(1)
 */
function match($s, $p) {
    if(!$p) {
        return !$s;
    }
    $sLen = strlen($s);
    $pLen = strlen($p);
    $firstMatch = $s && in_array($p[0], [$s[0], '.']);
    if($pLen >= 2 && $p[1] == '*') {
        return match($s, substr($p, 2, $pLen - 2)) || $firstMatch && match(substr($s, 1, $sLen - 1), $p);
    } else {
        return $firstMatch && match(substr($s, 1,  $sLen - 1), substr($p, 1, $pLen - 1));
    }
}
```
# 表示数值的字符串(53) #
```
/**
 * 遍历
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function isNumeric($str) {
    $len = strlen($str);
    if(!$len) return false;
    $i = 0;
    //符号判断
    if($str[$i] == '+' || $str[$i] == '-') {
        $i++;
    }
    //扫描数字
    scanDigits($str, $i);
    if($i == $len) {
        return true;
    }
    //小数点
    if($str[$i] == '.') {
        $i++;
        //扫描数字
        if(!scanDigits($str, $i)) {
            return false;
        }
        if($i == $len) {
            return true;
        }
    }
    //科学计数法
    if($str[$i] == 'e' || $str[$i] == 'E') {
        $i++;
        if($i < $len && ($str[$i] == '+' || $str[$i] == '-')) {
            $i++;
        }
        //扫描数字
        if(!scanDigits($str, $i)) {
            return false;
        }
        if($i == $len) {
            return true;
        }
    }
}
function scanDigits($str, &$i) {
    $flag = false;
    $len = strlen($str);
    while($i < $len &&  '0' <= $str[$i] && $str[$i] <= '9') {
        $i++;
        $flag = true;
    }
    return $flag;
}
```
# 字符流中第一个不重复的字符(54) #
```
```
# 链表中环的入口结点(55) #
```
/**
 * hash表
 * 时间复杂度O(n)
 * 空间复杂度O(n)
 */
function entryNodeOfLoop($head) {
    if(!$head) return null;
    $map = [];
    $cur = $head;
    while ($cur) {
        if(isset($map[$cur->value])) {
            return $cur;
        } else {
            $map[$cur->value] = $cur;
        }
        $cur = $cur->next;
    }
    return null;
}
```
```
/**
 * 快慢指针
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function entryNodeOfLoop1($head) {
    if(!$head) return null;
    $hasCycle = false;
    $slow = $fast = $head;
    while ($fast && $fast->next) {
        $slow = $slow->next;
        $fast = $fast->next->next;
        if($slow->value == $fast->value) {
            $hasCycle = true;
            break;
        }
    }
    if(!$hasCycle) return null;
    $k = 0;
    $tmp = $slow;
    do {
        $slow = $slow->next;
        $k++;
    } while ($slow != $tmp);
    $slow = $fast = $head;
    while($k) {
        $fast = $fast->next;
        $k--;
    }
    while($slow != $fast) {
        $slow = $slow->next;
        $fast = $fast->next;
    }
    return $slow;
}
```
# 删除链表中重复的结点(56) #
```
/**
 * 遍历
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function deleteDuplication($head) {
    if(!$head) return null;
    $dummy = new Node(-1);
    $dummy->next = $head;
    $pre = $dummy;
    while ($head && $head->next) {
        $value = $head->value;
        if($value == $head->next->value) {
            while ($head && $value == $head->value) {
                $head = $head->next;
            }
            $pre->next = $head;
        } else {
            $pre = $head;
            $head = $head->next;
        }
    }
    return $dummy->next;
}
```
# 二叉树的下一个结点(57) #
```
/**
 * 遍历
 * 时间复杂度o(n)
 * 空间复杂度O(1)
 */
function getNext($node) {
    $next = null;
    if($node->right) {
        $next = $node->right;
        while($next->left) {
            $next = $next->left;
        }
    } elseif ($node->next) {
        $parent = $node->next;
        while($parent && $parent->right == $node) {
            $node = $parent;
            $parent = $parent->next;
        }
        $next = $parent;
    }
    return $next;
}
```
# 对称的二叉树(58) #
```
/**
 * 遍历
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function isSymmetrical($root) {
    if(!$root) {
        return true;
    }
    return isSymmetricalNode($root->left, $root->right);    
}
function isSymmetricalNode($p1, $p2) {
    if(!$p1 && !$p2) {
        return true;
    }
    if(!$p1 || !$p2) {
        return false;
    }
    if($p1->val != $p2->val) {
        return false;
    }
    return isSymmetricalNode($p1->left, $p2->right)
        && isSymmetricalNode($p1->right, $p2->left)
    ;
}
```
# 按之字顺序打印二叉树(59) #
```
/**
 * 遍历
 * 时间复杂度O(n)
 * 空间复杂度O(n)
 */
function myPrint($root) {
    $res = [];
    if(!$root) {
        return $res;
    }
    $odd = $even = [];
    array_push($odd, $root);
    while ($odd || $even) {
        $tmpOdd = $tmpEven = [];
        while ($odd) {
            $node = array_pop($odd);
            $tmpOdd[] = $node->val;
            if($node->left) {
                array_push($even, $node->left);
            }
            if($node->right) {
                array_push($even, $node->right);
            }
        }
        if($tmpOdd) {
            $res[] = $tmpOdd;
        }
        while ($even) {
            $node = array_pop($even);
            $tmpEven[] = $node->val;
            if($node->right) {
                array_push($odd, $node->right);
            }
            if($node->left) {
                array_push($odd, $node->left);
            }
        }
        if($tmpEven) {
            $res[] = $tmpEven;  
        }
    }
    return $res;
}
```
# 把二叉树打印成多行(60) #
```
/**
 * 遍历
 * 时间复杂度O(n)
 * 空间复杂度O(n)
 */
function rowPrint($root) {
    $res = [];
    if(!$root) {
        return $res;
    }
    $queue = [];
    array_push($queue, $root);
    while ($queue) {
        $tmp = [];
        $len = count($queue);
        for($i = 0; $i < $len; $i++) {
            $node = array_shift($queue);
            $tmp[] = $node->val;
            if($node->left) {
                array_push($queue, $node->left);
            }
            if($node->right) {
                array_push($queue, $node->right);
            }
        }
        $res[] = $tmp;
    }
    return $res;
}
```
# 序列化二叉树(61) #
```
function MySerialize($root) {
    $res = '';
    if(!$root) {
        return $res;
    }
    serializeNode($root, $res);
    return $res;
}
function serializeNode($root, &$str) {
    if(!$root) {
        $str .= '#';
        return;
    }
    $str .= $root->val . ',';
    serializeNode($root->left, $str);
    serializeNode($root->right, $str);
}

function MyDeserialize($str) {
    if(!$str) {
        return null;
    }
    return unserializeNode($str);
}
function unserializeNode(&$str) {
    if(stripos($str, '#') === 0) {
        $str = substr($str, 1);
        return null;
    }
    $pos = stripos($str, ',');
    $node = new TreeNode(intval(substr($str, 0, $pos)));
    $str = substr($str, $pos+1);
    if(!$str) {
        return $node;
    }
    $node->left = unserializeNode($str);
    $node->right = unserializeNode($str);
    return $node;
}
```
# 二叉搜索树的第k个结点(62) #
```
/**
 * 遍历
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function kthNode($root, &$k) {
    $target = null;
    if(!$root) {
        return $target;
    }
    if($root->left) {
        $target = kthNode($root->left, $k);
    }
    if(!$target) {
        if($k == 1) {
            $target = $root;
        } 
        $k--;
    }
    if(!$target && $root->right) {
        $target = kthNode($root->right, $k);
    }
    return $target;
}
```
# 数据流中的中位数(63) #
```
```
# 滑动窗口的最大值(64) #
```
```
# 矩阵中的路径(65) #
```
/**
 * 遍历
 * 时间复杂度O()
 * 空间复杂度O(m*n)
 */
function exist($board, $word) {
    $rLen = count($board);
    if(!$rLen) return false;
    $cLen = count($board[0]);
    if(!$cLen) return false;
    for($i = 0; $i < $rLen; $i++) {
        for($j = 0; $j < $cLen; $j++) {
            $visited = [[]];
            if(search($board, $i, $j, $word, 0, $visited)) {
                return true;
            }
        }
    }
    return false;
}
function search($board, $row, $col, $word, $index, &$visited) {
    if($index == strlen($word)) {
        return true;
    }
    $rLen = count($board);
    $cLen = count($board[0]);
    if(($row < 0 || $row >= $rLen)
        || ($col < 0 || $col >= $cLen)
    ) {
        return false;
    }
    if($board[$row][$col] == $word[$index] && (!isset($visited[$row][$col]) || !$visited[$row][$col])) {
        $visited[$row][$col] = true;
        $index++;
        if(search($board, $row - 1, $col, $word, $index, $visited)
            || search($board, $row, $col + 1, $word, $index, $visited)
            || search($board, $row +1, $col, $word, $index, $visited)
            || search($board, $row , $col - 1, $word, $index, $visited)
        ) {
            return true;
        }
        $visited[$row][$col] =false;
    }
    return false;
}
```
# 机器人的运动范围(66) #
```
/**
 * 遍历
 * 时间复杂度O()
 * 空间复杂度O(m*n)
 */
function exist($rows, $cols, $k) {
    if(!$rows) return false;
    if(!$cols) return false;
    $visited = [[]];
    return search($rows, $cols, 0, 0, $k, $visited);
}
function search($rows, $cols, $row, $col, $k, &$visited) {
    $count = 0;
    if(($row < 0 || $row >= $rows)
        || ($col < 0 || $col >= $cols)
    ) {
        return $count;
    }
    if((getDigitSum($row) + getDigitSum($col) <= $k) && (!isset($visited[$row][$col]) || !$visited[$row][$col])) {
        $visited[$row][$col] = true;
        $count += 1 
            + search($rows, $cols, $row - 1, $col, $k, $visited)
            + search($rows, $cols, $row, $col + 1, $k, $visited)
            + search($rows, $cols, $row +1, $col, $k, $visited)
            + search($rows, $cols, $row , $col - 1, $k, $visited)
        ;
    }
    return $count;
}
function getDigitSum($value) {
    $sum = 0;
    while ($value) {
        $sum += $value % 10;
        $value = intval($value / 10);
    }
    return $sum;
}
```
