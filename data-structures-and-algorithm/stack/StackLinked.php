<?php
/**
 * 节点
 */
class Node {
    /**
     * 值
     */
    public $value;
    /**
     * 指针
     */
    public $next;

    /**
     * 初始化
     */
    public function __construct($value) {
        $this->value = $value;
    }

}

/**
 * 用链表实现栈
 */
class StackLinked {

    /**
     * 头结点
     */
    private $head;

    /**
     * 入栈
     */
    public function push($value) {
        $node = new Node($value);
        if($this->head) {
            $node->next = $this->head;
        }
        $this->head = $node;
    }

    /**
     * 出栈
     */
    public function pop() {
        if(!$this->head) {
            return null;
        }
        $value = $this->head->value;
        $this->head = $this->head->next;
        return $value;
    }

    public function printAll() {
        $p = $this->head;
        while ($p) {
            echo $p->value . PHP_EOL;
            $p = $p->next;
        }
        echo PHP_EOL;
    }

}

$stack = new StackLinked();
$stack->push(1);
$stack->push(2);
$stack->push(3);
$stack->printAll();
$stack->pop();
$stack->printAll();