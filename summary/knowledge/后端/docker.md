# [容器间怎么通讯/一个访问另外一个容器?](https://www.tutorialworks.com/container-networking/)
> 多个容器处于同个用户自定义的网络下, 容器间可以通过ip或者他们的容器名相互访问.

docker有2种网络: 
- default bridge network: 允许容器间用ip互相访问. 无须配置docker就会自带叫bridge的默认网络, 没有明确指定network的容器都会连接到此容器.
- user-defined bridge network: 自己创建的network, 允许通过ip或者容器名访问互相访问.
操作:
创建自定义network: docker network create 自定义网络名
将已运行的容器接入指定network: docker network connect 网络名 容器名
列出已有的network: docker network list
查看network下接入了哪些容器: docker network inspect 网络名
**怎么看容器的ip**: docker inspect <container_id> | grep IPAddress

docker容器内访问宿主机ip?
- 在容器内,该host.docker.internal域名指向的是宿主机的ip

docker怎么查看最近实时日志? 不要输出过去全部的旧日志.
- docker logs --tail 100  -f nginx-proxy // --tail表示只输出尾部日志,这很重要,不然docker会从头开始输出历史日志, -f表示follow实时日志.