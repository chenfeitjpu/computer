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
 * 向已反转的链表中添加未反转元素(从后向前遍历)
 */
function reverseList($head) {
    if(!$head->next)  return $head;
    $p = reverseList($head->next);
    $head->next->next = $head;
    $head->next = null;
    return $p;
}
```
# 对区间内的链表进行反转 #
```
/**
 * 反转区间范围内的链表再连接
 */
function reverseBetween($head, $m, $n) {
    $dummy = new ListNode(-1);
    $dummy->next = $head;
    $pre = $dummy;
    for($i = 0; $i < $m-1; $i++) {
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
 * 对反转区间内的元素逐个进行反转
 */
function reverBetween($head, $m, $n) {
    $dummy = new ListNode(-1);
    $dummy->next = $head;
    $pre = $dummy;
    for($i = 0; $i < $m - 1; $i++) {
        $pre = $pre->next;
    }
    $start = $pre->next;
    $tail = $start->next;
    for($i = 0; $i < $n - $m + 1; $i++) {
        $start->next = $tail->next;
        $tail->next = $pre->next;
        $pre->next = $tail;
        $tail = $start->next;
    }
    return $dummy->next;
}
```