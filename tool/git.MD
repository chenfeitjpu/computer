**GIT**
- [定义](#定义)
- [使用](#使用)


# 定义 #
版本控制工具

# 使用 #
```
仓库
- 中央仓库
  标准版本
- 本地仓库
  副本
  - 工作区(workspace)
  - 暂存区(stage)
  - 仓库(repository)


```
  - create & clone
    - git init
    - git clone path
  - add & remove
    - git add file
    - git add .
    - git rm file
  - commit & synchronize
    - git commit -m "msg"
    - git commi -a -m "msg"
    - git push origin
    - git remote add origin server
    - git pull origin
  - restore
    - git reset head
    - git checkout -- 
    - git checkout head
  - branch
    - git branch
    - git checkout <branchname>
    - git checkout -b <branchname>
    - git branch -d <branchname>
    - git merge <branchname>
  - tag
    - git tag
    - git tag -a <tagname> -m "msg"
    - git tag -d <tagname>
    - git pull --tags
  - log
    - git log
    - git reflog
  - diff
    - git diff


参考资料  
[官网](https://git-scm.com/)  
[git版本控制原理解析及实战分享](https://zhuanlan.zhihu.com/p/670878449)
[git深入理解(一)：暂存区(Stage)，索引(index)](https://blog.csdn.net/raoxiaoya/article/details/110824019)