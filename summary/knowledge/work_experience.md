- 用redis做数量限制, 两种方法: 1.使用计数器累加, 然后在限制值做比较; 2.初始值从限定值开始一直递减,在和0作比较; 第二种比较好, 因为如果redis由于
某种原因坏了. 那么方法1就会从又从0开始,这就会导致超发.

- 做接口时,需要考虑调用频率和实际会用到的数据.尽量拆分细点.比如app上的消息(最外层显示未读数,点进去在显示消息内容),此时是做成1个接口还是2个接口好,
从技术上可以合并成一个是方便.但是考虑到实际使用场景,点进入的人并不多,所以做成1个接口每次都下发消息内容是浪费的.所以拆成2个接口是比较合理的:即
一个只下发未读数,一个具体消息内容.

- 消息接口分页怎么设计?
    1. 用第几页page和每页数量size控制.此方式只适用消息是从旧到新展示.如果是新到旧加载就有可能会出现错位(突然来了些新消息,这页内容就会不一样了).
    2. 有个偏移量offset和每次取的条数size控制, 比如偏移量可以用库中的id来做, 所以往新或旧的方向偏移都可以.而且不会出现错位问题.所以此种方式会更好!

- 怎么根据pv预估qps?
  一天按扣去睡觉10个小时左右的时间算.得出平均,平均和峰值的关系可以参考已有监控中平均qps和峰值qps的倍数来计算(可能2倍左右).