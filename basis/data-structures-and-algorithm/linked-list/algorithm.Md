* [反转链表](#反转链表)
* [反转链表(区间)](#反转链表区间)
* [两两交换链表中的节点](#两两交换链表中的节点)
* [K个一组翻转链表](#k个一组翻转链表)
* [环形链表(判断有环)](#环形链表判断有环)
* [环形链表(返回入口)](#环形链表返回入口)

# 反转链表 #
```
/**
 * 把当前元素的指针指向前一个元素(从前向后遍历)
 */
function reverseList($head) {
    $pre = null;
    $cur = $head;
    while ($cur) {
        $tmp = $cur->next;
        $cur->next = $pre;
        $pre = $cur;
        $cur = $tmp;
    }
    return $pre;
}
```
```
/**
 * 把后一个元素的指针指向当前元素(从后向前遍历)
 */
function reverseList2($head) {
    if(!$head->next) return $head;
    $p = reverseList2($head->next);
    $head->next->next = $head;
    $head->next = null;
    return $p;
}
```
# 反转链表(区间) #
```
/**
 * 拼接法
 */
function reverseBetween($head, $m, $n) {
    $dummy = new ListNode(-1);
    $dummy->next = $head;
    $pre = $dummy;
    for($i = 0; $i < $m - 1; $i++) {
        $pre = $pre->next;
    }
    $node = null;
    $cur = $pre->next;
    for($i = 0; $i < $n - $m + 1; $i++) {
        $tmp = $cur->next;
        $cur->next = $node;
        $node = $cur;
        $cur = $tmp;
    }
    $pre->next->next = $cur;
    $pre->next = $node;
    return $dummy->next;
}
```
```
/**
 * 插入法
 */
function reverseBetween2($head, $m, $n) {
    $dummy = new ListNode(-1);
    $dummy->next = $head;
    $pre = $dummy;
    for($i = 0; $i < $m - 1; $i++) {
        $pre = $pre->next;
    }
    $start = $pre->next;
    $tail = $start->next;
    for($i = 0; $i < $n - $m; $i++) {
        $start->next = $tail->next;
        $tail->next = $pre->next;
        $pre->next = $tail;
        $tail = $start->next;
    }
    return $dummy->next;
}
```
# 两两交换链表中的节点 #
```
/**
 * 循环
 */
function swapPairs($head) {
    $dummy = new ListNode(-1);
    $dummy->next = $head;
    $pre = $dummy;
    while ($pre->next && $pre->next->next) {
        $start = $pre->next;
        $end = $pre->next->next;
        $pre->next = $end;
        $start->next = $end->next;
        $end->next = $start;
        $pre = $start;
    }
    return $dummy->next;
}
```
```
/**
 * 递归
 */
function swapPairs($head) {
    if(!$head || !$head->next) return $head;
    $next = $head->next;
    $head->next = swapPairs($next->next);
    $next->next = $head;
    return $next;
}
```
# K个一组翻转链表 #
```
/**
 * 循环+尾插入
 */
function reverseKGroup($head, $k) {
    $dummy = new ListNode(-1);
    $dummy->next = $head;
    $pre = $tail = $dummy;
    while (true) {
        $count = $k;
        while ($count && $tail) {
            $tail = $tail->next;
            $count--;
        }
        if(!$tail) break;
        $head = $pre->next;
        while ($pre->next != $tail) {
            $cur = $pre->next;
            $pre->next = $cur->next;
            $cur->next = $tail->next;
            $tail->next = $cur;
        }
        $pre = $tail = $head;
    }
    return $dummy->next;
}
```
```
/**
 * 递归
 */
function reverseKGroup2($head, $k) {
    $cur = $head;
    $count = 0;
    while ($cur && $count != $k) {
        $cur = $cur->next;
        $count++;
    }
    if($count == $k) {
        $cur = reverseKGroup2($cur, $k);
        while ($count) {
            $tmp = $head->next;
            $head->next = $cur;
            $cur = $head;
            $head = $tmp;
            $count--;
        }
        $head = $cur;
    }
    return $head;
```
# 环形链表(判断有环) #
```
/**
 * 散列表
 */
function hasCycle($head) {
    $map = [];
    while ($head) {
        if(isset($map[$head->val])) {
            return true;
        }
        $map[$head->val] = $head->val;
    }
    return false;
}
```
```
/**
 * 双指针
 */
function hadCycle2($head) {
    $fast = $head;
    while ($head && $fast && $fast->next) {
        $head = $head->next;
        $fast = $fast->next->next;
        if($head->val == $fast->val) return true;
    }
    return false;
}
```
# 环形链表(返回入口) #
```
/**
 * 散列表
 */
function detectCycle($head) {
    $map = [];
    while ($head) {
        if(isset($map[$head->val])) {
            return $map[$head->val];
        }
        $map[$head->val] = $head;
    }
    return null;
}
```
```
/**
 * 双指针
 */
function detectCycle2($head) {
    $fast = $slow = $head;
    $hasCycle = false;
    while ($head && $fast && $fast->next) {
        $slow = $slow->next;
        $fast = $fast->next->next;
        if($slow->val == $fast->val) {
            $hasCycle = true;
            break;
        }
    }
    if($hasCycle) {
        $fast = $head;
        while ($fast->val != $slow->val) {
            $slow = $slow->next;
            $fast = $fast->next;
        }
        return $slow;
    }
    return null;
}
