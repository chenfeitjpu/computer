**Linux**
- [内容](#内容)

# 内容 #
```
帮助命令
- man command
- info command 
- help command
- whatis command
- whereis command
- which command

文件及目录管理
- mkdir
- touch
- rm
- mv
- cp
- cd 
- ls
- chown
- chmod
- ln [expression] [source] [destination]

目录|文件查找  
find [path] [expression]  
-name 名称查找
-type 类型搜索
-size 大小搜索
-atime 访问时间
-mtime 修改时间
-ctime 变化时间
-perm 权限查找
-user 用户查找
-regex 正则查找   
! 否定参数
-maxdepth 搜索深度
-exec {} 执行动作
-print 定界符

查看文件内容
- cat [expression] [filename]
- head [expression] [filename]
- tail [expression] [filename]

查找文件内容
grep [expression] [pattern] [filename]  
-o 只输出匹配的文本行
-v 只输出没有匹配的文本行
-c 统计文件中包含文本的次数
-n 打印匹配的行号
-i 搜索时忽略大小写
-l 只打印文件名
-r 多级目录中对文本递归搜索
-e 多个模式

args
- -n 指定输出为多行
- -I {} 指定替换字符串

sort  
-n 按数字进行排序
-d 按字典序进行排序
-r 逆序排序
-k N 指定按第N列排序

uniq消除重复行  
-c 统计各行在文件中出现的次数
-d 找出重复行

tr
-d 删除字符
-c 求补集
-s 压缩文本中出现的重复字符

cut
-b 以字节为单位
-c 以字符为单位
-f 以字段为单位（使用定界符）
N- 第N个字段到结尾
-M 第1个字段为M
N-M N到M个字段

paste  
-d指明定界符

wc
-l 统计行数
-w 统计单词数
-c 统计字符数

sed 
- 首处替换 sed 's/text/replace_text/' file  
- 全局替换 sed 's/text/replace_text/g' file
- 移除空白行 sed '/^$/d' file
- 变量转换 echo this is en example | sed 's/[a-z]*/[&]/g'
- 子串匹配标记 echo hello1 | sed 's/hello\([0-9]\)/\1/'

awk
awk 'BEGIN{statements} {statements2} END{statements}'
- print
- NR 表示记录数量，在执行过程中对应当前行号
- NF 表示字段数量，在执行过程总对应当前行的字段数
- $0 这个变量包含执行过程中当前行的文本内容
- $1 第一个字段的文本内容
- $2 第二个字段的文本内容
- for(i in array)

磁盘管理
- df -h
- du -sh
- tar -zcvf *.tar 路径
- tar -zxvf *.tar -C 路径

进程管理工具
- ps -ef
- top
- kill
- lsof

网络工具
- netstat -ntl | grep prot
```






