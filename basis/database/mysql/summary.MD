* [架构](#架构)
* [日志](#日志)
* [事务](#事务)
* [索引](#索引)

# 架构 #
  - 客户端
  - SERVER
    - 连接器 建立连接，读取权限，校验权限
    - 分析器 词法分析，语法分析，语义分析
    - 优化器 选择索引，生成执行计划
    - 执行器 校验权限，调用引擎
  - 存储引擎 操作数据
  
# 日志 #
  - redolog 引擎层(innodb特有)记录内存中数据变化，同步到磁盘
  - binlog server层记录所有SQL语句

两者区别
<table>
	<tr>
	   <td>日志类型</td>
	   <td>存贮位置</td>
	   <td>记录内容</td>
	   <td>写入方式</td>
	</tr>
	<tr>
		<td>redolog</td>
		<td>引擎层</td>
		<td>数据变化</td>
		<td>循环写</td>
	</tr>
	<tr>
		<td>binlog</td>
		<td>server层</td>
		<td>逻辑变化</td>
		<td>追加写</td>
	</tr>
</table>

# 事务 #
特性
  - 原子性(atomicity)
  - 持久性(consistency)
  - 隔离性(isolation)
    - 读未提交(read uncommitted)
    - 读提交(read committed)
    - 可重复度(repeatable read)
    - 串行化(serializable)	
  - 一致性(durability)
  
# 索引 #
索引模型
  - 哈希表
  - 有序数组
  - 树
分类
  - 主键索引
  - 普通索引
特性
  - 覆盖索引
  - 最左原则
  - 索引下推