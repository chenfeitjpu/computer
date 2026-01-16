**Elasticseach**
- [定义](#定义)
- [使用](#使用)
  - [基础](#基础)
  - [实现](#实现)

# 定义 #
全文搜索引擎

# 使用 #
## 基础 ##
```
概念
- 索引(index)
- 映射(mapping)
- 文档(doc)

操作
- 索引(index)
  - put /{index_name}
  - get /{index_name}
  - get /_cat/indices?v
  - delete /{index_name}
- 映射(mapping)
  - put /{index_name}/mapping
  - get /{index_name}/mapping
  - 不能删除
- 文档(document)
  - post /{index_name}/_doc
  - post /{index_name}/_doc/id
  - post /{index_name}/_bulk
  - get /{index_name}/_doc/id
  - get /{index_name}/_search
    - match_all  查询所有
    - match  单字段查询
    - multi_match  多字段查询
    - term  关键词精准查询
    - terms  多关键词精准查询
  - put /{index_name}/_update/id
  - delete /{index_name}/_doc/id
  - post /{index_name}/_delete_by_query=
```

## 实现 ##
```
分词器
- IK分词器
  - 分词模式
    - ik_max_word（最大化分词）
      最细粒度，尽可能拆分出所有可能词语
    - ik_smart（智能分词）
      粒度较粗，更符合人类阅读习惯

倒排索引
- 概念
  - 正排索引(正向索引)  通过文档ID去查找关键词
  - 倒排索引(反向索引)  通过关键词查找文档ID
- 实现
  - 分词
    - 字符过滤
    - 分词
    - token过滤
  - 倒排列表
- 查找过程
  - 在Term Index中找到单词在Term Dictionary的位置
  - 在Term Dictionary中查找到Posting List中所对应的文档ID
  - 通过文档ID在正排索引中查找到对应的数据列

- 搜索
  - 搜索过程
    - Query阶段
      - Client 发送查询请求到 Server 端，Node1 接收到请求然后创建一个大小为 from + size 的优先级队列用来存放结果，此时 Node1 被称为 coordinating node（协调节点）
      - Node1 将请求广播到涉及的 shard 上，每个 shard 内部执行搜索请求，然后将执行结果存到自己内部的大小同样为 from+size 的优先级队列里
      - 每个 shard 将暂存的自身优先级队列里的结果返给 Node1，Node1 拿到所有 shard 返回的结果后，对结果进行一次合并，产生一个全局的队列，存在 Node1 的优先级队列中。
    - Fetch阶段
      - Node1 根据合并后保存在优先级队列中的 from+size 条数据的 id 集合，发送请求到对应的 shard 上查询 doc 数据详情
      - 各 shard 接收到查询请求后，查询到对应的数据详情并返回为 Node1
      - Node1 获取到对应的分页数据后，返回给 Client
  - 搜索方式
    - from + size
    - search_after
    - scroll
      为每个shard创建search context，并在服务端记录当前读取位置
```

学习资料  
[官方文档](https://www.elastic.co/guide/en/elasticsearch/reference/current/index.html)  
[中文文档](https://www.elastic.co/guide/cn/elasticsearch/guide/current/index.html)  
[【ES从入门到实战】完整合集版，带思维导图](https://juejin.cn/post/6844904181325627400)  
[Elasticsearch8（ES）保姆级菜鸟入门教程](https://blog.csdn.net/TinpeaV/article/details/149352335)
[面试官：你真的认为ElasticSearch比MySQL快](https://zhuanlan.zhihu.com/p/705332207)