<?php
/**
 * 数组实现队列
 */
class QueueArray {

    /**
     * 集合
     */
    private $data = [];

    /**
     * 容量
     */
    private $capacity = 0;

    /**
     * 头部
     */
    private $head = 0;

    /**
     * 尾部
     */
    private $tail = 0;

    /**
     * 初始化
     */
    public function __construct($capacity) {
        $this->capacity = $capacity;
    }

    /**
     * 入队
     */
    public function push($value) {
        if($this->tail == $this->capacity) {
            if($this->head == 0) {
                return false;
            }
            for($i = $this->head; $i < $this->tail; $i++) {
                $this->data[$i - $this->head] = $this->data[$i];
            }
        }
        $this->data[$this->tail++] = $value;
        return true;
    }

    /**
     * 出队
     */
    public function pop() {
        if($this->head == $this->tail) {
            return null;
        }
        return $this->data[$this->head++];
    }

    /**
     * 输出所有
     */
    public function printAll() {
        for($i = $this->head; $i < $this->tail; $i++) {
            echo $this->data[$i] . PHP_EOL;
        }
        echo PHP_EOL;
    }

}

//test case
$queue = new QueueArray(3);
$queue->push(1);
$queue->push(2);
$queue->push(3);
$queue->printAll();
$queue->pop();
$queue->printAll();