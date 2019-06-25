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
            if(array_pop($stack) != $map[$char]) {
                return false;
            }
        } else {
            $stack[] = $char;
        }
    }
    return !$stack;
}
```