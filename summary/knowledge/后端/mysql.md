##常用基本语法

- 创建数据库:   CREATE DATABASE RUNOOB
- 删除数据库:   DROP DATABASE RUNOOB
- 创建数据表:   CREATE TABLE table_name (column_name1 column_type1, column_name2 column_type2,)
- 删除数据表:   DROP TABLE table_name
- 插入数据:     INSERT INTO table_name ( field1, field2,...fieldN ) VALUES  ( value1,value2,...valueN )
- 更新数据:     UPDATE table_name SET field1=new-value1, field2=new-value2   [WHERE Clause]
- 删除数据:     DELETE FROM table_name [WHERE Clause]

##mysql启动

- Linux安装多个mysql
  
  下载mysql二进制包, 然后初始化, 初始化时务必使指定basedir和database格式, 这样就能避免与已安装的冲突
  `bin/mysqld --initialize --user=mysql --basedir=/opt/mysql/mysql --datadir=/opt/mysql/mysql/data`

- 指定配置文件启动(Linux)
  
  `mysql_path/bin/mysqld --defaults-file=customize_config_path/my.cnf`
  
- 查看mysqld会以什么参数启动或初始化
  
  `bin/mysqld [--defaults-file=path/my.cnf] --print-defaults`
  

【数据库迁移,导出及其导入】

    导入： mysqldump -u root -p --all-databases > $destDir/all_databases_20180314.bak   直接在linux命令行中输入
        导入sql脚本:
           1. mysqldump -uroot -p database_name < import.sql   //Linux命令行下导入import.sql文件到库名为database_name的数据库中
           2. 先进入myslq
              use datebase
              source /root/import.sql
    
    导出： mysql -u root -p < $destDir/all_databases_20180314.bak
    

- 添加一个mysql用户并授权:   grant all privileges on *.* to 创建的用户名@"%" identified by "密码"; // % 表示所有地方都可登录
                    
    flush privileges; //刷新后才生效

ASC升序 / DESC 降序

mysqli_multi_query()   :执行多条语句

##函数:

- FROM_UNIXTIME('时间戳字段', '%Y-%m-%d');     格式化时间戳为时间格式 

- UNIX_TIMESTAMP([date]);   转换为时间戳,不传入参数为当前时间戳, 给定date(格式为正常日期时间格式如 2019-6-6 10:10:10)时则返回当时的时间戳
   current_timestamp()/ current_time()/ now()/ current_date() 获取当前的时间戳/ 完整的日期加时间/ 时间(10:10:01)/ 日期(2019-12-01)
    
- length(string)            -- string长度，字节

- char_length(string)        -- string的字符个数

- substring(str, position [,length])        -- 从str的position开始,取length个字符

- replace(str ,search_str ,replace_str)    -- 在str中用replace_str替换search_str

- CONCAT(str1, str2, ...):  拼接字符串

