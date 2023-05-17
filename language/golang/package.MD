**包管理**  
- [内容](#内容)
  - [使用](#使用)
    - [定义](#定义)
    - [引入](#引入)
    - [初始化](#初始化)
  - [go module](#go-module)
    - [命令](#命令)
    - [代理](#代理)
    - [引入包](#引入包)

# 内容 #
## 使用 ##
### 定义 ###
package packagename  
- packagename 包名，可以不与文件夹的名称一致，不能包含-符号，最好与其实现的功能相对应

### 引入 ###
import importname "path/to/package"  
- importname 引入的包名，通常都省略，默认值为引入包的包名
- path/to/package 引入包的路径名称，必须使用双引号包裹起来
- Go语言中禁止循环导入包

### 初始化 ###
- 先执行依赖的包中声明的init函数再执行当前包中声明的init函数  
- init函数会按照它们声明的顺序自动执行  
  
## go module ##
### 命令 ###
- go mod init	初始化项目依赖，生成go.mod文件
- go mod download	根据go.mod文件下载依赖
- go mod tidy	比对项目文件中引入的依赖与go.mod进行比对
- go mod graph	输出依赖关系图
- go mod edit	编辑go.mod文件
- go mod vendor	将项目的所有依赖导出至vendor目录
- go mod verify	检验一个依赖包是否被篡改过
- go mod why	解释为什么需要某个依赖 
  
### 代理 ###
**GOPROXY**  

**GOPRIVATE**  

### 引入包 ###
- go get
- go mod download