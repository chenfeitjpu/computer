* [括号生成(22)](#括号生成22)
* [N皇后(51)](#n皇后51)
* [N皇后(52)](#n皇后52)
* [有效的数独(36)](#有效的数独36)
* [数独(37)](#数独37)

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
# N皇后(51) #
```
function solve($row, $n, &$res, $col, $pie, $na, $sol) {
    if($row >= $n) {
        $res[] = $sol;
        return;
    }
    for($i = 0; $i < $n; $i++) {
        if((!isset($col[$i]) || !$col[$i])
            && (!isset($pie[$row + $i]) || !$pie[$row + $i])
            && (!isset($na[$row - $i]) || !$na[$row - $i])
        ) {
            //更新
            $col[$i] = 1;
            $pie[$row + $i] = 1;
            $na[$row - $i] = 1;
            $sol[$row] = str_repeat('.', $i) . 'Q' . str_repeat('.', $n - 1 - $i);
            solve($row + 1, $n, $res, $col, $pie, $na, $sol);
            $sol[$row] = '';
            //还原
            $col[$i] = 0;
            $pie[$row + $i] = 0;
            $na[$row - $i] = 0;
        }

    }
}
function solveNQueens($n) {
    if($n <= 1) return [['Q']];
    $res = [];
    solve(0, $n, $res, [], [], [], []);
    return $res;
}
```
# N皇后(52) #
```
function solve($row, $n, &$count, $col, $pie, $na) {
    if($row >= $n) {
        $count++;
        return;
    }
    for($i = 0; $i < $n; $i++) {
        if((!isset($col[$i]) || !$col[$i])
            && (!isset($pie[$row + $i]) || !$pie[$row + $i])
            && (!isset($na[$row - $i]) || !$na[$row - $i])
        ) {
            //更新
            $col[$i] = 1;
            $pie[$row + $i] = 1;
            $na[$row - $i] = 1;
            solve($row + 1, $n, $count, $col, $pie, $na);
            //还原
            $col[$i] = 0;
            $pie[$row + $i] = 0;
            $na[$row - $i] = 0;
        }

    }
}
function totalNQueens($n) {
    if($n <= 1) return 1;
    $count = 0;
    solve(0, $n, $count, [], [], []);
    return $count;
}
```
# 有效的数独(36) #
```
function isValidSudoku($board) {
    $len = count($board);
    if(!$len) return false;
    $row = $col = $box = [];
    for($i = 0; $i < $len; $i++) {
        for($j = 0; $j < $len; $j++) {
            $value = $board[$i][$j];
            if($value == '.') {
                continue;
            }
            $index = (floor($i / 3)) * 3 + floor($j / 3);
            if(isset($row[$i][$value])
                || isset($col[$j][$value])
                || isset($box[$index][$value])
            ) {
                return false;
            }
            $row[$i][$value] = 1;
            $col[$j][$value] = 1;
            $box[$index][$value] = 1;
        }
    }
    return true;
}
```
# 数独(37) #
```
function solve(&$board, $rowList, $colList, $boxList, $row, $col) {
    if($col == count($board)) {
        $col = 0;
        $row++;
        if($row == count($board)) {
            return true;
        }
    }
    $value = $board[$row][$col];
    if($value == '.') {
        for($i = 1; $i <= 9; $i++) {
            $index = floor($row / 3) * 3 + floor($col / 3);
            if(isset($rowList[$row][$i])
                || isset($colList[$col][$i])
                || isset($boxList[$index][$i])
            ) {
                continue;
            } else {
                $board[$row][$col] = strval($i);
                $rowList[$row][$i] = 1;
                $colList[$col][$i] = 1;
                $boxList[$index][$i] = 1;
                if(solve($board, $rowList, $colList, $boxList, $row, $col+1)) {
                    return true;
                }
                $board[$row][$col] = '.';
                unset($rowList[$row][$i]);
                unset($colList[$col][$i]);
                unset($boxList[$index][$i]);
            }
        }
    } else {
        return solve($board, $rowList, $colList, $boxList, $row, $col+1);
    }
    return false;
}
function solveSudoku($board) {
    $len = count($board);
    if(!$len) return false;
    $rowList = $colList = $boxList = [];
    for($i =0 ; $i < $len; $i++) {
        for($j = 0; $j < $len; $j++) {
            $value = $board[$i][$j];
            if($board[$i][$j] != '.') {
                $rowList[$i][$value] = 1;
                $colList[$j][$value] = 1;
                $index = floor($i / 3) * 3 + floor($j / 3);
                $boxList[$index][$value] = 1;
            }
        }
    }
    solve($board, $rowList, $colList, $boxList, 0, 0);
    return $board;
}
```