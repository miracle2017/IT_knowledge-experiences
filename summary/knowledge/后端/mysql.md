##常用基本语法

- 创建数据库:   CREATE DATABASE RUNOOB
- 删除数据库:   DROP DATABASE RUNOOB
- 创建数据表:   CREATE TABLE table_name (column_name1 column_type1, column_name2 column_type2,)
- 删除数据表:   DROP TABLE table_name
- 插入数据:     INSERT INTO table_name ( field1, field2,...fieldN ) VALUES  ( value1,value2,...valueN )
- 更新数据:     UPDATE table_name SET field1=new-value1, field2=new-value2   [WHERE Clause]
- 删除数据:     DELETE FROM table_name [WHERE Clause]

【数据库迁移,导出及其导入】

    导入： mysqldump -u root -p --all-databases > $destDir/all_databases_20180314.bak   直接在linux命令行中输入
    
    导出： mysql -u root -p < $destDir/all_databases_20180314.bak
    

- 添加一个mysql用户并授权:   grant all privileges on *.* to 创建的用户名@"%" identified by "密码"; // % 表示所有地方都可登录
                    
    flush privileges; //刷新后才生效

ASC升序 / DESC 降序

mysqli_multi_query()   :执行多条语句

##函数:

    FROM_UNIXTIME('时间戳字段', '%Y-%m-%d');     格式化时间戳为时间格式
    UNIX_TIMESTAMP([date]);   转换为时间戳,不传入参数为当前时间戳, 给定date(格式为正常日期时间格式如 2019-6-6 10:10:10)时则返回当时的时间戳
   current_timestamp()/ current_time()/ now()/ current_date() 获取当前的时间戳/ 完整的日期加时间/ 时间(10:10:01)/ 日期(2019-12-01)
    
    CONCAT(str1, str2, ...):  拼接字符串
    
    count()高级用法: 如下:
        select count(IF(status=1, 1, NULL) as total, count(IF(status=0, 1, NUll) as open from table_name; (该句获取status为1的数量和status为0的数量)

    IF 用法: IF(表达式1, expr2, expr3); 表达式1为true 返回expr2; 否则返回expr3.  表达式中可用的条件运算符: "=、<、<=、>、>=、!="

    group by: 单独使用只能获取分组中的一个数据, 可以和 group_concat(name1, name2)使用(获取name1拼接上name2字段的值的整个数组):如下
        select group_concat('{id:"', name, ';:"title":"', title, '"}' from table_name; 获取出一组内容为json格式,之间逗号隔开的字符串

    ON DUPLICATE KEY:
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

    set profiling = 1; 开启
	show profile;  显示执行语句各阶段详细执行时间
	show profiles; 显示语句执行总的时间
	last_query_cost: 查询陈本 show status like 'last_query_cost'
	
	mysql语句前加上explain; 显示mysql如何使用索引等情况
	
##索引生效条件

    假设index（a,b,c）
    最左前缀匹配：模糊查询时，使用%匹配时：’a%‘会使用索引，’%a‘不会使用索引
    条件中有or，索引不会生效
    a and c，a生效，c不生效
    b and c，都不生效
    a and b > 5 and c,a和b生效，c不生效。
    
##mysql优化30条经验
[参考http://www.jincon.com/archives/120/](http://www.jincon.com/archives/120/)

    
##mysql存储引擎之Federated

    Federated实现同步远端表格, 实现数据库映射.一边更改时,对方都会随之变化.

>开启:

  - show engines; 查看federated引擎是否开启, 远端的mysql表的存储引擎可以不是federated

  - 没有开启进入my.ini文件加入一行 `federated` 即可, 重启再次show engines查看是否开启

>使用: 

 - 创建新表加上CONNECTION='mysql://mysql_user:password@remote_ip:port/database_name/table_name'
 
   例子: CONNECTION='mysql://test:test@172.16.16.204:3306/lry/fed_test'; 

##杂项
    
innodb默认是行锁，**前提条件是建立在索引之上的**。如果筛选条件没有建立索引，会降级到表锁。
即如果where条件中的字段都加了索引，则加的是行锁；否则加的是表锁。

索引对update语句影响 例:update table_name set a = value where b = value;  
b字段有索引时能用到索引,mysql能快速定位要更新的位置速度变快, a有索引更新不仅要更新表数据还要更新索引所以变慢.
