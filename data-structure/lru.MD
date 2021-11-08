# LRU #

LRU

# 定义 #
最近最少使用

# 应用 #
## LEETCODE ##
### 146.LRU缓存机制 ###
<details>
<summary>代码</summary>
<pre>
<code>
class DoubleLinkedList {

    public $key;

    public $value;

    public $prev;

    public $next;

    public function __construct($key, $value) {
        $this->key = $key;
        $this->value = $value;
    }

}
class LRUCache {

    private $size = 0;

    private $capaticy = 0;

    private $map = [];

    private $head;

    private $tail;

    function __construct($capacity) {
        $this->capaticy = $capacity;
        $this->head = new DoubleLinkedList(PHP_INT_MIN, PHP_INT_MIN);
        $this->tail = new DoubleLinkedList(PHP_INT_MAX, PHP_INT_MAX);
        $this->head->next = $this->tail;
        $this->tail->prev = $this->head;
    }

    function get($key) {
        $node = $this->map[$key] ?? null;
        if (!$node) {
            return -1;
        }
        $this->moveToHead($node);
        return $node->value;
    }

    function put($key, $value) {
        $node = $this->map[$key] ?? null;
        if ($node) {
            $node->value = $value;
            $this->moveToHead($node);
        } else {
            if ($this->size == $this->capaticy) {
                $tail = $this->tail->prev;
                $this->removeNode($tail);
                unset($this->map[$tail->key]);
                $this->size--;
            }
            $new = new DoubleLinkedList($key, $value);
            $this->addToHead($new);
            $this->size++;
            $this->map[$key] = $new;
        }
    }

    private function moveToHead($node) {
        $this->removeNode($node);
        $this->addToHead($node);
    }

    private function addToHead($node) {
        $node->next = $this->head->next;
        $node->prev = $this->head;
        $this->head->next->prev = $node;
        $this->head->next = $node;
    }

    private function removeNode($node) {
        $node->prev->next = $node->next;
        $node->next->prev =$node->prev;
    }

}
</code>
</pre>
</details>