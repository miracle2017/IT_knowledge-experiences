##第4章
- 4.1 持久化选项
  
  持久化两种方法: 
  - 1 快照(snapshot)
  - 2 只追加文件(AOP, append-only file)
    - 将被执行命令追加到文件尾, Redis执行一遍这些命令就能恢复数据
    - 用户可以考虑使用 appendfsync everysec 选项，让 Redis以每秒一次的频率对 AOF 文件进行同步。
      Redis 每秒同步一次 AOF 文件时的性能和不使用任何持久化特性时的性能相差无几，当硬盘忙于执行
      写入操作的时候，Redis 还会优雅地放慢自己的速度以便适应硬盘的最大写入速度。

- 4.3 处理系统故障
  - 4.3.2 更换故障主服务器
    > 假如有a, b, c三台服务器运行着redis; a是主,b为从, c备用. 现在a宕机了. 有如下2中方法更换.
    - 1.在redis b上执行save产生一个快照(一般叫dumb.rdb) -> 
         将这个文件复制到 c 服务器上的redis根目录下,并启动 c 的redis服务 -> 
         将 b 服务器的redis设置c为自己的主服务器(slaveof c服务器host port)成功更换
    - 2. 在 b 上redis设置停止作为从服务器(slaveof no one) -> 
         开启 c 服务器的redis服务, 将 b 的redis设为自己的主服务器(slaveof b的host port)