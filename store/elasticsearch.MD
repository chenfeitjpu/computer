**Elasticseach**
- [定义](#定义)
- [使用](#使用)
  - [基础](#基础)

# 定义 #
全文搜索引擎

# 使用 #
## 基础 ##
```
概念
- 索引 
- 类型
- 文档

操作
- 新增/修改
  - put /index/type/id  修改文档
    必须指定id，id不存在则新增，存在则修改
  - post /index/type/id  新增文档
    不指定id，则新增
    指定id，id不存在则新增，存在则修改
  - _update /index/type/id/_update
    数据相同则不更新
- 查询
  - get /index/type/id  查询文档
- 删除
  - delete /index/type/id  删除文档
  - delete /index  删除索引
```

学习资料  
[官方文档](https://www.elastic.co/guide/en/elasticsearch/reference/current/index.html)  
[中文文档](https://www.elastic.co/guide/cn/elasticsearch/guide/current/index.html)  
[【ES从入门到实战】完整合集版，带思维导图](https://juejin.cn/post/6844904181325627400)  