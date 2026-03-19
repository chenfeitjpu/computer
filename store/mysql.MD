**MySQL**
- [简介](#简介)
- [查询](#查询)
- [事务](#事务)
- [日志](#日志)
- [锁](#锁)
- [内存管理](#内存管理)
- [集群](#集群)

## 简介
```
三范式
- 1NF  字段必须原子化，每一列都是不可再分的单一值
- 2NF  消除对主键的部分依赖，非主键字段必须完全依赖主键
- 3NF  消除非主键之间的传递依赖，非主键字段不能依赖其他非主键字段

字符集转换过程
多次字符集转换，确保解析一致，比较一致，返回一致
- 客户端编码
- 服务端按`character_set_client`解码
- 转`character_set_connection`
  - 灵活性，不同连接可以使用不同的SQL语义
  - 稳定性，同一连接内SQL语义不变
- 转列字符集，保证比较一致性
- 转`character_set_results`返回

查询顺序
from -> join -> on-> where -> group by -> having -> select -> order by -> limit

请求过程
连接器 -> 解析器 -> 优化器 -> 执行器 -> 存储引擎

数据类型
- 整型  tinyint、smallint、mediumint、int、bigint
  - int(M)  M是显示宽度，只在设置zerofill且数字宽度不足M的时候，会显示00XXX
- 浮点数  float(M,D)、double(M,D)  
- 定点数  decimal(M,D) 
- 时间和日期  year、date、time、datetime、timestamp
  - timestamp(受时区影响)
    - 默认值
      - default current_timestmap  插入当前时间
      - on update current_timestamp  更新当前时间
    - timestamp只能表示1970-2038年
    - timestmp必须显式地设置时区，不要使用默认(系统时区)，否则存在性能问题
- 字符串  char(M)、varchar(M)、tinytext、text、mediumtext、longtext、enum、set
  - char(M)  M是字符数，占用M*W(某个字符集编码一个字符最多需要的字节)个字节，剩余空间会用空格字符填充
  - varchar(M)  M是字符数，占用空间字符串长度(1或者2个字节)+字符串个字节
    - varchar(50) vs varchar(100)
      - 磁盘占用  磁盘占用空间大小是一样的
      - 索引占用  索引大小会使用定义长度  
      - 内存占用  排序、临时表(memory引擎是定长行结构)会使用定义长度
- 二进制字符串  bit(M)、binary(M)、varbinary(M)、tinyblob、blob、mediumblob、longblob

engine  
- InnoDB  支持事务、行级锁、外键，适用于高并发读写的场景
- MyISAM  存储空间小、读取性能好，适用于大量读的场景
- MEMORY  基于哈希索引，存储在内存，用于临时表 

column
- `auto_increament` 自增
  - 一个表中最多有一个具有AUTO_INCREMENT属性的列
  - 具有AUTO_INCREMENT属性的列必须建立索引  
  - 拥有AUTO_INCREMENT属性的列就不能再通过DEFAULT来指定默认值
- `zerofill` 零填充
  - 该列必须是整数类型的
  - 该列必须有zerofill(会自动添加unsigned)的属性
  - 该列的实际值的位数必须小于显示宽度  

SQL
DDL、DML、DQL、DCL、TCL   
```

## 查询
```
查询
- 单表  `select * from table [where] [group by column having] [order by column] [limit]`
- 连接查询
  - `inner join`  内连接
  - `left join`  左外连接
  - `right join`  右外连接
- 子查询   
  - 分类
    - 标量子查询
    - 行子查询
    - 列子查询
    - 表子查询
    - exists子查询
  - 优化
    - 标量子查询、行子查询
      - 不相关查询  
        - 单独执行子查询  
        - 再执行外层查询
      - 相关查询  
        - 先从外层查询中获取一条记录  
        - 执行子查询  
        - 检测外层查询  
    - IN子查询优化  
      - 半连接 
      - 执行in to exists转换  
      - 把结果集物化之后再执行查询
    - 表子查询优化
      - 和外层的表合并  
      - 把结果集物化之后再执行查询
- 组合查询
  - `union all`  保留重复记录
  - `union`  去除重复记录

索引
- 作用  减少扫描的数据量，提高查询效率
- 分类
  - 按数据结构  B+tree索引、Hash索引、倒排索引
  - 按物理存储  聚簇索引、非聚簇索引
  - 按字段特性  主键索引、唯一索引、普通索引、前缀索引
    - 主键索引的适用条件
      - 唯一、非空
      - 有递增的趋势
      - 不使用业务字段
  - 按字段个数  单列索引、联合索引
- 应用  全值匹配、匹配左边的列、匹配列前缀、匹配范围值、用于分组、用于排序
- 代价  
  - 占用额外的存储空间  
  - 增删改时需要维护索引值的顺序  
- 存储结构  B+树
  - 为什么使用B+树 
    - 非叶子节点不存储数据，降低树高，减少磁盘IO，单点查询效率高
    - 节点采用双向链表，便于范围查找
    - 有冗余节点存在，插入和删除操作对树的调整较少
  - 为什么不用二叉树
    相同的数据量，二叉树层数过高导致的磁盘io次数增多
  - 为什么不用hash
    hash表不适合做范围查询
  - 为什么不用跳表
    相同的数据量，跳表层数过高导致的磁盘io次数增多
- 失效
  - 对索引列使用模糊匹配
  - 对索引列进行表达式计算、对索引列使用函数
  - 对索引列隐式类型转换  MySQL遇到字符串和数字比较的时候，会自动把字符串转为数字，然后再进行比较
  - 联合索引非最左匹配
  - WHERE子句中的OR 只要有条件列不是索引列，就会进行全表扫描
- 回表  
  - 过程
    - 会使用到两个B+树索引，一个二级索引，一个聚簇索引  
    - 访问二级索引使用顺序I/O，访问聚簇索引使用随机I/O  
  - 减少回表
    - 索引覆盖  一个索引包含了查询所需的所有列
    - 索引下推  将原本需要在回表之后在Server过滤的条件，下推到存储引擎层，在二级索引扫描阶段提前过滤，从而减少回表次数
- 注意事项
  - 只为用于搜索、排序或分组的列创建索引
  - 为列的基数大的列创建索引
  - 索引列的类型尽量小
  - 可以只对字符串值的前缀建立索引
  - 为了尽可能少的让聚簇索引发生页面分裂和记录移位的情况，建议让主键拥有AUTO_INCREMENT属性
  - 尽量使用覆盖索引进行查询，避免回表带来的性能损耗
  - 只有索引列在比较表达式中单独出现才可以使用索引

查询原理
- 单表访问方法
  - const  通过等值匹配到一条记录  
  - ref  通过等值匹配到多条记录  
  - ref_or_null  通过等值或null匹配到多条记录  
  - range  范围匹配
  - index  扫描整个索引  
  - all  全表扫描  
- 单表索引合并  
  - Intersection  
  - Union  
  - Sort-Union  
- 连接查询
  - 嵌套循环查询(Nested Loop Join)  
  - 基于块的嵌套循环查询(Block Nested Loop Join)  

查询成本
- 成本计算
  - IO成本  从磁盘到内存损耗的时间
  - CPU成本  检测记录，对结果集进行排序等损耗的时间
- 单表查询成本
  - 根据搜索条件，找出所有可能使用的索引  
  - 计算全表扫描的代价  
  - 计算使用不同索引执行查询的代价 
  - 对比各种执行方案的代价，找出成本最低的那一个  
- 连接查询成本
  连接查询总成本 = 单次访问驱动表的成本 + 驱动表扇出数 x 单次访问被驱动表的成本

执行计划(explain)
- id  查询语句中每出现一个SELECT关键字，就会为它分配一个唯一的id值
- select_type  查询方式 
- table  查询表名
- partitions
- type  表的访问方式
- possible_keys  可能用到的索引
- key  实际用到的索引  
- key_len  索引记录的最大长度  
- ref  与索引列作等值匹配的内容  
- rows  预计需要扫描的行数  
- filtered  驱动表扇出值  
- extra  额外信息   

SQL优化
- 定位SQL
  - slow_query_log  开启慢查询
  - show processlist  显示用户正在运行的线程
- explain查看执行计划
- 原因
  - 没加索引
  - 索引失效
  - 回表太多
  - 文件排序
  - 生成临时表
  - 锁等待
```

## 事务
```
特性  
- 原子性(Atomicity)  一个事务中的所有操作，要么全部完成，要么全部不完成
- 一致性(Consistency)  事务执行前后，数据库从一个一致状态转变为另一个一致状态，满足约束和业务规则
- 隔离性(Isolation)  多个事务并发执行时，彼此之间互不干扰，一个事务的中间状态对其他事务不可见
- 持久性(Durability)  事务提交后，对数据的修改是永久的，即使系统崩溃也不会丢失
InnoDB使用undo log(回滚日志)保证原子性，使用redo log(重做日志)保证持久性，使用MVCC和锁来保证隔离性，通过原子性、隔离性、持久性来保证一致性 

并发问题  
- 脏写  一个事务修改了另一个未提交事务修改的数据 
- 脏读  一个事务读取到了另一个未提交事务修改的数据  
- 不可重复读  在同一个事务中，多次读取同一行数据，结果不一致
- 幻读  同一事务中，两次按照相同条件的查询，返回的记录数不同

隔离级别  
- read uncommitted  读未提交
- read committed  读已提交   
- repeatable read  可重复读
- serializable  可串行化
| 隔离级别          | 脏读          | 不可重复读     | 幻读 |  
| :---:            | :---:        | :---:        | :---: |
| read uncommitted | Possible     | Possible     | Possible |
| read committed   | Not Possible | Possible     | Possible |
| repeatable read  | Not Possible | Not Possible | Possible |
| serializable     | Not Possible | Not Possible | Not Possible |

MVCC
- 隐藏列
  - trx_id  最后一次修改该记录的事务ID
  - roll_pointer  指向该记录的undo log，undo log通过指针形成版本链，可以回溯到历史版本
- ReadView    
  - m_ids  生成ReadView时，系统中所有未提交事务ID列表（活跃事务）
  - min_trx_id  m_ids中最小的事务ID
  - max_trx_id  当前系统即将分配的下一个事务ID
  - creator_trx_id  创建该ReadView的事务ID  
- 访问过程
  - trx_id == creator_trx_id，可见(读自己修改) 
  - trx_id < min_trx_id，可见(生成ReadView前已提交)
  - trx_id >= max_trx_id，不可见(生成ReadView 之后才开始)
  - trx_id in m_ids, 不可见(事务还未提交)，否则可见(事务已提交)
- 生成时机  
  - READ COMMITTED  每次读取数据前都生成一个ReadView  
  - REPEATABLE READ  第一次读取数据时生成一个ReadView  
- 常见问题
  - 可重复读隔离级别，出现幻读的情况(快照读中混用了当前读)
    - 事务A先执行快照读，事务B插入记录，事务A再执行当前读，仍然会出现幻读  
    - 事务A先执行快照读，事务B插入记录，事务A更新了事务B插入的记录，事务A再执行当前读，仍然会出现幻读

```

## 日志
```
undo log(回滚日志)
- 作用
  - 保障事务的原子性
  - 实现MVCC(多版本并发控制)

redo log(重做日志)
- 作用
  - 实现事务的持久性
  - 将写操作从随机写变成了顺序写

bin日志
server层生成的日志，主要用于数据备份和主从复制

relay log
主从复制场景下，slave通过io线程拷贝master的bin log后本地生成的日志

慢日志
记录执行时间过长的sql

两阶段提交
- 事务提交
  - 将redo log持久化到磁盘，事务状态设置为prepare
  - 将binlog持久化到磁盘，事务状态设置为commit
```

## 锁
```
InnoDB存储引擎中的锁
分类
- 全局锁
  - FTWRL  `flush tables with read lock` 语句会将整个数据库就处于只读状态了，主要应用于全库逻辑备份
- 表级锁
  - 表锁(S锁、X锁)
  - 自增锁
    - AUTO-INC  插入记录数量不定时使用，插入语句开始前上锁，插入数据结束释放锁
    - 轻量级的锁  插入记录数量确定时，插入语句开始前上锁生成值，然后释放锁
  - 元数据锁
  - 意向锁(IS锁、IX锁)  在加表级别的S锁和X锁时可以快速判断表中的记录是否被上锁
  | 兼容性 |   X   |   IX  |   S   |  IS   |
  | :---: | :---: | :---: | :---: | :---: |
  | X     | 不兼容 | 不兼容 | 不兼容 | 不兼容 |
  | IX    | 不兼容 | 兼容   | 不兼容 | 兼容 |
  | S     | 不兼容 | 不兼容 | 兼容   | 兼容 |
  | IS    | 不兼容 | 兼容   | 兼容   | 兼容 |
- 行级锁
  - Record Locks
  - Gap Locks
  - Next-Key Locks
  - Insert Intention Locks
  - 隐式锁
    一个事务对新插入的记录可以不显式的加锁，但是由于事务id的存在，相当于加了一个隐式锁
    别的事务在对这条记录加S锁或者X锁时，由于隐式锁的存在，会先帮助当前事务生成一个锁结构，然后自己再生成一个锁结构后进入等待状态
  | 兼容性    | 间隙锁   | 插入意向锁 |
  | :---:    | :---:   | :---:    |
  | 间隙锁    | 兼容     |  不兼容    |
  | 插入意向锁 | 不兼容   | 兼容     |

加锁
- 写操作
  - INSERT 不加锁 
    - 待插入记录的下一条记录上已经被其他事务加了gap锁时，生成一个插入意向锁
    - 重复键
      - 主键值重复
        插入新记录的事务会给已存在的主键值重复的聚簇索引记录添加S型正经记录锁
      - 唯一二级索引列重复
        插入新记录的事务会给已存在的二级索引列值重复的二级索引记录添加S型next-key锁
  - DELETE  记录加X锁，执行逻辑删除  
  - UPDATE
    - 不修改主键值，原记录修改 记录加X锁
    - 不修改主键值，新记录修改 记录加X锁彻底删除(把记录移入垃圾链表)，再insert
    - 修改主键值  记录加X锁逻辑删除再insert
- 读  
  - 对读取的记录加S锁  `SELECT ... LOCK IN SHARE MODE`
  - 对读取的记录加X锁  `SELECT ... FOR UPDATE`
  - 不同隔离级别下
    - read uncommitted | read committed  只会加record锁
    - repeatable read  会加next-key锁

乐观锁和悲观锁
- 悲观锁  对数据被其它事务的修改持保守态度，访问数据时加锁
- 乐观锁  对数据被其它事务的修改持乐观态度，修改时对比版本

死锁
- 出现条件
  - 互斥
  - 占有且等待
  - 不可强占用
  - 循环等待
```

## 内存管理
```
buffer pool 


change buffer
```

## 集群
```
主从复制
- 过程
  - master服务器在数据变更时，会记录bin log⽇志
  - slave服务器会定期通过I/O thread拉去master的bin log
  - master 节点为每个I/O线程启动⼀个dump线程，⽤于向Slave发送⼆进制事件
  - slave节点会将收到的⼆进制事件保存⾄本地的中继⽇志relay log中
  - slave节点会启动SQL线程从中继⽇志relay log中读取⼆进制变更
  - slave的SQL tread在本地重放中继⽇志，使得其数据和主节点的保持⼀致
```