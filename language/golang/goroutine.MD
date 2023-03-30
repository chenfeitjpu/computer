**协程**  
- [内容](#内容)
  - [控制](#控制)

# 内容 #
## 控制 ##
**同步控制**  
```
func main() {
	cha := make(chan struct{}, 1)
	chb := make(chan struct{}, 1)
	chc := make(chan struct{}, 1)

	wg := &sync.WaitGroup{}
	wg.Add(3)
	cha <- struct{}{}

	go func() {
		print("a", cha, chb, wg)
	}()
	go func() {
		print("b", chb, chc, wg)
	}()
	go func() {
		print("c", chc, cha, wg)
	}()
	wg.Wait()
}

func print(char string, cur, next chan struct{}, wg *sync.WaitGroup) {
	defer wg.Done()
	for i := 0; i < 10; i++ {
		<-cur
		fmt.Println(char)
		next <- struct{}{}
	}
}
```

**数量控制**  
*有缓冲channel*  
```
wg := sync.WaitGroup{}
ch := make(chan struct{}, 3)
for i := 0; i < 10; i++ {
    wg.Add(1)
    ch <- struct{}{}
    go func(i int) {
        defer wg.Done()
        fmt.Printf("goroutine: %d, 协程数量: %d\n"+
            "", i, runtime.NumGoroutine())
        <-ch
    }(i)
}
wg.Wait()
```

*无缓冲channel*  
```
ch := make(chan struct{})
wg := &sync.WaitGroup{}
for i := 0; i < 3; i++ {
    go func(i int) {
        for range ch {
            fmt.Printf("goroutine: %d, total: %d\n", i, runtime.NumGoroutine())
            wg.Done()
        }
    }(i)
}
for i := 0; i < 10; i++ {
    wg.Add(1)
    ch <- struct{}{}
}
wg.Wait()
```

**超时控制**  
*创建有缓冲区的channel*  

*创建无缓冲区的channel*  

