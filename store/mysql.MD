# MySql #

## 定义 ##
关系型数据库

## 内容 ##
### 数据类型 ###
  - 数值
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
  - 字符串
    - char
    - varchar
    - tinytext
    - text
    - mediumtext
    - longtext
    - enum
    - set
  - 时间
    - year
    - date
    - time
    - datetime
    - timestamp
  - 二进制
    - bit
    - binary
    - varbinary
    - tinyblob
    - blob
    - medibumblob
    - longblob

### SQL ###
  - DDL
    - database
      - show databases 
      - create database dbname 
      - drop database dbname
      - use dbname
    - table
      - show tables
      - desc tablename
      - show create table tablename
      - create table tablename
      - drop table tablename
      - alter table tablename
    - column  
      default、not null、auto_increament、zerofill、primary key、unique key、constraint foreign key references
  - DML 
    - insert into tablename values
    - update tablename set 
    - delete from tablename
    - select from 

### 运算符 ###
   - 算术
   +, -, *, /, %
   - 比较
   >, >=, <, <=, !=, between and
   - 逻辑
   and, or
   - 匹配 
   in, not in, is null, is not null
   - 通配
   _, %
### 函数 ###
  - 数值
  - 字符串
  - 时间
  - 聚集