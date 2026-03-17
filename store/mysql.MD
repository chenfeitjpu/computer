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
- 转`character_set_connection`，统一内部处理
  - 灵活性，不同连接可以使用不同的SQL语义
  - 稳定性，同一连接内SQL语义不变
- 转列字符集，保证比较一致性
- 转`character_set_results`返回

查询顺序
from -> on -> join -> where -> group -> having -> select -> order -> limit

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
    - timestmp必须显式地设置时区，不要使用默认系统时区，否则存在性能问题
- 字符串  char(M)、varchar(M)、tinytext、text、mediumtext、longtext、enum、set
  - char(M)  M是字符数，占用M*W(某个字符集编码一个字符最多需要的字节)个字节，剩余空间会用空格字符填充
  - varchar(M)  M是字符数，占用空间字符串长度(1或者2个字节)+字符串个字节
    - varchar(50) vs varchar(100)
      - 磁盘占用  磁盘占用空间大小是一样的
      - 索引占用  索引大小会使用定义长度  
      - 内存占用  排序、临时表会使用定义长度
- 二进制字符串  bit(M)、binary(M)、varbinary(M)、tinyblob、blob、mediumblob、longblob

engine  
- InnoDB  支持事务、行级锁、外键，适用于高并发的读写操作
- MyISAM  存储空间小、读取性能好，适用于大量读操作的场景
- MEMORY  基于哈希表，存储在内存，用于临时表 

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
  - 按数据结构  B+tree索引、Hash索引、Full text索引
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
  - 对索引列进行表达式计算、对索引使用函数
  - 对索引列隐式类型转换  MySQL遇到字符串和数字比较的时候，会自动把字符串转为数字，然后再进行比较
  - 联合索引非最左匹配
  - WHERE子句中的OR 只要有条件列不是索引列，就会进行全表扫描
- 回表  
  - 过程
    - 会使用到两个B+树索引，一个二级索引，一个聚簇索引  
    - 访问二级索引使用顺序I/O，访问聚簇索引使用随机I/O  
  - 减少回表
    - 索引覆盖  一个索引包含了查询所需的所有列
    - 索引下推  
      在存储引擎层之上(Server层)执行的过滤操作，下推到更底层的存储引擎层去执行。
      查询条件需要包含联合索引的最左列，并且还有其他索引列的条件
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
  - IO成本  从磁盘到内存这个加载的过程损耗的时间
  - CPU成本  检测记录，对结果集进行排序等这些操作损耗的时间
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
- type  表的访问方式
- possible_keys  可能用到的索引
- key  实际用到的索引  
- key_len  索引记录的最大长度，由三个部分构成，主要用来区分某个使用联合索引的查询具体用了几个索引列  
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
- 一致性(Consistency)  事务操作前和操作后，数据满足完整性约束，数据库保持一致性状态
- 隔离性(Isolation)  数据库允许多个并发事务同时对其数据进行读写
- 持久性(Durability)  事务处理结束后，对数据的修改是永久的
InnoDB使用undo log(回滚日志)保证原子性，使用redo log(重做日志)保证持久性，使用MVCC和锁来保证隔离性，通过原子性、隔离性、持久性来保证一致性 

并发问题  
- 脏写  A事务修改了未提交B事务修改过的数据，A事务提交后，B事务发生回滚，A事务的修改会丢失  
- 脏读  A事务读到了未提交B事务修改过的数据，A事务提交后，B事务发生回滚，A事务读到了不存在的数据   
- 不可重复读  一个事务读到另一个已经提交的事务修改过的数据，并且其他事务每次对该数据进行修改并提交后，该事务都能查询到最新值  
- 幻读  一个事务先根据某些条件查询出一些记录，之后另一个事务又向表中插入了符合这些条件的记录，原先的事务再次按照该条件查询时，能把另一个事务插入的记录也读出来

隔离级别  
- read uncommitted  读未提交
- read committed  读已提交   
- repeatable read  可重复读
- serializable  可串行化
| 隔离级别 | 脏读 | 不可重复读 | 幻读 |  
| :---: | :---: | :---: | :---: |
| read uncommitted | Possible | Possible | Possible |
| read committed | Not Possible | Possible | Possible |
| repeatable read | Not Possible | Not Possible | Possible |
| serializable | Not Possible | Not Possible | Not Possible |

MVCC
- 基础
  - trx_id 
    每次一个事务对某条聚簇索引记录进行改动时，都会把该事务的事务id赋值给trx_id隐藏列
  - roll_pointer 
    每次对某条聚簇索引记录进行改动时，都会把旧的版本写入到undo日志中，然后这个隐藏列就相当于一个指针，可以通过它来找到该记录修改前的信息  
- ReadView    
  - m_ids  表示在生成ReadView时当前系统中活跃的读写事务的事务id列表  
  - min_trx_id  表示在生成ReadView时当前系统中活跃的读写事务中最小的事务id，也就是m_ids中的最小值
  - max_trx_id  表示生成ReadView时系统中应该分配给下一个事务的id值
  - creator_trx_id  表示生成该ReadView的事务的事务id  
- 访问过程
  - 如果被访问版本的trx_id属性值与ReadView中的creator_trx_id值相同，意味着当前事务在访问它自己修改过的记录，所以该版本可以被当前事务访问  
  - 如果被访问版本的trx_id属性值小于ReadView中的min_trx_id值，表明生成该版本的事务在当前事务生成ReadView前已经提交，所以该版本可以被当前事务访问  
  - 如果被访问版本的trx_id属性值大于或等于ReadView中的max_trx_id值，表明生成该版本的事务在当前事务生成ReadView后才开启，所以该版本不可以被当前事务访问
  - 如果被访问版本的trx_id属性值在ReadView的min_trx_id和max_trx_id之间，那就需要判断一下trx_id属性值是不是在m_ids列表中，如果在，说明创建ReadView时生成该版本的事务还是活跃的，该版本不可以被访问；如果不在，说明创建ReadView时生成该版本的事务已经被提交，该版本可以被访问  
- 生成时机  
  - READ COMMITTED  每次读取数据前都生成一个ReadView  
  - REPEATABLE READ  第一次读取数据时生成一个ReadView  

常见问题
- 可重复读隔离级别，出现幻读的情况
  - 快照读  
    - 事务B插入记录，事务A更新了事务B插入的记录，事务A就能看到事务B插入的记录，仍然会出现幻读
  - 当前读
    - 事务A先执行快照读，事务B插入一条记录，事务A再执行当前读，仍然会出现幻读  
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