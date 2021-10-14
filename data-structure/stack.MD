栈

# 定义 #
只能在尾部插入、删除数据

# 特点 #
先进后出

# 应用 #
## LEETCODE ##
### 232.用栈实现队列 ###
<details>
<summary>代码</summary>
<pre>
<code>
class MyQueue {

    /**
     * @var array $inStack
     */
    private $inStack = [];

    /**
     * @var array $outStack
     */
    private $outStack = [];

    /**
     * Initialize your data structure here.
     */
    function __construct() {

    }

    /**
     * Push element x to the back of queue.
     * @param Integer $x
     * @return NULL
     */
    function push($x) {
        while ($this->outStack) {
            array_push($this->inStack, array_pop($this->outStack));
        }
        array_push($this->inStack, $x);
    }

    /**
     * Removes the element from in front of queue and returns that element.
     * @return Integer
     */
    function pop() {
        while($this->inStack) {
            array_push($this->outStack, array_pop($this->inStack));
        }
        return array_pop($this->outStack);
    }

    /**
     * Get the front element.
     * @return Integer
     */
    function peek() {
        if ($this->empty()) {
            return null;
        }
        while($this->inStack) {
            array_push($this->outStack, array_pop($this->inStack));
        }
        return end($this->outStack);
    }

    /**
     * Returns whether the queue is empty.
     * @return Boolean
     */
    function empty() {
        return !count($this->inStack) && !count($this->outStack);
    }

}
</code>
</pre>
</details>

### 155.最小栈 ###
<details>
<summary>代码</summary>
<pre>
<code>
class MinStack {

    /**
     * @var array $stack
     */
    private $stack = [];
    /**
     * @var array $minStack
     */
    private $minStack = [];

    /**
     * initialize your data structure here.
     */
    function __construct() {

    }

    /**
     * @param Integer $val
     * @return NULL
     */
    function push($val) {
        array_push($this->stack, $val);
        if (!$this->minStack || $val <= end($this->minStack)) {
            array_push($this->minStack, $val);
        }
    }

    /**
     * @return NULL
     */
    function pop() {
        $val = array_pop($this->stack);
        if ($val == end($this->minStack)) {
            array_pop($this->minStack);
        }
    }

    /**
     * @return Integer
     */
    function top() {
        if ($this->stack) {
            return end($this->stack);
        }
        return null;
    }

    /**
     * @return Integer
     */
    function getMin() {
        if ($this->minStack) {
            return end($this->minStack);
        }
        return null;
    }

}
</code>
</pre>
</details>

### 20.有效的括号 ###
<details>
<summary>代码</summary>
<pre>
<code>
function isValid($s) {
    if (!$s) {
        return true;
    }
    $map = [
        ')' => '(',
        ']' => '[',
        '}' => '{',
    ];
    $stack = [];
    $len = strlen($s);
    for ($i = 0; $i < $len; $i++) {
        if (!isset($map[$s[$i]])) {
            array_push($stack, $s[$i]);
        } else if ($map[$s[$i]] != array_pop($stack)){
            return false;
        }
    }
    return !count($stack);
}
</code>
</pre>
</details>

### 739.每日温度 ###
<details>
<summary>代码</summary>
<pre>
<code>
function dailyTemperatures($T) {
    $len = count($T);
    if (!$len) {
        return [];
    }
    $ans = array_fill(0, $len, 0);
    $stack = [];
    for ($i = 0; $i < $len; $i++) {
        while ($stack && $T[$i] > $T[end($stack)]) {
            $index = array_pop($stack);
            $ans[$index] = $i - $index;
        }
        array_push($stack, $i);
    }
    return $ans;
}
</code>
</pre>
</details>