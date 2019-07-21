* [剑指offer题解](#剑指offer题解)
  * [用两个栈实现队列(5)](#用两个栈实现队列5)
  * [包含min函数的栈(20)](#包含min函数的栈20)
  * [栈的压入、弹出序列(21)](#栈的压入弹出序列21)
* [LeeCode题解](#leecode题解)
  * [有效的括号](#有效的括号)
  * [用栈实现队列](#用栈实现队列)
      
# 剑指offer题解 #
## 用两个栈实现队列(5) ##
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
## 包含min函数的栈(20) ##
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
## 栈的压入、弹出序列(21) ##
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
# LeeCode题解 #
## 有效的括号 ##
```
/**
 * 利用栈进行匹配
 */
function isValid($s) {
    $map = [
        ')' => '(',
        ']' => '[',
        '}' => '{',
    ];
    $stack = [];
    $len = strlen($s);
    for($i = 0; $i < $len; $i++) {
        $char = $s[$i];
        if(isset($map[$char])) {
            if(!$stack || array_pop($stack) != $map[$char]) {
                return false;
            }
        } else {
            $stack[] = $char;
        }
    }
    return !$stack;
}
```
## 用栈实现队列 ##
```
class MyQueue {

    private $in = [];

    private $out = [];

    public function push($value) {
        while($this->out) {
            array_push($this->in, array_pop($this->out));
        }
        array_push($this->in, $value);
    }

    public function pop() {
        while($this->in) {
            array_push($this->out, array_pop($this->in));
        }
        return array_pop($this->out);
    }

    public function peek() {
        while($this->in) {
            array_push($this->out, array_pop($this->in));
        }
        return $this->out[count($this->out)-1];
    }

    public function empty() {
        return !$this->in && !$this->out;
    }

}
```