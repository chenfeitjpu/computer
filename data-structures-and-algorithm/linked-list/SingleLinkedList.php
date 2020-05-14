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
 * 链表
 */
class SingleLinkedList {

    /**
     * 头结点
     */
    public $head;

    /**
     * 插入
     */
    public function insert($node) {
        if(!$this->head) {
            $this->head = $node;
        } else {
            $p = $this->head;
            while ($p->next) {
                $p = $p->next;
            }
            $node->next = $p->next;
            $p->next = $node;
        }
    }

    /**
     * 删除
     */
    public function delete($node) {
        if(!$this->head) {
            return null;
        }
        $pre = null;
        $p = $this->head;
        while ($p && $p->value != $node->value) {
            $pre = $p;
            $p = $p->next;
        }
        if(!$p) {
            return null;
        }
        if($p == $this->head) {
            $this->head = null;
        } else {
            $pre->next = $p->next;
        }
    }

    /**
     * 查找
     */
    public function get($node) {
        if(!$this->head) {
            return null;
        }
        $p = $this->head;
        while ($p && $p->value != $node->value) {
            $p = $p->next;
        }
        return $p;
    }

    /**
     * 打印链表
     */
    public function printAll() {
        if(!$this->head) {
            return null;
        }
        $p = $this->head;
        while ($p) {
            echo $p->value . PHP_EOL;
            $p = $p->next;
        }
        echo PHP_EOL;
    }
}

$node1 = new Node(1);
$node2 = new Node(2);
$node3 = new Node(3);
$linkedList = new SingleLinkedList();
$linkedList->insert($node1);
$linkedList->insert($node2);
$linkedList->insert($node3);
$linkedList->printAll();
$linkedList->delete($node2);
$linkedList->printAll();
echo $linkedList->get($node3)->value;