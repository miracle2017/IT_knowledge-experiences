## redis在命令行中设值,value太大命令行粘贴不了复制的全部内容? value从文件读取! [answer](https://stackoverflow.com/a/47368673/8714749)
cat file | redis-cli -h host -p port -a password -x SET key

### redis怎么从其他不同redis实例复制个key到当前redis?
以下命令复制host a的redis的key到host b的redis上.以下命令在host b机器上执行.
redis-cli -h host_a -p port -a password --no-auth-warning  --raw get key_name | xargs redis-cli -h host_b -p port -a password --no-auth-warning -x set key_name

### redis怎么获取某个key的使用内存大小?
#[官方文档](https://redis.io/commands/memory-usage/)
#返回key和value存储所需要的内存(字节)
MEMORY USAGE key