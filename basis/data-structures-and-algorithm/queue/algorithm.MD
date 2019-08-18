* [用队列实现栈](#用队列实现栈)
* [滑动窗口最大值](#滑动窗口最大值)

# 用队列实现栈 #
```
class Stack {

    private $in = [];

    private $out = [];

    public function push($value) {
        if($this->in) {
            array_push($this->in, $value);
        } else {
            array_push($this->out, $value);
        }
    }

    public function pop() {
        if($this->in) {
            while (count($this->in) > 1) {
                array_push($this->out, array_shift($this->in));
            }
            return array_shift($this->in);
        } else {
            while (count($this->out) > 1) {
                array_push($this->in, array_shift($this->out));
            }
            return array_shift($this->out);
        }
    }

    public function top() {
        $top = $this->pop();
        if($this->in) {
            array_push($this->in, $top);
        } else {
            array_push($this->out, $top);
        }
        return $top;
    }

    public function empty() {
        return !$this->in && !$this->out;
    }

}
```
