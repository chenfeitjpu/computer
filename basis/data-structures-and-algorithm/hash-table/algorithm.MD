* [有效的字母异位词](#有效的字母异位词)

# 有效的字母异位词 #
```
function isAnagram($s, $t) {
    $slen = strlen($s);
    $tlen = strlen($t);
    if($slen != $tlen) return false;
    $map = [];
    for($i = 0; $i < $slen; $i++) {
        isset($map[$s[$i]]) ? $map[$s[$i]]++ : $map[$s[$i]] = 1;
        isset($map[$t[$i]]) ? $map[$t[$i]]-- : $map[$t[$i]] = -1;
    }
    foreach ($map as $k => $v) {
        if($v) {
            return false;
        }
    }
    return true;
}
```