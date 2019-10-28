# MySQL官方手册

## 2.安装升级MySQL
- Postinstallation Setup and Testing
  - mysql_secure_installation: 安装MySQL后, 运行此程序后会提供一些安全方面的建议 
  
  - Upgrading MySQL

## 4.MySQL Programs

### 4.2 Using MySQL Programs

#### 4.2.2 Specifying Program Options
 
##### 4.2.2.1 Using Options on the Command Line
    
  - 命令行中指定程序选项
    
    - 横杠(-): 可以紧接值, 或者空格在接值.(唯独 -p 例外, 必须马上接值, 不然空格会当成密码)
    - 双横杠(--): 后面必须紧接 =值(其间不能有空格), 或者一个空格再紧接值(不建议, 选项有默认值就不会起作用甚至报错)
    - 短横杠开头的选项为简写, 双横杠开头的选项为全称格式
    - 指定系统变量时, 横杠与下划线等价(开头横杠不行);(如 --skip-grant-tables 等价 --skip_grant_tables;) 但在运行中设置系统变量时(如set, select), 必须使用下划线格式(如SET GLOBAL general_log = ON;)
    - 选项的值中有空格时,必须使用引号, 如果是多条mysql语句用;分隔(如mysql -u root -p -e "SELECT VERSION();SELECT NOW()")
    
