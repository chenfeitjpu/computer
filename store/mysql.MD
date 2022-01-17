**MySql**
- [定义](#定义)
- [内容](#内容)
  - [系统](#系统)
    - [变量](#变量)
    - [状态](#状态)
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
    - [InnoDB记录结构](#innodb记录结构)
      - [行格式](#行格式)
      - [分类](#分类-1)
        - [Compact](#compact)
        - [Redundant](#redundant)
        - [Dynamic](#dynamic)
        - [Compressed](#compressed)
      - [行溢出](#行溢出)
    - [InnoDB数据页结构](#innodb数据页结构)
      - [File Header](#file-header)
      - [Page Header](#page-header)
      - [Infimun + Supremum](#infimun--supremum)
      - [User Records](#user-records)
      - [Page Directory](#page-directory)
      - [File Trailer](#file-trailer)
    - [InnoDB索引结构](#innodb索引结构)
    - [数据目录](#数据目录)
    - [InnoDB表空间](#innodb表空间)

# 定义 #
关系型数据库

# 内容 #
## 系统 ##
### 变量 ###
  - `show variables` 查看系统变量
  
### 状态 ###
  - `show status` 查看系统状态
  
### 字符集和比较规则 ###
**查看**  
  + `show (character set | charset)` 查看字符集
  + `show collation` 查看比较规则
  
**级别**
  + 服务器级别  
    *查看*  
    `show variables like 'character_set_server'`  
    `show variables like 'collation_server'`

    *设置*  
    `set character_set_server='utf8mb4'`  
    `set collation_server='utf8mb4_0900_ai_ci'`

  + 数据库级别  
    *查看*  
    `show create database 数据库名`
    
    *设置*  
    ```
    create database 数据库名
    [[default] character set 字符集名称]
    [[default] collate 比较规则名称]

    alter database 数据库名
    [[default] character set 字符集名称]
    [[default] collate 比较规则名称]
    ```

  - 表级别  
    *查看*  
    `show create table 表名`

    *设置*  
    ```
    create table 表名 (列的信息)
    [[default] character set 字符集名称]
    [collate 比较规则名称]]

    alter table 表名
    [[default] character set 字符集名称]
    [collate 比较规则名称]
    ```
    
  - 列级别  
    *查看*  
    `show create table 表名`

    *设置*
    ```
    CREATE TABLE 表名(
        列名 字符串类型 [CHARACTER SET 字符集名称] [COLLATE 比较规则名称]
    )

    ALTER TABLE 表名 MODIFY 列名 字符串类型 [CHARACTER SET 字符集名称] [COLLATE 比较规则名称]
    ```
    
**转换过程** 
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
    | **year** | 4位 1901~2155 | 1个字节 |
    | **date** | '1000-01-01'~'9999-12-31' | 3个字节 |
    | **time** | '-838:59:59[.000000]'~'838:59:59[.000000]' | 3个字节+小数秒的存储空间 |
    | **datetime** | '1000-01-01 00:00:00[.000000]'~'9999-12-31 23:59:59[.999999]' | 5个字节+小数秒的存储空间 |
    | **timestamp** | '1970-01-01 00:00:01[.000000]'~'2038-01-19 03:14:07[.999999]' | 4个字节+小数秒的存储空间 |

    | 保留的小数秒位数 | 额外需要的存储空间要 |
    | :--- | :--- |
    | 1或2 | 1字节 |
    | 3或4 | 2字节 |
    | 5或6 | 3字节 |
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
    | **bit(M)** | M个比特位 | 1~64 | (M+7)/8个字节 | 
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
    - `create database 库名` 创建库
    - `drop database 库名` 删除库
    - `use 库名` 选择库
  
  - **table**
    - `show tables` 查看所有表
    - `show create table 表名` 查看表定义
    - `desc 表名` 查看表描述
    - `create table 表名` 创建表
    - `alter table 表名 [add column|modify column|alter column|change column|drop column|rename to]` 修改表
    - `drop table 表名` 删除表
  
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
  - `insert into 表名 values` 插入数据
  - `update 表名 set` 修改数据 
  - `delete from 表名` 删除数据
  - 

### DQL ###
  - `select [distinct] [column] from tablename [where] [group by having] [order by] [limit offset length]` 查询数据
  
### DCL ###
  - `grant 权限 on 库名.表名 to 用户@主机 identified by 密码` 授权
  - `revoke 权限 on 库名.表名 to 用户@主机` 回收权限  

## 查询 ##
### 分类 ###
  - *简单查询*
    - `where`
    - `order by asc, desc`
    - `limit offset length`
    - `distinct`
  
  - *分组查询*
    - `group by having`
  
  - *子查询*
  
  - *连接查询*
    - `inner join on`
    - `left join on`
    - `right join on`
     
  - *组合查询*
    - `union all`
    - `union`

### 运算符 ###
  - *算术*  
    `+, -, *, /, %`
  - *比较*  
    `\>, \>=, \<, \<=, =, !=, between and`
  - *逻辑*  
    `and, or`
  - *匹配*  
    `in, not in, is null, is not null`
  - *通配*  
    `_, %`

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
  - `desc 视图名` 查看视图描述
  - `show create view 视图名` 查看视图定义
  - `create view 视图名 as select` 创建视图
  - `drop view 视图名` 删除视图

## 存储程序 ##
### 语法 ###
  - *变量*
    - `declare name 类型 default value` 定义局部变量
    - `set name=value` 变量赋值
    - `into name, name` 多个变量赋值
    - `delimiter` 结束分隔符
  
  - *选择语句*
    ```
    if then  
    elseif then  
    else  
    end if;
    ```

  - *循环语句*
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
  - *游标*
    - `declare 游标名 cursor for select` 创建游标 
    - `declare continue handler for not found` 事件响应
    - `open 游标名` 打开游标  
    - `fetch 游标名 into` 移动游标
    - `close 游标名` 关闭游标
  
### 存储函数 ###
  - `show function status like` 查看所有函数
  - `show create function 函数名` 查看函数定义
  - ```
    create function 函数名(参数名 数据类型, 参数名 数据类型)  
    returns 返回值类型  
    begin  
        函数体内容  
    end;
    ```
  - `drop function 函数名` 删除函数

### 存储过程 ###
  - `show procedure status like` 查看所有存储过程
  - `show create procedure 存储过程名` 查看存储过程定义
  - ```
    create procedure 存储过程名([in|out|inout]参数名 数据类型)  
    begin  
    end
    ```
  - `drop procedure 存储过程名` 删除存储过程

### 触发器 ###
  - `show triggers` 查看所有触发器
  - `show create trigger 触发器名` 查看触发器定义
  - ```
    create trigger 触发器名  
    {before|after} on {insert|update|delete} on 表名  
    for each row  
    begin  
      {old|new}  
    end
    ``` 
 - `drop trigger 触发器名` 删除触发器
  
### 事件 ###
  - `show events` 查看所有事件
  - `show create event 事件名` 查看事件定义
  - ```
    create event 事件名  
    on schedual  
    {  
      at 某个确定的时间点  
      every 期望的时间间隔 [STARTS datetime][END datetime]  
    }  
    do  
    begin  
    end 
    ```
  - `drop event 事件名` 删除事件

## 结构 ##
### InnoDB记录结构 ###
#### 行格式 ####
  + 查看  
    `SHOW TABLE STATUS LIKE 表名\G`
  + 设置  
    ```
    CREATE TABLE 表名 (列的信息) ROW_FORMAT=行格式名称

    ALTER TABLE 表名 ROW_FORMAT=行格式名称
    ```  

#### 分类 ####
##### Compact #####
  <table>
      <tr><td colspan="3">记录的额外信息</td><td>记录的真实数据</td></tr>
      <tr><td>变长字段长度列表</td><td>NULL值列表</td><td>记录头信息</td><td>列的值</td></tr>
  </table>

  + 变长字段长度列表
    - 逆序排列  
    - 可变字段允许存储的最大字节数(M×W)超过255字节并且真实存储的字节数(L)超过127字节，则使用2个字节，否则使用1个字节  
    - 使用字节的第一个二进制位作为标志位  
    如果该字节的第一个位为0，那该字节就是一个单独的字段长度  
    如果该字节的第一个位为1，那该字节就是半个字段长度

  + NULL值列表
    - 逆序排列  
    - NULL值列表必须用整数个字节的位表示

  + 记录头信息
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

    - 固定5个字节, 40个二进制位    

  + 记录的真实数据  
    - 隐藏列  
      | 列名 | 是否必须 | 占用空间 | 描述 |
      | :---: | :---: | :---: | :---: |
      | DB_ROW_ID | 否 | 6字节 | 行ID，唯一标识一条记录 |
      | DB_TRX_ID | 是 | 6字节 | 事务ID |
      | DB_ROLL_PTR | 是 | 7字节 | 回滚指针
      * InnoDB表对主键的生成策略：优先使用用户自定义主键作为主键，如果用户没有定义主键，则选取一个Unique键作为主键，如果表中连Unique键都没有定义的话，则InnoDB会为表默认添加一个名为row_id的隐藏列作为主键
    - NULL值处理
      * 不存储 
    - CHAR(M)列的存储格式
      * 当列采用的是定长字符集时，该列占用的字节数不会被加到变长字段长度列表，而如果采用变长字符集时，该列占用的字节数也会被加到变长字段长度列表  
      * 变长字符集的CHAR(M)类型的列要求至少占用M个字节

##### Redundant #####
  <table>
      <tr><td colspan="2">记录的额外信息</td><td>记录的真实数据</td></tr>
      <tr><td>字段长度偏移列表</td><td>记录头信息</td><td>列的值</td></tr>
  </table>

  + 字段长度偏移列表
    - 采用两个相邻数值的差值来计算各个列值的长度  
    - 偏移量值的第一个比特位作为是否为NULL的依据

  + 记录头信息
    | 名称 | 大(单位：bit) | 描述 |
    | :---: | :---: | :---: |
    | 预留位1 | 1 | 没有使用 |
    | 预留位2 | 1 | 没有使用 |
    | delete_mask | 1 | 标记该记录是否被删除 |
    | min_rec_mask | 1 | B+树的每层非叶子节点中的最小记录都会添加该标记 |
    | n_owned | 4 | 表示当前记录拥有的记录数 |
    | heap_no | 13 | 表示当前记录在记录堆的位置信息 |
    | n_field | 10 | 表示记录中列的数量 |
    | 1byte_offs_flag | 1 | 标记字段长度偏移列表中每个列对应的偏移量是使用1字节还是2字节表示的 |
    | next_record | 16 | 表示下一条记录的相对位置 |

    - 固定6个字节, 48个二进制位 
    - `1byte_offs_flag` 记录的真实数据占用的存储空间大小大于127, 使用2个字节来表示该列对应的偏移量
    
  + 记录的真实数据
    - NULL值处理 
      * 如果存储NULL值的字段是定长类型的，则NULL值也将占用记录的真实数据部分，并把该字段对应的数据使用0x00字节填充  
      * 如果该存储NULL值的字段是变长类型的，则不在记录的真实数据处占用任何存储空间
    - CHAR(M)列的存储格式
      * 占用空间M×W个字节
       
##### Dynamic #####
格式类似于COMPACT行格式，处理行溢出数据时把所有的字节都存储到其他页面中，只在记录的真实数据处存储其他页面的地址

##### Compressed #####
格式类似于Dynamic，采用压缩算法对页面进行压缩

#### 行溢出 ####
一个页一般是16KB，当记录中的数据太多，当前页放不下的时候，会把多余的数据存储到其他页中，这种现象称为行溢出

### InnoDB数据页结构 ###
  | 名称 | 中文名 | 占用空间 | 简单描述 |
  | :---: | :---: | :---: | :---: |
  | File Header | 文件头部 | 38字节 | 页的一些通用信息 |
  | Page Header | 页面头部 | 56字节 | 数据页专有的一些信息 |
  | Infimun + Supremum | 最小记录和最大记录 | 26字节 | 两个虚拟的行记录 |
  | User Records | 用户记录 | 不确定 | 实际存储的行记录内容 |
  | Free Space | 空闲空间 | 不确定 | 页中尚未使用的空间 |
  | Page Directory | 页面目录 | 不确定 | 页中的某些记录的相对位置 |
  | File Trailer | 文件尾部 | 8字节 | 校验页是否完整 |

#### File Header ####
  | 名称 | 占用空间大小 | 描述 |
  | :---: | :---: | :---: |
  | FIL_PAGE_SPACE_OR_CHKSUM | 4字节 | 页的校验和 |
  | FIL_PAGE_OFFSET | 4字节 | 页号 |
  | FIL_PAGE_PREV | 4字节 | 上一页 |
  | FIL_PAGE_NEXT | 4字节 | 下一页 |
  | FIL_PAGE_LSN | 8字节 | 页面被最后修改时对应的日志序列位置 |
  | FIL_PAGE_TYPE | 2字节 | 该页的类型 |
  | FIL_PAGE_FILE_FLUSH_LSN | 8字节 | 仅在系统表空间的一个页中定义，代表文件至少被刷新到了对应的LSN值 |
  | FIL_PAGE_ARCH_LOG_NO_OR_SPACE_ID | 4字节 | 页属于哪个表空间 |

#### Page Header ####
  | 名称 | 占用空间大小 | 描述 |
  | :---: | :---: | :---: |
  | PAGE_N_DIR_SLOTS | 2字节 | 在页目录中的槽数量 |
  | PAGE_HEAP_TOP | 2字节 | 还未使用的空间最小地址，也就是说从该地址之后就是Free Space |
  | PAGE_N_HEAP | 2字节 | 本页中的记录的数量（包括最小和最大记录以及标记为删除的记录） |
  | PAGE_FREE | 2字节 | 第一个已经标记为删除的记录地址（各个已删除的记录通过next_record也会组成一个单链表，这个单链表中的记录可以被重新利用） |
  | PAGE_GARBAGE | 2字节 | 已删除记录占用的字节数 |
  | PAGE_LAST_INSERT | 2字节 | 最后插入记录的位置 |
  | PAGE_DIRECTION | 2字节 | 记录插入的方向 |
  | PAGE_N_DIRECTION | 2字节 | 一个方向连续插入的记录数量 |
  | PAGE_N_RECS | 2字节 | 该页中记录的数量（不包括最小和最大记录以及被标记为删除的记录） |
  | PAGE_MAX_TRX_ID | 8字节 | 修改当前页的最大事务ID，该值仅在二级索引中定义 |
  | PAGE_LEVEL | 2字节 | 当前页在B+树中所处的层级 |
  | PAGE_INDEX_ID | 8字节 | 索引ID，表示当前页属于哪个索引 |
  | PAGE_BTR_SEG_LEAF | 10字节 | B+树叶子段的头部信息，仅在B+树的Root页定义 |
  | PAGE_BTR_SEG_TOP | 10字节 | B+树非叶子段的头部信息，仅在B+树的Root页定义 |

  + **PAGE_DIRECTION**  
    假如新插入的一条记录的主键值比上一条记录的主键值大，我们说这条记录的插入方向是右边，反之则是左边
  + **PAGE_N_DIRECTION**  
    假设连续几次插入新记录的方向都是一致的，InnoDB会把沿着同一个方向插入记录的条数记下来

#### Infimun + Supremum ####

#### User Records ####
  | 名称 | 大小（单位：bit） | 描述 |
  | :---: | :---: | :---: |
  | 预留位1 | 1 | 没有使用 |
  | 预留位2 | 1 | 没有使用 |
  | delete_mask | 1 | 标记该记录是否被删除 |
  |  min_rec_mask | 1 | B+树的每层非叶子节点中的最小记录都会添加该标记 |
  | n_owned | 4 | 表示当前记录拥有的记录数 |
  | heap_no | 13 | 表示当前记录在记录堆的位置信息 |
  | record_type | 3 | 表示当前记录的类型，0表示普通记录，1表示B+树非叶节点记录，2表示最小记录，3表示最大记录 |
  | next_record | 16 | 表示下一条记录的相对位置 |  

  + **delete_mask**  
    这个属性标记着当前记录是否被删除，占用1个二进制位，值为0的时候代表记录并没有被删除，为1的时候代表记录被删除掉了

    所有被删除掉的记录都会组成一个所谓的垃圾链表，在这个链表中的记录占用的空间称之为所谓的可重用空间
  + **min_rec_mask**  
    B+树的每层非叶子节点中的最小记录都会添加该标记 
  + **n_owned**  
    该记录拥有多少条记录
  + **heap_no**  
    当前记录在本页中的位置
  + **record_type**
    0表示普通记录，1表示B+树非叶节点记录，2表示最小记录，3表示最大记录
  + **next_record**  
    当前记录的真实数据到下一条记录的真实数据的地址偏移量

    下一条记录指得并不是按照我们插入顺序的下一条记录，而是按照主键值由小到大的顺序的下一条记录

#### Page Directory ####
  + 目录的生成  
    - 将所有正常的记录（包括最大和最小记录，不包括标记为已删除的记录）划分为几个组
    - 每个组的最后一条记录（也就是组内最大的那条记录）的头信息中的n_owned属性表示该记录拥有多少条记录，也就是该组内共有几条记录
    - 将每个组的最后一条记录的地址偏移量单独提取出来按顺序存储到靠近页的尾部的地方

  + 记录分组过程
    > 分组规定：对于最小记录所在的分组只能有 1 条记录，最大记录所在的分组拥有的记录条数只能在 1~8 条之间，剩下的分组中记录的条数范围只能在是 4~8 条之间
    - 初始情况下一个数据页里只有最小记录和最大记录两条记录，它们分属于两个分组
    - 之后每插入一条记录，都会从页目录中找到主键值比本记录的主键值大并且差值最小的槽，然后把该槽对应的记录的n_owned值加1，表示本组内又添加了一条记录，直到该组中的记录数等于8个
    - 在一个组中的记录数等于8个后再插入一条记录时，会将组中的记录拆分成两个组，一个组中4条记录，另一个5条记录。这个过程会在页目录中新增一个槽来记录这个新增分组中最大的那条记录的偏移量

  #### File Trailer ####
    + 前4个字节代表页的校验和
    + 后4个字节代表页面被最后修改时对应的日志序列位置（LSN）

### InnoDB索引结构 ###
  + 聚簇索引查找过程
    - 确定目录项记录页
    - 通过目录项记录页确定用户记录所在的页
    - 在用户记录的页中定位到具体的记录

  + 二级索引查找过程
    - 确定目录项记录页
    - 通过目录项记录页确定用户记录所在的页
    - 在用户记录的页中定位到具体的记录
    - 根据主键值去聚簇索引中再查找一遍完整的用户记录
  
  + 索引操作
    - 添加
      ```
      CREATE TALBE 表名 (
          各种列的信息 ··· , 
          [KEY|INDEX] 索引名 (需要被索引的单个列或多个列)
      )
      ```
      `ALTER TABLE 表名 ADD [INDEX|KEY] 索引名 (需要被索引的单个列或多个列);` 

    - 删除
      `ALTER TABLE 表名 DROP [INDEX|KEY] 索引名`  

  + 索引使用
    - 全值匹配
    - 匹配左边的列
    - 匹配列前缀
    - 匹配范围值
    - 用于排序
    - 用于分组
  
  + 注意事项
    - 只为用于搜索、排序或分组的列创建索引
    - 为列的基数大的列创建索引
    - 索引列的类型尽量小
    - 可以只对字符串值的前缀建立索引
    - 只有索引列在比较表达式中单独出现才可以适用索引
    - 为了尽可能少的让聚簇索引发生页面分裂和记录移位的情况，建议让主键拥有AUTO_INCREMENT属性
    - 定位并删除表中的重复和冗余索引
    - 尽量使用覆盖索引进行查询，避免回表带来的性能损耗

### 数据目录 ###
  + 查看
    `SHOW VARIABLES LIKE 'datadir'`
  
  + 结构
    - 数据库在文件系统中的表示
    -  

### InnoDB表空间 ###