- count()高级用法: 如下:
    select count(IF(status=1, 1, NULL) as total, count(IF(status=0, 1, NUll) as open from table_name; (该句获取status为1的数量和status为0的数量)

- IF 用法: IF(表达式1, expr2, expr3); 表达式1为true 返回expr2; 否则返回expr3.  表达式中可用的条件运算符: "=、<、<=、>、>=、!="

- group by: 单独使用只能获取分组中的一个数据, 可以和 group_concat(name1, name2)使用(获取name1拼接上name2字段的值的整个数组):如下
    select group_concat('{id:"', name, ';:"title":"', title, '"}' from table_name; 获取出一组内容为json格式,之间逗号隔开的字符串

- ON DUPLICATE KEY:
    INSERT INTO TABLE (a,c) VALUES (1,3) ON DUPLICATE KEY UPDATE c=c+1; (存在重复值则更新)


##mysql命令行:

    show （full)　proceesslist 显示当前连接到mysql的连接或线程的清单, full将完整的显示每个查询的全文
    
    @为会话(session)变量, @@为系统变量.
    
    show variables [like "要查找的变量名,%为通配符"]
    
    show gloal|session variables    显示全部的全局或会话变量
    
    select @@global.var_name|@@var_name|@@session.var_name  查看全局变量var_name|全局变量var_name|会话变量var_name的值
    
	show [gloal] status [like "要查找的变量名,%为通配符"]  查看服务器运行状态
	
	help content

	show status like "table_locks_waited" 显示有多少锁需要等待  
	
##mysql性能分析操作

- set profiling = 1; 开启

- show profile;  显示执行语句各阶段详细执行时间

- show profiles; 显示语句执行总的时间

- last_query_cost: 查询成本 show status like 'last_query_cost'

- mysql语句前加上explain; 显示mysql如何使用索引等情况
>- [官网参考https://dev.mysql.com/doc/refman/8.0/en/explain-output.html#explain-join-types](https://dev.mysql.com/doc/refman/8.0/en/explain-output.html#explain-join-types)
>- [参考](https://www.jianshu.com/p/593e115ffadd)
        
       QEP:查询执行计划
       注：标注星号的字段为重点
        
 >- 1.__id__：SELECT语句的标识符，代表SELECT查询在整个查询中的序号。
 >>- id越大执行顺序越优先
 >>- id相同，执行顺序由上至下
 >- 2.__select_type__: SELECT查询的类型，该类型的值有11种类型。
 
 >- 3.__table__: 输出行所引用的表名。
 
 >- 4.__partitions__: 查询所匹配到的分区, 非分区表为`null`。
 
 >- 5.__*type__: 连接类型。
 >>&nbsp;&nbsp; 以下从最好到差排序
 >>- system: 当表只有一行时,这个const的特例
 >>- const: 表中最多只有一行被匹配, 因为只返回一行所以很快. 将`PRIMARY KEY` 或 `UNIQUE INDEX`索引和常量值比较时,会使用const。
 >>- eq_ref: 假设A JOIN B，B表读取A表的各个行组合的一行时，通过B表的PRIMARY KEY或UNIQUE NOT NULL索引列连接时，优化器会使用eq_ref类型，
 >>- ref: 基于键值选择出行数不止一行. 
 >>- fulltext: 使用可全文索引.
 >>- ref_or_null: 连接类型类似ref,同时附加查找包含null的值.
 >>- index_merge: 查询中有多个独立索引,但是只能使用一个, mysql分别对多个索引进行扫描,然后合并结果.只能合并单表不能合并多表的扫描结果.
 >>- unique_subquery: eq_ref类型在子查询中的替代类型.
 >>- range: 在WHERE子句中，执行>,<,<>,=,BETWEEN,IN() 等操作时，MySQL可能会(不一定)使用range类型.
 >>- index: index类型和ALL类型几乎相同. 
 >>>&nbsp;&nbsp;有两种情况:
 >>>- select 中的列被全部索引覆盖, mysql只需要对索引树进行扫描, 这种情况下extra会显示  USING INDEX
 >>>- 使用索引读取主键值, 按照索引的顺序对全表进行扫描, 此时extra 中没有 USING INDEX
 >>- all: 对表中每一行进行扫描, 这个最糟糕的情况. 
 
 >- 6.__possible_key__: 在查询中能够用到的索引，但是实际中不一定会被全部用到, 这取决`mysql`优化器的选择.
 
 >- 7.__*key__: 查询中实际用到的索引, 该列的值可能包含`possible_key`列中没有出现的索引; 当查询满足覆盖索引的条件时，`possible_keys`列为`NULL`，索引仅在`key`列显示，`MySQL`只需要扫描索引树，不用到实际的数据行检索即可得到结果，查询会更高效，`Extra`列显示`USING INDEX`，则证明使用了覆盖索引。 
                            
 >- 8.__key_len__: 实际用到的索引字段长度，越短越好。     
 
 >- 9.__ref__: 显示哪个列或者常数和索引比较筛选出结果。
 
 >- 10.__rows__: MySQL认为执行查询必须检查的行数，对Innodb表来说，这是一个预估值，可能并不是确切的值。

 >- 11.__filtered__: 过滤百分比, 1~100, 值越大可能意味着索引越好。
 
 >- 12.__*Extra__: 附加信息
 
 
 
	
##索引生效条件

>假设index（a,b,c）
>- 最左前缀匹配：模糊查询时，使用%匹配时：'a%'会使用索引，'%a'不会使用索引
>- 条件中有or: 索引不会生效
>- a and c: a生效，c不生效
>- b and c: 都不生效
>- a and b > 5 and c : a和b生效，c不生效。
    
    
## mysql优化

[MySQL优化/面试，看这一篇就够了](https://zhuanlan.zhihu.com/p/53865600)

[mysql优化30条经验参考http://www.jincon.com/archives/120/](http://www.jincon.com/archives/120/)
[参考https://dbaplus.cn/news-155-1531-1.html](https://dbaplus.cn/news-155-1531-1.html)
[参考http://itindex.net/detail/55421-mysql-sql-%E8%AF%AD%E5%8F%A5](http://itindex.net/detail/55421-mysql-sql-%E8%AF%AD%E5%8F%A5)
[参考https://www.cnblogs.com/huchong/p/10219318.html#_lab2_1_0](https://www.cnblogs.com/huchong/p/10219318.html#_lab2_1_0)


>###mysql查询执行过程
>- 客户端向MySQL服务器发送一条查询请求
>- 服务器首先检查查询缓存，如果命中缓存，则立刻返回存储在缓存中的结果。否则进入下一阶段
>- 服务器进行SQL解析、预处理、再由优化器生成对应的执行计划
>- MySQL根据执行计划，调用存储引擎的API来执行查询
>- 将结果返回给客户端，同时缓存查询结果
>![](../../../images/mysql/mysql查询过程.jpg)

    
##mysql存储引擎之Federated

    Federated实现同步远端表格, 实现数据库映射.一边更改时,对方都会随之变化.

>开启:

  - show engines; 查看federated引擎是否开启, 远端的mysql表的存储引擎可以不是federated

  - 没有开启进入my.ini文件加入一行 `federated` 即可, 重启再次show engines查看是否开启

>使用: 

 - 创建新表加上CONNECTION='mysql://mysql_user:password@remote_ip:port/database_name/table_name'
 
   例子: CONNECTION='mysql://test:test@172.16.16.204:3306/lry/fed_test'; 
   
##mysql存储引擎之MRG_MyISAM
    >将所有表具有相同的列数据类型和索引信息集合到一个表上.MERGE表 的替代方法是分区表(它将单个表的分区存储在单独的文件中。分区使得一些操作能够更有效地执行，并且不限于MyISAM 存储引擎。)
   
##mysql备份与恢复
  [官网的参考https://dev.mysql.com/doc/refman/5.7/en/backup-and-recovery.html](https://dev.mysql.com/doc/refman/5.7/en/backup-and-recovery.html)
  - 使用mysqldump进行备份及恢复
  - 使用二进制文件进行增量备份或者恢复
  
##mysql经典面试题
  [参考https://www.jianshu.com/p/977a9e7d80b3](https://www.jianshu.com/p/977a9e7d80b3)
  
  
##mysql数据类型
  - 数值
  
    >对于整数类型，M表示最大显示宽度。最大显示宽度为255.显示宽度与存储大小,类型可包含的值范围无关. 当插入的表的字段数据长度小于设定的INT(M)最大长度的时候，检索出来的数据会自动空格补充, 如果你设定zerofill, 那么可以看到存入的格式是在实际数字前补零到总的位数等于M。zerofill(补零)，当实际插入的数据长度小于建表的时候设定的长度时候，它会从左开始补零, 具体补多少与int(M)的M有关。这个修饰符可以防止MySQL存储负值。比如int(20)表示显示宽度是20, 但是实际上可以存储的只有10位数范围2^32-1(无符号), 整数的类型决定着存储的大小, 具体大小和范围如下
    
    >对于浮点和定点类型， M是可以存储的总位数。
     
    - TINYINT: 1个字节, 无符号的取值范围: 0 ~ 2^8-1, 有符号 -128 ~ 127
    - SMALLINT: 2个字节  无符号的取值范围: 0 ~ 2^16-1
    - MEDIUMINT: 3个字节 无符号的取值范围: 0 ~ 2^24-1
    - INT: 4个字节  无符号的取值范围: 0 ~ 2^32-1
    - BIGINT: 8个字节 无符号的取值范围: 0 ~ 2^64-1
    
  - 字符串
    >varchar(M) M表示最大存储范围M个字节, 实际存储多少字节是变动的, 内容多少就是多少字节
     char(M) M表示最大存储范围M个字节, 实际存储时都是固定的M字节 

    >ps: 手机号建议存成字符串类型
   
  
    
##Mysql工具使用集合

- ###monyog --- mysql性能检测工具(window)  

- ###mysql主从同步,主主同步（可用于读写分离)
 
  [参考https://blog.csdn.net/mycwq/article/details/17136001](https://blog.csdn.net/mycwq/article/details/17136001)
  [参考https://www.jianshu.com/p/0d07b446ae33](https://www.jianshu.com/p/0d07b446ae33)
  ps: master1->master2实现主从同步, 反过来mater2->master1也实现主从同步,这样就主主同步了
 
  >使用到的三个线程. 2个在从服务器上, 1个在主服务 
  >>[官网参考https://dev.mysql.com/doc/refman/5.7/en/replication-implementation-details.html](https://dev.mysql.com/doc/refman/5.7/en/replication-implementation-details.html)
    - Binlog dump thread: 在从设备连接时将二进制日志内容发送到从设备。
    - Slave I/O thread: 连接并接收主服务器发送的数据并存储在中继日志(relay log)文件上
    - Slave SQL thread: 读取中继日志(relay log )文件, 执行其中的事件
    
- ###Percona toolkit分析mysql工具
  >感觉不是很有用
  
- ###PXC(Percona XtraDB Cluster)实现mysql集群
   [参考https://www.jianshu.com/p/db7190658926](https://www.jianshu.com/p/db7190658926)
   
- ###mysql性能检测工具之 innotop
  >安装
  - yum install innotop
  >使用
  - innotop -u username -p 'password'
  - 进入后输入 ` 模式代码字母(大小写敏感) ` 进行模式切换
  
##忘记密码
  
  [How to Reset the Root Password官网](https://dev.mysql.com/doc/refman/5.6/en/resetting-permissions.html)

##杂项
    
- innodb默认是行锁，**前提条件是建立在索引之上的**。如果筛选条件没有建立索引，会降级到表锁。
即如果where条件中的字段都加了索引，则加的是行锁；否则加的是表锁。

- 索引对update语句影响 例:update table_name set a = value where b = value;  
b字段有索引时能用到索引,mysql能快速定位要更新的位置速度变快, a有索引更新不仅要更新表数据还要更新索引所以变慢.

- mysql使用UNIX sock方式或者tcp连接
  
  host是localhost时，优先使用socket方式，也可以使用--protocol指定采用什么方式连接
  在php编程中，host为localhost即可实现使用socket方式连接

- 删除重复字段保留最大或者最小值? 
  - 方法1 (即找出所有重复的id, 然后在找出每组重复id最小值, 然后去除此部分. 需要用到一个中间表, 不然会报错因为不能对一个表又select又delete(update等)操作)
  
    DELETE FROM ls_article_new WHERE id in
    (SELECT id FROM
    (SELECT
    id
    FROM 
    ls_article_new 
    where
    id in (SELECT id FROM `ls_article_new` GROUP BY  out_article_id HAVING COUNT(out_article_id) > 1)
    AND
    id NOT in (SELECT min(id) FROM `ls_article_new` GROUP BY  out_article_id HAVING COUNT(out_article_id) > 1)
    ) as a)
  
