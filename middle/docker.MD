**docker**
- [定义](#定义)
- [使用](#使用)

# 定义 #
容器技术

# 使用 #
```
- 镜像
  - 查看
    docker images
    docker image ls
  - 搜索
    docker search 镜像名
  - 获取
    docker pull 仓库地址/用户/仓库:标签 
  - 删除
    docker rmi <镜像ID> 
  - 创建
    - 通过容器创建
      docker commit -a="作者" -m="描述信息" 容器名或容器ID 用户名/仓库名:标签 
    - 通过Dockerfile创建镜像
      docker image build -t 仓库名:标签 当前路径
      docker push 用户名/仓库名:标签
- 容器
  - 查看
    docker container ls
  - 创建
    docker create 
  - 启动
    docker start 容器ID或容器名
  - 暂停
    docker stop 容器ID或容器名
  - 重启
    docker restart 容器ID或者容器名
  - 删除
    docker rm 容器ID或容器名
  - 日志
    docker logs 容器ID或容器名
  - 进入
    docker exec -it 容器ID或容器名 /bin/bash
```