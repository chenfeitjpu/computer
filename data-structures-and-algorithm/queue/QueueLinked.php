<?php
/**
 * 节点
 */
class Node {

    /**
     * 节点值
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
 * 链表实现队列
 */
class QueueLinked {

    /**
     * 头结点
     */
    private $head;

    /**
     * 尾结点
     */
    private $tail;

    /**
     * 入队
     */
    public function push($value) {
        $node = new Node($value);
        if(!$this->tail) {
            $this->head = $this->tail = $node;
        } else {
            $this->tail->next = $node;
            $this->tail = $node;
        }
    }

    /**
     * 出队
     */
    public function pop() {
        if(!$this->head) {
            return null;
        }
        $value = $this->head->value;
        $this->head = $this->head->next;
        if(!$this->head) {
            $this->tail = null;
        }
        return $value;
    }

    /**
     * 输出所有元素
     */
    public function printAll() {
        $p = $this->head;
        while ($p) {
            echo $p->value . PHP_EOL;
            $p = $p->next;
        }
        echo PHP_EOL;
    }

}

//test case
$queue = new QueueLinked(3);
$queue->push(1);
$queue->push(2);
$queue->push(3);
$queue->printAll();
$queue->pop();
$queue->printAll();