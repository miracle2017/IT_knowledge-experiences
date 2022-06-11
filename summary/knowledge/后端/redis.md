- 用redis实现锁的好实践[answer](https://redis.io/docs/reference/patterns/distributed-locks/)
  - 单实例中锁的正确实现方式.(https://redis.io/docs/reference/patterns/distributed-locks/#correct-implementation-with-a-single-instance)
    大体思路: `SET resource_name my_random_value NX PX 30000` 其中注意点my_random_value应该要是你应用中全局唯一的,释放key时要同时
    对比value是否等于要删除他的客户端设的,相等时才能删除; 否则,则表明锁过了设定时间被其他客户端获取了.
  - 分布式锁(https://redis.io/docs/reference/patterns/distributed-locks/#the-redlock-algorithm)
    大体思路: 分布式系统即是有多台redis主机,互相独立,所以不需要主从复制或者其他暗藏辅助系统.实现即是每次获取锁时都按顺序依次从全部实例中用
    语句`SET resource_name my_random_value NX PX 30000`获取锁,如果获得大于(N/2 + 1)个节点的锁, 则认为取得锁. 释放锁时,全部实例都释放
    一遍(不论是否获取到了)