##### 4.2.2.2 Using Option Files
   - Option File Processing Order
     window, Linux读取配置文件的顺序[链接](https://dev.mysql.com/doc/refman/5.7/en/option-files.html#option-file-order),后面的配置优先前者
   - Option File Syntax
     - #和;为注释符, #注释可以出现在句中
     - [group] group选项配置应用于同名的程序上(如[mysql] 应用与mysql客户端程序)
   - Option File Inclusions
     - !include /home/mydir/myopt.cnf : 引入配置文件
     - !includedir /home/mydir : 在指定目录查找.cnf后缀的配置文件(Unix系统); .ini或.cnf后缀文件(window系统), 不使用引号,路劲中不能有转义字符, 
     例子(`!include C:\\ProgramData\\MySQL\\MySQL Server\\myopts.ini`)
   
#### 4.2.5 Connection Compression Control
   压缩连接能减少数据的传送, 需要服务端和客户端都支持, 默认关闭; 压缩连接都会增加服务端和客户端的cpu负载, 因为都要压缩和解压缩; 
   因为会降低性能所以仅在低网速(网络传输消耗大于压缩解压缩)才会有收益.
 
##### 4.5.1.3 mysql Client Logging
命令行交互式语句默认都会被记录在home目录下默认名字为.mysql_history的文件中, 也可以设置为不记录
需注意, 设置密码时, 明文可能会被记录, 所以需确认设置密码会不会被记录以提高安全性

##### 4.5.1.5 Executing SQL Statements from a Text File
> 从文件读取sql语句并执行, 如下2种方法
  1. >shell mysql -uroot -p [datebase_name] < test_file > result.log; 如果文件有use datebase; datebase_name参数就不需要在命令行中指定
  2. >mysql source test_file 或 >mysql  \. test_file

#### 4.5.3 mysqlcheck — A Table Maintenance Program
>mysqlcheck是checks, repairs, optimizes,analyzes tables sql语句方便调用的一个工具. mysqlcheck和myisamchk差不多, 在mysql serve运行时使用mysqlcheck, 关闭时使用myisamchk
- quick: prevents the check from scanning the rows to check for incorrect links.这是最快的check方式. 如果使用该方式去repair表, 则只repair index tree, 这是最快的repair方式.
- fast: 仅检查为正确关闭的表
- check: check table for error
- repair:  fix almost anything except unique keys that are not unique
- analyze: 分析表
- optimize: 优化表

#### 4.5.4 mysqldump — A Database Backup Program
> mysqldump施行的是逻辑备份(即是sql语句), 也可以导出为其他的定界文本如csv

　- --opt: 导出时默认使用该选项, 其为多个选项集合的缩写, 性能也不错
  - 一键复制到远程:mysqldump --opt db_name | mysql --host=remote_host -C db_name
  - --master-data[=value]: 会在导出的备份文件中会包含一个`CHANGE MASTER TO`语句以记录下binary log的坐标(日志文件名和位置), 后续要从二进制文件中恢复数据就知道从日志文件名的那个位置开始执行了.value为1时, 重新导入备份文件时,该CHANGE MASTER TO语句会被执行, 而value=2时, 语句只是显示信息而已不会被执行, 如果没有指定value默认为1.

#### 4.5.5 mysqlimport — A Data Import Program
>为`load data` sql语句提供一个命令行界面

#### 4.5.7 mysqlslap — Load Emulation Client
>负载仿真测试工具

#### 4.6.1 innochecksum — Offline InnoDB File Checksum Utility
>  prints checksums for InnoDB files. 

#### 4.6.2 myisam_ftdump — Display Full-Text Index information
>展示MyISAM表的索引(因为他是直接读取MyISAM索引文件,所以该程序要和表是在同一服务器上); 如果服务器是开启的请先执行flush tables在该命令执行之前

####　4.6.5 myisampack — Generate Compressed, Read-Only MyISAM Tables
>生成一个压缩只读的表. 在服务器停机后执行是最安全的

#### 4.6.6 mysql_config_editor — MySQL Configuration Utility
>管理名为.mylogin.cnf(默认在用户home目录下)的模糊登录路径文件, 当如mysql. mysqladmin等客户端工具使用--login-path=.mylogin.cnf启动时, 这些客户端会读取其中的[client], [mysql], [mypath]块配置(优先权高于其他配置文件但低于命令行的), 这样就能知道要连接那个mysql server, 同时记录在.mylogin.cnf的密码不是明文的有一定安全性(但是不要认为它是牢不可破,因为无法阻挡有决心的攻击者), 有多个mysql服务器时方便连接切换

#### 4.6.8 mysqlbinlog — Utility for Processing Binary Log Files

- 使用mysqldump + mysqlbinlog for Backup and Restore
  事先使用mysqldump导出备份文件作为快照, 使用 mysqlbinlog备份bin log二进制文件(可以永不断开的持续实时备份). 在万一数据丢失了,先导入备份文件, 然后执行二进制备份,可执行类似如下命令 `mysqlbinlog --start-position=27284 binlog.001002 binlog.001003 binlog.001004 | mysql --host=host_name -u root -p`

#### 4.6.9 mysqldumpslow — Summarize Slow Query Log Files

#### 4.7.3 my_print_defaults — Display Options from Option Files
> my_print_defaults展示给定程序会使用配置文件中给定选项组的具体配置. 使用例子: my_print_defaults mysqlcheck client -uroot -p

#### 4.8.2 replace — A String-Replacement Utility
> 替换文件中字符串, 如 replace a b b a -- file_name(将a和b互换)

#### 4.8.3 resolveip — Resolve Host name to IP Address or Vice Versa
> 将ip解析成host names或者将host name解析成ip

### 5.1 The MySQL Server
#### 5.1.1 Configuring the Server
最重要的配置变量: key_buffer_size and table_open_cache

#### 5.1.6 Server Command Options

#### 5.1.7 Server System Variables
- back_log: mysql可以拥有未完成连接请求的数量, 默认50, -1自动调整. 当你短时间有很多请求才需要提高此值

- big_tables: mysql server将所有临时表都存储在disk上而不是内存上, 可以避免需要大的临时表不够的情况, 但同时也降低原本在内存表就够的查询

- bind_address: mysql server监听单个网络套接字上侦听TCP / IP连接. 有如下取值:
  - `*`: 默认值. 所有服务主机的ipv4接口和ipv6接口(如果支持).(ps: 所有现有的mysql账号都可连接)
  - `0.0.0.0`: 监听所有服务主机的ipv4接口
  - `::` : 监听所有服务主机的ipv6接口
 
- bulk_insert_buffer_size: 
- completion_type: 
- concurrent_insert:
- delay_key_write: 只对MyISAM表有效. 不会在每次索引更新时都为key buffer都进行刷新只在表关闭时.
- flush: 
- flush_time
- foreign_key_checks
- general_log: 
- general_log_file: 
- ignore_db_dirs:
- init_connect: 在每个客户端(超级用户除外,因为以防sql有错误所有客户端都没能登录)连接初始时执行指定的sql语句(多个sql;分隔).


## 10 
### 10.8   

#### 10.8.5 The binary Collation Compared to _bin Collations   

- The Unit for Comparison and Sorting
  - binary collation的比较和排序基于数字字节值(base on numeric byte values)
  - nobinary string是字符序列(sequences of characters), 它的collations值定义了用于比较和排序的字符值的顺序
- Character Set Conversion
  - 当character set有变化时, binary collation的字符串的值不会改变
- Lettercase Conversion
  nobinary string的collation提供字母大小信息, 而二进制字符串没有
  如使用 select upper(binary 'aZ'); 结果还是 'aZ', upper要生效需将collation转换为非二进制的

- Trailing Space Handling in Comparisons
  - 进行比较时,nobinary string会裁掉尾部的空格, select 'a' = 'a  '结果是1.
  - 进行比较时, binary string则是原样比较 select 'a' = 'a  '结果0
  
- Trailing Space Handling for Inserts and Retrievals
  - CHAR(N) columns: 
    - 插入时: 当插入值小于N时, 尾部补上空格; 读取时: 去掉尾部的空格
  - BINARY(N) columns: 
    - 插入时: 当插入值与N时, 尾部不上0x00 bytes(就是(N-插入值)个00); 读取时, 不会任何移除, 原样返回
    
##### 13.7.2.1 ANALYZE TABLE Syntax    
>performs a key distribution analysis and stores the distribution. 而MySQL会使用stored key distribution决定表join的顺序(join对象是constant 情况除外); 以及查询语句中表的哪个index被使用

##### 13.7.2.2 CHECK TABLE Syntax
>检测表错误.对于MyISAM表,the key statistics are updated as well.

##### 13.7.2.3 CHECKSUM TABLE Syntax
>对于表内容检验和, 可用于检测backup, rollback等操作前后表的内容是否一致

##### 13.7.2.4 OPTIMIZE TABLE Syntax
>reorganizes the physical storage of table data and associated index date, to reduce storage space and improve I/O efficiency

- 支持的存储引擎: InnoDB, MyISAM,ARCHIVE


- 可在如下场合中使用
  1. after doing substantial insert, update, or 
  delete operations on an InnoDB table.( innodb_file_per_table配置要是ON)
  2. After doing substantial insert, update, or delete operations on columns that are part of a FULLTEXT index in an InnoDB table.
  3. After deleting a large part of a MyISAM or ARCHIVE table, 或者 making many changes to a MyISAM or ARCHIVE table with variable-length rows (tables that have VARCHAR, VARBINARY, BLOB, or TEXT columns). deleted rows are maintained in a linked list之后的insert操作会reuse old row positions.使用OPTIMIZE TABLE可对未使用的空间进行回收和整理data file的碎片.

##### 13.7.2.5 REPAIR TABLE Syntax
>修复可能损坏的表. 通常你永远都不必执行该语句, 但如果发生灾难, 该语句可能能让你从MyISAM表中取回所有数据
- 支持的存储引擎:MyISAM, ARCHIVE, and CSV，不支持视图

- 重要事项 
  - 在修复表前请先备份backup表, 因为可能会导致数据的丢失
  - 在修复表时服务器崩溃了, 在重启服务器后请必须马上先再执行修复表命令, 在做其他操作之前. 在最坏的情况, 你可能会有一个新的索引文件而没有包含任何数据文件信息 所以这就是提前备份的价值.
  - 如果修复一张在master的损坏表, 其对原始表的修改变化不会被传播到slaves上
  
- 参数选项
  - QUICK: 仅仅修复索引文件, 不会修复数据文件  
    
## 14.innoDB storage Engine

### 14.6innoDB On-Disk Structures

#### 14.6.1 Tables
#### 14.6.1.4 AUTO_INCREMENT Handling in InnoDB
 - InnoDB AUTO_INCREMENT Lock Modes
   1. innodb_autoinc_lock_mode = 0 ("traditional" lock mode)
      会产生表锁
   2. innodb_autoinc_lock_mode = 1 ("consecutive" lock mode)
      
   3. innodb_autoinc_lock_mode = 2 ("interleaved" lock mode)
      速度最快(有些情况也会产生表级锁), 但是it is not safe whenusing statement-based replication or recovery scenarios when SQL statements are replayed from the binary log

 - InnoDB AUTO_INCREMENT Lock Mode Usage Implications

   - Using auto-increment with replication
     - 使用statement-based replication: 设置innodb_autoinc_lock_mode为0或1同时master和slaves必须同一个值, 这样是安全的
     - row-based or mixed-format replication: innodb_autoinc_lock_mode的所有模式都安全
     - "Lost" auto-increment values and sequence gaps
        所有模式中, 当一个值已经分配给自增键, 这个值都不会再被使用, 无论事务是否回滚
     - 自增值超过定义类型的最大值: 会报错duplicate entry ...
     
 - InnoDB AUTO_INCREMENT Counter Initialization
   在InnoDB中, 自增计数器存储内存中; 空表默认1(auto_increment_offset可以设置)开始; 当服务器重启了, 自增计数器会在第一次插入操作或show table status时初始化(做类似的操作: SELECT MAX(ai_col) FROM table_name FOR UPDATE;)
 
 
##命令行命令
>mysql命令行键入: `help`, 可以获取全部可用的命令信息 
 - status (\s): 从服务端获取状态信息(比如连接信息等等), 用法 直接在命令行中键入status或\s
 
>获取serve side help; mysql命令行中键入 `help contents` 获取所有分类help
   
##有用(未分类)

  - 设置mysql server slow shutdown: mysql -u root -p --execute="SET GLOBAL innodb_fast_shutdown=0" , 然后mysqladmin -u root -p shutdown
  
  
## 常用基本语法

- SQl(Structured Query Language, 结构化查询语言)分为4种语言:
    - DDl(Data Definition Language, 数据定义语言)
    - DML(Data Manipulate Language, 数据操纵语言)
    - DCL(Data Control Language, 数据控制语言)
    - TCL(transaction Control Language, 事务控制语言)

- 创建数据库:   CREATE DATABASE RUNOOB
- 删除数据库:   DROP DATABASE RUNOOB
- 创建数据表:   CREATE TABLE table_name (column_name1 column_type1, column_name2 column_type2,)
- 删除数据表:   DROP TABLE table_name
- 插入数据:     INSERT INTO table_name ( field1, field2,...fieldN ) VALUES  ( value1,value2,...valueN )
- 更新数据:     UPDATE table_name SET field1=new-value1, field2=new-value2   [WHERE Clause]
- 删除数据:     DELETE FROM table_name [WHERE Clause]

- 创建用户: CREATE USER 'jeffrey'@'localhost' IDENTIFIED BY 'password';(刚创建的用户没有操作数据库的权限, 只能登录, 故需给用户授权)

- 授权用户: GRANT ALL ON *.* TO 'someuser'@'somehost';(该句例子为全局授权)

- 删除用户: DROP USER 'jeffrey'@'localhost';

## mysql启动

- Linux安装多个mysql
  
  下载mysql二进制包, 然后初始化, 初始化时务必使指定basedir和database格式, 这样就能避免与已安装的冲突
  `bin/mysqld --initialize --user=mysql --basedir=/opt/mysql/mysql --datadir=/opt/mysql/mysql/data`

- 指定配置文件启动(Linux)
  
  `mysql_path/bin/mysqld --defaults-file=customize_config_path/my.cnf`
  
- 查看mysqld会以什么参数启动或初始化
  
  `bin/mysqld [--defaults-file=path/my.cnf] --print-defaults`
  

【数据库迁移,导出及其导入】

- 导出： mysqldump -u root -p --all-databases > $destDir/all_databases_20180314.bak   直接在linux命令行中输入

- 导入： mysql -u root -p < $destDir/all_databases_20180314.bak
    导入sql脚本:
       1. mysqldump -uroot -p database_name < import.sql   //Linux命令行下导入import.sql文件到库名为database_name的数据库中
       2. 先进入myslq
          use datebase
          source /root/import.sql
    

- 添加一个mysql用户并授权:   grant all privileges on *.* to 创建的用户名@"%" identified by "密码"; // % 表示所有地方都可登录
  flush privileges; //刷新后才生效

ASC升序 / DESC 降序

mysqli_multi_query()   :执行多条语句

## 函数:

- FROM_UNIXTIME('时间戳字段', '%Y-%m-%d');     格式化时间戳为时间格式 

- UNIX_TIMESTAMP([date]);   转换为时间戳,不传入参数为当前时间戳, 给定date(格式为正常日期时间格式如 2019-6-6 10:10:10)时则返回当时的时间戳
   current_timestamp()/ current_time()/ now()/ current_date() 获取当前的时间戳/ 完整的日期加时间/ 时间(10:10:01)/ 日期(2019-12-01)
   
- TIMESTAMPDIFF(unit, datetime_expr1, datetime_expr2): datetime_expr2, datetime_expr1可以是date或datetime, 返回datetime_expr2 − datetime_expr1的值, unit控制结果的单位. 例: TIMESTAMPDIFF(MONTH,'2002-02-01 12:12:12','2003-05-01'); 结果15
    
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


## mysql命令行:

- show status:(provides server status information) 服务器系统状态 [官网](https://dev.mysql.com/doc/refman/5.7/en/show-status.html)

- show variables:(shows the values of MySQL system variables) 系统变量, 分为GLOBAL和SESSION, 大部分可以被改变  [官网](https://dev.mysql.com/doc/refman/5.7/en/show-variables.html)

    show （full)　proceesslist 显示当前连接到mysql的连接或线程的清单, full将完整的显示每个查询的全文
    
    @为会话(session)变量, @@为系统变量.
    
    show variables [like "要查找的变量名,%为通配符"]
    
    show gloal|session variables    显示全部的全局或会话变量
    
    select @@global.var_name|@@var_name|@@session.var_name  查看全局变量var_name|全局变量var_name|会话变量var_name的值
    
	show [gloal] status [like "要查找的变量名,%为通配符"]  查看服务器运行状态
	
	help content

	show status like "table_locks_waited" 显示有多少锁需要等待  
	
	
## mysql性能分析操作

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
 
 
 
	
## 索引生效条件

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


>### mysql查询执行过程
>- 客户端向MySQL服务器发送一条查询请求
>- 服务器首先检查查询缓存，如果命中缓存，则立刻返回存储在缓存中的结果。否则进入下一阶段
>- 服务器进行SQL解析、预处理、再由优化器生成对应的执行计划
>- MySQL根据执行计划，调用存储引擎的API来执行查询
>- 将结果返回给客户端，同时缓存查询结果
>![](../../../images/mysql/mysql查询过程.jpg)

    
## mysql存储引擎之Federated

    Federated实现同步远端表格, 实现数据库映射.一边更改时,对方都会随之变化.

>开启:

  - show engines; 查看federated引擎是否开启, 远端的mysql表的存储引擎可以不是federated

  - 没有开启进入my.ini文件加入一行 `federated` 即可, 重启再次show engines查看是否开启

>使用: 

 - 创建新表加上CONNECTION='mysql://mysql_user:password@remote_ip:port/database_name/table_name'
 
   例子: CONNECTION='mysql://test:test@172.16.16.204:3306/lry/fed_test'; 
   
## mysql存储引擎之MRG_MyISAM
    >将所有表具有相同的列数据类型和索引信息集合到一个表上.MERGE表 的替代方法是分区表(它将单个表的分区存储在单独的文件中。分区使得一些操作能够更有效地执行，并且不限于MyISAM 存储引擎。)
   
## mysql备份与恢复
  [官网的参考https://dev.mysql.com/doc/refman/5.7/en/backup-and-recovery.html](https://dev.mysql.com/doc/refman/5.7/en/backup-and-recovery.html)
  - 使用mysqldump进行备份及恢复
  - 使用二进制文件进行增量备份或者恢复
  
## mysql经典面试题
  [参考https://www.jianshu.com/p/977a9e7d80b3](https://www.jianshu.com/p/977a9e7d80b3)
  
  
## mysql数据类型
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
   
  
    
## Mysql工具使用集合

- ### monyog --- mysql性能检测工具(window)  

- ### mysql主从同步,主主同步（可用于读写分离)
 
  [参考https://blog.csdn.net/mycwq/article/details/17136001](https://blog.csdn.net/mycwq/article/details/17136001)
  [参考https://www.jianshu.com/p/0d07b446ae33](https://www.jianshu.com/p/0d07b446ae33)
  ps: master1->master2实现主从同步, 反过来mater2->master1也实现主从同步,这样就主主同步了
 
  >使用到的三个线程. 2个在从服务器上, 1个在主服务 
  >>[官网参考https://dev.mysql.com/doc/refman/5.7/en/replication-implementation-details.html](https://dev.mysql.com/doc/refman/5.7/en/replication-implementation-details.html)
    - Binlog dump thread: 在从设备连接时将二进制日志内容发送到从设备。
    - Slave I/O thread: 连接并接收主服务器发送的数据并存储在中继日志(relay log)文件上
    - Slave SQL thread: 读取中继日志(relay log )文件, 执行其中的事件
    
- ### Percona toolkit分析mysql工具
  >感觉不是很有用
  
- ### PXC(Percona XtraDB Cluster)实现mysql集群
   [参考https://www.jianshu.com/p/db7190658926](https://www.jianshu.com/p/db7190658926)
   
- ### mysql性能检测工具之 innotop
  >安装
  - yum install innotop
  >使用
  - innotop -u username -p 'password'
  - 进入后输入 ` 模式代码字母(大小写敏感) ` 进行模式切换
  
## 忘记密码
  
  [How to Reset the Root Password官网](https://dev.mysql.com/doc/refman/5.6/en/resetting-permissions.html)

## 杂项
    
- innodb默认是行锁，**前提条件是建立在索引之上的**。如果筛选条件没有建立索引，会降级到表锁。
即如果where条件中的字段都加了索引，则加的是行锁；否则加的是表锁。

- 索引对update语句影响 例:update table_name set a = value where b = value;  
b字段有索引时能用到索引,mysql能快速定位要更新的位置速度变快, a有索引更新不仅要更新表数据还要更新索引所以变慢.

- mysql使用UNIX sock方式或者tcp连接
  
  host是localhost时，优先使用Unix domain sockets方式，也可以使用--protocol指定采用什么方式连接
  在php编程中，host为localhost即可实现使用socket方式连接. [php官网关于数据库连接的说明](https://www.php.net/manual/zh/mysqli.quickstart.connections.php)

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
    
- Foreign Keys: InnoDB表才支持

- 字符串搜索是否大小敏感? 
  [Case Sensitivity in String Searches](https://dev.mysql.com/doc/refman/5.6/en/case-sensitivity.html)
  - 以下2种情况大小写敏感
    - 被搜索字段与搜索字符串的排序规则(collation)如果是相同
    - 被搜索字段与搜索字符串至少有一个是binary(有一个是binary,就当作binary比较, 被搜索的字段的collation有_bin后缀就是binary)
  - 怎么才能用上大小敏感的搜索
      永久: 将表的字段的排序顺序(collate)设置为binary(即有_bin后缀就是, 如字符集(chart set为utf8, 那么utf_bin就是binary的))
      如果表中字段不是binary又不想改, 那么需将搜索字符串定义为binary. 例如 select * from table_name where binary name = "value" 或者 select * from table_name where name = binary "value";
  - 查看字段是否是大小敏感?
     show collation(column name);结果有_bin后缀或binary就是大小写敏感 (如show collation(version()) )
  - binary collate string和nobinary string的比较?[参考](#1085)

- navicat使用技巧
  在输入查询语句时按下esc为智能提示 
 
