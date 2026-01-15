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
```

学习资料  
[官方文档](https://www.elastic.co/guide/en/elasticsearch/reference/current/index.html)  
[中文文档](https://www.elastic.co/guide/cn/elasticsearch/guide/current/index.html)  
[【ES从入门到实战】完整合集版，带思维导图](https://juejin.cn/post/6844904181325627400)  
[Elasticsearch8（ES）保姆级菜鸟入门教程](https://blog.csdn.net/TinpeaV/article/details/149352335)