* [网络请求](#网络请求)
  * [DNS预解析](#dns预解析)
  * [缓存](#缓存)
    * [强缓存](#强缓存)
    * [协商缓存](#协商缓存)
    * [缓存策略](#缓存策略)
  * [HTTP/2\.0](#http20)
* [加载、渲染和执行](#加载渲染和执行)
  * [预加载](#预加载)
  * [预渲染](#预渲染)
  * [懒加载](#懒加载)
  * [懒执行](#懒执行)

# 网络请求 #
## DNS预解析 ##
DNS 解析也是需要时间的，可以通过预解析的方式来预先获得域名所对应的 IP。

`<link rel="dns-prefetch" href="//www.google.cn">`

## 缓存 ##
良好的缓存策略可以降低资源的重复加载提高网页的整体加载速度
### 强缓存 ###
强缓存表示在缓存期间不需要请求
  - Expires HTTP/1.0的产物，受限于本地时间
  
`Expires: Wed, 22 Oct 2018 08:41:00 GMT`
  - Cache-Control 出现于HTTP/1.1，优先级高于Expires
  
`Cache-control: max-age=30`
### 协商缓存 ###
协商缓存需要请求，如果缓存有效会返回304。
  - Last-Modified 和 If-Modified-Since Last-Modified 表示本地文件最后修改日期，If-Modified-Since 会将 Last-Modified 的值发送给服务器，询问服务器在该日期后资源是否有更新，有更新的话就会将新的资源发送回来。
  但是如果在本地打开缓存文件，就会造成 Last-Modified 被修改。
  - ETag 和 If-None-Match ETag 优先级比 Last-Modified 高。 ETag 类似于文件指纹，If-None-Match 会将当前 ETag 发送给服务器，询问该资源 ETag 是否变动，有变动的话就将新的资源发送回来。
### 缓存策略 ###
  - 对于不需要缓存的资源，可以使用 Cache-control: no-store，表示该资源不需要缓存
  - 对于频繁变动的资源，可以使用 Cache-Control: no-cache 并配合 ETag 使用，表示该资源已被缓存，但是每次都会发送请求询问资源是否更新。
  - 对于代码文件来说，通常使用 Cache-Control: max-age=31536000 并配合策略缓存使用，然后对文件进行指纹处理，一旦文件名变动就会立刻下载新的文件。
## HTTP/2.0 ##
HTTP / 2.0 中引入了多路复用，能够让多个请求使用同一个 TCP 链接，极大的加快了网页的加载速度。并且还支持 Header 压缩，进一步的减少了请求的数据大小。  

# 加载、渲染和执行 #
## 预加载 ##
强制浏览器请求资源

`<link rel="preload" href="test.mp4" as="video" type="video/mp4">`
## 预渲染 ##
将下载的文件预先在后台渲染

`<link rel="prerender" href="http://example.com"> `
## 懒加载 ##
懒加载就是将不需要的资源延后加载
## 懒执行 ##
懒执行就是将某些逻辑延迟到使用时再执行
