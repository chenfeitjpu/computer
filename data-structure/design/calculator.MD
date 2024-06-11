**计算器**
- [定义](#定义)
- [实现](#实现)
- [使用](#使用)

# 定义 #
```
基本计算器
```

# 实现 # 
<details>
<summary>代码</summary>
<prv>
<code>

```
func calculate(s string) int {
	s = strings.Replace(s, " ", "", -1)
	optLevel := map[byte]int{
		'+': 1,
		'-': 1,
		'*': 2,
		'/': 2,
	}
	nums, opts := []int{0}, make([]byte, 0)
	for i, length := 0, len(s); i < length; i++ {
		char := s[i]
		switch {
		case char == '(':
			opts = append(opts, char)
		case char == ')':
			for len(opts) > 0 {
				lastOpt := opts[len(opts)-1]
				if lastOpt == '(' {
					opts = opts[:len(opts)-1]
				} else {
					cal(&nums, &opts)
				}
			}
		case isDigit(char):
			num, j := 0, i
			for ; j < length && isDigit(s[j]); j++ {
				num = num*10 + int(s[j]-'0')
			}
			i = j - 1
			nums = append(nums, num)
		default:
			if i > 0 && s[i-1] == '(' && char == '-' {
				nums = append(nums, 0)
			}
			for len(opts) > 0 {
				lastOpt := opts[len(opts)-1]
				if lastOpt == '(' || optLevel[lastOpt] < optLevel[char] {
					break
				}
				cal(&nums, &opts)
			}
			opts = append(opts, char)
		}
	}
	for len(opts) > 0 {
		cal(&nums, &opts)
	}
	return nums[len(nums)-1]
}

func cal(nums *[]int, opts *[]byte) {
	numList, optList := *nums, *opts
	numLen, optLen := len(numList), len(optList)
	if numLen < 2 || optLen < 1 {
		return
	}
	num2, num1, numList := numList[numLen-1], numList[numLen-2], numList[:numLen-2]
	opt, optList := optList[optLen-1], optList[:optLen-1]
	num := 0
	switch opt {
	case '+':
		num = num1 + num2
	case '-':
		num = num1 - num2
	case '*':
		num = num1 * num2
	case '/':
		num = num1 / num2
	}
	numList = append(numList, num)
	*nums, *opts = numList, optList
}

func isDigit(char byte) bool {
	return '0' <= char && char <= '9'
}
```
</code>
</pre>
</details>

<details>
<summary>代码</summary>
<pre>
<code>

```
func calculate(s string) int {
	i := 0
	return cal(s, &i)
}

func cal(s string, i *int) int {
	nums, length := []int{0}, len(s)
	var (
		sign byte = '+'
		num       = 0
	)
	for ; *i < length; *i++ {
		char := s[*i]
		if char == '(' {
			*i++
			num = cal(s, i)
		}
		if isDigit(char) {
			num = num*10 + int(char-'0')
		}
		if !isDigit(char) && char != ' ' || *i == length-1 {
			switch sign {
			case '+':
				nums = append(nums, num)
			case '-':
				nums = append(nums, -num)
			case '*':
				nums[len(nums)-1] = nums[len(nums)-1] * num
			case '/':
				nums[len(nums)-1] = nums[len(nums)-1] / num
			}
			sign = char
			num = 0
		}
		if char == ')' {
			break
		}

	}
	sum := 0
	for _, num := range nums {
		sum += num
	}
	return sum
}

func isDigit(char byte) bool {
	return '0' <= char && char <= '9'
}
```
</code>
</pre>
</details>

# 使用 #
```
应用
- LeetCode
  - 224.基本计算器
  - 227.基本计算器 II
```
