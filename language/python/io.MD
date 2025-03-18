**IO操作**
- [文件操作](#文件操作)
  - [文本](#文本)
  - [CSV](#csv)
  - [Excel](#excel)
    - [xls](#xls)
    - [xlsx](#xlsx)
  - [Word](#word)
  - [PowerPoint](#powerpoint)
  - [PDF](#pdf)

## 文件操作 ##
### 文本 ###
**模式**
- 基本模式
  ```
  - r  # 只读	
  - w  # 覆盖写入	
  - a  # 追加写
  - x  # 独占创建
  ```
- 二进制模式
  ```
  - rb  # 以二进制模式读取	
  - wb  # 以二进制模式写入	
  - ab  # 以二进制模式追加	
  - xb  # 以二进制模式创建
  ```
- 读写模式
  ```
  r+	# 读 + 写	修改文件， 文件必须存在
  w+	# 读 + 写（清空文件）覆盖写入
  a+	# 读 + 追加写入	追加内容
  rb+   # 二进制读 + 写	二进制文件
  wb+	# 二进制读 + 写（清空）	二进制文件
  ab+	# 二进制读 + 追加写入
  ```

**读写**
- 读取所有
  ```
  file = open('example.txt', 'r', encoding='utf-8')
  print(file.read())
  file.close()
  ```
- 逐行读取
  ```
  file = open('example.txt', 'r', encoding='utf-8')
  for line in file:  # 逐行读取
      print(line, end='')
  file.close()
  
  file = open('example.txt', 'r', encoding='utf-8')
  lines = file.readlines() # 一次性读取全部
  for line in lines:
      print(line, end='')
  file.close()
  ```
- 写入
  ```
  file = open('example.txt', 'a', encoding='utf-8')
  file.write('\n标题：《致橡树》')
  file.write('\n作者：舒婷')
  file.write('\n时间：1977年3月')
  file.close()
  ```

### CSV ###
- 写入
  ```
  with open('scores.csv', 'w') as file:
      writer = csv.writer(file)
      writer.writerow(['姓名', '语文', '数学', '英语'])
      names = ['关羽', '张飞', '赵云', '马超', '黄忠']
      for name in names:
          scores = [str(random.randrange(50, 101)) for _ in range(3)]
          scores.insert(0, name)
          writer.writerow(scores)
  ```
- 读取
  ```
  with open('scores.csv', 'r') as file:
      reader = csv.reader(file)
      for data_list in reader:
          print(reader.line_num, end='\t')
          for elem in data_list:
              print(elem, end='\t')
  ```

### Excel ###

#### xls ####
**安装**
```
pip install xlwt xlrd xlutils
```

**读取**

**写入**

#### xlsx ####
**安装**  
```
pip install openpyxl
```

**读取**  

**写入**  

### Word ###
**安装**
```
pip install python-docx
```

**读取**

**写入**

### PowerPoint ###
**安装**
```
pip install python-pptx
```

**读取**

**写入**

### PDF ###
**安装**
```
pip install PyPDF2
```

**读取**

**写入**

