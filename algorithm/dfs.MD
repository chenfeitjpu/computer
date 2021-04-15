# DFS #

## 定义 ##
搜索到一个新节点，立即对该节点进行遍历

## 常见问题 ##
### LEETCODE ###
#### 695.岛屿的最大面积 ####
<details>
<summary>递归</summary>
<pre>
<code>
/**
 * DFS-递归
 */
function maxAreaOfIsland($grid) {
    $m = count($grid);
    $n = count($grid[0]);
    $max = 0;
    for ($i = 0; $i < $m; $i++) {
        for ($j = 0; $j < $n; $j++) {
            $max = max($max, areaOfIsland($grid, $m, $n, $i, $j));
        }
    }
    return $max;
}
function areaOfIsland(&$grid, $m, $n, $row, $col) {
    $area = 0;
    if ($row < 0 || $row > $m -1 || $col < 0 || $col > $n - 1 || $grid[$row][$col] == 0) {
        return $area;
    }
    $grid[$row][$col] = 0;
    $area++;
    return $area
        + areaOfIsland($grid, $m, $n, $row, $col + 1)
        + areaOfIsland($grid, $m, $n, $row, $col - 1)
        + areaOfIsland($grid, $m, $n, $row - 1, $col)
        + areaOfIsland($grid, $m, $n, $row + 1, $col)
    ;
}
</code>
</pre>
</details>
<details>
<summary>迭代</summary>
<pre>
<code>
/**
 * DFS-迭代
 */
function maxAreaOfIsland($grid) {
    $m = count($grid);
    $n = count($grid[0]);
    $max = 0;
    for ($i = 0; $i < $m; $i++) {
        for ($j = 0; $j < $n; $j++) {
            if ($grid[$i][$j] == 0) {
                continue;
            }
            $grid[$i][$j] = 0;
            $area = 1;
            $stack = [[$i, $j]];
            while ($stack) {
                list($r, $c) = array_pop($stack);
                $direction = [[0, -1], [0, 1], [-1, 0], [1, 0]];
                foreach ($direction as $d) {
                    $row = $r + $d[0];
                    $col = $c + $d[1];
                    if ($row < 0 || $row > $m - 1 || $col < 0 || $col > $n - 1 || $grid[$row][$col] == 0) {
                        continue;
                    }
                    $grid[$row][$col] = 0;
                    $area++;
                    array_push($stack, [$row, $col]);
                }
            }
            $max = max($max, $area);
        }
    }
    return $max;
}
</code>
</pre>
</details>

#### 547.省份数量 ####
<details>
<summary>递归</summary>
<pre>
<code>
/**
 * DFS-递归
 */
function findCircleNum($isConnected) {
    $m = count($isConnected);
    $cnt = 0;
    $visited = array_fill(0, $m, 0);
    for ($i = 0; $i < $m; $i++) {
        if ($visited[$i] == 1) {
            continue;
        }
        $cnt++;
        findCircle($isConnected, $m, $i, $visited);
    }
    return $cnt;
}
function findCircle($isConnected, $m, $row, &$visited) {
    $visited[$row] = 1;
    for ($j = 0; $j < $m; $j++) {
        if ($isConnected[$row][$j] == 0 || $visited[$j] == 1) {
            continue;
        }
        findCircle($isConnected, $m, $j, $visited);
    }
}
</code>
</pre>
</details>
<details>
<summary>迭代</summary>
<pre>
<code>
/**
 * DFS-迭代
 */
function findCircleNum($isConnected) {
    $m = count($isConnected);
    $cnt = 0;
    $visited = array_fill(0, $m, 0);
    for ($i = 0; $i < $m; $i++) {
        if ($visited[$i] == 1) {
            continue;
        }
        $cnt++;
        $visited[$i] = 1;
        $stack = [$i];
        while ($stack) {
            $row = array_pop($stack);
            for ($j = 0; $j < $m; $j++) {
                if ($isConnected[$row][$j] == 0 || $visited[$j]) {
                    continue;
                }
                $visited[$j] = 1;
                array_push($stack, $j);
            }
        }
    }
    return $cnt;
}
</code>
</pre>
</details>

####  ####
<details>
<summary>代码</summary>
<pre>
<code>
</code>
</pre>
</details>
