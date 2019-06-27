* [买卖股票的最佳时机(122)](#买卖股票的最佳时机122)

# 买卖股票的最佳时机(122) #
```
function maxProfit($prices) {
    $len = count($prices);
    if($len <= 2) return 0;
    $profit = 0;
    for($i = 1; $i < $len; $i++) {
        if($prices[$i] > $prices[$i -1]) {
            $profit += $prices[$i] - $prices[$i - 1];
        }
    }
    return $profit;
}
```