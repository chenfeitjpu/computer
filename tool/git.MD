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
    当前文件内容
  - 暂存区(stage)
    当前文件版本
  - 仓库(repository)
    仓库版本

命令
- init
  - git init <project>
  - git remote add <name> <url>
  - git push --set-upstream <remote> <branch>
  - git push -u <remote> <branch> 
  - git clone <path>
- add 
  - git add <file>
  - git commit -m <msg>
  - git commit -a -m <msg>
- pull 
  - git pull <remote> <remote branch : local branch>
  - git fetch <remote> <branch>
  - git push <remote> <local branch : remote branch>
- restore
  - git rm <file>
  - git restore <file>
    - git restore <file>
      让工作区中的所有文件撤销更改  
    - git restore --staged <file>
      让暂存区中的所有文件撤销更改 
  - git reset <commit-id>
    - git reset --mixed
      此为默认方式，将撤回的代码，存放到工作区。同时会保留本地未提交的内容
    - git reset --soft
      回退到某个版本，将撤回的代码，存放到暂存区。同时会保留本地未提交的内容
    - git reset --hard
      彻底回退到某个版本，丢弃将撤回的代码，本地没有commit的修改会被全部擦掉
  - git revert <commit-id>
- branch
  - git branch <name>
  - git checkout <name>
  - git checkout -b <chname>
  - git branch -d <branchname>
  - git merge <name>
- tag
  - git tag <name>
  - git tag -a <name> -m <msg>
  - git tag -d <name>
  - git pull --tags
- log
  - git log
  - git reflog
- diff
  - git diff
```

参考资料  
[官网](https://git-scm.com/)  
[git版本控制原理解析及实战分享](https://zhuanlan.zhihu.com/p/670878449)  
[git深入理解(一)：暂存区(Stage)，索引(index)](https://blog.csdn.net/raoxiaoya/article/details/110824019)  