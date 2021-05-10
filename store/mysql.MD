# MySql #

## 定义 ##
关系型数据库

## 内容 ##
### 数据类型 ###
#### 数值 ####
  - 整型
    - tinyint
    - smallint
    - mediumint
    - int
    - longint
  - 浮点数
    - float
    - double
  - 定点数
    - decimal
#### 字符串 ####
  - char
  - varchar
  - tinytext
  - text
  - mediumtext
  - longtext
  - enum
  - set
#### 时间 ####
  - year
  - date
  - time
  - datetime
  - timestamp
#### 二进制 ####
  - bit
  - binary
  - varbinary
  - tinyblob
  - blob
  - medibumblob
  - longblob

### SQL ###
#### DDL ####
##### database #####
  - show databases 
  - create database dbname 
  - drop database dbname
  - use dbname
##### table #####
  - show tables
  - desc tablename
  - show create table tablename
  - create table tablename
  - drop table tablename
  - alter table tablename
##### column #####  
default, not null, auto_increament, zerofill, primary key, unique key, constraint foreign key  references
#### DML #### 
  - insert into tablename values
  - update tablename set 
  - delete from tablename
  - select from   
    distinct, group by having, order by, limit start length
#### 运算符 ####
  - 算术  
  +, -, *, /, %
  - 比较  
  \>, >=, <, <=, =, !=, between and
  - 逻辑  
  and, or
  - 匹配  
  in, not in, is null, is not null
  - 通配  
  _, %
#### 函数 ####
  - 数值
  - 字符串
  - 时间
  - 聚集

### 视图 ###
#### 操作 ####
  - create view viewname as
  - drop view

### 游标 ###
#### 操作 ####  
  - 新建 declare cursorname cursor for
  - 打开 open cursorname
  - 读取 fetch cursorname into 
  - 异常处理 declare continue handler for not found
  - 关系 close cursorname

### 事务 ###
#### 特性 ####  
  - 原子性
  - 一致性
  - 隔离性
  - 持久性  
#### 状态 ####  
  - 活动
  - 部分提交
  - 提交
  - 失败
  - 中止
#### 操作 ####  
  - start transaction | begin
  - commit
  - rollback
  - savepoint pointname
  - release savepoint pointname
  - rollback to pointname
#### 并发问题 #### 
  - 脏写
  - 脏读
  - 不可重复读
  - 幻读  
#### 隔离级别 ####  
  - READ UNCOMMITTED
  - READ COMMITED
  - REPEATABLE READ
  - SERIALIZABLE
#### 日志 ####
redo日志 
undo日志   
#### 锁 ####
类型    
  - S锁
  - X锁  
级别  
  - 表锁
  - 行锁

### 查询 ###
#### 访问方式 ####
  - const
  - ref
  - ref_or_null
  - range
  - index
  - all
#### 多表查询 ####
  - 子查询
  - 连接查询
  - 组合查询