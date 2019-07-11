<?php
/**
 * 实现一个数组
 * 支持增删改查
 * 支持动态扩容
 */
class MyArray {

    /**
     * 数据集合
     */
    private $data = [];

    /**
     * 数组容量
     */
    private $capacity;

    /**
     * 数据数量
     */
    private $count;


    /**
     * 初始化
     */
    public function __construct($capacity) {
        $this->capacity = $capacity;
        for($i = 0; $i < $this->capacity; $i++) {
            $this->data[$i] = null;
        }
        $this->count = 0;
    }

    /**
     * 添加一个元素
     */
    public function insert($index, $value) {
        //边界校验
        if($index < 0) {
            return false;
        }
        //扩容
        if($index >= $this->capacity) {
            $this->expansion($index + 1);
        } else if($this->count == $this->capacity){
            $this->expansion($this->capacity * 2);
        }
        //元素后移
        if($this->data[$index] !== null) {
            for($i = $this->capacity - 1; $i > $index; $i--) {
                $this->data[$i] = $this->data[$i-1];
            }
        }
        $this->data[$index] = $value;
        $this->count++;
    }

    /**
     * 删除一个元素
     */
    public function delete($index) {
        //边界校验
        if($this->indexOutOfBounds($index)) {
            return null;
        }
        //元素迁移
        for($i = $index; $i < $this->capacity-1; $i++) {
            $this->data[$i] = $this->data[$i+1];
        }
        $this->data[$this->capacity - 1] = null;
        $this->count--;
        return true;
    }

    /**
     * 修改一个元素
     */
    public function set($index, $value) {
        if($index < 0) {
            return false;
        }
        if($index > $this->capacity) {
            return $this->insert($index, $value);
        }
        $this->data[$index] = $value;
        return true;
    }

    /**
     * 获取一个元素
     */
    public function get($index) {
        //边界校验
        if($this->indexOutOfBounds($index)) {
            return null;
        }
        return $this->data[$index];
    }

    /**
     * 打印数组
     */
    public function printAll() {
        foreach($this->data as $key => $value) {
            echo $key . ':' . $value . PHP_EOL;
        }
        echo PHP_EOL;
    }

    /**
     * 数组越界检查
     */
    private function indexOutOfBounds($index) {
        return $index < 0 || $index >= $this->capacity;
    }

    /**
     * 数组扩容
     */
    private function expansion($capacity) {
        for($i = $this->capacity; $i < $capacity; $i++) {
            $this->data[$i] = null;
        }
        $this->capacity = $capacity;
    }

}

$myArray = new MyArray(3);
$myArray->insert(0, 1);
$myArray->insert(4, 2);
$myArray->printAll();
$myArray->delete(4);
$myArray->printAll();
$myArray->set(2, 3);
$myArray->printAll();
echo $myArray->get(2);
