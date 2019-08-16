* [剑指offer题解](#剑指offer题解)
  * [顺时针打印矩阵(19)](#顺时针打印矩阵19)
  
# 剑指offer题解 #
## 顺时针打印矩阵(19) ##
```
/**
 * 遍历
 * 时间复杂度O(n)
 * 空间复杂度O(n)
 */
function spiralOrder($matrix) {
    $res = [];
    $row = count($matrix);
    if(!$row) return $res;
    $col = count($matrix[0]);

    $visit = [];
    $r = $c = $d = 0;
    $step = [
        [0, 1],
        [1, 0],
        [0, -1],
        [-1, 0],
    ];
    $count = $row * $col;
    for($i = 0; $i < $count; $i++) {
        $res[] = $matrix[$r][$c];
        $visit[$r][$c] = true;
        $tr = $r + $step[$d][0];
        $tc = $c + $step[$d][1];
        if(0 <= $tr && $tr < $row && 0 <= $tc && $tc < $col && !isset($visit[$tr][$tc])) {
            $r = $tr;
            $c = $tc;
        } else {
            $d = ($d + 1) % 4;
            $r += $step[$d][0];
            $c += $step[$d][1];
        }
    }
    return $res;
}
```