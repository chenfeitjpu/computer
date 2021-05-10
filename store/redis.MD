# Redis #

## 定义 ##
键值对数据库

## 内容 ##
### 键 ###
#### 操作 ####
  - keys <pattern>
  - scan cursor match <pattern> count <count>
  - exists <key>
  - type <key>
  - randomkey
  - del <key>
  - unlink <key>
  - rename <key> <newkey>
  - renamenx <key> <newkey>
  - move <key> <db>
  - dump <key>
  - expire <key> <second>
  - pexpire <key> <millisecond>
  - expireat <key> <timestamp>
  - pexpireat <key> <millitimestamp>
  - persist <key>
  - persist <key>
  - dbsize
### 库 ###
#### 操作 ####
  - select <db>
  - flushdb
  - flushall

### 数据结构 ###
#### string ####
##### 操作 #####
  - set <key> <value> [ex <second> | px <millisecond>] [nx | xx]
  - setex <key> <second> <value>
  - psetex <key> <millisecond> <value>
  - setnx <key> <value>
  - mset <key> <value> <key> <value>
  - msetnx <key> <value> <key> <value>
  - getset <key> <value>
  - append <key> <value>
  - setrange <key> <offset> <value>
  - incr <key>
  - incrby <key> <increment>
  - incrbyfloat <key> <increment>
  - decr <key>
  - decyby <key> <decrement>
  - get <key>
  - mget <key> <key>
  - getrange <key> <start> <end>
  - strlen <key>
#### 内部编码 ####
  - int
  - embstr
  - raw