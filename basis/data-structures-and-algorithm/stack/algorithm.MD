# 有效的括号 #
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
# 用栈实现队列 #
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