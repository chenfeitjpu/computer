**切片**  

# 内容 #
## 使用 ##
**结构**  
- 指针 指向数组中slice指定的开始位置
- 长度 slice的长度 len()
- 容量 slice开始位置到数组的最后位置的长度 cap()

**声明**  
var name []type
name := make([]T, length, capacity)

**添加**
- append
- copy