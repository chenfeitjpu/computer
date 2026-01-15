**MySQL**
- [定义](#定义)
- [使用](#使用)
  - [系统架构](#系统架构)
  - [数据类型](#数据类型)
  - [数据操作](#数据操作)
  - [事务](#事务)
  - [日志](#日志)
  - [锁](#锁)
  - [内存管理](#内存管理)
  - [集群](#集群)

# 定义 #
关系型数据库

# 使用 #
## 系统架构 ##
```
字符集&比较规则
- 查看
  - `show (character set | charset)`
  - `show collation`
- 字符集设置
  服务器级别、数据库级别、表级别、列级别  
- 字符集转换过程   
  - 客户端使用操作系统的字符集编码请求字符串，向服务器发送的是经过编码的一个字节串  
  - 服务器将客户端发送来的字节串采用character_set_client代表的字符集进行解码，将解码后的字符串再按照character_set_connection代表的字符集进行编码  
  - 如果character_set_connection代表的字符集和具体操作的列使用的字符集一致，则直接进行相应操作，
  - 否则的话需要将请求中的字符串从character_set_connection代表的字符集转换为具体操作的列使用的字符集之后再进行操作  
  - 将从某个列获取到的字节串从该列使用的字符集转换为character_set_results代表的字符集后发送到客户端  
  - 客户端使用操作系统的字符集解析收到的结果集字节串


查询顺序
- from
- on
- join
- where
- group
- having
- select
- order
- limit

请求过程
- 连接管理
  连接器
- 解析与优化
  解析器、优化器、执行器
- 存储引擎
```

## 数据类型 ##
```
整型
tinyint、smallint、mediumint、int、bigint
- int(M)
  M是显示宽度，只在设置zerofill且数字宽度不足M的时候，会显示00XXX

浮点数  
float(M,D)、double(M,D)  

定点数  
decimal(M,D) 

时间和日期
year、date、time、datetime、timestamp
- timestamp
  - 默认值
    - default current_timestmap  插入当前时间
    - on update current_timestamp  更新当前时间
  - timestamp只能表示1970-2038年
  - timestmp必须显式地设置时区，不要使用默认系统时区，否则存在性能问题

字符串
char(M)、varchar(M)、tinytext、text、mediumtext、longtext、enum、set
- char(M)
  M是字符数，占用M*W(某个字符集编码一个字符最多需要的字节)个字节，剩余空间会用空格字符填充
- varchar(M)
  M是字符数，占用空间字符串长度(1或者2个字节)+字符串个字节
  - varchar(50) vs varchar(100)
    - 磁盘占用  磁盘占用空间大小是一样的
    - 内存占用  部分操作(排序、临时表)会使用定义长度
    - 索引占用  索引大小会使用定义长度  

二进制字符串
bit(M)、binary(M)、varbinary(M)、tinyblob、blob、mediumblob、longblob
```

## 数据操作 ##
```
SQL
- DDL
  - engine
    - `show engines` 查看存储引擎
      - InnoDB  支持事务、行级锁、外键，适用于高并发的读写操作
      - MyISAM  具有较低的存储空间和内存消耗，适用于大量读操作的场景
      - MEMORY  存储在内存，用于临时表
  - database    
    - `show databases` 查看所有库
    - `show create database 库名`  查看库定义
    - `create database [if not exists] 库名` 创建库
    - `drop database [if exists] 库名` 删除库
    - `use 库名` 选择库
  - table    
    - `show tables [from 库名]` 查看所有表
    - `show create table [库名.]表名` 查看表定义
    - `[describe|desc|explain|show columns from|show fields form] 表名` 查看表描述
    - `create table [if not exists] 表名` 创建表
    - `drop table [if exists ]表名` 删除表
    - `rename table 旧表名 to 新表名` 修改表名
    - `alter table 旧表名 rename to 新表名` 修改表名
    - `alter table 表名 add [column] 列名 数据类型 [列的属性] [first|after 列名]` 增加列
    - `alter table 表名 drop [column] 列名` 删除列
    - `alter table 表名 change [column] 列名 新列名 新数据类型 [新属性]` 修改列
    - `alter table 表名 modify [column] 列名 新数据类型 [新属性] [first|after 列名]` 修改列
  - column    
    - `default` 默认值
    - `not null` 非空
    - `comment` 注释
    - `auto_increament` 自增
      - 一个表中最多有一个具有AUTO_INCREMENT属性的列
      - 具有AUTO_INCREMENT属性的列必须建立索引  
      - 拥有AUTO_INCREMENT属性的列就不能再通过指定DEFAULT属性来指定默认值
    - `zerofill` 零填充
      - 该列必须是整数类型的
      - 该列必须有unsigned zerofill的属性
      - 该列的实际值的位数必须小于显示宽度  
    - `primary key`  主键
    - `unique key [索引名](列名)`  唯一键
    - `key [索引名](列名)`  普通索引
    - `foreign key [索引名](列1, 列2, ...) references 父表名 (父列1, 父列2, ...)`  外键
- DML
  - `insert [ignore] into 表名 (列名, 列名) values (值, 值) [on duplicate key update 列名 = 值|values(列名)]` 插入数据
  - `delete from 表名 [where 表达式]` 删除数据
  - `update 表名 set 列名=值 [where 表达式]` 更新数据 
- DQL
  - `select [distinct] 列名 [as] [别名] from 表名` 查询
  - `limit [开始行,] 限制条数` 限制查询结果条数
  - `order by 列名 asc|desc[, 列名 asc|desc]` 按照单列|多列的值进行排序，默认升序
- DCL
  - `grant 权限 on 库名.表名 to 用户@主机` 授权
  - `revoke 权限 on 库名.表名 to 用户@主机` 回收权限  

查询
- 分类
  - 单表
    `select * from table [where] [group by column having] [order by column] [limit]`
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
          对于s1表的某条记录来说，我们只关心在s2表中是否存在与之匹配的记录，而不关心具体有多少条记录与之匹配，最终的结果集中只保留s1表的记录  
          - Table pullout(子查询中的表上拉) 
          - DuplicateWeedout execution strategy(重复值消除)
          - FirstMatch execution strategy(首次匹配)
          - LooseScan execution strategy(松散扫描)
        - 将结果集物化之后再执行查询
        - 执行in to exists转换  
      - 表子查询优化
        - 把结果集物化  
        - 和外层的表合并  
  - 组合查询
    - `union all`  保留重复记录
    - `union`  去除重复记录

- 索引
  - 作用
    减少扫描的数据量，提高查询效率
  - 基本操作  
    CREATE TALBE 表名 (
        各种列的信息 ··· , 
        [KEY|INDEX] 索引名 (需要被索引的单个列或多个列)
    )
    ALTER TABLE 表名 ADD [INDEX|KEY] 索引名 (需要被索引的单个列或多个列)
    ALTER TABLE 表名 DROP [INDEX|KEY] 索引名
    CREATE INDEX 索引名 ON 表名(列名)
    DROP INDEX 索引名 ON 表名
  - 分类
    - 按数据结构分类
      B+tree索引、Hash索引、Full text索引
    - 按物理存储分类
      聚簇索引、非聚簇索引
    - 按字段特性分类
      主键索引、唯一索引、普通索引、前缀索引
      - 主键索引的适用条件
        - 唯一、非空
        - 有递增的趋势
        - 不使用业务字段
    - 按字段个数
      单列索引、联合索引
  - 应用  
    - 全值匹配
    - 匹配左边的列
    - 匹配列前缀
    - 匹配范围值
    - 用于分组
    - 用于排序
  - 代价  
    - 占用额外的存储空间  
    - 增删改时需要维护索引值的顺序  
  - 存储结构
    B+树
    - 为什么使用B+树 
      - 非叶子结点不存储数据，降低树高，减少磁盘IO，单点查询效率高
      - 节点采用双向链表，便于范围查找
      - 有冗余节点存在，插入和删除操作对树的调整较少
    - 为什么不用二叉树
      相同的数据量，二叉树层数过高导致的磁盘io次数增多
    - 为什么不用hash
      hash表不适合做范围查询
    - 为什么不用跳表
      相同的数据量，跳表层数过高导致的磁盘io次数增多
  - 失效
    - 对索引使用左或者左右模糊匹配
    - 对索引进行表达式计算
    - 对索引使用函数
    - 对索引隐式类型转换  MySQL遇到字符串和数字比较的时候，会自动把字符串转为数字，然后再进行比较
    - 联合索引非最左匹配
    - WHERE子句中的OR 只要有条件列不是索引列，就会进行全表扫描
  - 回表  
    - 过程
      - 会使用到两个B+树索引，一个二级索引，一个聚簇索引  
      - 访问二级索引使用顺序I/O，访问聚簇索引使用随机I/O  
    - 减少回表
      - 索引覆盖  一个索引包含了查询所需的所有列
      - 索引下推  
        在存储引擎层之上（Server层） 执行的过滤操作，下推到更底层的存储引擎层去执行。
        查询条件需要包含联合索引的最左列，并且还有其他索引列的条件
  - 注意事项
    - 只为用于搜索、排序或分组的列创建索引
    - 为列的基数大的列创建索引
    - 索引列的类型尽量小
    - 可以只对字符串值的前缀建立索引
    - 为了尽可能少的让聚簇索引发生页面分裂和记录移位的情况，建议让主键拥有AUTO_INCREMENT属性
    - 尽量使用覆盖索引进行查询，避免回表带来的性能损耗
    - 只有索引列在比较表达式中单独出现才可以使用索引

- 查询原理
  - 单表访问方法
    - const  主键或者唯一二级索引列通过等值来定位一条记录  
    - ref  二级索引列进行等值或者null比较后可能匹配到多条连续的记录  
    - ref_or_null  二级索引列的值等于某个常数(包括空)的记录  
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

- 查询成本
  - 成本计算
    - IO成本  从磁盘到内存这个加载的过程损耗的时间
    - CPU成本 检测记录是否满足对应的搜索条件、对结果集进行排序等这些操作损耗的时间
  - 单表查询成本
    - 根据搜索条件，找出所有可能使用的索引  
    - 计算全表扫描的代价  
      - 聚簇索引占用的页面数  Data_length / innodb_page_size
      - 该表中的记录数  Rows
    - 计算使用不同索引执行查询的代价 
      - 二级索引占用页面数 一个区间就是一个页面
      - 二级索引记录数 区间最左记录和区间最右记录相隔不大于10个页面，那就可以精确统计。否则只沿着区间最左记录向右读10个页面，计算平均每个页面中包含多少记录，然后用这个平均值乘以区间最左记录和区间最右记录之间的页面数量就可以了
      - 回表一条记录算一个页面
    - 对比各种执行方案的代价，找出成本最低的那一个  
  - 连接查询成本
    连接查询总成本 = 单次访问驱动表的成本 + 驱动表扇出数 x 单次访问被驱动表的成本
    - 单点区间记录计算
      - index dive 直接访问索引对应的B+树来计算某个范围区间对应的索引记录条数，小于等于10精确统计，否则估算
      - 索引统计 单点区间超过eq_range_index_dive_limit时使用，记录数/基数

- 执行计划(explain)
  - id  查询语句中每出现一个SELECT关键字，就会为它分配一个唯一的id值
  - select_type  查询方式
    - SIMPLE  查询语句中不包含UNION或者子查询的查询都算作是SIMPLE类型  
    - PRIMARY  对于包含UNION、UNION ALL或者子查询的大查询来说，它是由几个小查询组成的，其中最左边的那个查询的select_type值就是PRIMARY  
    - UNION  对于包含UNION或者UNION ALL的大查询来说，它是由几个小查询组成的，其中除了最左边的那个小查询以外，其余的小查询的select_type值就是UNION  
    - UNION RESULT  MySQL选择使用临时表来完成UNION查询的去重工作，针对该临时表的查询的select_type就是UNION RESULT  
    - SUBQUERY  子查询是不相关子查询  
    - DEPENDENT SUBQUERY  子查询是相关子查询  
    - DEPENDENT UNION  子查询都依赖于外层查询的话  
    - DERIVED  采用物化的方式执行的包含派生表的查询  
    - MATERIALIZED  将子查询物化之后与外层查询进行连接查询  
  - type  表的访问方式
    - const  根据主键或者唯一二级索引列与常数进行等值匹配  
    - eq_rel  在连接查询时，如果被驱动表是通过主键或者唯一二级索引列等值匹配的方式进行访问  
    - ref  普通的二级索引列与常量进行等值匹配  
    - ref_or_null  普通二级索引进行等值匹配查询，该索引列的值也可以是NULL值时  
    - index_merge  使用Intersection、Union、Sort-Union这三种索引合并的方式来执行查询  
    - unique_subquery  子查询可以使用主键进行等值匹配  
    - index_subquery  子查询使用的普通索引进行等值匹配  
    - range  使用索引获取某些范围区间的记录  
    - index  扫描全部的索引记录  
    - all  全表扫描  
  - possible_keys  可能用到的索引
  - key  实际用到的索引  
  - key_len  索引记录的最大长度，由三个部分构成，主要用来区分某个使用联合索引的查询具体用了几个索引列  
    - 索引实际占用的存储空间的最大长度
    - 如果该索引列可以存储NULL值，则key_len比不可以存储NULL值时多1个字节
    - 对于变长字段来说，都会有2个字节的空间来存储该变长列的实际长度
  - ref  与索引列作等值匹配的内容  
    - const 常数
    - 列名
    - func 函数
  - rows  预计需要扫描的行数  
  - filtered  驱动表扇出值  
  - Extra  额外信息  
    - No tables used  查询语句的没有FROM子句  
    - Impossible WHERE  查询语句的WHERE子句永远为FALSE  
    - No matching min/max row  当查询列表处有MIN或者MAX聚集函数，但是并没有符合WHERE子句中的搜索条件的记录时  
    - Using index  查询列表以及搜索条件中只包含属于某个索引的列，也就是在可以使用索引覆盖的情况下  
    - Using index condition  索引条件下推  
    - Using where  搜索条件需要在server层进行判断时 
    - Using join buffer (Block Nested Loop)  基于块的嵌套循环算法  
    - Not exists  使用左（外）连接时，如果WHERE子句中包含要求被驱动表的某个列等于NULL值的搜索条件，而且那个列又是不允许存储NULL值的  
    - Using intersect(...)、Using union(...)和Using sort_union(...)  使用索引合并的方式执行查询  
    - Zero limit  当LIMIT子句的参数为0时  
    - Using filesort  使用文件排序  
    - Using temporary  使用到了内部临时表  
    - Start temporary, End temporary  查询优化器会优先尝试将IN子查询转换成semi-join，而semi-join又有好多种执行策略，当执行策略为DuplicateWeedout时，也就是通过建立临时表来实现为外层查询中的记录进行去重操作时，驱动表查询执行计划的Extra列将显示Start temporary提示，被驱动表查询执行计划的Extra列将显示End temporary提示  
    - LooseScan  在将In子查询转为semi-join时，如果采用的是LooseScan执行策略，则在驱动表执行计划的Extra列就是显示LooseScan提示  
    - FirstMatch  在将In子查询转为semi-join时，如果采用的是FirstMatch执行策略，则在被驱动表执行计划的Extra列就是显示FirstMatch(tbl_name)提示  

SQL优化
  - 定位SQL
    - 开启慢查询
      slow_query_log
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

## 事务 ##
```
- 特性  
  - 原子性(Atomicity)  一个事务中的所有操作，要么全部完成，要么全部不完成
  - 一致性(Consistency)  事务操作前和操作后，数据满足完整性约束，数据库保持一致性状态
  - 隔离性(Isolation)  数据库允许多个并发事务同时对其数据进行读写
  - 持久性(Durability)  事务处理结束后，对数据的修改就是永久的
  InnoDB使用undo log(回滚日志)保证原子性，使用redo log(重做日志)保证持久性，使用MVCC和锁来保证隔离性，，通过原子性、持久性、隔离性来保证一致性
- 使用
  - `BEGIN`  开启事务   
  - `COMMIT`  提交事务
  - `ROLLBACK`  手动中止事务 
  - `START TRANSACTION [READ ONLY|READ WRITE] [WITH CONSISTENT SNAPSHOT]`  开启事务  
- 并发问题  
  - 脏写  A事务修改了未提交B事务修改过的数据，A事务提交后，B事务发生回滚，A事务的修改会丢失  
  - 脏读  A事务读到了未提交B事务修改过的数据，A事务提交后，B事务发生回滚，A事务读到了不存在的数据   
  - 不可重复读  一个事务读到另一个已经提交的事务修改过的数据，并且其他事务每对该数据进行一次修改并提交后，该事务都能查询得到最新值  
  - 幻读  一个事务先根据某些条件查询出一些记录，之后另一个事务又向表中插入了符合这些条件的记录，原先的事务再次按照该条件查询时，能把另一个事务插入的记录也读出来
- 隔离级别  
  - read uncommitted  未提交读
  - read committed  已提交读   
  - repeatable read  可重复读
  - serializable  可串行化
  | 隔离级别 | 脏读 | 不可重复读 | 幻读 |  
  | :---: | :---: | :---: | :---: |
  | read uncommitted | Possible | Possible | Possible |
  | read committed | Not Possible | Possible | Possible |
  | repeatable read | Not Possible | Not Possible | Possible |
  | serializable | Not Possible | Not Possible | Not Possible |
  - 设置隔离级别  
    `show variables like 'transaction_isolation`  
    `SET [GLOBAL|SESSION] TRANSACTION ISOLATION LEVEL level`  [read uncommitted|read committed|repeatable read|serializable]
- MVCC
  - 基础
    - trx_id 
      每次一个事务对某条聚簇索引记录进行改动时，都会把该事务的事务id赋值给trx_id隐藏列
    - roll_pointer 
      每次对某条聚簇索引记录进行改动时，都会把旧的版本写入到undo日志中，然后这个隐藏列就相当于一个指针，可以通过它来找到该记录修改前的信息  
      记录每次更新后，都会将旧值放到一条undo日志中，就算是该记录的一个旧版本，随着更新次数的增多，所有的版本都会被roll_pointer属性连接成一个链表，我们把这个链表称之为版本链
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
- 常见问题
  - 可重复读隔离级别，出现幻读的情况
    - 快照读  
      - 事务B插入记录，事务A更新了事务B插入的记录，事务A就能看到事务B插入的记录，仍然会出现幻读
    - 当前读
      - 事务A先执行快照读，事务B插入一条记录，事务A再执行当前读，仍然会出现幻读  
```

## 日志 ##
```
undo日志
- 作用
  - 保障事务的原子性
  - 实现MVCC(多版本并发控制)

redo日志
- 作用
  - 实现事务的持久性
  - 将写操作从随机写变成了顺序写

bin日志
server层生成的日志，主要用于数据备份和主从复制
- 格式
  - STATEMENT
  - ROW
  - MIXED

relay log
主从复制场景下，slave通过io线程拷贝master的bin log后本地生成的日志

慢日志
记录执行时间过长的sql

两阶段提交
- 过程
  - 事务提交
    - 将redo log持久化到磁盘，事务状态设置为prepare
    - 将binlog持久化到磁盘，事务状态设置为commit
```

## 锁 ##
```
InnoDB存储引擎中的锁
- 全局锁
  - FTWRL 
    flush tables with read lock 语句会将整个数据库就处于只读状态了，主要应用于全库逻辑备份
- 表级锁
  - 表锁(S锁、X锁)
  - 自增锁
    - AUTO-INC  插入记录数量不定时使用，插入语句开始前上锁，插入数据结束释放锁
    - 轻量级的锁  插入记录数量确定时，插入语句开始前上锁生成值，然后释放锁
  - 元数据锁
  - 意向锁(IS锁、IX锁)
    在加表级别的S锁和X锁时可以快速判断表中的记录是否被上锁

  | 兼容性 | X | IX | S | IS |
  | :---: | :---: | :---: | :---: | :---: |
  | X | 不兼容 | 不兼容 | 不兼容 | 不兼容 |
  | IX | 不兼容 | 兼容 | 不兼容 | 兼容 |
  | S | 不兼容 | 不兼容 | 兼容 | 兼容 |
  | IS | 不兼容 | 兼容 | 兼容 | 兼容 |
- 行级锁
  - Record Locks
  - Gap Locks
  - Next-Key Locks
  - Insert Intention Locks
  - 隐式锁
    一个事务对新插入的记录可以不显式的加锁，但是由于事务id的存在，相当于加了一个隐式锁
    别的事务在对这条记录加S锁或者X锁时，由于隐式锁的存在，会先帮助当前事务生成一个锁结构，然后自己再生成一个锁结构后进入等待状态
  | 兼容性 | 间隙锁 | 插入意向锁 |
  | :---: | :---: | :---: |
  | 间隙锁 | 兼容 | 不兼容 |
  | 插入意向锁 | 兼容 | 兼容 |
- 加锁
  - 写操作
    - INSERT  不加锁  
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
      - repeatable read   会加next-key锁
- 乐观锁和悲观锁
  - 悲观锁  对数据被其它事务的修改持保守态度，访问数据时加锁
  - 乐观锁  对数据被其它事务的修改持乐观态度，修改时对比版本
- 死锁
  - 出现条件
    - 互斥
    - 占有且等待
    - 不可强占用
    - 循环等待
```

## 内存管理 ##
```
buffer pool 


change buffer
```

## 集群 ##
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