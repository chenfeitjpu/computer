<?php
/**
 * 用数组实现栈
 */
class StackArray {

    /**
     * 数据
     */
    private $data = [];

    /**
     * 容量
     */
    private $capacity;

    /**
     * 数据数量
     */
    private $count = 0;

    /**
     * 初始化
     */
    public function __construct($capacity){
        $this->capacity = $capacity;
        for($i = 0; $i < $capacity; $i++) {
            $this->data[$i] = null;
        }
    }

    /**
     * 入栈
     */
    public function push($value) {
        if($this->count == $this->capacity) {
            return false;
        }
        $this->data[$this->count] = $value;
        $this->count++;
    }

    /**
     * 出栈
     */
    public function pop() {
        if($this->count) {
            $value = $this->data[$this->count - 1];
            $this->count--;
            return $value;
        } else {
            return null;
        }
    }

    /**
     * 输入所有
     */
    public function printAll() {
        for($i = $this->count - 1; $i >=0 ; $i--) {
            echo $this->data[$i] . PHP_EOL;
        }
        echo PHP_EOL;
    }

}
$stack = new StackArray(3);
$stack->push(1);
$stack->push(2);
$stack->printAll();
$stack->pop();
$stack->printAll();