**HTML**
- [定义](#定义)
- [使用](#使用)
  - [结构](#结构)

# 定义
> HTML(HyperText Markup Language，超文本标记语言)是一种用于创建网页的标准标记语言。  
> 它通过定义网页的结构和内容，使浏览器能够正确地显示和呈现信息。  

# 使用
## 结构
**基本结构**
```
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="refresh" content="30">  <!-- 控制浏览器行为 -->
        <meta property="og:title" content="前端开发教程">  <!-- 提供社交元数据 -->
        <meta name="robots" content="index, follow">  <!-- 提供页面元数据 -->
        <title></title>
    </head>
    <body></body>
</html>
```

**常见标签**  
- 文本
  - 标题
    > \<h1\>  
    > \<h2\>  
    > \<h3\>  
    > \<h4\>  
    > \<h5\>  
    > \<h6\>  
  - 段落
    > \<p\>  
- 容器
  - 块
    > \<div\>
  - 行内
    > \<span\>
- 多媒体
  - 图片
    > \<img\>
  - 音频
    > \<audio\>
  - 视频
    > \<video\>
- 交互标签
  - 超链接
    > \<a\>
  - 按钮
    > \<button\>
  - 表单
    > \<form\>

**语义标签**  
> 增强可读性  
> SEO友好  
> 实现无障碍  

- 结构语义标签  
  - \<header\>
  - \<nav\>
  - \<main\>
  - \<section\>
  - \<article\>
  - \<aside\>
  - \<footer\>
- 文本语义标签  
  - \<h1\>至\<h6\>
  - \<p\>
  - \<blockquote\>
  - \<cite\>
  - \<code\>
  - \<strong\>
  - \<em\>
- 表格语义标签  
  - \<table\>
  - \<thead\>
  - \<tbody\>
  - \<tfoot\>
  - \<th\>
  - \<caption\>
- 表单语义标签  
  - \<form\>
  - \<label\>
  - \<fieldset\>
  - \<legend\>