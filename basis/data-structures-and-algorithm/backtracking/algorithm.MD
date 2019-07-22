* [剑指offer题解](#剑指offer题解)
  * [矩阵中的路径(65)](#矩阵中的路径65)
  * [机器人的运动范围(66)](#机器人的运动范围66)
      
# 剑指offer题解 #
## 矩阵中的路径(65) ##
```
/**
 * 遍历
 * 时间复杂度O()
 * 空间复杂度O(m*n)
 */
function exist($board, $word) {
	$rLen = count($board);
	if(!$rLen) return false;
	$cLen = count($board[0]);
	if(!$cLen) return false;
	for($i = 0; $i < $rLen; $i++) {
		for($j = 0; $j < $cLen; $j++) {
			$visited = [[]];
			if(search($board, $i, $j, $word, 0, $visited)) {
				return true;
			}
		}
	}
	return false;
}
function search($board, $row, $col, $word, $index, &$visited) {
	if($index == strlen($word)) {
		return true;
	}
	$rLen = count($board);
	$cLen = count($board[0]);
	if(($row < 0 || $row >= $rLen)
		|| ($col < 0 || $col >= $cLen)
	) {
		return false;
	}
	if($board[$row][$col] == $word[$index] && (!isset($visited[$row][$col]) || !$visited[$row][$col])) {
		$visited[$row][$col] = true;
		$index++;
		if(search($board, $row - 1, $col, $word, $index, $visited)
			|| search($board, $row, $col + 1, $word, $index, $visited)
			|| search($board, $row +1, $col, $word, $index, $visited)
			|| search($board, $row , $col - 1, $word, $index, $visited)
		) {
			return true;
		}
		$visited[$row][$col] =false;
	}
	return false;
}
```
## 机器人的运动范围(66) ##
```
/**
 * 遍历
 * 时间复杂度O()
 * 空间复杂度O(m*n)
 */
function exist($rows, $cols, $k) {
	if(!$rows) return false;
	if(!$cols) return false;
	$visited = [[]];
	return search($rows, $cols, 0, 0, $k, $visited);
}
function search($rows, $cols, $row, $col, $k, &$visited) {
	$count = 0;
	if(($row < 0 || $row >= $rows)
		|| ($col < 0 || $col >= $cols)
	) {
		return $count;
	}
	if((getDigitSum($row) + getDigitSum($col) <= $k) && (!isset($visited[$row][$col]) || !$visited[$row][$col])) {
		$visited[$row][$col] = true;
		$count += 1 
			+ search($rows, $cols, $row - 1, $col, $k, $visited)
			+ search($rows, $cols, $row, $col + 1, $k, $visited)
			+ search($rows, $cols, $row +1, $col, $k, $visited)
			+ search($rows, $cols, $row , $col - 1, $k, $visited)
		;
	}
	return $count;
}
function getDigitSum($value) {
	$sum = 0;
	while ($value) {
		$sum += $value % 10;
		$value = intval($value / 10);
	}
	return $sum;
}
```