**MySql**
- [定义](#定义)
- [内容](#内容)
  - [系统](#系统)
    - [变量](#变量)
    - [字符集和比较规则](#字符集和比较规则)
  - [数据类型](#数据类型)
  - [SQL](#sql)
    - [DDL](#ddl)
    - [DML](#dml)
    - [DQL](#dql)
    - [DCL](#dcl)
  - [查询](#查询)
    - [分类](#分类)
    - [运算符](#运算符)
    - [函数](#函数)
    - [视图](#视图)
  - [存储程序](#存储程序)
    - [语法](#语法)
    - [存储函数](#存储函数)
    - [存储过程](#存储过程)
    - [触发器](#触发器)
    - [事件](#事件)
  - [结构](#结构)
    - [记录结构](#记录结构)

# 定义 #
关系型数据库

# 内容 #
## 系统 ##
### 变量 ###
  - `show variables` 查看系统变量
  - `show status` 查看系统状态
  
### 字符集和比较规则 ###
1. 查看  
  + `show (character set | charset)` 查看字符集
  + `show collation` 查看比较规则
2. 级别
  + 服务器级别
    `character_set_server` 字符集  
    `collation_server` 比较规则   
  + 数据库级别
    ```
    create database 数据库名
    [[default] character set 字符集名称]
    [[default] collate 比较规则名称]

    alter database 数据库名
    [[default] character set 字符集名称]
    [[default] collate 比较规则名称]
    
    ```
  - 表级别
    ```
    create table 表名 (列的信息)
    [[default] character set 字符集名称]
    [collate 比较规则名称]]

    alter table 表名
    [[default] character set 字符集名称]
    [collate 比较规则名称]
    ```
  - 列级别
    ```
    CREATE TABLE 表名(
        列名 字符串类型 [CHARACTER SET 字符集名称] [COLLATE 比较规则名称]
    )

    ALTER TABLE 表名 MODIFY 列名 字符串类型 [CHARACTER SET 字符集名称] [COLLATE 比较规则名称]
    ```
3. 转换过程 
> + 客户端使用操作系统的字符集编码请求字符串，向服务器发送的是经过编码的一个字节串  
> + 服务器将客户端发送来的字节串采用character_set_client代表的字符集进行解码，将解码后的字符串再按照character_set_connection代表的字符集进行编码  
> + 如果character_set_connection代表的字符集和具体操作的列使用的字符集一致，则直接进行相应操作，否则的话需要将请求中的字符串从character_set_connection代表的字符集转换为具体操作的列使用的字符集之后再进行操作  
> + 将从某个列获取到的字节串从该列使用的字符集转换为character_set_results代表的字符集后发送到客户端  
> + 客户端使用操作系统的字符集解析收到的结果集字节串

## 数据类型 ##
  - **整型**  
    | 类型 | 取值范围 | 存储空间 |
    | :--- | :--- | :--- | 
    | **tinyint** | 无符号 0\~2⁸-1 &nbsp;有符号 -2⁷\~2⁷-1 | 1个字节 |
    | **smallint** | 无符号 0\~2¹⁶-1 &nbsp;有符号 -2¹⁵\~2¹⁵-1 | 2个字节 |
    | **mediumint** | 无符号 0\~2²⁴-1 &nbsp;有符号 -2²³\~2²³-1 | 3个字节 |
    | **int** | 无符号 0\~2³²-1 &nbsp;有符号 -2³¹\~2³¹-1 | 4个字节 |
    | **longint** | 无符号 0\~2⁶⁴-1 &nbsp;有符号 -2⁶³\~2⁶³-1 | 8个字节 |
  - **浮点数**
    | 类型 | 存储空间 |
    | :--- | :--- |
    | **float** | 4个字节 | 
    | **double** | 8个字节 |  
  - **定点数**
    | 类型 | 取值范围 | 存储空间 |
    | :--- | :--- | :--- |
    | **decimal(M,D)** | M 1\~65 D 0\~30 | 取决于M和D 
  - **时间和日期**
    | 类型 | 取值范围 | 存储空间 |
    | :--- | :--- | :--- |
    | **year** | 4位 1901~2155 &nbsp;2位 1970－2069 | 1个字节 |
    | **date** | '1000-01-01'~'9999-12-31' | 3个字节 |
    | **time** | '-838:59:59[.000000]'~'838:59:59[.000000]' | 3个字节+小数秒的存储空间 |
    | **datetime** | '1000-01-01 00:00:00[.000000]'~'9999-12-31 23:59:59[.999999]' | 5个字节+小数秒的存储空间 |
    | **timestamp** | '1970-01-01 00:00:01[.000000]'~'2038-01-19 03:14:07[.999999]' | 4个字节+小数秒的存储空间 |
  - **字符串**
    | 类型 | 最大长度 | 取值范围 | 存储空间 |
    | :--- | :--- | :--- | :--- |
    | **char(M)** | M个字符 | 0~255 | M×W |
    | **varchar(M)** | M个字符 | 1~65535 | L+1或2 |
    | **tinytext** | 2⁸-1个字节 |  | L+1个字节 |
    | **text** | 2¹⁶-1个字节 |  | L+2个字节 |
    | **mediumtext** | 2²⁴-1个字节 |  | L+3个字节 |
    | **longtext** | 2³²-1个字节 |  | L+4个字节 |
    | **enum** |  |  |  |
    | **set** |  |  |  | 
  - **二进制**
    | 类型 | 最大长度 | 取值范围 | 存储空间 |
    | :--- | :--- | :--- | :--- |
    | **bit(M)** | M个比特位 | 1\~64 | (M+7)/8个字节 | 
    | **binary(M)** | M个字节 | 0~255 | M个字节 | 
    | **varbinary(M)** | M个字节 | 1~65535 | L+1或2个字节 | 
    | **tinyblob** | 2⁸-1个字节 |  | L+1个字节 | 
    | **blob** | 2¹⁶-1个字节 |  | L+2个字节 | 
    | **mediumblob** | 2²⁴-1个字节 |  | L+3个字节 | 
    | **longblob** | 2³²-1个字节 |  | L+4个字节 | 

## SQL ##
### DDL ###
  - **database**
    - `show databases` 查看所有库
    - `create database dbname` 查看库定义  
    - `drop database dbname` 删除库
    - `use dbname` 选择库
  - **table**
    - `show tables` 查看所有表
    - `show create table tablename` 查看表定义
    - `desc tablename` 查看表描述
    - `create table tablename` 创建表
    - `alter table tablename [add column|modify column|alter column|change column|drop column|rename to]` 修改表
    - `drop table tablename` 删除表
  - **column**
    - `default` 默认值
    - `not null` 非空
    - `auto_increament` 自增
    - `zerofill` 零填充
    - `constraint` 约束
      - `primary key` 主键
      - `unique key` 唯一键
      - `foreign key` 外键
  
### DML ###
  - `insert into tablename values` 插入数据
  - `update tablename set` 修改数据 
  - `delete from tablename` 删除数据
  - 

### DQL ###
  - `select [distinct] [column] from tablename [where] [group by having] [order by] [limit start length]` 查询数据
  
### DCL ###

## 查询 ##
### 分类 ###
  - **简单查询**
    - `where`
    - `order by asc, desc`
    - `limit start length`
    - `distinct`
  - **分组查询**
    - `group by having`
  - **子查询**
  - **连接查询**
    - `inner join on`
    - `left join on`
    - `right join on`
  - **组合查询**
    - `union all`
    - `union`

### 运算符 ###
  - **算术** `+, -, *, /, %`
  - **比较** `\>, \>=, \<, \<=, =, !=, between and`
  - **逻辑** `and, or`
  - **匹配** `in, not in, is null, is not null`
  - **通配** `_, %`

### 函数 ###
  - **文本**
    - `left` 从左边取指定长度的子串
    - `right` 从右边取指定长度的子串
    - `length` 获取字符串长度
    - `upper` 大写格式
    - `lower` 小写格式
    - `ltrim` 去掉字符串左边空格
    - `rtrim` 去掉字符串右边空格
    - `substring` 字符串截取
    - `concat` 字符串拼接
  - **时间**
    - `now` 获取当前日期和时间
    - `curdate` 获取当前日期
    - `curtime` 获取当前时间
    - `date(datetime)` 提取日期
    - `date_add(datetime, interval value type)` 添加指定的时间间隔
    - `date_sub(datetime, interval value type)` 减去指定的时间间隔
    - `datediff(date, date)` 返回两个日期之间的天数
    - `date_format(datetime, format)` 格式化显示日期和时间
  - **数值**
    - `rand` 随机数
    - `mod` 取余
    - `abs` 绝对值
    - `pi` 圆周率
    - `exp` e的指定次方
    - `sqrt` 平方根
    - `sin` 正弦
    - `cos` 余弦
    - `tan` 正切
  - **聚集**
    - `count` 总数
    - `max` 最大值
    - `min` 最小值
    - `sum` 求和
    - `avg` 平均值

### 视图 ###
  - `show tables` 查看所有视图
  - `desc viewname` 查看视图描述
  - `show create view viewname` 查看视图定义
  - `create view viewname as select` 创建视图
  - `drop view viewname` 删除视图

## 存储程序 ##
### 语法 ###
  - **变量**
    - `declare name 类型 default value` 定义局部变量
    - `set name=value` 变量赋值
    - `into name, name` 多个变量赋值
    - `delimiter` 结束分隔符
  - **选择语句**
    ```
    if then  
    elseif then  
    else  
    end if;
    ```
  - **循环语句**
    ```
    while do  
    end while;
    ```
    ```
    repeat  
    until end repeat;
    ```
    ```
    loop  
    end loop;
    ```
  - **游标**
    - `declare cursorname cursor for select` 创建游标 
    - `declare continue handler for not found` 事件响应
    - `open cursorname` 打开游标  
    - `fetch cursorname into` 移动游标
    - `close cursorname` 关闭游标
  
### 存储函数 ###
  - `show function status like` 查看所有函数
  - `show create function functionname` 查看函数定义
  - ```
    create function functionname(参数名 数据类型, 参数名 数据类型)  
    returns 返回值类型  
    begin  
        函数体内容  
    end;
    ```
  - `drop function functionname` 删除函数

### 存储过程 ###
  - `show procedure status like` 查看所有存储过程
  - `show create procedure procedurename` 查看存储过程定义
  - ```
    create procedure procedurename([in|out|inout]参数名 数据类型)  
    begin  
    end
    ```
  - `drop procedure procedurename` 删除存储过程

### 触发器 ###
  - `show triggers` 查看所有触发器
  - `show create trigger triggername` 查看触发器定义
  - ```
    create trigger triggername  
    {before|after} on {insert|update|delete} on tablename  
    for each row  
    begin  
      {old|new}  
    end
    ``` 
  - `drop trigger triggername` 删除触发器
  
### 事件 ###
  - `show events` 查看所有事件
  - `show create event eventname` 查看事件定义
  - ```
    create event eventname  
    on schedual  
    {  
      at 某个确定的时间点  
      every 期望的时间间隔 [STARTS datetime][END datetime]  
    }  
    do  
    begin  
    end 
    ```
  - `drop event eventname` 删除事件

## 结构 ##
### 记录结构 ###
1. **compact**  
<table>
    <tr><td colspan="3">记录的额外信息</td><td>记录的真实数据</td></tr>
    <tr><td>变长字段长度列表</td><td>NULL值列表</td><td>记录头信息</td><td>列的值</td></tr>
</table>

  - **变长字段长度列表**
    > 1.逆序排列  
    > 2.可变字段允许存储的最大字节数(M×W)超过255字节并且真实存储的字节数(L)超过127字节，则使用2个字节，否则使用1个字节
  
  - **NULL值列表**
    > 1.逆序排列
    > 2.NULL值列表必须用整数个字节的位表示
  - **记录头信息** 固定5个字节, 40个二进制位  
    | 名称 | 大(单位：bit) | 描述 |
    | :---: | :---: | :---: |
    | 预留位1 | 1 | 没有使用 |
    | 预留位2 | 1 | 没有使用 |
    | delete_mask | 1 | 标记该记录是否被删除 |
    | min_rec_mask | 1 | B+树的每层非叶子节点中的最小记录都会添加该标记 |
    | n_owned | 4 | 表示当前记录拥有的记录数 |
    | heap_no | 13 | 表示当前记录在记录堆的位置信息 |
    | record_type | 3 | 0表示普通记录，1表示B+树非叶子节点记录，2表示最小记录，3表示最大记录 |
    | next_record | 16 | 表示下一条记录的相对位置 |
    
2. **redundant**
3. **dynamic**
4. **compressed**
