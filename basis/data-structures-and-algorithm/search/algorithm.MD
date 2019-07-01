* [括号生成(22)](#括号生成22)

# 括号生成(22) #
```
function generateParenthesis($n) {
    $res = [];
    if(!$n) return [''];
    for($i = 0; $i < $n; $i++) {
        foreach (generateParenthesis($i) as $left) {
            foreach (generateParenthesis($n- 1 - $i) as $right) {
                $res[] = '(' . $left . ')' . $right;
            }
        }
    }
    return $res;
}
```