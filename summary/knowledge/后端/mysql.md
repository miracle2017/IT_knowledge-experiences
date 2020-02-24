# MySQL官方手册

## 2.安装升级MySQL
- 安装
  - 二进制安装包安装:[地址](https://dev.mysql.com/doc/refman/5.6/en/binary-installation.html#binary-installation-layout)
- Postinstallation Setup and Testing
  - mysql_secure_installation: 安装MySQL后, 运行此程序后会提供一些安全方面的建议 
  - Upgrading MySQL

## 4.MySQL Programs

### 4.2 Using MySQL Programs

#### 4.2.2 Specifying Program Options
 
##### 4.2.2.1 Using Options on the Command Line
  - 命令行中指定程序选项
    - 横杠(-): 可以紧接值, 或者空格后再接值.(唯独 -p 例外, 必须马上接值, 不然空格会当成密码)
    - 双横杠(--): 后面必须紧接 =值(其间不能有空格), 或者一个空格再紧接值(不建议, 选项有默认值就不会起作用甚至报错)
    - 短横杠开头的选项为简写, 双横杠开头的选项为全称格式
    - 指定系统变量时, 横杠与下划线等价(开头横杠除外);(如 --skip-grant-tables 等价 --skip_grant_tables;) 但在运行中设置系统变量时(如set, select), 必须使用下划线格式(如SET GLOBAL general_log = ON;)
    - 选项的值中有空格时,必须使用引号, 如果是多条mysql语句用;分隔(如mysql -u root -p -e "SELECT VERSION();SELECT NOW()")
    
##### 4.2.2.2 Using Option Files
   - Option File Processing Order
     window, Linux读取配置文件的顺序[链接](https://dev.mysql.com/doc/refman/5.7/en/option-files.html#option-file-order),后面的配置优先前者
   - Option File Syntax
     - '#'和';'为注释符,#注释可以出现在句中
     - [group] group选项配置应用于同名的程序上(如[mysql] 应用与mysql客户端程序)
   - Option File Inclusions
     - !include /home/mydir/myopt.cnf : 引入配置文件
     - !includedir /home/mydir : 在指定目录查找.cnf后缀的配置文件(Unix系统); .ini或.cnf后缀文件(window系统), 不使用引号,路径中不能有转义字符, 
     例子(`!include C:\\ProgramData\\MySQL\\MySQL Server\\myopts.ini`)
   
#### 4.2.5 Connection Compression Control
   压缩连接能减少数据的传送, 需要服务端和客户端都支持, 默认关闭; 压缩连接都会增加服务端和客户端的cpu负载, 因为都要压缩和解压缩; 
   因为会降低性能所以仅在低网速(网络传输消耗大于压缩解压缩)才会有收益.
 
##### 4.5.1.3 mysql Client Logging
命令行交互式语句默认都会被记录在home目录下默认名字为.mysql_history的文件中,也可以设置为不记录. 需注意,设置密码时,明文可能会被记录, 所以需确认设置密码会不会被记录以提高安全性

##### 4.5.1.5 Executing SQL Statements from a Text File
> 从文件读取sql语句并执行, 如下2种方法
  1. >shell mysql -uroot -p [datebase_name] < test_file > result.log; 如果文件有use datebase; datebase_name参数就不需要在命令行中指定
  2. >mysql source test_file 或 >mysql  \. test_file

#### 4.5.3 mysqlcheck — A Table Maintenance Program
>mysqlcheck是checks,repairs,,optimizesanalyzes tables sql语句方便调用的一个工具. mysqlcheck和myisamchk差不多, 在mysql serve运行时使用mysqlcheck,停机时用myisamchk
- quick: prevents the check from scanning the rows to check for incorrect links.这是最快的check方式. 如果使用该方式去repair表, 则只repair index tree, 这是最快的repair方式.
- fast: 仅检查未正确关闭的表
- check: check table for error
- repair:  fix almost anything except unique keys that are not unique
- analyze: 分析表
- optimize: 优化表

#### 4.5.4 mysqldump — A Database Backup Program
> mysqldump实行的是逻辑备份(即是sql语句), 也可以导出为其他的定界文本如csv
　- --opt: 导出时默认使用该选项, 其为多个选项集合的缩写, 性能也不错
  - 一键复制到远程:mysqldump --opt db_name | mysql --host=remote_host -C db_name
  - --master-data[=value]: 会在导出的备份文件中会包含一个`CHANGE MASTER TO`语句以记录下binary log的坐标(日志文件名和位置), 后续要从二进制文件中恢复数据就知道从日志文件名的那个位置开始执行了.value为1时, 重新导入备份文件时,该CHANGE MASTER TO语句会被执行, 而value=2时, 语句只是显示信息而已不会被执行.如果没有指定value默认为1.

#### 4.5.5 mysqlimport — A Data Import Program
>为`load data` sql语句提供一个命令行界面

#### 4.5.7 mysqlslap — Load Emulation Client
>负载仿真测试工具

#### 4.6.1 innochecksum — Offline InnoDB File Checksum Utility
>  prints checksums for InnoDB files. 

#### 4.6.2 myisam_ftdump — Display Full-Text Index information
>展示MyISAM表的全文索引(因为他是直接读取MyISAM的索引文件,所以该程序要和表是在同一服务器上); 如果服务器是开启的请先执行flush tables在该命令执行之前

#### 4.6.5 myisampack — Generate Compressed, Read-Only MyISAM Tables
>生成一个压缩只读的表. 在服务器停机后执行是最安全的

#### 4.6.6 mysql_config_editor — MySQL Configuration Utility
>管理名为`.mylogin.cnf`(默认在用户home目录下,名字最前面是有点的)的模糊登录路径文件, 当如mysql. mysqladmin等客户端工具使用--login-path=.mylogin.cnf启动时, 这些客户端会读取其中的[client], [mysql], [mypath]块配置(优先权高于其他配置文件但低于命令行的), 这样就能知道要连接那个mysql server, 同时记录在.mylogin.cnf的密码不是明文的有一定安全性(但是不要认为它是牢不可破,因为无法阻挡有决心的攻击者), 有多个mysql服务器时方便连接切换

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
在调优mysql服务器时,最重要的配置变量:key_buffer_size和table_open_cache,你首先应该确信自己已经对这两个值设置适当值在修改参数前.
table_open_cache: 所有线程的能打开表数量,增大该值将增加mysql所需的文件描述符的数量.可通过opened_tables状态变量查看是否修改增加table_open_cache值,如果你没用经常执行flush tables(flush tables会强制将所有的表关闭重新打开)而opened_tables值很大时你就需要增加table_open_cache值了.
key_buffer_size: 缓冲MyISAM表的索引块(这些缓冲是并被所有线程共享的).(只缓冲MyISAM表,同时他是只缓冲索引不缓冲数据的,对于innoDB表缓冲的是索引和数据是一起的)
一些配置参考的例子:(见官网上)...

#### 5.1.6 Server Command Options

#### 5.1.7 Server System Variables
- back_log: mysql可以拥有未完成连接请求的数量, 默认50, -1自动调整. 当你短时间有很多请求才需要提高此值
- big_tables: mysql server将所有临时表都存储在disk上而不是内存上, 可以避免需要大的临时表不够的情况, 但同时也会降低原本在内存表就够的查询
- bind_address: mysql server监听单个网络套接字上侦听TCP / IP连接. 有如下取值:
  - `*`: 默认值. 所有服务主机的ipv4接口和ipv6接口(如果支持).(ps: 所有现有的mysql账号都可连接)
  - `0.0.0.0`: 监听所有服务主机的ipv4接口
  - `::` : 监听所有服务主机的ipv6接口
- bulk_insert_buffer_size: 
- completion_type: 
- concurrent_insert:
- delay_key_write: 只对MyISAM表有效.不会在每次索引更新时都为key buffer都进行刷新只在表关闭时.
- flush: on/off,如果开启则每句后都会flush所有更改到磁盘
- flush_time:过多少flush_time秒关闭所有表以释放资源并将未刷新(unflushed)的数据同步磁盘上.该选项最好仅在资源很少的系统上使用
- foreign_key_checks
- general_log: 
- general_log_file: 
- ignore_db_dirs:
- **init_connect: 在每个客户端(超级用户除外,因为以防sql有错误所有客户端都没能登录)连接初始时执行指定的sql语句(多个sql;分隔).**
- init_file: server启动时从文件中读取sql语句并执行
- **interactive_timeout: 交互式连接多久没有活动关闭连接**
- join_buffer_size:
- keep_files_on_create:该值off时,会有如下表现; 创建myisamI表如没有指定date directory, 而发现有相同的.MYD文件存在则会被覆盖而不产生错误.(同理没有指定index directory,存在的.MYI会被覆盖) 
- key_buffer_size: 
- lc_messages_dir: 错误消息存放目录
- **local_infile: 是否允许客户端执行load data语句**
- **lock_wait_timeout: 获取元数据锁最多等待多少秒,默认31536000(1年)**
- **log_error: 错误消息存放位置**
- **log_output: 错误消息存放目标地, table,file,none(可多选)**
- log_queries_not_using_indexes:
- log_slow_queries: 记录其他警告消息到错误日志中
- long_query_time: 秒, 也定义为毫秒
- low_priority_updates
- lower_case_file_system: off时数据目录的文件名大小写敏感, on反之
- **lower_case_table_names: 表名或数据库名存储比较时大小写是否敏感; 在大小写不敏感的平台上此值不能设为0, 因为当你使用不正确的大小写访问表时有可能造成索引损坏. 有使用innodb表时, 在所有平台上都应该将此值设为1.**
- **max_allowed_packet:**
- **max_connect_errors: 主机能连续尝试连接服务器不成功的次数, 超过则不能再登录, 除非flush host以清除记录**
- **max_connections: 最大连接数**
- max_digest_length: 
- **max_heap_table_size: 限制用户创建的内存表大小**
- max_join_size:
- max_length_for_sort_data:
- max_seeks_for_key:
- max_sort_length: 决定使用排序值的前几个字节进行排序
- **max_user_connections: 给定用户最大同时连接数**
- max_write_lock_count:
- myisam_recover_options: 
- myisam_sort_buffer_size:
- net_buffer_length
- net_retry_count
- **open_files_limit:**mysql从操作系统可使用的最大文件描述符
- optimizer_switch: 控制优化器行为
- performance_schema_xxx: performance schema系统变量的设置
- profiling: 
- query_cache_limit:如果一个查询结果超过此字节数(byte),则不会缓存.
- query_cache_size:
- query_cache_type:
- query_prealloc_size
- read_only:当该设置开启时,mysql服务器不会允许任何客户端更新操作除了超级用户.但即使该值开启,mysql服务器仍然允许如下操作:
  - 由从线程(slave threads)执行的更新,**如果是从服务器上,则开启read_only很有帮助这能确保从服务器只接受主服务器的更新而不是其他客户端的.**
  - read_only设置的目的是保护表的结构和内容被更改,但是对于优化和分析(analysis and optimization)操作不是属于这种更改操作,所以是允许的.
  - 对于临时表的操作
  - 插入log表(mysql.general_log和mysql.slow_log)
- **secure_file_priv:对于具有file权限用户导入导出数据和读取文件的限制(具体就是用load data语句导数据,load_file()函数读取文件).该值为空是没有任何限制;如果是绝对目录路径那么只允许读取或导入导出该目录下文件和数据;如果是null,则禁止任何用户导入导出的操作**
- **skip_external_locking: 禁止external locking(system locking),外部锁定仅对访问myisam表有影响**
- skip_name_resolve：是否解析主机名，如果禁止就只能使用ip登录
- **skip_networking: 服务器是否允许通过tcp连接, 如果只要本地用户连接, 强烈推荐开启此项**
- slow_launch_time;
- sort_buffer_size:　当show GLOBAL STATUS like "Sort_merge_passes per"每秒的值很大时, 可以提高sort_buffer_size可以提高无法通过查询优化或索引再提高的order by或group by的运行速度
- sql_buffer_result: 强制将select的查询结果存入临时表, 这有助于提前释放表锁或者发送数据给客户端需要长时间
- sql_log_off:
- sql_mode:
- storage_engine：默认存储引擎
- system_time_zone: 设置时区, 与time_zone变量不同(用于客户端连接时初始化时区)
- **table_open_cache:mysql所有线程允许的打开表数量,增加该值将增加mysql所需的文件描述符**
- table_open_cache_instances:
- **thread_cache_size: mysql缓存多个线程(thread)以用于复用.默认-1为自动调整.**
- thread_handling:服务器对于连接线程的处理模型
- thread_stack:
- time_zone: 用于每个客户端连接时初始化时区
- timestamp: 
- tmp_table_size: 决定内部临时内存表的最大值, 该值不会影响用户能创建多大内存表的大小(因为它限制的是类似GROUP BY语句能创建表的大小. 实际能创建的内部临时内存表的上限是取决于tmp_table_size和 max_heap_table_size较小的值. 如果超过这个限制,mysql则会将其转化为硬盘上的myisam表.(可以比较 Created_tmp_disk_tables and Created_tmp_tables这两个status
变量来看是否需要提高内部临时内存表的值)
- tmpdir: 
- transaction_prealloc_size
- tx_isolation:
- tx_read_only: 
- **unique_checks: 对innodb表的二级索引是否执行唯一性检测.如果该值设置为关闭, 则引擎不需要ignore duplicate keys**
- version_comment:  
- **tx_isolation: 事务隔离性, 默认值为`REPEATABLE-READ`**

#### 5.1.9 Server Status Variables
**mysql服务器维护着许多个操作信息的状态变量. 许多变量在执行`FLUSH STATUS`语句后重置为0**
- Aborted_clients：没有正确关闭的连接数
- Aborted_connects: 连接mysql服务器失败的尝试次数
- Binlog_cache_disk_use:
- Binlog_cache_use: 
- Bytes_received: 所有客户端接收的字节数
- Bytes_send: 发送给所有客户端的字节数
- Com_xxx:　计算xxx语句的执行次数
- Handler_read_rnd: 基于固定位置读取行的请求数. 如果需要执行很多对结果进行排序的查询该值会很高;这可能是你执行了许多需要全表扫描或joins没有正确使用键的查询
- Handler_read_rnd_next: 读取数据文件的下一行的请求数. 如果该值很高则说明做了很多的表扫描, 通常这表明未正确建立索引或你的查询没有很好利用索引
- Innodb_row_lock_current_waits: 现在需要等待行锁的数量
- Innodb_row_lock_time: 花费在取得innodb行锁总的时间(单位毫秒)
- Innodb_row_lock_time_avg: 取得innodb行锁的平均时间(毫秒)
- Innodb_row_lock_time_max: 取得innodb行锁中耗时最大的时间(毫秒)
- Key_blocks_unused:
- Last_query_cost: 上次查询语句编译的总开销(由查询优化器计算), 这对与对比同一查询语句的不同查询计划的开销很有帮助. 仅在简单语句中计算得精确, 对于复杂语句(如包含了子查询或union)该值为0
- Last_query_partial_plans
- **Max_used_connections: 服务器开机以来最大的同时连接数量**
- Open_files:
- Open_tables:
- Select_full_join: join时执行了表扫描而没有使用到索引的次数, 如果该值不为0, 请注意检查表的索引
- Select_range_check:　如果该值不为0, 请注意检查表的索引
- Select_scan:　join时第一个表进行了全表扫描的数量
- Slow_launch_threads: 开启线程花费的秒数比slow_launch_time值还大的次数
- Slow_queries: 查询花费的时间比long_query_time值还大的次数
- Sort_merge_passes
- Sort_range:使用范围来完成排序的次数
- Sort_scan: 扫描表来完成排序的次数
- Table_locks_immediate: 可以立即授予对表锁定的请求的次数
- Table_locks_waited: 无法立即授予对表锁的请求并且需要等待的次数. 如果该值很高并且有性能问题时, 你首先应该优化查询语句,
然后将表进行拆分或者使用主从复制
- Threads_connected: 当前打开的连接数
- Threads_created:

##### 5.1.10 Server SQL Modes
系统变量sql mode默认值为`NO_ENGINE_SUBSTITUTION`, 也可以设置为只对当前session有效.
- 重要注意事项: 
  - **当创建使用了用户自定义分区的表, 强烈建议永远不要改变sql mode.因为这有可能会造成数据丢失或数据损坏**
  - 当复制分区表时, 主从服务器的sql mode不同时也出现问题, 所以最好的方法就是主从服务器都是使用相同的sql mode
- most important sql modes
  > 本手册的`strict mode`是指启用了`STRICT_TRANS_TABLES`或`STRICT_ALL_TABLES`, 或者同时两者
  - ANSI: 此模式更改语法和行为以更符合标准sql
  - STRICT_TRANS_TABLES: 
  - TRADITIONAL: 简单的描述就是当插入一个不正确的值时, 会产生一个错误而不是warning. 注意在插入或更新时,当一有错误发生就会马上中止.**所以当你使用的是非事务型存储引擎时,这可能不是你想要的结果因为在错误之前的数据更改不会回滚,导致了部分完成更新**
  
- full list(笔记只做了部分)
  - HIGH_NOT_PRECEDENCE: 提高not运算符的优先级
  - NO_AUTO_VALUE_ON_ZERO: 该值影响着AUTO_INCREMENT列, 通常你可以插入0或null来生成下一个序列号.但是开启该值时插入0的行为将被抑制, 只有插入null才会生成下一个序列号. 这对于0被存储在AUTO_INCREMENT列(不建议存储0)上非常有用, 比如在导出表后又重新加载导入表时, 如果没有开启该值mysql在导入时如果遇到0值则会生成一个新的序号.为此mysqldump在输出中自动包含了开启NO_AUTO_VALUE_ON_ZERO的语句
  - NO_ENGINE_SUBSTITUTION: 该值开启时, 当create或alert语句指定了不能使用的或未编译的存储引擎时则会产生一个错误; 而关闭该值时, create语句会产生一个警告并使用默认引擎替代, alert语句则会产生一个warning但该表不会改变
  - NO_UNSIGNED_SUBTRACTION: 当两个整数相减, 其中有一个是unsigned时, 则结果默认的也是unsigned的,所以当结果是负数时则会产生一个错误. 如果开启该变量则可以避免这个问题. 如果用该结果对一个unsigned整数列进行更新时,结果会被裁减为该列类型的最大值, 或者被裁减为0当NO_UNSIGNED_SUBTRACTION值开启时.
  - NO_ZERO_DATE: 该值从5.6.17起不赞成. 该值没开启时, '0000-00-00'是一个有效的日期, 插入该值是允许的; 该值开启时'0000-00-00'是允许的插入时会产生一个warning; 如果strict mode和NO_ZERO_DATE同时开启, '0000-00-00'不允许, 插入产生一个错误除非使用insert ignore或update ignore则可以插入但会产生一个warning.
  - STRICT_ALL_TABLES: 为所有引擎都开启strict mode

- Combination SQL Modes
  >以下提供了特殊模式作为上面模式值组合的简写
  - ANSI
  - TRADITIONAL: 等于 STRICT_TRANS_TABLES, STRICT_ALL_TABLES, NO_ZERO_IN_DATE, NO_ZERO_DATE, ERROR_FOR_DIVISION_BY_ZERO, NO_AUTO_CREATE_USER, 和NO_ENGINE_SUBSTITUTION.
  
- Strict SQL Mode
  >在启用了STRICT_ALL_TABLES或STRICT_TRANS_TABLES, 或者两者同时, Strict SQL Mode生效
  - STRICT_ALL_TABLES和STRICT_TRANS_TABLES的一些区别
    - 对于事务型表, 两种模式都是会产生一个错误当更改数据语句中有无效或缺失的值, 该语句中止并回滚
    - 非事务型表, 更改数据语句(insert,update)中有无效或缺失的值
      - 该坏值出现在数据更改的第一行, 两种模式的行为都是是一样的, 语句被中止且数据表不会被改变
      - 该值出现在数据更改的第二行及以后
        - STRICT_ALL_TABLES模式, 返回一个错误并中止剩余的语句执行, 因为较早的行已被插入或更新,所以结果是部分更新. 为了避免该情况,请使用单行语句,可以在不更改表的情况下中止该语句(即第一句一有错误就中止了)
        - STRICT_TRANS_TABLES模式会将无效值转换成最接近的有效值并插入, 如果是缺少的值则会使用隐私的默认值插入.在两种情况中都会产生一个警告而不是错误并且执行后续的语句
  
#### 5.1.14 Server Response to Signals

#### 5.1.15 The Server Shutdown Process
  1. 关闭过程将启动. 
  2. 如果需要服务器创建一个关闭线程. 
     >这取决于服务器是怎么关闭, 如果是从客户端中发起关闭的,这将会创建一个关闭线程. 如果是接收到一个`SIGTERM`信号,那么发出SIGTERM信号的线程可能来处理关闭或者他会创建一个单独的进程来处理. 
  3. 服务器停止接受新的连接.
     >服务器通过关闭通常监听的网络接口的程序来停止接收新的连接
  4. 服务器终止当前的活动 
     >对于与客户端连接的每个线程, 服务器都断开和客户端的连接并将该线程标记为killed. 当线程注意到自己被标记时就会die掉, 对于空闲的连接线程可以很快die掉,当前正在处理语句的线程会定期检测其状态所以会花费更长的时间die掉.
     - 对于具有开放事务的线程, 该事务会被回滚; 而一个更新非事务表的线程, 如多行的更新或插入的操作可能会留下部分更新,因为该操作可以在完成之前终止
  5. 服务器关闭或关闭存储引擎
     >该阶段服务器将刷新表缓存并关闭所有表.每个存储引擎都对其管理的表进行任何有必要的操作.innodb刷新缓冲池到磁盘, 将当前的LSN写入表空间,并终止自己的内部线程,MyISAM刷新表的所有未决索引写入(pending index write)
  6. 服务器退出
  
### 5.3 The mysql System Database
该部分为介绍mysql系统数据库,就是名为`mysql`的数据库
- 分类
  - 授权表
  - 对象信息系统表
    - event: Information about Event Scheduler events.
    - func: 用户定义的函数
    - plugin: 服务器端的插件
    - proc: Information about stored procedures and functions
  - 日志系统表(使用csv存储引擎)
    - general_log
    - slow_log
  - 服务端帮助系统表
  - 时区系统表
  - 复制(replication)系统表
  - 优化器系统表
  - 杂项系统表
  
### 5.4 MySQL Server Logs
- 服务器日志种类
  1. error log: 
  2. general query log:建立的客户端连接和从客户端接收的语句
  3. binary log: 改变数据的语句
  4. relay log: 从复制主服务器接收到的数据更改
  5. slow query log:
  6. DDL log(metadata log): DDL执行的元数据操作
  
- 系统变量log_output控制输出目的类型是file, table, none的任意组合; 系统变量general_log和slow_query_log控制对应的日志是否开启;general_log_file and slow_query_log_file控制着对应日志文件存放的路径(如果有给定的话)和文件名;系统变量sql_log_off控制general query logging是否关闭(这假定general query log为开启)

- 使用log table(将日志存储在mysql表)的好处和特点
  便于查询是哪个客户端发起的查询,只要能连接上服务器就能进行日志查询
  
#### 5.4.2 The Error Log  
#### 5.4.2.2 Error Logging on Unix and Unix-Like Systems  
- log-error没有指定值时则将错误信息输出到console(即是stderr), 如果指定了文件名或绝对路径就将日志写入对应文件中去
- log-warning控制warning日志是否记录到error log中, 如果该值大于1则将新连接尝试连接但被拒绝访问的错误和中断连接写入错误日志中

#### 5.4.2.5 Error Log File Flushing and Renaming
- 使用FLUSH ERROR LOGS或FLUSH LOGS命令flush log,mysql服务器会关闭和重新打开任何他之前正在写入的错误日志文件.如果要重命名错误日志文件名,则进行如下的操作(以linux为例子, 在window上请用rename代替mv)
  mv host_name.err host_name.err.old
  mysqladmin flush-logs
  mv host_name.err.old backup-directory//最后将其移动到备份目录中
  注意: 如果错误日志文件的位置mysql服务器没有写入权限那么flush log操作就不能生成新的日志文件

#### 5.4.4 The Binary Log
在一个语句或事务后但在释放任何锁或任何提交(commit)之前立即执行二进制日志记录; 在执行对非事务表的更新后立即存储在二进制日志中。在未提交事务中, 所有改变事务表更新操作都会被缓存直到服务器接收commit语句, 此时在commit执行前将整个事务写入二进制日志; 对于非事务表的改变是无法被回滚,如果一个事务包含对非事务表的更改回滚了, 则二进制日志会在事务后记录所有rollback语句以确保这些表的更改

##### 5.4.4.1 Binary Logging Formats
- 二进制日志记录格式(3种): 
  1. 基于sql语句日志
  2. 基于行日志: 记录被影响的单个表行
  3. 混合(以上两种混合)日志: 默认是statement-based, 在特定情况下使用row-based保证可以被安全复制

#### 5.4.4 The Binary Log
- 二进制日志不记录像select或show之类不修改数据语句。如果要记录所有语句，请使用general query log。
- log-bin系统变量控制是否开启错误日志**log_bin_basename可以指定文件名或带绝对路径的文件名(后缀会被忽略并由mysql自己生成.** sql_log_bin(scope为session)可以设置当前的session的二进制日志是否开启
- PURGE BINARY LOGS删除二进制日志
- binlog_error_action系统变量控制二进制日志记录出错时所采用的动作
  - IGNORE_ERROR(默认): 服务器会将继续进行中的事务并记录错误, 然后停止二进制日志记录,但会继续执行更新.排除错误要重启服务器才能从新记录二进制日志.这对于二进制日志是不重要的情况可以怎么做
  - **ABORT_SERVER(推荐): 停止二进制日志记录并关闭服务器.**
- **sync_binlog控制每N个提交组后将二进制日志同步到磁盘. 最安全的值为1,但仍然存在二进制日志和表内容不一致的可能当宕机时**
- max_binlog_size: 指定二进制单个文件最大值, 如果达到就旋转日志(即按序列重起一个文件存储)
  
在一个语句或事务后但在释放任何锁或任何提交(commit)之前立即执行二进制日志记录; 在执行对非事务表的更新后立即存储在二进制日志中。在未提交事务中, 所有改变事务表更新操作都会被缓存直到服务器接收commit语句, 此时在commit执行前将整个事务写入二进制日志; 对于非事务表的改变是无法被回滚,如果一个事务包含对非事务表的更改回滚了, 则二进制日志会在事务后记录所有rollback语句以确保这些表的更改

###### 5.4.4.4 Logging Format for Changes to mysql Database Tables
  
#### 5.4.5 The Slow Query Log  
- 默认的慢日志不记录管理语句和不使用索引的语句, 但是log_slow_admin_statements 和 log_queries_not_using_indexes进行设置

#### 5.4.7 Server Log Maintenance
- mysqladmin flush-logs刷新日志时: 1.**二进制日志会重新创建一个文件,** 2.**而一般日志(general log)和慢日志只会关闭再重新打开**
 
#### 5.5 MySQL Server Plugins 
**从INFORMATION_SCHEMA.PLUGINS table 或 SHOW PLUGINS获取插件的信息及状态, mysql.plugin表查看注册了的插件**

#### 5.6 MySQL Server User-Defined Functions 

#### 5.7 Running Multiple MySQL Instances on One Machine 
一台机器上运行多个mysql实例(有这两种情况 1.同个二进制文件不同data目录; 2.不同二进制文件的) 
          
## 6 Security   
rainbow table破解hash加密
          
#### 6.2.2 Privileges Provided by MySQL          
- Privilege Descriptions
  - reload: 允许flush语句的操作: flush-hosts, flush-logs, flush-privileges, flush-status, flush-tables, flush-threads,refresh and reload. reload语句告诉服务器重新加载权限表到内存中, flush-privileges是reload的同义词. refresh操作是关闭和重新打开日志文件和刷新所有的的表. 其他的flush-xxx命令和refresh相似, 只不过是更具体, 如flush-log就只针对log操作.
- Privilege-Granting Guidelines
  对于file权限和管理员特权应该特别注意
- file权限:
  - 具有该权限的用户可以读取mysql服务器主机上的文件,这包括所有world-readable的文件和mysql服务器的data目录.**用户可以使用select load_file("file_path")将服务器上的内容传输到用户本地上**.应该特别注意.
- 授权选项: 允许用户将自己的权限授予其他用户, 所以两个有不同权限的用户同时又具有授权特权(grant option)时能组合权限
- PROCESS:能够查看当前正执行语句的纯文本,包括设置和更改密码语句

#### 6.2.3 Grant Tables
可以使用SHOW GRANTS FOR 'root'@'pc84.example.com';查看对应用户名和主机名被授予的权限
服务器在启动时会将几个权限组合起来加载到内存中, 如需重新加载可以使用mysql命令行中输出flush privileges 或 mysqladmin flush-privileges 或mysqladmin reload命令

- Grant Table Overview
  以下这些表包含授权信息(这些表都在数据库名为mysql中)
  - user: 用户账号, 全局权限, 和其他没有权限的列
  - db: 数据库级别权限
  - tables_priv: 表级别权限
  - columns_priv: 列级别权限
  - procs_priv: 存储过程函数的权限
  - proxies_priv: 代理用户权限

host, proxy_host在存到授权表前转换为小写,权限表User, Proxied_user, Password, Db, and Table_name列大小敏感, Host, Proxied_host, Column_name, and Routine_name大小写不敏感
 
##### 6.2.5 Access Control, Stage 1: Connection Verification         
""@"%":表示任何用户名字从任何主机名进行连接只要能匹配上密码都能连接, ""表示匹配任何用户名字

当user表被加载到内存时都会对其进行排序, 越具体的行排行越前. 所有当一个用户名和host连接进来可能会匹配到多个行时, mysql只会使用匹配中排序最靠前的那一行进行登录认证
查看当前登录用户名和host: SELECT CURRENT_USER(); 
 
#### 6.2.6 Access Control, Stage 2: Request Verification
user表中设置全局的基础权限, 比如授权了全局的delete权限,那么他可delete任何database的数据即使设置了默认的database. 所以如非必要, user表的权限都设置为N,在颗粒级别更具体的地方设置权限.

#### 6.2.7 Adding Accounts, Assigning Privileges, and Dropping Accounts
创建用户: create user "username"@"hostname" identified by 'password'; 
删除用户: drop use "username"@"hostname"
修改密码: set password for "username"@"hostname" = password("password")
该用户名或主机名: rename user "old_username"@"old_hostname" to "new_username"@"new_hostname"
修改当前用户密码: set password = password("password")
用户授权: GRANT all on "." to "username"@"hostname"
撤销权限: revoke all on "." from "username"@"hostname"

#### 6.2.8 When Privilege Changes Take Effect
修改权限表何时生效? 
- **使用账号管理语句(如GRANT, REVOKE, SET PASSWORD, and RENAME USER等)这种间接方式修改表的方式, mysql服务器会在一注意到变化时立即从新加载到内存; 而直接通过insert, update语句(不推荐)对表直接修改则要需要flush privileges使其生效.**

**授权表的重新加载对现有客户端会话权限的影响?**
- **对于表级和列级的权限, 会在下一个请求生效**
- database权限需要在用户执行use db_name语句时生效
- **对于全局权限和密码对已连接的会话不会有影响,只有当下次重连时才会生效.**

**对于使用--skip-grant-tables选项开启服务器的,不会有任何的访问权限检查, 若想使其重新开启访问检查,flush privileges.**

#### 6.2.13 Setting Account Resource 
对账号资源使用的限制; 可以从以下方面(同样的名字存在mysql.user表中)进行控制; 使用grent语句进行设置
- max_queries_per_hour
- max_updates_per_hour
- max_connections_per_hour 
- MAX_USER_CONNECTIONS: 该账号最大同时连接数量 

per-hour的资源使用量可以被全局重置(置0)通过使用flush user_resource或者重载grant表(如flush privileges)

#### 6.2.15 SQL-Based Account Activity Auditing
**user()和current_user()区别?**
- current_user()显示是当前登录用户对应配到mysql.user表中到user和host字段的值,有可能会包含通配符; 
- user()是登录时实际的客户端提供的用户名和实际客户端的host值

#### 6.3.3.1 Creating SSL Certificates and Keys Using openssl
[使用openssl创建ssl证书和密钥](https://dev.mysql.com/doc/refman/5.6/en/creating-ssl-files-using-openssl.html)

#### 6.3.5 Connecting to MySQL Remotely from Windows with SSH
window上通过ssh远程登录mysq: 如用navicat时, 配置mysql账号外还要再配置ssh登录服务器的账号密码

## Chapter 7 Backup and Recovery                                                                          
### 7.1 Backup and Recovery Types
- 物理(原始) 与 逻辑   
  - 物理备份
    > 由复制原始的储存数据库内容的目录和文件的副本组成.适合大型数据库,需要快速恢复.
    - 通常就是mysql的data目录一部分或所有的文件的备份
    - 比逻辑备份快,因只要复制文件而不需涉及转换
    - 比逻辑备份更紧凑
    - 备份和恢复的粒度从数据库到单个文件. 是否支持表级粒度取决于存储引擎,如每个myisam表都是对应一组文件的, 而每个innodb表则可以独立也可以与其他表共享.
    - 备份的工具:mysqlbackup,mysql表的mysqlhotcopy, 任何文件系统级命令(cp, scp, tar等)等
    - 备份可在mysql没有运行时或在运行中执行相应的锁以防止数据修改
  - 逻辑备份
    > 由sql语句组成
    - 比物理备份速度慢, 体积大
    - 逻辑备份与计算机无关可移植性更高
    - 备份工具: mysqldump或select ... into outfile语句(扩展:该句为将表数据导出到文件中,而load data语句为该语句的补充,load data语句为将文件数据导入到表中.)
    - 恢复备份: load data语句或mysqlimport
- Online 与 Offline Backups
  >区别在于mysql是否运行,也可称为热备份与冷备份(hot versus cold), 还有一种warm备份就是服务器仍运行,但是加锁了无法修改数据
- 本地与远程
  - mysqldump:可从本地与远程登录, 备份在本地或远程转储到客户端上
  - mysqlhotcopy:只能本地
  - SELECT ... INTO OUTFILE:语句可由本地或远程发起, 但输出文件只会放在服务端
  
### 7.2 Database Backup Methods
- 通过mysqldump或mysqlhotcopy备份
  mysqldump更加通用, mysqlhotcopy5.7将移除, 他是使用flush tables,lock tables, cp命令进行数据文件的备份, 且支持myisam,ARCHIVE存储引擎
- 通过复制表文件备份
  如myisam表,可以复制表文件(*.frm, *.MYD, *.MYI)来做备份, 为了保证一致性, 需先停止mysql或lock并flush相关的table(语句如下)
   `FLUSH TABLES tbl_list WITH READ LOCK;`
- 通过开启二进制日志进行增量备份
  当你做完一个完整备份后, 你应该flush logs语句来旋转(rotate)你的二进制日志,也就是重起一个二进制文件记录
- 通过从服务器进行复制
  为了在备份时mysql也不会有性能问题.那么从服务器复制是一个方案

### 7.4 Using mysqldump for Backups  
**mysqldump产生两种类型输出**
 - 不带--tab选项, 那么输出就是包含了输出对象的表结构和表内容等的sql语句  
 - 带 --tab选项, 会输出两个文件一个是包含创建表的sql语句名为table_name.sql和名为table_name.txt文件以制表分隔符(tab-delimited)格式储存表内容, 每一个表行一个文本行.

#### 7.4.1 Dumping Data in SQL Format with mysqldump 
- **导出多个数据库**
  - mysqldump --databases db1 db2 db3 > dump.sql, 加上database选项mysql会将后面的内容都当作数据库
  - mysqldump db1 db2 db3 > dump.sql: 与上一句比较不带--database, 导出文本不会包含创建数据库语句和use database语句, 所以你想事先创建和use
- **只导出表格**
  - mysqldump db1 t1 t3 t7 > dump.sql: 不加其他选项, mysql将第一个参数当作数据库, 后续的内容都作为表格
  
#### 7.4.3 Dumping Data in Delimited-Text Format with mysqldump
备份分隔符格式的备份最好还是服务器主机上操作, 如果你是从远程连接到服务器上,那么.sql文件(由mysqldump生成)将放在客户端上, .txt文件(由mysql服务器执行select...into outfile语句得到)将放在mysql服务主机上

#### 7.4.5 mysqldump Tips
>一些比较使用备份还原例子,可以看看
##### 7.4.5.4 Dumping Table Definitions and Content Separately  
-  --no-data:mysql服务器只会导出create table语句而不包含表内容
- --no-create-info: 服务器只会导出表内容sql语句而不包含create table语句

### 7.5 Point-in-Time (Incremental) Recovery Using the Binary Log
**假设2019-12-4 9:00时误删除了一张大表,不同恢复方式如下?**
- 7.5.1 Point-in-Time Recovery Using Event Times
  >指定开始的时间到结束的时间来做时间点恢复
    - 恢复操作: 先将最近的一份全备份恢复, 然后指定时间截止时间2019-12-4 8:59的二进制日志进行回放, 如果你是过了很久之后才发现的这误删操作,那么你还需要执行开始时间为2019-12-4 9:01开始到现在的二进制日志进行回放
- 7.5.2 Point-in-Time Recovery Using Event Positions
  >指定事件位置来做时间点恢复, 同一时间有多个事务时则该模式可控制粒度更加精确
    - 恢复操作: 先确定出那条删除语句的事件位置(如2000), 那么将二进制日志恢复到1999, 然后在从2001开始恢复剩下的

### 7.6 MyISAM Table Maintenance and Crash Recovery

### 7.6 MyISAM Table Maintenance and Crash Recovery
- 每个myisam表在数据目录中都对应着3个文件, 他们的含义分别如下:
	file                purpose
	tb1_name.frm     definition(format) table
	tb1_name.MYD     Data file
	tb1_name.MYI     index file
	
#### 7.6.3 How to Repair MyISAM Tables
4个等级
- 普通修复
- .MYI的索引文件损坏
- .frm定义文件损坏

#### 7.6.4 MyISAM Table Optimization
myisam表的优化

#### 7.6.5 Setting Up a MyISAM Table Maintenance Schedule
做定期维护mysql的计划(文中有个crontab例子)

## Chapter 8 Optimization

### 8.1 Optimization Overview
- **Optimizing at the Database Level**
  - 表结构是否合适? 特别是列是否设置了正确的数据类型,比如频繁更新的应用程序拥有较多的表,但表的列比较少; 而分析大量数据的应用程序通常有很少的表,但有较多的列
  - 是否为每个表设置了适当的存储引擎,并利用其的优势和功能?
  - 是否设置了正确的索引提高查询效率?
  - 是否设置适当的行格式?
  - 应用程序是否使用了适当的锁策略?
  - 用于缓存的所有内存区域大小是否设置正确? 即大到足以容纳经常访问的数据, 但太大会导致内存过载和分页.**最主要的内存配置是: InnoDB buffer pool, MyISAM key cache, MySQL query cache**
- Optimizing at the Hardware Level
  - 磁盘搜索(disk seek). 磁盘需要花费时间去找到一条数据, 现代磁盘一次平均在10ms以下, 理论上100次/s. 对于单表这个时间非常难优化, 对于这种情况的优化, 可以将数据分发到不同磁盘上.
  - 磁盘读和写. 现代的一个磁盘至少可以提供20~30MB/s的吞吐量. 你可以从多个磁盘中并行读来达到优化效果.
- Balancing Portability and Performance
  在可移植的程序中,可以将mysql关键字写在/*!- */注释分割符中,其他的sql语言会忽略掉

### 8.2 Optimizing SQL Statements
#### 8.2.1 Optimizing SELECT Statements
>即使对于一个使用缓存而快速查询的语句,你仍能进一步优化语句使用更少的缓存来使你的应用更具有扩展性. 扩展性意味着可处理更多的用户和更大的查询而不会出现性能大幅下降

##### 8.2.1.1 WHERE Clause Optimization
- 在查询中所有的常量表都将先被读取在其他表之前.常量表可以是以下任意一种:
  - 一个空表或表中只包含一行    
  - 一个表的基于PRIMARY KEY或UNIQUE KEY的where从句, 其中索引部分都直接与常量表达式进行比较并被定义为not null
- **通过尝试所有的可能来找到最佳的联表联结组合.ORDER BY或GROUP BY从句中的所有列都来自同一个表,那么join时首先将他放前面**
- **如果一个ORDER BY从句和一个不同的GROUP BY从句, 或者ORDER BY or GROUP BY从句中的列不是来自联表(join)顺序中第一个表的列, 都会创建临时表**
- 如果使用SQL_SMALL_RESULT修饰符,则mysql会使用一个内存中的临时表
- mysql将查询表的索引, 并使用最佳索引除非优化器认为使用表扫描更加有效. 是否使用索引或者扫描, 看是否扫描30%以上, 但现在也基于固定的百分比, 也取决例如表大小,行数,I/O块大小
- 在输出每一行之前将跳过与HAVING字句不匹配的行

#### 8.2.1.2 Range Optimization     

#### 8.2.1.3 Index Merge Optimization

#### 8.2.1.5 Index Condition Pushdown Optimization
>Index Condition Pushdown (ICP)优化就是mysql使用index从表中获取行数据
- 没有使用ICP情况下, 优化器工作步骤
  1. 读取下一行是先读取索引, 然后使用索引去定位并读取完整的表行数据
  2. 然后测试是否符合where条件, 有则接受没有拒绝
- 使用ICP情况, 优化器的工作步骤
  1. 读取一行是从索引中读取(不读取整个表行数据)
  2. 然后只使用索引的字段测试是否满足用在此表上的where条件, 如果不满足则继续读取一个索引
  3. 满足则才使用索引去定位并读取完整的表行数据
  4. 然后在继续测试其他不在此表上的where条件, 满足接受否则拒绝
  
EXPLAIN输出中的Extra字段如果显示using index则表示使用了Index Condition Pushdown (ICP),反之就是没有使用到这个优化因为必须要读取完整的表行数据 

#### 8.2.1.6 Nested-Loop Join Algorithms

#### 8.2.1.7 Nested Join Optimization
>外联表语句中的有些括号不能忽略(否则结果会不一样),具体看原文例子还不是很理解

将括号内的逗号视为innner join如: 
   `SELECT * FROM t1 LEFT JOIN (t2, t3, t4) ON (t2.a=t1.a AND t3.b=t1.b AND t4.c=t1.c) ` 
   等价于 
   SELECT * FROM t1 LEFT JOIN (t2 INNER JOIN t3 INNER JOIN t4) ON (t2.a=t1.a AND t3.b=t1.b AND t4.c=t1.c)
- 语句中只有内联结的可以忽略括号,从左到右评估连接, 其实表可以被评估为任意的顺序
- 但是如果是外联或外联内联混合则不一定, 忽略有可能会造成结果不一致

#### 8.2.1.8 Outer Join Optimization
外联有left join和right join

#### 8.2.1.9 Outer Join Simplification
**在解析阶段(parse stage), 带有right join的查询会被等效转换成只带有left join的语句**

#### 8.2.1.10 Multi-Range Read Optimization
>Multi-Range Read (MRR)优化的目的是减少对磁盘的随机访问而是基于表数据进行连续的访问
- EXPLAIN输出的extra字段为MRR就是使用了此优化
- 在innoDB和MYISAM如果查询不需要读取全部表的所有字段则不会使用MRR,因为不能从中获益

#### 8.2.1.11 Block Nested-Loop and Batched Key Access Joins

#### 8.2.1.12 IS NULL Optimization

#### 8.2.1.13 ORDER BY Optimization
- Use of Indexes to Satisfy ORDER BY
  - 默认的, mysql会对group by col1, col2, ...语句进行排序操作,所以你在语句后显式的指定相同列的order by col1, col2, ...语句, mysql会对于进行优化不会任何的速度损失,不管他是否排序(**使用索引就不用排序(filesort), 因为索引本身就是顺序的**). **如果想让包含group by的语句避免排序的开销, 加上order by null可以抑制排序,但是仅仅是抑制对结果的排序.**
    - note: 需要排序时,明确的指出ASC还是DESC,而不能依赖于group by隐式的排序(ASC或DESC), 因为未来优化器的优化策略可能会有变.
  
- Use of filesort to Satisfy ORDER BY
  order by语句使用了filesort,filesort操作事先需要文件排序的内存,优化器会分配固定的 sort_buffer_size字节(byte)内存(各个session可以改变这个值以避免过多的使用). 如果结果集太大无法放入内存中,那么就会创建一个临时表
  
- Influencing ORDER BY Optimization
  - 没有使用filesort的order by(也就是使用索引)出现排序很慢的情况? 那么将max_length_for_sort_data系统变量值降低到合适值以便触发filesort.(该值设置太高的一个症状就是磁盘活动过多同时cpu活动率低,)
  - **如果想要提高order by速度,先检查下能否使用索引而不是需要额外的排序阶段(用索引不用排序),** 如果不可能,可尝试一下策略:
    - **增加sort_buffer_size系统变量值**.理想的该值应该足够大以装下整个结果集在sort buffer中(避免写入到磁盘和合并过程), 监视合并的次数(合并临时文件),可以查看Sort_merge_passes状态变量, 如果该值很大则应考虑增加sort_buffer_size的值
    - 增加read_rnd_buffer_size变量值，以便一次读取更多行
    - 每行使用更少的内存: 可通过仅声明列上存储数据需要的大小的值, 如char(16)比char(200)好如果该列的值从未超过16字符(character)
    - 更改temdir系统变量指向具有大量可用空间的专用文件系统.该路径位置应该是不同的物理磁盘上, 而非同一物理磁盘的不同分区
    
- ORDER BY Execution Plan Information Available
>EXPLAIN并不能区分filesort操作是否是在内存中完成,可通过optimizer trace输出信息查看

#### 8.2.1.14 GROUP BY Optimization
>group by最通常的做法是扫描整个表然后创建一个临时表, 其每组的所有行都是连续的, 然后使用此表发现组和应用聚合函数(如果有的话), 在某些情况下,mysql会做得更好, 通过访问索引而避免创建临时表.**group by使用索引最重要的前提是所有group by列均使用同一索引属性**, 并且索引是按顺序存储键值的(例如BTREE索引就是, 而HASH索引则不是)

- Loose Index Scan
  - 最左前缀列规则. 假设表t1在(c1, c2, c3)上具有索引, 则group by c1, c2情况下loose index scan适用, **如果group by c2,c3(列不是最左前缀) 或group by c1, c2, c4(c4不在索引中), 则不适合**
  - 选择列(select list)中使用了聚合函数且只有min()和max()时,它们必须是同一列, 该列必须在索引中同时必须马上紧跟group by中的列
  - 必须整列值都被索引, 如有c1 varchar(20), index(c1(10)), 则索引只是使用c1值部分前缀, 所以不能用于loose index scan
  - loose index scan支持聚合函数, 不同的函数有如下的区别:
    - AVG(DISTINCT), SUM(DISTINCT), and COUNT(DISTINCT)是支持, 但除了 COUNT(DISTINCT col1 col2)可以接受多个参数外, 其他的只能接受一个参数
    - 查询语句中必须没有group by或DISTINCT从句

- Tight Index Scan
>tight index scan可能是全索引扫描或范围扫描. 这取决与查询条件. 所有group by引用的键的各部分之前或之间都有常量等价条件. 如有一个index idx(c1,c2,c3)在表t1(c1,c2,c3,c4)上,以下语句可以不会使用loose index scan, 但tight index scan适用
  `SELECT c1, c2, c3 FROM t1 WHERE c2 = 'a' GROUP BY c1, c3;` //group by有个缺口但被c2='a'覆盖
  `SELECT c1, c2, c3 FROM t1 WHERE c1 = 'a' GROUP BY c2, c3;` //虽然不是由第一个索引开始, 但常量为该部分提供了条件

#### 8.2.1.15 DISTINCT Optimization
DISTINCT和ORDER BY的结合使用, 在许多场景中都需要创建一个临时表.因为DISTINCT可能使用到group by, 许多情况下DISTINCT从句可以看成一种特殊的group by

#### 8.2.1.16 LIMIT Query Optimization
- 可以使用limit 0可以快速的返回空集

#### 8.2.1.17 Function Call Optimization

#### 8.2.1.18 Row Constructor Expression Optimization

#### 8.2.1.19 Avoiding Full Table Scans
- 当EXPLAIN输出的type字段为all时则mysql使用了全表扫描来处理查询,这通常会在以下情况发生:
  - 当表很小,全表扫描比索引还快时.对于小于10行或行长度较短的这个常见的.
  - 在索引列上on或where语句没有可用的限制
  - 将索引和常量比较时,mysql计算到常量占用表很大一部分而全表扫描会更快
  - 键的基数较低(即一个键值会匹配到许多行),此情况下, mysql假设使用键(key)时需要执行许多的键查找,而全表扫描会更快

- 对于小表来说,全表扫描更恰当,其对性能的影响可忽略不计.而对于大表, 可以使用技术来避免优化器错误地选择表扫描
  - 使用ANALYZE TABLE tbl_name去更新扫描表的键值分布
  - 对扫描表使用FORCE INDEX去告诉mysql使用表扫描比使用给定索引贵
  - 设置系统变量max_seeks_for_key=1000来告诉优化器如果没有键扫描将1000个键查找
  
### 8.3 Optimization and Indexes

#### 8.3.1 How MySQL Uses Indexes
- 许多索引(PRIMARY KEY, UNIQUE, INDEX, FULLTEXT)都是存储在B-trees中, 除了空间数据类型(spatial data type)索引使用R-trees;内存表(memory table)也支持hash索引;**innoDB对fulltext使用反向列表**(INVERTED LIST FOR FULLTEXT INDEXS)

- mysql使用索引进行如下操作:
  - 快速的找到与where语句匹配的行
  - 从考虑中消除行, 如果有多个索引可供选择,mysql通常会使用找到最少行的索引(最具选择性的索引)
  - 如果表有多列索引, 任何最左前缀索引都能被使用.如有一个3列的索引(col1, col2, col3),你已经在(col1), (col1, col2), (col1,col2, col3)上建立了索引搜索功能
  - 执行join时从其他表检索行,如果声明了相同的类型和大小(same type and size),mysql可以更有效的在列上使用索引.在这种情况下varchar和char声明为相同的大小则认为它们相同, 如varchar(10)和char(10)大小相同,但varchar(10)和char(15)大小不相同.
    - 对于非二进制字符串列之间的比较两个列应使用相同的字符集(如将utf8列于latin1列进行比较就不能使用到索引). 
    - 比较不相似的列(如将字符串列和时间或数字列)可能会阻止使用索引如果无法在不进行转换的情况下直接比较值.例如数字列数值为1,他可能与字符串中的任何值进行比较,如'1', ' 1','00001','01.e1'是相等的,所有这排除了对字符串列使用任何索引的可能.
    - 如果在可用索引的最左前缀完成了sort和group by操作,同时在所有的键后都有DESC,则按照相反顺序读取键值.
    - 有些查询可以直接从索引读取所有需要信息而不用读取数据行,这成为覆盖索引,直接从索引树获取结果可提高速度.

- 索引对小表或大表的查询需要处理大多数或所有的行而言,索引没那么重要.当一个查询需要太多的行时, **顺序读取比通过索引快.顺序读取可以最大程度的减少磁盘查找(disk seek),即使查询不需要所有行.**

#### 8.3.2 Primary Key Optimization
如果你的表又大又重要,但没有明显的列或一组列用作主键,你应该创建一个自增的独立列作为主键.这些唯一的id可用于在其他表指向对应的行当联表时使用外键.

#### 8.3.3 Foreign Key Optimization

#### 8.3.4 Column Indexes
- 最常见的索引类型涉及单列,存储着该列在数据结构中的值的副本.允许使用相应的列值来快速查找行.B-trees数据结构使得索引可以快速找到满足where从句(如=,>,<,between, in等)的特定值或一组值或一个范围值
- 每个表的最大索引数和最大索引长度由存储引擎决定.所有的存储引擎都支持每表至少16个索引和每表索引长度总和至少256字节(bytes), 大多数存储引擎有更高的值.

- Index Prefixes
当有一个字符串列col_name(N),你可以只索引前N个字符,这样会使索引更小.当你对BLOB或TEXT列作索引时, 你必须指定索引前缀长度.索引最长可达到1000字节(bytes)(innoDB最大767bytes,但 系统变量innodb_large_prefix被设置后可以更大). 前缀限制的长度以字节为单位, 而create table, alter table和create index语句的前缀长度被解释为非二进制字符串类型的字符数和二进制字符串类型.所以在为多字节集的非二进制字符串列指定前缀长度时,需要考虑到这点.

- FULLTEXT Indexes
**只有MyISAM和innoDB存储引擎支持全文索引,而且只有char,varchar和text列支持.全文索引只会对整列索引,不支持前缀索引**

- Spatial Indexes
>可在空间数据类型(spatial data types)上创建空间数据类型索引, 只有MyISAM支持空间类型上的R-tree索引, 其他存储引擎使用B-trees索引空间类型(除了ARCHIVE,它不支持空间类型索引)

- Indexes in the MEMORY Storage Engine
**MEMORY存储引擎默认使用hash索引, 但也支持B-tree**

#### 8.3.5 Multiple-Column Indexes
- **mysql可以创建复合索引(即在多列上建索引).一个索引最多可以包含16列.**对于复合索引的替代方法,在表上多建一列基于其他列组合的值的hash列, 如果此列较短,合理唯一并且已经建立索引则可能比复合索引快.
- 复合索引只在符合最左前缀下生效

#### 8.3.6 Verifying Index Usage
>始终检查你的所有查询是否使用表中的索引.可以使用EXPLAIN语句

#### 8.3.7 InnoDB and MyISAM Index Statistics Collection
- 存储引擎收集有关表的统计信息,以供优化器使用.表统计信息基于值组,其中值组是一组具有相同前缀值的行.出于优化目的,一个重要统计数据是平均值组的大小.
  - mysql会在以下方式中使用平均值组
    - 评估每个ref访问必须读取多少行
    - 估计部分联表(partial join)将产生多少行
  - 随着索引的平均值组的增大, 该索引在上述的两个方面中的用途越小, 因为每次查询到的行数增加.为了使索引更好的用于优化,每个索引最好对应着数据表中比较少的行数.当一个给定的索引值对应着大量的行时,则mysql不太可能使用它.
  - **平均值组的大小与表基数有关,表基数就是值数的数目.show index语句显示的基数值字段(cardinality)基于N/S, N为表的所有行数, S为值组的平均大小, 该比率指示着表中大约多少个值组.**
  - 对于基于<=>的join, null与其他任何值都一样: null<=>null(为true), 就像N<=>N(为true)一样.(**`<=>`操作符为比较两个变量,相同返回1不同返回0,其中对于null:只有当两个都是null才返回1,只有一个为null时返回0,而平常的`=`操作符null于其它任何值相比都是返回null**)
  - 基于=运算符的join, null与其他non-null值不相等, 当expr1或expre2为null(或两者都是)时, expr1 = expr2不为true.这会影响到ref访问以tabl_name.key = expr形式比较,如果expr值为null,则mysql不会访问表因为比较不会为真.(也就是`=`操作符,null与其它任何值相比都是返回null)
- **对于=比较,表中有多少null值都无关紧要.出于优化目的,相关值是非null值组的平均大小, 目前mysql还不支持收集和使用该平均值.**
- 对于innoDB和MyISAM表,可以通过系统变量innodb_stats_method and myisam_stats_method来控制表统计信息的收集.这两个值有以下3个可能的值:
  - nulls_equal,所有null值都会被认为相等(即它们是同一个值组)
  - nulls_unequal,所有null都被认为不相等.每个null值单独组成大小为1的值组.
  - nulls_ignored,null值会被忽略
- **如果倾向使用许多<=>比较而不是=比较的联表(join),则nulls_equal是合适的统计方法.**

- innodb_stats_method有全局值,myisam_stats_method具有全局和会话值,所以可以设置myisam_stats_method的会话值来强制使用给定方法重新生成表的统计信息,而不影响其他客户端.你可以使用如下方法重新生成MyISAM表的统计信息:
  - 执行myisamchk --stats_method=method_name --analyze
  - 更改表以致表的统计信息过期(如插入一行再删除),然后set myisam_stats_method,最后执行ANALYZE TABLE语句
- 一些关于使用innodb_stats_method和myisam_stats_method的警告  
  - 无法确定表的统计信息是由那种方法生成
  - 这两个变量分别仅对InnoDB和MyISAM表有效.其他的存储引擎只有一种收集统计信息的方法,它更接近nulls_equal方法
  
#### 8.3.8 Comparison of B-Tree and Hash Indexes  
- B-Tree Index Characteristics
  - B-tree索引能被用于=,>,>=,<,<=,BETWEEN的比较,**如果like的参数是不以通配符开头的常量字符串(如'Pat%_ck%')的like操作也可以使用索引**
  - **col_name IS NULL语句也可以使用索引当col_name加了索引**
  - *(重要但没很看明白)没有覆盖where从句中所有and级别的任何索引都不会用于优化查询,也就是为了能够使用索引, 必须在每个and组中使用索引前缀.
  - 有时,即使索引可用,mysql也不会使用索引.例如有种情况, 优化器估计使用索引将需要读取表中很大比例的数据行(这种情况, 表扫描可能会更快,因为他需要更少的查找).但是如果这样的语句使用limit只是检索某些行, 则mysql仍然会使用索引, 因为他可以更快找到并返回结果的几行.
    
- Hash Index Characteristics
  - 只适用=或<=>的运算符比较(但非常快),不能使用比较运算符(如<)来查找值的范围.依赖于这种单值查找类型的系统称为"键值存储"(key-value stores)
  - 无法使用hash索引加速order by操作(hash索引无法按顺序搜索下一条目)
  - mysql无法确定两个值之间大约有多少行(范围优化器使用它来决定使用那个索引)
  - **仅整个键可用于搜索表行(对于B-tree索引,任何键的最左前缀都可以用于查找表行)**

#### 8.3.9 Use of Index Extensions  
- innoDB通过将每个二级索(secondary index)引后附上主键列来自动扩展每个二级索引.
  - 比如i1, i2是主键, 则有一个名为k_d索引,则内部会扩展它并将他认为了(d, i1, i2)
  - 在确定如何以及是否使用该索引时,优化器会考虑到二级索引的主键列, 这会导致更有效的执行计划和更好的性能.
- 还可以通过flush status;(先清除状态计数器) SHOW STATUS LIKE 'handler_read%'语句查看使用了扩展索引的优化器行为上的差异
- optimizer_switch系统变量的use_index_extensions=on/off标志可以控制优化器是否对innoDB表的二级索引的主键列进行考虑.默认是启用的.
  
#### 8.3.10 Indexed Lookups from TIMESTAMP Columns
  
### 8.4 Optimizing Database Structure

#### **8.4.1 Optimizing Data Size**
>设计表以最小化在磁盘上的空间.通过减少对磁盘的写入和读取的数据量,这会带来巨大改进.
- Table Columns
  - 尽可能使用最有效的数据类型.这能节省磁盘空间和内存.比如如果够用MEDIUMINT比INI是更好的选择,因为这需要更少的空间
  - **如果可能声明列不为null,通过更好的使用索引并消除测试每个值是否为null的开销可加快sql的操作.如果确实需要使用null值,就使用但是避免设置默认值为null.**
- Row Format
  - 在mysql5.6中,innoDB表默认使用COMPACT row存储格式(ROW_FORMAT=COMPACT).紧凑的行格式系列包括了COMPACT, DYNAMIC, COMPRESSED,减少了行存储空间但增加某些操作的cpu使用率.如果你的工作负载是典型的受缓存命中率和磁盘速度,则会更快;如果仅仅只是受限于cpu速度, 那么反而会更慢.
    - **紧凑的行格式还可以优化使用了可变长度字符集(如utf8mb3或utf8mb4时)的char列存储.如果ROW_FORMAT=REDUNDANT,则char(N)占用N x 字符集最大字节长度.许多语言主要可使用单字节utf8字符集编写, 所以一个固定的存储长度往往是浪费空间的.使用紧凑的行格式系列,InnoDB通过剥离尾部的空格, 在N到N x 该列字符集的最大字节长度的范围内分配存储长度.在典型情况下, 最小的存储长度为N字节以方便就地更新.**
  - **要通过压缩的形式存储表数据来进一步减少空间,可在创建innoDB表时指定ROW_FORMAT=COMPRESSED,或对已存在的myisam表执行myisampack命令.(innoDB压缩表是可读写的,而myisam压缩表只能读)**
  - 对于myisam表,如果没有任何可变长度列(varchar,text,blob),则使用固定大小的行格式.这样会比较快,但可能会浪费一些空间.
- indexs
  - **表中的主索引应尽可能小.这使得识别每一行变得容易有效.对于innoDB表,主键列都会附在二级索引后, 因此如果你有许多二级索引时,则较短的主键可节省大量空间.**
  - **索引能提高读取性能,但会减慢插入和更新操作.如果你需要搜索多列组合来访问表,则创建一个复合索引,而不是为每个单独的创建索引.索引的第一部分应该是最常使用的列.**
  - 如果一个长的字符串列很可能在前几个字符上具有唯一的前缀, 则可在该列的最左部分创建索引.较短的索引会更快, 这不仅是他需要更少的磁盘空间,而且还会增加索引缓存的命中次数,从而减少了磁盘寻道
- joins
  - 在某些情况中, 将经常扫描的表分为两部分是有益的.如果是动态格式的表,可以使用较小的静态格式表去查找相关的行在扫描表时,则尤其如此.
  - 在不同表中声明相同的数据类型以加快基于相应列的联表(join)
  - **保持列名简单, 以便在不同的表中使用相同的名称以简化联接查询.例如在名为customer的表中, 使用name代替customer_name,** 为了使名称能够移植到其他sql server中,请考虑名称短语18个字符
- Normalization
  - 通常,尝试使所有数据都保持非冗余(即是符合第三范式).无需冗长的值(如名字,地址),而是分配它们一个唯一id,在其他有需要的表使用该id.

#### 8.4.2 Optimizing MySQL Data Types

#### 8.4.2.1 Optimizing for Numeric Data
- **对于唯一id或其他可以被表示为数字或字符串的值,数字列好于字符串列.因为大数值可以比相应的字符串存储使用更少的字节,因此使用更少内存的来传输和比较**
- **如果使用的是数字型数据(numeric data),则许多情况下从数据库访问比文本访问更快.**

#### 8.4.2.2 Optimizing for Character and String Types
- **当你不需要特地语言的排序规则功能时,请使用二进制排序规则快速比较和排序操作.在查询中可以使用BINARY运算符来指定使用二进制排序规则.**
- 比较来自不同列的值时,尽可能声明为相同字符集和排序规则,以避免在查询中进行字符串转换.
- 对于小于8kb的列值,请使用binary VARCHAR而不是BLOB.group by和order by子句可以生成临时表,并且如果原始表不包含任何的BLOB列,则这些临时表可以使用MEMORY存储引擎.
- **如果一个表包含像名字或地址但许多查询又通常用不到的列,考虑将这些列拆分成为单独的列,在需要的时候使用join查询.当mysql从一行中读取任何值时,它将读取一个包含该行所有列的数据块,所以尽可能保持每行较小.**
- innoDB中,当你使用随机值作为主键时,尽可能为其加上一个上升值的前缀,如当前日期和时间.当连续的主键值在物理存储上彼此靠近时,innoDB可以更快的读取和插入它们

##### 8.4.2.3 Optimizing for BLOB Types
- 当存储包含文本数据的大blob数据时,首先考虑压缩它.但当整个表由innoDB或myisam压缩时,请勿使用此技术.
- **对于具有多列的表,为了减少不使用blob列的查询对内存的需求,请考虑将blob列拆分成一个单独的表,在需要时使用join查询**
- 由于检索和显示BLOB值对性能的要求相比其他数据类型会较大的不同.你可以将特定于blob表放在不同的存储设备或甚至是单独的数据库实例.比如检索blob需要读取较大的顺序磁盘,而这传统磁盘更适合而不是SSD设备
- **而不是针对一个非常长的文本字符串测试是否相等, 你可以将列值的hash值存储在一个列中并建立索引,然后在查询使用hash查找.由于hash函数可能会由不同输入值产生重复的结果,为此你仍然可以再加上and blob_colname=long_string_value来保证不会将错误结果也包含进来.**

##### 8.4.2.4 Using PROCEDURE ANALYSE
- **ANALYSE()检查查询结果并对结果进行分析,然后返回每列最佳数据类型的建议.减小表大小**.用法在select语句后附上PROCEDURE ANALYSE([max_elements,[max_memory]]);如下例子:
  `SELECT ... FROM ... WHERE ... PROCEDURE ANALYSE([max_elements,[max_memory]])`    
  
### 8.4.3 Optimizing for Many Tables  
#### 8.4.3.1 How MySQL Opens and Closes Tables
- **mysql是多线程的, 所以当有许多客户端同时对一个表进行查询,为了最小化多个客户端会话对于同一张表具有不同的状态的问题,该表由于并发的会话独立打开,这会二外增加内存但通常会增加性能.对于myisam表,对于每个打开表的客户端, 打开数据文件(data file)都需要一个额外的文件描述符(相反索引文件(index file)描述符在所有会话间是共享的)** 
- **table_open_cache和max_connections系统变量影响着服务器保持打开的最大文件的数量,如果你增加其中一个或两个值,你可能也需要提高由你操纵施加的每个进程打开的文件描述符的数量.许多操作系统都允许你增加打开文件的限制.**
- table_open_cache: 该值与max_connections有关,比如200个并行的连接, 那么指定该值最少200*N,N为任何你要的执行查询语句中联表的最大数量, 同时你必须为临时表和文件保留额外的文件描述符
- **对于myisam存储引擎需要注意的是,每个唯一打开的表都需要两个文件描述符.对于有分区的mysql表,每个分区都需要两个文件描述符.当mysql打开带有分区的myisam表时,都会打开所有的分区表不管查询语是否有指定分区.如要增加mysql可用的文件描述符的数量,可以设置open_files_limit.**

- mysql会在如下情景中关闭不需要使用的表并从table cache中移除:
  - 当缓存已经满了,一个线程想要打开不在缓存中的表
  - 当缓存包含多于table_open_cache数量并且缓存中的表不在被任何线程使用.
  - 当使用table-flushing的操作时.
- 当表缓存占满时,服务器使用如下程序去定位一个缓存条目使用
  - 从最近最少使用的表开始,释放当前未使用的表
  - 如果必须打开一个表,但缓存已经满了并无法释放,则缓存会按需要临时扩展,当表从已使用变为未使用状态时则将表关闭并从缓存中释放.
- myisam将为每个并发访问都打开一个myisam表.这意味着两个线程访问同一个表或一个进程访问表两次(比如join自己)都打开两次表.
- 检查你的table cache是否太小,检查opened_tables状态变量,这指示着自服务器启动以来表打开操作的数量.如果该值很大或增加迅速,即使你没有执行许多flash table语句,那么在服务器启动时要增加table_open_cache值

##### 8.4.3.2 Disadvantages of Creating Many Tables in the Same Database
- 如果你有许多mysql在同一个数据库中, 如果你在许多不同的表上执行select语句,这会有些开销当你在table cache满了,因为对于要打开的每个表,另外一个表必须被关闭.
  
##### 8.4.4 Internal Temporary Table Use in MySQL
- 在一些情况中,mysql会创建内部的临时表当处理语句时.用户无法直接控制.mysql会在如下情况中创建临时表:
  - 评估UNION语句 
  - 一些视图中,比如使用了TEMPTABLE算法,UNION或聚合的视图
  - 评估派生表
  - 为子查询或半联接(semijoin materialization)而创建的表
  - 评估包含一个order by子句和另一个不同的group by子句, 或者对于order by或group by包含的列在联表(join)顺序中第一个表外.
  - 评估DISTINCT与ORDER BY的结合可能需要临时表
  - 查询中使用SQL_SMALL_RESULT修饰符查询则mysql会使用内存中临时表, 除非查询还包含需要在磁盘存储的元素
  - 评估insert和select都是同一个表的INSERT ... SELECT语句,mysql需要一个临时表.
  - 评估多表update语句时
  - 评估GROUP_CONCAT()或COUNT(DISTINCT)的表达式时
- 为了确定语句是否使用了临时表,使用EXPLAIN然后查看extra列是否标注了using temporary.对于派生表或物化的临时表( derived or materialized temporary tables)不一定会标出.
- **当mysql创建一个内部临时表时(不管是在内存还是磁盘上),它会增加Created_tmp_tables状态变量.如果在磁盘的临时表(不管是最初的或者通过转换内存中的表),它会增加 Created_tmp_disk_tables状态变量**
- 某些查询条件会阻止使用内存中的临时表,而使用在磁盘上的临时表来替代如下:
  - **表中存在BOLB或TEXT列,这包括被当作BLOB或TEXT(这取决于它们的值是二进制还是非二进制字符串)的用户自定义的字符串变量**
  - 任何在GROUP BY或DISTINCT中的字符串列大于512(二进制字符串大于512字节(bytes),非二进制字符串大于512字符(characters))
  - 在union或union all中,select的列存在大于512字符串(二进制字符串大于512字节(bytes),非二进制字符串大于512字符(characters))
  - show colums和describe语句某些列使用BLOB类型,因此用于结果的临时表是在磁盘上的.
  - 
- Internal Temporary Table Storage Engine
  - 一个内部临时表可以存储在内存中,由MEMORY存储引擎处理;或者存储在磁盘上,由myisam存储引擎处理.如果一个在内存中内部临时表变得太大将会被自动转换为到磁盘表,最大的值由tmp_table_size或max_heap_table_size值决定,以较小为准,这不同使用create table显式创建的memory表,对于此表只有max_heap_table_size决定了表能增长的最大值,并且不会转换为磁盘格式.
- Internal Temporary Table Storage Format
  - 内存中的临时表由memory存储引擎管理,该引擎使用固定长度的行格式()fixed-length row format).VARCHAR和VARBINARY列被填充到最大列长度,实际上它们被存储为char和binary列
  - 磁盘上的临时表由myisam存储引擎管理,该引擎使用动态长度的行格式(dynamic-width row format),列仅占用所需的存储空间; 与使用固定长度行格式的磁盘表相比,减少了磁盘I/O和空间需求以及处理时间
  - 对于最初在内存中创建的内部临时表之后太大自动转换为磁盘上的表的语句,如果跳过转换步骤则一开始就在磁盘上创建表可能会获取更好的性能.big_tables变量可用于强制所有的内部临时表都使用磁盘存储
  
#### 8.4.5 Limits on Number of Databases and Tables
- mysql对于数据的数量没有限制,基础文件系可能对目录数量有所限制.
- mysql对表的数量没有限制,基础文件系统可能对文件数量有所限制;各个存储引擎可能会强加特定于引擎的约束,innodb最多40亿张表

#### 8.4.6 Limits on Table Size
- Windows用户,请注意FAT和VFAT（FAT32）不适用于MySQL。请改用NTFS.

#### 8.4.7 Limits on Table Column Count and Row Size  
- Column Count Limits
  - mysql硬性限制表最大4096列,但实际有效列可能比这小, 具体取决如下情况:
    - 最大行大小限制了列的数量(也可能是大小)
    - 存储引擎可能施加其他的限制,比如innoDB限制每个表最大1017列
- Row Size Limits
  - mysql表内部表示形式最大行大小限制为65536字节(bytes),即使是存储引擎能提供更大的值也是如此.BLOB和TEXT列仅对行大小贡献9-12字节,因为它们的内容与行的其余部分分开存储
  - innoDB(数据本地存储在一个数据页面中)的最大行大小略小于页的一半.例如,对于默认16kb的innodb页面大小(page size),最大行大小略小于8kb,该页面大小由innodb_page_size设置.
    如果一个行中包含可变长度的列超出了innodb最大行大小,则innodb选择可变长度列进行页外存储,直到改行适合最大行大小限制.
  - 不同存储格式使用不同数量的页面标题和尾部数据,这会影响到可用存储量.
    - innodb行格式
    - myisam存储格式  
- Row Size Limit Examples    
  - 对于myisam表, null列在行中需要占用额外的空间以记录其值是否为null,每个null列都要多加1bit,四舍五入到最近的字节.(比如一行有3个null列那么就是占用3bit舍入为1byte)
    
#### 8.5 Optimizing for InnoDB Tables
- 一旦你的数据达到稳定大小或者增长了几十或几百兆字节,考虑使用OPTIMIZE TABLE语句重组表并压缩所有浪费的空间.重组后的表需要更少的磁盘I/O执行全表扫描.这是直接的技术(如改善索引使用或调整程序代码)在其他技术不可行时提高性能.
- 对于innoDB表,如果主键很长(不管是单列有很长的值或多列的复合索引组成长值)这将会浪费许多磁盘空间,因为每一行的主键值都会附在该行所有的二级索引值后面.所以创建一个自增加的列作为主键如果你的主键很长或者索引较长VARCHAR列的前缀而不是整列
- 存储变长字符串时或一列中有许多的null值时,使用varchar数据类型代替char类型, char(N)列始终使用N字符(character)存储数据,即使字符串较短或者存储值为null.较小的表更适合缓冲池并减少磁盘I/O. 当使用COMPACT行格式(innoDB默认格式)存储可变长字符集(如utf8)时, char(N)占用的空间大小为可变的,但至少N字节.

#### 8.5.2 Optimizing InnoDB Transaction Management
>要优化innoDB事务处理,请在事务功能的性能开销和服务器工作负载之间找到一个平衡.例如应用程序每秒提交数千次则可能遇到性能问题,如果仅每2-3小时提交一次,则可能会遇到不同的性能问题.
- 默认的MYSQL设置AUTOCOMMIT=1可能会繁忙的数据库服务器造成性能限制.在可行的情况下,通过发出SET AUTOCOMMIT=0或START TRANSACTION语句,然后在进行所有更改后再执行COMMIT语句,将几个相关的数据更改操作包装在单个事务中. innoDB必须flush log到磁盘中在每次事务commit(该事务更改数据库).在每次更改都进行commit(默认的自动提交机制即autocommit=1),存储设备的I/O吞吐量将会限制每秒可能进行的操作的数量.
- 对于只包含一个select语句的事务,打开autocommit可以帮助innoDB识别只读事务并优化它.
- 避免在插入,更新或删除大量行后执行回滚,因为执行时间可能是原始数据更改操作的几倍.终止数据库进程也无济于事,因为回滚会在服务器启动后再次开始.为了最小化这种事情的发生:
  - 增加缓冲池(buffer pool)大小以便可以缓存所有数据更改而不是立即写入磁盘.
  - 设置innodb_change_buffering=all以便除了插入外,更新和删除操作也会被缓存
  - 在大数据量操作时考虑定期的执行commit语句,可能将单个删除或更新分解为对较少行数进行操作的多个语句
  对于已经发生的失控的回滚,可以增加buffer pool大小以使回滚变为受限于cpu并快速运行, 或者终止服务器并以innodb_force_recovery=3重新启动
  设置了innodb_change_buffering = all(默认设置)预计很少出现此问题,该设置允许将更新和删除操作缓存在内存中,从而使它们可以更快的执行,并且在需要时可以更快地回滚.确保在处理具有许多插入,更新或删除操作的长期事务的服务器上使用此参数.
  - 如果你承受一些最近提交的事务的损失,可将innodb_flush_log_at_trx_commit设置为0.无论如何,innoDB都会每秒刷新一次日志,尽管不能保证刷新成功,另还可将innodb_support_xa设置为0,这将减少由磁盘数据和二进制日志同步而导致的磁盘刷新次数.
  - 修改或删除行后,不会立即删除行和关联的undo log,甚至在提交事务后都不会立即删除.保留旧数据,直到更早或同时开始的事务完成为止,以便那些事务可以访问已修改或已删除行的先前状态.因此长时间的事务可以防止innoDB清除由其它事务更改的数据.
  - 当一个长时间的事务更改或删除了行, 其他事务使用了READ COMMITTED和REPEATABLE READ隔离水平并读取了相同的行,则需要更多的工作去重建较旧的数据.
  - 当运行时间 长的事务修改表时,来自其他事务对该表的查询不会使用覆盖索引技术.通常可以从二级索引获取所有结果列,而不是从表数据中查找适当值的查询.如果发现二级索引页面PAGE_MAX_TRX_ID太新或者二级索引中的记录带有删除标记,innoDB可能需要使用聚簇索引查找记录
  
#### 8.5.3 Optimizing InnoDB Read-Only Transactions 
- innoDB可以避免与已知为已读的事务设置ID(TRX_ID字段)相关的开销.仅对可能执行写操作或锁定读取的事务(例如select ... for update),才需要事务ID.消除不必要的事务ID,可以减少每次查询或数据更改语句构造读取视图时都要查询的内部数据结构的大小.    
- innoDB在如下情况会被认为是read-only
  - 事务由 START TRANSACTION READ ONLY语句开始,在这种情况中,事务中语句如果尝试修改数据库则会报错;但是你仍然可以跟更改会话创建的临时表,或执行locking查询语句,因为该改变和锁对其他的事务是不可见.
  - 打开了autocommit,所以是被保证为仅为单条语句,如果这些语句是由"non-locking"的select语句组成(即是select语句中没有使用FOR UPDATE或LOCK IN SHARE MODE从句)
  
#### 8.5.4 Optimizing InnoDB Redo Logging  
- 可以从以下方面考虑优化redo loggin
  - 使你的redo log文件变大,甚至和缓冲池(buffer pool0一样大.当redo filesbei被innoDB写满时,它必须在检查点(checkpoint)将缓冲池的已修改内存写入磁盘.小的redo log files导致许多不必要的磁盘写入.因此你应该有自信使用大的redo log file.
    - 可通过innoDB_log_file_size和innoDB_log_file_in_group系统变量分别控制redo log fiels的大小和数量.
  - 考虑增加log buffer的大小.一个大的log buffer能够允许大事务的执行在commit前不需要将log写入到磁盘中.因此有更新,插入或删除许多行的事务增大log buffer能够节省磁盘I/O, 可通过innodb_log_buffer_size系统变量来控制log buffer大小.

##### 8.5.5 Bulk Data Loading for InnoDB Tables
>以下的性能技巧补充了8.2.4.1 “Optimizing INSERT Statements”.章节中快速插入的一般指南
- 当导入数据到innoDB表中,关闭autocommit,因为它会在每次插入后都执行日志刷新磁盘的操作.所以关闭autocommit,用commit语句手动提交你的操作. 用mysqldump的--opt选项可以创建快速导入到innoDB表的dump file,即使不关闭autocommit.
- 如果你在二级索引上UNIQUE限制,那么可在导入时临时关闭uniqueness检测来加快速度,代码如下:
  `SET unique_checks=0;... SQL import statements ...`
  `SET unique_checks=1;`
- 如果表有FOREIGN KEY限制,可以在导入时临时关闭foreign key来加速, 代码如下:
  `SET foreign_key_checks=0;... SQL import statements ...`
   `SET foreign_key_checks=1;`  
- 插入多行时,使用多行插入语法可以减少客户端和服务端通讯的开销, 对于其他类型表也有效,不仅是innodb
- 对带有自增列的表进行批量插入时,可将 set innodb_autoinc_lock_mode设置为2代替默认值1.
- 当执行批量插入时,按照主键(PRIMARY KEY)顺序插入会更快.innoDB使用了聚簇索引,这使得按primary key顺序使用数据相对较快.对于不完全容纳在缓存池中的表,按照主键顺序批量插入尤为重要.
- 为了将数据加载到innoDB fulltext索引中时以获得以获最佳性能,请遵循以下步骤:
  1. 创建表时创建一列fts_doc_id(bigint unsigned not null格式), 并对其创建一个唯一索引FTS_DOC_ID_INDEX; 代码例子如下:
    `CREATE TABLE t1 (
     FTS_DOC_ID BIGINT unsigned NOT NULL AUTO_INCREMENT,
     title varchar(255) NOT NULL DEFAULT '',
     text mediumtext NOT NULL,
     PRIMARY KEY (`FTS_DOC_ID`)
     ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
     CREATE UNIQUE INDEX FTS_DOC_ID_INDEX on t1(FTS_DOC_ID);`
  2. 将数据导入表中
  3. 数据导入完创建fulltext索引    
  
#### 8.5.6 Optimizing InnoDB Queries
- 为了调整innoDB表查询,可对表创建适当的索引.创建索引请参照一下准则:
  - 为每个表指定一组主键列,这些列用于最重要或时间紧迫的查询
  - 主键不宜包含太多列或列值太长,因为在主键都会自动附在二级索引后.
  - 不要为每一列都单独创建索引,因为每个查询只能使用一个索引, 很少使用的列或列的值只有几个不同的值可能对查询帮助不大.如果对同一个表有许多不同的查询,测试不同的列组合,创建少量的串联列不是大量的单列索引.
  - 如果一列不允许null值,则声明表时标明为not null,当优化器知道每列是否包含null时,可以更好决定用哪个索引最有效.
  - 对于单查询(single-query)事务的优化,参见8.5.3,“Optimizing InnoDB Read-Only Transactions”.
 
 #### 8.5.7 Optimizing InnoDB DDL Operations   
 - 由于主键对于每个innodb表的存储布局是必不可少的,并且更改主键将涉及重新组织整个表,所以在create table时就应该包含主键设置并预先计划好,避免后续的更改或删除.
    
##### 8.5.8 Optimizing InnoDB Disk I/O    
>如果你遵循了mysql数据设计的最佳实践和sql操作的调优技术,但是mysql还是因为I/O繁忙活动而很慢, 请考虑这些I/O优化.如果你使用top工具显示cpu的使用率低于70%,那么你的工作负载可能受限于磁盘. 
  - 增加buffer pool大小
    - 通过innodb_buffer_pool_size设置,此内存区域非常重要,因此建议配置为系统的50%-75%. 
  - 调整flush方法
  - 增加I/O容量避免积压
    - 如果由于checkpoint操作造成吞出量周期性下降,请考虑增加innodb_io_capacity变量值,越高则flush越频繁,从而避免了积压的工作量
  - 降低I/O容量如果flush没有落后  
  - Disable logging of compressed pages

#### 8.5.9 Optimizing InnoDB Configuration Variables    
- 你可以执行的主要配置步骤如下(优化的目录,这里没有详细列出,要看原文)
    
### 8.6 Optimizing for MyISAM Tables
>由于表锁定限制了同时更新的能力,因此myisam存储引擎在以只读数据为主要或低并发操作方面表现最佳.    

#### 8.6.1 Optimizing MyISAM Queries
>以下为一些加速myisam表查询的一般技巧
- 在加载数据后使用ANALYZE TABLE或myisamchk --analyze,这将为每个索引部分更新上一个值,改值指示着具有相同值的平均行数.在不是恒定表达式(nonconstant express)的表join中优化器使用该值决定使用哪个索引.
- 根据某个索引对数据和索引进行排序这会使得如果有一个唯一索引要从中按顺序读取所有的行的查询更快; myisamchk --sort-index --sort-records=1(假设你要对索引号为1的索引进行排序,索引号可从show index语句获得)
- mysql支持并发插入数据,如果表的数据文件中间没有空闲块(free block),则可以在其他线程正在读取数据的同时,向其中插入新行.如果能够做到这一点对于你很重要,那么请考虑避免删除表行,另一个可能就是当你删除许多行后使用OPTIMIZE TABLE语句整理碎片.通过设置concurrent_insert系统变量可以控制并发插入行的行为,该变量可采用如下的值:
  - NEVER: 禁止并发插入
  - AUTO: (默认,但当服务以--skip-new选项启动则被设置为NEVER)当MyISAM表没有孔(holes)时,允许并发插入
  - ALWAYS: 允许并发插入MyISAM表,即使这些表有holes.该模式下当一个有holes的MyISAM表被其它线程使用时,当前线程对其插入时则新行都被插入到表的最后.否则MyISAM表的插入,是mysql获取一个正常写锁并将行插入到hole中.
- 对于频繁更改的MyISAM表,避免使用变长的列(varchar,blob,text),该表使用动态行格式(dynamic row format)即使该表只包含一个变长的列.
- 通常,仅由于行太大而将表拆分不同的表是没用的.在访问一行时,最大的性能损失是查找该行第一个字节所需要的磁盘搜索,找到数据后,对于大多数现代磁盘都可以快速读取整个行.拆分表的唯一情况是:如果你能将动态行格式的myisam表更改为固定行大小(fixed row size);或者你需要经常扫描表但不需要其中大多数列.
- 使用alter table table_name order by expr1, expr2,...对表进行按照索引的顺序将数据进行排序,这样会有利于后续你查询数据时以expr1,expr2..的顺序查询
- 如果你需要基于大量行中的信息来计算结果(例如计数器), 则最好引入一个新表并实时更新它,如下例子更新表格就非常快:
  `UPDATE tbl_name SET count_col=count_col+1 WHERE key_col=constant;`
  这对于使用像myisam这种仅有表级锁(table-level locking)的存储引擎(表级锁即是同时可以一个写和多个读)非常重要,同时对于其他许多数据库系统也能获得更好的性能因为在这种情况下行级锁管理器的工作量减少了.
- 定期的执行 OPTIMIZE TABLE语句避免动态格式的myisam表碎片化.
- 使用DELAY_KEY_WRITE=1选项声明myisam表(该选项有仅适用于myisam),可以加快是索引更新更快因为在关闭表时才会将索引的更新刷新到磁盘.不足之处是当myisam表在打开时mysql服务被kill了,你必须保证表是正常的通过设置了myisam_recover_options系统变量的运行mysql服务器,或者在mysql服务器重启前使用myisamchk检测表.(即使在这种情况下,使用了DELAY_KEY_WRITE你也不会任何损失,因为你总能从数据行中生成键信息).
- 字符串在myisam索引中自动进行前缀和结尾空间(end-space)压缩    
- 在自己的应用上缓存查询和答案(query and answers),然后一起执行许多插入或更新操作来提高性能.在此期间锁定表可确保在所有更新后索引缓存只flush一次.你也可以利用mysql的查询缓存达到类似的结果 

#### 8.6.2 Bulk Data Loading for MyISAM Tables  
>以下的一些性能提示补充8.2.4.1, “Optimizing INSERT Statements”中有关快速插入的一般准则
- 使用INSERT DELAYED语句提升多个客户端插入许多行时.这对于myisam和其他引擎是有效的,但是innoDB不行.
   - 注意 INSERT DELAYED已经不赞成使用,在将来的版本中将被移除,请使用 INSERT(不带DELAYED)语句代替
- 通过一些额外的工作,当表具有许多索引时,可以使用load data以使myisam运行得更快.操作步骤如下:
  1. 执行flush table语句或mysqladmin flush-tables命令
  2. 执行myisamchk --keys-used=0 /path/to/db/tabl_name以在插入时禁止更新表的所有索引
  3. 使用load data语句插入数据,该操作不更新任何索引所以很快
  4. 如果将来只打算从表中读取,请使用myisampack对表进行压缩
  5. 执行myisamchk -rq /path/to/db/table_name命令重新创建索引.该操作在写入磁盘前在内存中创建索引树,所以相比在load data时更新索引更快因为它避免许多磁盘的搜寻
  6. 执行flush tables语句或mysqladmin flush-tables命令
  - 如果要插入的myisam表为空,则load data会自动执行上述的优化操作,自动优化和程序指定     的区别是: 
  - 你还可以通过以下语句禁用或启用myisam表的非唯一索引.
    `ALTER TABLE tbl_name DISABLE KEYS;
     ALTER TABLE tbl_name ENABLE KEYS;`

- 对非事务表执行多条语句插入操作,锁定表会更快:
	 `lock tables table_name write;
	  insert sql;
	  unlock tables;`
   - 该操作提高性能得益于因为在所有insert语句完成后索引缓冲区(index buffer)才flush到磁盘上.通常地,索引缓冲区刷新与insert语句一样多.如果可以单个insert语句插入所有行则不需要显示的锁定语句.
   - 插入时使用锁会减少多个连接中执行总的时间,尽管单个连接等待可能会增加.如下举个例子,插入时没有使用锁表,那么连接2,3,4会在连接1,5之前完成.如果加了表锁,那么连接2,3,4可能不会在连接1或5之前完成,但是总的耗时应该快了40%
     - 连接1做1000个插入
     - 连接2,3,4个做1个插入
     - 连接5做1000个插入
   - mysql中插入更新删除操作是很快的,但你可以在所有大约有5个以上的连续插入或更新的操作上加上锁来获得更好的整体性能.如果你要执行很多连续的插入,你可不时地使用lock table和unlock tables语句(每1000行左右)以使其他线程也能访问表,这也能获取不错的性能提升.但insert语句仍然比load data语句加载数据慢很多,即使是使用刚描述的策略.
- 对于myisam表,增加key_buffer_size系统变量的值对于load data和insert语句都能带来性能提升.

#### 8.6.3 Optimizing REPAIR TABLE Statements
- 对myisam表使用REPAIR TABLE语句类似于myisamchk的修复操作,并且应用一些相同的性能优化
  
#### 8.7 Optimizing for MEMORY Tables  
- 对于经常访问和只读或很少更新的非关键数据可以考虑使用MEMORY表,将应用程序与等效的innoDB或myisam表进行基准测试,以确认提升的性能是否值得冒丢失数据的风险,或当应用启动时从磁盘上的表复制数据的开销

### 8.8 Understanding the Query Execution Plan
#### 8.8.1 Optimizing Queries with EXPLAIN
- explain可以运用在select,insert,delete,update,replace语句(对于相同操作的预处理语句不支持)
#### 8.8.2 EXPLAIN Output Format
#### 8.8.3 Extended EXPLAIN Output Format
- 使用explain EXTENDED时,输出信息会多包含一个filtered列(指示过滤的表行的估计的百分比);
- 此外对于select语句(只有select有,其他update等都没有)还会有一些其他信息但是不会包含explain输出中,但是可以通过在explain语句后马上执行show warning语句来查看.
#### 8.8.4 Obtaining Execution Plan Information for a Named Connection
- 获取一个给定的连接名正在执行语句(需支持explainable的语句)的执行计划,用法如下:
  `EXPLAIN [options] FOR CONNECTION connection_id;`
  `小提示SELECT CONNECTION_ID();可以获取当前连接id`
   有时候由于数据的改变(以及辅助的统计信息),这可能和你在等效的语句上执行explain会产生不同的结果.行为上的这种差异对于诊断更多瞬时性能问题很有帮助.假设你一个线程中有语句执行很慢,这时你可以在另一个线程中使用该语句查看到该语句执行慢的一些有用信息.必须是在该慢语句正在执行时同时该语句要支持explain

#### 8.8.5 Estimating Query Performance
- 在大多数情况下,你可以通过计算磁盘寻道次数来估计查询性能,对于小型表,通常寻找一行一个磁盘寻道(one disk seek)(因为索引可能已缓存);对于较大型表,使用B-tree索引,可以使用以下公式来评估寻找一行需要多少个磁盘寻道.
  - log(row_count) / log(index_block_length / 3 * 2 / (index_length + data_pointer_length)) + 1. 
    - 在mysql,index_block_length通常是1024bytes, data_pointer_length通常是4bytes
  - 但是对于写,你需要4个磁盘寻道来定位何处放置新的索引值,通常需要2个磁盘寻道来更新索引并写入行数据    
- 在前面的讨论中,性能并不会因为log N的增大而退化,只要所有操作系统或mysql服务器能缓存所有的内容,当表变大时只会稍微慢点.但当表太大而无法缓存时,就会变得缓慢很多直到你应用的性能仅受磁盘寻道(log N增长)的约束,为了避免此,请增加键缓存大小(ket cache size)当数据增长时.

### 8.9 Controlling the Query Optimizer   
#### 8.9.1 Controlling Query Plan Evaluation
- 查询优化器的任务是找到最好的执行计划.最好和最坏的计划可能是相差几个级别.对于join查询,mysql优化器调查的可能计划的数量与查询中引用的表的数量成指数增长.对于少量的表(7-10个)这不是问题, 但是如果提交较大的查询时花在优化上的时间可能成为服务器性能的主要瓶颈.
- 一种更灵活的查询优化方法,使用户可以控制优化器在搜索最佳查询评估计划时的详尽程度.通常想法是,优化器调查的计划越少则编译所花费的时间越少;另一方面,由于优化器跳过一些计划,这可能会错过最佳计划.可以使用如下两个系统变量对优化器评估计划的数量的行为:
 - optimizer_prune_level: 改系统变量基于每个表访问的行数的估计值告诉优化器去跳过某些计划,根据我们的经验,这种有根据的很少错过最佳计划.可能会大大减少查询编译时间.这就是为什么(optimizer_prune_level=1)是默认值.如果你确信优化器错过了最佳执行计划,你可以关闭该功能(optimizer_prune_level=0).请注意,即使是这样,优化器仍会探索大约指数级别的计划.
 - optimizer_search_depth: 该变量指示了查询优化器执行的深度,如果不知道该设置多少,可以设置为0让优化器自动确定该值.

#### 8.9.2 Switchable Optimizations 
- optimizer_switch系统变量控制优化器的一些行为.该值为一组标志,每个标志都为on或off.

#### *8.9.3 Index Hints 
- 在查询处理期间,index hint(索引提示)为优化器提供了如何选择索引的信息,索引提示仅对select,update语句有效.index hints跟在表后面
   - USE INDEX (index_list)告诉优化器仅使用index_list其中一个索引去寻找行;相反的,ignore index (index_list)告诉优化器不使用index_list的索引;
   - force index提示与use index类似
   - 没有hint都需要一个索引名,要是主键使用PRIMARY
   - index_name的值不需要必须是一个完整的索引名,可以是索引值不会混淆的前缀值,如果该前缀不唯一(会产生混淆)则会有错误产生.
- index hints的语句有如下特征:
  - 在语句上对于use index,省略index_list是有效的,这表示什么索引都不用;但force index,ignore index语句如果省略了index_list了就会产生语法错误
  - 你可通过在hint后添加for从句来指定索引提示的范围,可以有for join,for order by,for group by
  - 你可以指定多个索引提示, 如果 use index for order by (index1) ignore index for group by (index2)
  - 如果你的index hints没有指定范围(for从句), 这等同于指定了for order by, for group by, for join这三个范围

### 8.10 Buffering and Caching  
#### 8.10.1 InnoDB Buffer Pool Optimization
#### 8.10.2 The MyISAM Key Cache
- 为了最小化磁盘I/O,myisam存储引擎,它使用了缓存机制将最常访问的表块数据保留在内存中.
  - 对于index block(索引块),由于一种叫key cache(or key buffer)的特殊结构维护,
  - 对于数据块(data block),myslq没使用特殊的缓存.相反,它们依赖于本机操作系统文件系统缓存.
- 当key cache不可用时,仅使用操作系统提供的本机文件系统缓存来访问索引文件(index files)(即就像访问data block一样)
- 一个索引块(index block)是对myisam索引文件的连续访问单元.通常一个索引块大小等于索引B-tree的节点的大小.(索引在磁盘以B-tree数据结构表示.在树底部的节点(node)是叶节点leaf node, 叶节点以上都是非叶节点(nonleaf nodes)))
- 当访问任何表索引块数据时,mysql服务器首先会检查在key cache中是否有可用的,如果是则读取和写入都是对key cache操作而不是操作磁盘.否则mysql服务器将选择一块cache block并用所需要表的索引替换它,后续就可以访问该新索引了.
- 如果一块更改过的缓存被选中为被替换对象,则该块视为脏,所以在被替换之前,会先将更改过的数据刷新到其对应的表索引中.
- 通常的mysql服务器遵循LRU(Least Recently Used)策略(最近最少使用),当选择一块作为替换对象时,它选择最近最少使用的索引块.为了使选择变得简单, key cache module维护着所有使用过的块在一个由使用的次数排序的特殊列表(LRU chain).当一个块访问时,它是最近访问所以放置到列表底部;当需要一个块被替换时,最经常使用的块置于该列表的底部,而该列表的开头成为第一个驱逐的候选者.
- innoDB存储引擎同样也使用LRU策略管理buffer pool.
  
#### 8.10.2.1 Shared Key Cache Access
- 线程间可以同时访问key cache buffers,但遵循以下条件:
  - 没有被更新的buffer可以被多个会话同时访问
  - 当一个会话要使用的buffer正在被更新时,则必须等待其更新完成后才能使用它

##### 8.10.2.2 Multiple Key Caches
- 对于key cache的共享访问并不能消除会话间的竞争关系.为了减少这种key cache访问的竞争,mysql提供了多个key caches,即允许将不同的表索引分配到不同的key caches.默认的,所有myisam表的indexs都被缓存(cache)在同一个key cache上.你可以使用cache index table_name[,table_name] in key_cache_name语句为表索引分配到指定名字的key cache上,同时还可以设置其大小. 当有一个key cache被销毁时,所有分配到这上的所有索引都将被重新分配到默认的key cache上.

- 对于一个繁忙的服务器, 可以使用以下的三个key caches策略:
  - 'hot' key cache:占所有为key cache分配空间的20%,该部分用经常搜索但是不更新的表
  - 'cold' key cache:20%,该部分用于中等大小,密集修改的表,如临时表
  - 'warm' key cache:60%,改部分最为默认的key cache,上述情况外都使用此区域

- cache index设置了表和key cache的关联,但是这个关联在mysql服务重启后就会丢失.如果你想在每次启动后都保持这种关联,有个办法是那么可以在my.cf文件中指定init_file=/path/mysqld_init.sql,在mysqld_init.sql中指定关联.

##### 8.10.2.3 Midpoint Insertion Strategy
- 默认的,mysql使用简单的LRU策略来选择需要驱逐的key cache block.而中点插入策略会将LRU链分为hot子列表和warm子列表两部分. 使用中点插入策略能够使得更有价值的blocks总是保留在cache中.如果仅想使用普通LRU,则将key_cache_division_limit设置它的默认值100.
   
##### 8.10.2.4 Index Preloading   
- 如果有足够的key cache block去容纳整个索引的块,至少是其对应的非叶节点的块.这在使用前将index blocks预先加载(preload)到key cache是有意思.这是将index blocks放入key cache最有效的方式,因为它从磁盘顺序读取.虽然没有preloading,index block也会因查询语句的需要而被加载到key cache中,也会一直保留(假设key cache足够),但是它们从磁盘中是以随机而非顺序读取的.
- LOAD INDEX INTO CACHE语句可以预先加载index到cache中.例如:
  `LOAD INDEX INTO CACHE t1, t2 IGNORE LEAVES;`
   - IGNORE LEAVES表示仅预加载索引的非叶节点. 以上表示预加载t1表的所有索引,t2表的索引的非叶节点.
   - 如果先前一个表的索引被CACHE INDEX语句指定到特定的key cache上,则preload操作时也会将索引放置到对应的缓存中.否则都是将索引预加载到默认key cache中
   
##### 8.10.2.5 Key Cache Block Size
- 可以使用key_cache_block_size为指定的一个key cache设置block buffers size.这允许调整索引文件的I/O操作的性能.当read buffer size等于本机文件系统I/O buffer的大小时,可以实现I/O操作性能达到最佳.
- 对于控制.MYI索引文件中的块大小, 可以在mysql服务器启动时通过--myisam-block-size(myisam索引页要使用的块大小)指定 
   
   
##### 8.10.2.6 Restructuring a Key Cache   
- 一个key cache可以随时通过设置它的key_buffer_size来达到重组.如果你设置了一个key cache的key_buffer_size或key_cache_block_size的值不同于当前的值,则mysql会销毁缓存旧的结构然后重新创建一个新的.如果cache包含任何脏数据块(dirty blocks),则在重新创建新的前会先将它们保存到磁盘.当你改变一个key cache的其他参数时,不会发生重建.
- 当重建一个key cache时,服务器首先将任何dirty buffer刷新到磁盘中,之后cache内存变得不可用,虽然重建不会阻止需要将索引分配到cache中的查询,相反服务器使用本机文件系统缓存直接访问表索引.文件系统缓存效率不如key cache,所以可以预见尽管执行查询,但速度会变慢.key cach重构后,它被再次启用,并且不再使用文件系统缓存来存储索引.
   
#### 8.10.3 The MySQL Query Cache
- 查询缓存将select语句和对应的发送到客户端的结果存储起来.以便后续有相同查询语句时可以直接从查询缓存获取而不必再解析执行.这对于表没有经常改而又经常用相同语句取数据的环境很有帮助.查询缓存不会返回陈旧的数据,当表被更改时,则对应的查询缓存条目都将被刷新. 分区表不支持查询缓存,涉及分区表的查询将自动禁止查询缓存.
- 一些基础测试数据: 查询从只包含一行的表中查询一行(这被认为是接近了查询缓存加速最少的情况),这种情况下也比没有使用查询缓存快(快多少视服务器性能和配置)
- 查询缓存具有显著提高性能的潜力,但并不是在所有情况下都会有提升,有时候甚至会降低.如下情况:
  - 分配过大的查询缓存,增加维护查询缓存的开销.通常几十M是有益的.而几百M则可能是不好的.
- 验证查询缓存是否有益,启用和关闭状态下测试mysql的工作,然后后期定期重新测试,因为查询缓存效率可能会随负载而变化.  

#### 8.10.3.1 How the Query Cache Operates
- 在解析前,将传入查询语句与查询缓存中的语句进行比较.查询语句必须完全相同(每字节都必须相同),如大小写不一样视为不想等.此外完全相同的查询在以下情况下也被视为不想等:使用的不是同一个数据库,不同的协议版本,不同的默认字符集(被分别缓存).
- 在查询结果被取出先,mysq会先检测用户是否有结果中涉及到的库和表的select权限
- 如果一个查询缓存命中则会增加Qcache_hits状态变量而不是Com_select的值.
- 如果一个表更改了,则使用该表的所有缓存查询都将无效并被从cache中移除.
- 查询缓存同样适用在innoDB表的事务内.
- 视图上的select查询的结果会被缓存.
- 包含以下函数则查询不被缓存

- 以下情况下也不被缓存

#### 8.10.3.2 Query Cache SELECT Options
- 查询语句中可以指定两个与查询缓存相关的选项
  - SQL_CACHE
  - SQL_NO_CACHE
  
#### 8.10.3.3 Query Cache Configuration  

#### 8.10.3.4 Query Cache Status and Maintenance  
- flush query cache可以对查询缓存进行碎片整理.该操作不会从缓存删除任何查询.RESET QUERY CACHE则清除所有查询缓存.flush tables语句也一样会.
- 使用SHOW STATUS LIKE 'Qcache%';来监视查询缓存的性能  

#### 8.11 Optimizing Locking Operations
- mysql用锁来管理表内容的争用
  - 内部锁:在mysql服务器本身内执行,以管理多个线程对表内容的争用
  - 外部锁
  
#### 8.11.1 Internal Locking Methods
- 行锁
  -  mysql为innoDB表使用行锁以支持多个会话的写操作.死锁会影响性能而不是代表严重错误,因为innoDB会自动死锁条件并回滚受影响的事务.
- 表锁
  - MySQL为MYISAM,MEMORY, MERGE使用表锁,同时仅允许一个会话更新表.表锁更适合只读,大多数为读或单用户的应用.表锁通过总是在一开始就请求所有需要的锁并始终按照相同的顺序锁定表来避免是死锁.
  - 表锁的优点
    - 所需要的了内存相对较少(行锁需要锁定每行或行组的内存)
    - 当使用一个表的一大部分时更快因为只有涉及一个锁
    - 当经常使用对表的一大部分数据进行group by操作或者必须经常的扫描整个表,则速度会很快
  - mysql怎么授予表写锁:
    1. 如果表上没有锁,则加上一个写锁
    2. 否则,将锁请求放入写锁队列中
  - mysql怎么授予读锁:
    1. 如果表上没有写锁,则加上读锁
    2. 否则,将锁请求放入读锁队列中
  - 表的更新权限比读高,因此当一个锁释放时,该锁先可用于写锁队列中请求,然后才是读锁队列中的请求.如果有许多更新则等到更新结束才能读取.SHOW STATUS LIKE 'Table%';可以查看表锁争用的信息.
  - myisam存储引擎支持并行插入以减少与读取器和写入器之间的争用.myisam表的数据文件中没用空闲块时,则插入行总是位于数据文件后,在这种情况下, 你可以随意组合select和insert语句操作myisam表而不需要锁.在这种情况下你就可以在插入表行的同时读取它.holes可以由于在表中间删除或更新了行导致的.如果显示的使用了lock tables,则可以在锁表时同时请求read local锁而不是read锁以使其他会话能够执行并发插入.
  - 如果对于一个表无法执行许多插入或查询时当这个表不能并发插入时,此时你可以将数据插入到临时表,然后将临时表的数据更新到实际表上.
  
#### 8.11.2 Table Locking Issues
- 对于innodb表避免使用LOCK TABLES语句,因为该语句不会提供任何额外的保护反而减少了并发新性.

- 锁性能问题的变通办法,以下列举些避免由于表争用的办法.
  - 考虑使用innoDB表
  - 优化select语句使其变快对表锁定的时间较短.你可能需要创建一些汇总表才能至执行此操作
  - 使用--low-priority-updates选项启动mysql,对于只有使用表锁的表,这会使得所有对表的更新语句比select语句权限更低.
  - 在会话中要使所有的更新语句都具有较低的权限,请在会话中设定low_priority_updates系统变量
  - 要为特定的insert,update, delete语句赋予较低的优先级,请使用LOW_PRIORITY属性
  - 要为特定的select语句赋予较高的权限,请使用HIGH_PRIORITY属性.
  - select语句时加上SQL_BUFFER_RESULT,这会使得表锁定的时更短.
  - 你也可以更改locking的代码(在mysys/thr_lock.c中)去使用单个队列,在这种情况下,读锁和写锁将具有相同的权限,这对于其他应用可能会有用.

#### 8.11.3 Concurrent Inserts  
- myisam存储引擎支持在向表末插入数据的同时读取表数据,如果有多个插入语句则顺序执行,与select语句同时执行.并发插入的结果可能不能马上可见.
- 语句中的HIGH_PRIORITY属性覆盖系统的--low-priority-updates的值.
- lock table,read local和read区别在于read local允许保持锁的同时执行无冲突的insert语句,
   
#### 8.11.4 Metadata Locking   
   
#### 8.11.5 External Locking   
- 启用外部锁后,需要访问表的每个进程都需要先获取表文件的文件系统锁,如果无法获取所有所必需的锁,则会阻止该进程访问表,直到锁被释放了后.

### 8.12 Optimizing the MySQL Server

#### 8.12.1 System Factors
- 一些系统级因素会在很大程度上影响性能
  - 如果你有足够大的RAM,你可以移除所有交换设备(swap device).一些操作系统也会使用交换设备即使你空闲的内存在某些情况下.

#### 8.12.2 Optimizing Disk I/O   
   
#### 8.12.3 Using Symbolic Links 
- 你可以将数据库或表从数据库目录移动到其他位置(如空间更大,更快的磁盘),推荐软链接整个数据库目录.软链接myisam表示最后的手段.

#### 8.12.3.1 Using Symbolic Links for Databases on Unix    
- 在UNIX上,符号链接数据库的方法是首先在有可用空间的磁盘上创建新的目录,然后从mysql数据目录创建到该目录的软连接.mysql不支持一个目录链接多个数据库.
  `mkdir /dr1/databases/test
   ln -s /dr1/databases/test /path/to/datadir` 

#### 8.12.3.2 Using Symbolic Links for MyISAM Tables on Unix   
- 仅有myisam表完全支持符号链接.对于其他引擎使用的表文件,如果使用软链接可能会有奇怪的问题.innoDB表如果想要将表放置不同磁盘位置可以在create table时指定. `SHOW VARIABLES LIKE 'have_symlink';` 查看是否支持或开启软链接

- myisam表是怎么处理软链接的?
  - myisam表的索引文件(.MYI)和数据文件(.MYD)可以使用软链接,但表定义文件(.frm)不能.
  - 可以将索引文件和数据文件独立的软链接到不同目录
  - 正在运行的mysql服务器可以在create table语句上指定DATA DIRECTOR和INDEX DIRECTOR来使用软链接;如mysqld不在运行则可以手动使用ln -s
  - myisamchk不会使用数据文件或者索引文件来代替软链接,它只能直接在真实文件上工作.任何临时文件都将创建在实际数据文件或索引文件所处的位置,执行alert table,optimize table,repair table语句的临时表的位置唯一同上.
  - 如果你没有软链接,使用--skip-symbolic-links选项启动mysqld开确保没人可以使用mysqld来删除或者重命名data directory外的文件.

#### 8.12.4 Optimizing Memory Use

##### 8.12.4.1 How MySQL Uses Memory    

##### 8.12.4.2 Enabling Large Page Support
   
#### 8.12.5 Optimizing Network Use   

##### 8.12.5.1 How MySQL Handles Client Connections   
- Network Interfaces and Connection Manager Threads   
  - 在谁有平台上,都有一个管理线程(manager thread)处理tcp/ip连接请求 
  - 在UNIX上,管理线程还处理UNIX socket file连接的请求 
  - 在window上,管理线程处理共享内存的连接请求;还需要另一个线程处理named-pipe的连接请求
  - note: mysql服务器不为没有监听的接口创建进程.比如window上不支持named-pipe连接的不会创建相应的线程.
  
- Client Connection Thread Management
  - 连接管理器线程每个客户端线程与专用于该客户端连接的线程相关联,该线程处理身份验证和对该连接的请求处理.管理线程在需要时会创建一个新线程,但会通过先咨询线程缓存(thread cache)看是否有可用的线程尽量避免创建新线程.当一个线程结束时,在线程缓存没有满时会返回到线程缓存中.
  - thread_cache_size系统变量决定线程缓存大小.默认改值在mysql服务器开启时自时调整;等于0则为禁止线程缓存,会为每个连接创建新的线程并在该线程在结束时被丢弃.通过Threads_cached和Threads_created系统变量来分别监视当前有多少个线程缓存和因为线程缓存不足而创建的线程数量.
  - 当线程栈(thread stack)太小时,这将限制服务器能执行语句的复杂成程度,存储过程递归的深度以及其他一些消耗内存的操作.该值通过thread_stack系统变量控制. 
- Connection Volume Management
  - 可以通过设置max_connections系统变量控制允许的同时最大客户端连接数.mysql服务器实际上允许最大max_connections + 1个连接,额外的那个1是保留给super特权用户的.超级用户可以使用SHOW PROCESSLIST语句诊断问题即使已经达到了最大非特权用户客户端连接数量.当服务器因为达到最大连接数量时而拒绝请求时,Connection_errors_max_connections状态变量会增加.Linux日常一般至少能支持500-1000个同时连接,最高10000,在你有许多GB内存并且每个连接负载很低或响应时间目标要求不高.
  
##### 8.12.5.2 DNS Lookup Optimization and the Host Cache
- 改变host_cache_size会隐式的执行flush hosts操作(该操作会清除host cache),以及truncate的host_cahce表,取消阻止所有被阻止的主机;开启skip_name_resolve 禁止DNS host name查找;开启skip_networking可以禁止tcp/ip连接.

### 8.13 Measuring Performance (Benchmarking)

#### 8.13.1 Measuring the Speed of Expressions and Functions
- 测试mysql执行一个表达或函数的速度, 可以使用 select BENCHMARK(count,expr);表示expr重复执行count次.

#### 8.13.2 The MySQL Benchmark Suite
- 免费的开源数据库基准测试工具:http://osdb.sourceforge.net/
- 基准测试
  - mysqlslap(mysql自带的)
  - 其他如SysBench或DBT2;
- 这些基准测试会使得系统崩溃,所以请仅在开发系统上测试  

#### 8.13.4 Measuring Performance with performance_schema
- 通过performance_schema数据库查询获取性能特征.具体在Chapter 22, MySQL Performance Schema    

### 8.14 Examining Thread Information
- 访问threads不需要互斥,并且对服务器的性能影响很小;INFORMATION_SCHEMA.PROCESSLIST和SHOW PROCESSLIST因为需要互斥所以对性能有负面影响. threads显示的信息包含了INFORMATION_SCHEMA.PROCESSLIST和SHOW PROCESSLIST不包含的后台线程(background threads)

## Chapter 9 Language Structure
### 9.1 Literal Values
- 多个带引号的字符串相邻被串联成单个字符串.如 `'a' ' ' 'string'` 与 `'a string` 等价
- ANSI_QUOTES模式开启时, "与` 一样被解释为标识符,所以就不用来引(quote)字符串了
- 二进制字符串是字节字符串(a binary string is a string of bytes); 非二进制字符串是字符的字符串(a nonbinary string is a string of characters). 对于这两种字符串的比较都是基于字符串单位的数值,二进制字符串的单位为byte,
- 字符串文字可能具有可选的字符集介绍程序(character set)和COLLATION从句
  `[_charset_name]'string' [COLLATE collation_name]` 
  `例如: SELECT _utf8'string' COLLATE utf8_danish_ci;`
- 在NO_BACKSLASH_ESCAPES模式没有开启时,在字符串中,某些序列具有特殊含义.这些序列以\开头的序列被称为转义字符.mysql可以识别表9.1,特殊字符转义序列中的所示的转义序列.对所有其他转义序列将忽略\,即是将转义字符解释为好像没有转义,同时这些序列是大小敏感的,例如:\x只是x;\b是退格字符,而\B只是B.
- 有几种在字符串包含引号字符的方法:
  - 在由单引号引起来的字符串中两个单引号表示一个单引号;同理双引号中,两个双引号表示为一个双引号.在引号前加转义字符\.在双引号中的单引号和单引号中双引号不用特殊处理,可以正常显示.
- 当将二进制数据插入到字符串列时(例如BLOB列),有些字符需要使用转义序列表示,\和用于引字符串的引号必须转义.在某些客户端环境中需要转义nul和Control+Z.mysql会截断引号字符串中nul字符,在window上,Control+Z可能会被当作是END-OF-FILE.

#### 9.1.2 Numeric Literals
- 数字包含精确的值(整数和DECIMAL)和近似值(浮点).精确值可能包含整数或小数部分,或者两个都有(如果.2,3.4,-5.5).用科学记数法表示的带有尾数和指数是近视值数字(如1.2E3, 1.2E-3)
- 两个数字看似相似但是被不同对待,如2.34是精确值(定点(fixed-point))而2.34E0是近似值(浮点(floating-point)).
- DECIMAL数据类型是定点类型(fixed-point)计算精确,也称为NUMERIC,DEC,FIXED; double和float数据类型是浮点类型(floating-point),计算值是近似的.
- 在浮点上下文中使用整数,它被解释为等效的浮点数.

#### 9.1.3 Date and Time Literals
- 日期和时间上下文中的字符串和数字
  - 一个字符串格式为'YYYY-MM-DD'或'YY-MM-DD','YYYY-MM-DD hh:mm:ss'或'YY-MM-DD hh:mm:ss',允许任何标点符号都可以作为日期部分间的分隔符.如('2012^12^31', '2012^12^31 11+30+45')

##### 9.1.4 Hexadecimal Literals
- 默认的,16进制文字表示的是二进制字符串,其中每两个二进制字符串表示一个字符.16进制用X'val'或0xval表示, 其中val取值为(0..9,A...F).前缀X和val的大小写不敏感,0x前缀不能是0X(因其大小写敏感).X'val'这种写法,val位数必须是双数,否则会报错,而oxval这种写法在val不是双数时自动在前面补0.
- 16进制文字可以包含可选的字符集介绍程序和COLLATION从句来指定为使用特定的字符集和排序规则(COLLATION)的字符串. `[_charset_name] X'val' [COLLATE collation_name]`
- 数字上下文中,16进制文字被视为BIGINT(64位整数).为了确保mysql对16进制文字当作数字处理,可以加上0或者使用CAST(... AS UNSIGNED)将其转化为unsigned.
- 将字符串或数字转换为16进制,使用HEX().

#### 9.1.5 Bit-Value Literals
- 位值(Bit-value)文字用b'val'或0bval表示,val取值为0或1.0bval的0b不能写成0B(因为其大小敏感).默认的,一个位值(bit-value)文字表示的是一个二进制字符串.位值文字可以包含可选的字符集介绍程序和COLLATION从句来指定为特定的字符集和排序规则(collation)的字符串.`[_charset_name] b'val' [COLLATE collation_name]`.
- 在数字上下文中,位值(bit-value)被视为整数.为了确保被当作数字对待,可以加上0或使用CAST(... AS UNSIGNED)将其转化为unsigned.

####　9.1.6 Boolean Literals
- 常量true和false被评估为1和0,常量的名字可以用任何字母大小书写.

#### 9.1.7 NULL Values
- NULL值表示无数据.null可以用任何大小写字母书写.其同义词是\N(大小敏感).
- 注意null值与0和空字符串的不同,以下是null的特点
  - 为了处理null值,可以使用is null, is not null运算符和IFNULL()函数.
  - null与其他任何值(null与null结果也不是true)比较都不会是true.
  - 表达式中包含null,结果永远都是null(如1+null结果还是null)(除非表达式中涉及的操作符和函数在文档有明确指出其他情况)
  - 聚合函数(如果sum(),count(),max()等)会对null值忽略.count()例外,它计算的是行值而不是列值.举个例子, count(*)和count(age)可能会产生不同的结果,前者计算表的行数而后者计算age列非null行的行数.
- 对于使用LOAD DATA或SELECT ... INTO OUTFILE执行的文本文件导入或导出操作，NULL使用\N表示.
- **在ORDER BY操作中,NULL值在升序中排在所有数据之前,在降序中排在所有数据之后.**

### 9.2 Schema Object Names
- 在mysql中某些对象(括数据库，表，索引，列，别名，视图，存储过程，分区，表空间和其他对象名)称为标识符(identifiers).
- 不建议使用Me或MeN开头的名字(其中M,N为整数),因为比如1e+3这样的表达式就变得不明确.使用md5()生成一个表名也要注意, 因为这有可能产生上述的问题.

### 9.2.1 Identifier Length Limits
- 在mysql中,因为databases,table,trigger在data目录都有对应的目录或者文件,所以底册操作系统的大小是否敏感对它们数据库名,表名,触发器名是否大小敏感起着作用.也就是说,wind上不区分大小写,而linux区分大小.table aliases在linux上大小敏感,而window上大小写不敏感.同时lower_case_table_names 系统变量也影响着mysql是否对标识符区分大小写. Column, index, stored routine, event names,column aliases.大小写不敏感在任何平台上.
   - note:虽然在window上数据库名,表名,触发器名大小写不敏感,但是在同一个语句中使用不同的大小写对它们进行引用那么将出错.比如(`SELECT * FROM my_table WHERE MY_TABLE.col=1;`)
- Lower_case_table_names影响着表名和数据库名在磁盘上的存储和在mysql中使用.但对触发器标识符是否区分大小写不影响的.默认的,该值在linux为0,window为1,macOS为2.以下是Lower_case_table_names取值对应的含义:
  - 0:表名和数据库名在存储和使用时由create table或create database语句中指定的.名字比较是大小写敏感的.在大小写不敏感的文件系统中(如window或macOS),不应该设置为0,如果强制设置为0则如果用不同的字母访问myisam表时,索引有可能会被损坏
  - 1:表名以小写存储在磁盘上并且名字比较不区分大小写.mysql在存储和查找时将所有表名转换为小写.以上行为也使用于数据库名和表别名.
  - 2:在存储时使用create table和create database语句中指定的,但在查找时mysql将它们先转化为小写.名字比较时大小写不敏感.在大小写不敏感的文件系统上,innoDB表名以小写形式存储.
- 默认的,如果只在一种平台上使用,通常你是不用更改其默认值.但是在两个大小写敏感不一的平台上转换时可能会遇到些困难.对此两种方案:
  - 在所有平台上使用lower_case_table_names=1,主要的缺点就是当使用show tables或show databases时,你不会看到它们真实的大小写.
  - 
- 在UNIX系统,想将lower_case_table_names=1前,必须先将旧的数据名和表名转换为小写在停止和用新的参数重新启动mysql前.为了达到此目的,有以下2中方案:
  - 对于单个表可以用rename语句
  - 对于转换一个或多个整个数据库.先将数据库一个一个的导出(dump);然后删除(drop)数据库;设置lower_case_table_names=1重启,然后导入数据库(在导入时会自动转换为小写).

#### 9.2.4 Mapping of Identifiers to File Names
- 数据库和表名标识符可以使用任何字符除了ascii NUl(X'00')

#### 9.2.5 Function Name Parsing and Resolution

- Function Name Resolution
  - 自定义函数和存储函数在同一个命名空间,所以自定义函数和存储函数创建的名称不能相同.

### 9.3 Keywords and Reserved Words
- 允许非保留关键字作为标识符而无需引用(quoting),允许将保留关键字引起来(quote)作为标识符.
- 是关键字但不是保留字作为标识符时可以不用引(quoting),因为关键字才要.

### 9.4 User-Defined Variables
- 用户变量用@var_name来表示,var_name由字母和点(.)和下划线(_)和$组成.也可以包含其他字符当你将val_name引成字符串或标识符(如果@'my-var', @`my-var`).用户变量大小写不敏感
- 用户变量只能在当前会话中使用,在其他会话或线程中无法使用,会话结束后自动释放.
- 用户变量可用set语句赋值,在set语句中=或:=都可被当作赋值运算符(但是在某些语句中=表示的是比较,所有可用:=代替)
  - `SET @var_name = expr [, @var_name = expr] ...`
- select语句中每个选择表达式仅在发送给客户端时才进行求值,这意味着,在having,group by,order by语句中引用了选择表达式列表(select expression list)中分配值的变量不能按照预期的工作.
- 用户变量不能直接在sql语句中作为标识符或者标识符的一部分.(例如用作表名,数据库名,或保留关键字如select都是不行),即使是加了quote也不行..当时对于该原则有个例外是当你构建字符串以用在预处理语句( prepared statement)中.

### 9.5 Expressions
- Temporal Intervals(时间间隔)
  - 时间间隔的语法:INTERVAL expr unit;expr表示数量,unit为单位,时间间隔常用于某些函数,如果DATE
  _ADD(),DATE_SUB();时间间隔表达式还可以用在与日期或日期时间的+,-操作(时间间隔为位于+左右两边都可以,在-运算中只能位于右边)

### 9.6 Comment Syntax
- mysql支持3中注释样式:
  - 从#到行尾
  - 从--到行尾,-- 后面必须仅跟着至少一个空格或控制字符(如果空格,tab等)
  - 从/*和*/间
- 默认的嵌套注释是不被支持(即使在某些情况下可能可以,但用户应该避免使用嵌套注释)
- 对/*![version]  MySQL-specific code */形式的注释,其他sql语言会忽略,但是mysql会执行其中的语句,如果指定了version,则表示mysql版本大等于该版本才执行.

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
    - 插入时: 当插入值为N时, 尾部补上0x00 bytes(就是(N-插入值)个00); 读取时, 不会任何移除, 原样返回

## Chapter 13 SQL Statements

###  13.1 Data Definition Statements
####13.1.1 ALTER DATABASE Statement
- alert语句允许你更改数据整体的特征.这些特征存储在该数据库目录下的db.opt文件中.

#### 13.1.7 ALTER TABLE Statement
- Table Options    
  - 为了保护因为疏忽而造成的数据丢失,alert table不允许将表存储引擎转换为MERGE和BLACKHOLE.
  - 对于设置AUTO_INCREMENT值时,如果小于或等于当前最大值,则将值设置为当前值+1.
- Performance and Space Requirements
  - alert table操作有2种处理算法:(没有指定默认地为inplace)
    - copy: 
    - inplace:   

#### 13.1.8 ALTER TABLESPACE Statement
- 添加新的数据文件或从表空间删除数据文件(data file),引擎只支持NDB和NDBCLUSTER..

#### 13.1.10 CREATE DATABASE Statement

### 13.1.13 CREATE INDEX Statement 
- create index映射到alert table以创建索引.create index无法创建主键,需要使用alter table语句.asc或desc关键字允许在将来中指定索引存储的顺序,虽然目前解析器会忽略asc和desc关键字并始终以asc顺序存储索引.
- Column Prefix Key Parts
  对于字符串列可以使用col_name(length)语法来创建仅使用列值开头的一部分作为索引.
  - 可以为char,varchar,binary和varbinary键指定前缀
  - blob和text键必须指定前缀,此外blob和text列只能为innoDB,myisam,blackhole表建立索引.
- Unique Indexes
  - 一个Unique Indexes创建了一个约束以使索引中所有值必须互不相同.如果为唯一索引指定前缀长度,那么列值在前缀内必须唯一.唯一索引允许多个null列值.
- Full-Text Indexes
  - 全文索引只支持innoDB和myisam表,并且只能是char,varchar,text列.索引总是在整列上进行的,所以不支持前缀索引,若指定了将忽略.
- Index Options
  - 每个存储引擎支持索引类型
    - innoDB: BTREE
    - MYISAM：BTREE
    - MEMORY/HEAP:HASH,BTREE
    - NDB: HASH/BTREE
- Table Options
  - ENGINE
    - innoDB:具有行锁和外键的事务安全表
    - MyISAM:
    - MEMORY:
    - CSV:以逗号分隔值格式存储行的表
    - ARCHIVE: 
    - EXAMPLE:
    - FEDERATED:访问远程表的存储引擎.
    - HEAP:MEMORY表的同义词
    - MERGE:myisam的集合用作一张表.也称为MRG_MyISAM.
    - NDB:群集的，基于内存的容错表，支持事务和外键。也称为NDBCLUSTER
  - COMMENT: 表注释,最大2048字符
  - INSERT_METHOD:仅适用于MERGE表.定义怎么插入行,取值first,last,no分别表示插入表前,表后,和防止插入.
  - STATS_AUTO_RECALC
      - 指定是否为一个innoDB表重新计算统计持久信息,该值为`default`时,则一个表的持久统计信息设置由innodb_stats_auto_recalc决定(该值为1时: 当innoDB表的10%被更改时则重新计算统计信息;该值为0:防止自动计算表统计信息,所以你要手动执行analyze table语句以重新计算统计信息)
  - STATS_PERSISTENT
      - 是否为innoDB表开启持久统计信息(即存入到磁盘),该值为`default`时,则是否开启持久统计信息取决于 innodb_stats_persistent系统变量(该值1表示开启,0为关闭)
  - STATS_SAMPLE_PAGES  
- Table Partitioning  

##### 13.1.17.1 CREATE TABLE Statement Retention
- 创建表时,原始的create table语句(包含所有规范和表选项)都将被mysql存储起来,以便使用ALTER TABLE语句改变表存储引擎等其他信息时,之前指定的表选项还能保留着.
- 由于是保存的是原始语句的文本.但是由于某些值或选项可以被静默的重新配置(如row_format),所以活动表的定义(通过describe或show table status获取)和表创建的字符串(通过SHOW CREATE TABLE获取)得到的值可能会有所不同. 
    

#### 13.1.16 CREATE SERVER Statement
- Column Data Types and Attributes
  - AUTO_INCREMENT
    - 每个表只能有一个自增列且必须被索引;不能有默认值;自增列仅在只包含正值的情况才能正常工作.
    - 对于myisam表,可以指定为多个索引的第二列设置AUTO_INCREMENT,则该自增值会根据第一列相同值为一组各自自增.(如果有其他索引将该自增列列为第一个那么就不会按组了)
  - comment 
    - 对于每一列的注释最大长度为1024字符(characters)
  - COLUMN_FORMAT
    - 目前COLUMN_FORMAT设置除了NDB存储引擎外都不起作用,mysql>=5.6该选项被静默忽略
  - STORAGE
    - 只能用于NDB存储引擎.可选择STORAGE DISK和STORAGE MEMORY.
- Indexes and Foreign Keys
  - PRIMARY KEY
    - 主键是not null的唯一索引,如果没有显示指定not null则mysql会静默的设置为not null.一个表只能有一个主键,主键的名称始终为primary,所以primary不能用作其他索引的名称.主键可以是多列的.
    - 如果表没有主键,则当应用程序要查询主键时则返回没有NULL列的第一个UNIQUE索引作为主键.
    - 在创建表时,按照主键第一,紧接着唯一索引然后非唯一索引位置来,这样有助于优化器确定哪个索引优先使用和更快检测重复的unique keys.
    - 表中有主键或unique not null索引时,且该索引由整数类型的单列组成,则可以在select语句中使用_rowid来引用索引列(index column)
    - 主键名字为primary,其他索引如果没有指定名字则用索引第一个列作为名字.
  - KEY | INDEX
    - 通常key是index的同义词.
  - unique
    - 对于所有引擎,允许包含null的列的唯一索引允许存在多个null.如果为列值的前缀加唯一索引,则在该前缀长度内列值必须唯一.
  - FOREIGN KEY
    - innoDB的分区表不支持外键

#### 13.1.17.2 Files Created by CREATE TABLE    
- mysql通过数据目录中的.frm表格式(表定义)文件表示每表.存储引擎可能还会创建其他文件.
  - 对于innoDB表,文件存储由innodb_file_per_table系统变量控制.当该值开启时,表数据和所有相关的索引都存储在数据库目录下的一个名为.ibd文件中;当该值为关闭时,所有的innoDB表和索引都存储在系统表空间中,由一个或多个ibdata*文件表示.
  - 对于myisam表,存储引擎创建数据和索引文件,因此对于每个myisam表都有3个磁盘文件
    - tbl_name.frm: table format(definition) file(表格式(定义)文件)
    - tbl_name.MYI: 数据文件
    - tbl_name.MYD: 索引文件
- Limits Imposed by .frm File Structure
  - 每个表都有一个包含表定义信息的.frm文件.mysql服务器会通过以下公式来检测文件中存储的某些表信息是否达到64kb的限制.如果达到该值则无法添加更多的列.

#### 13.1.17.3 CREATE TEMPORARY TABLE Statement  
- create table导致一个隐式提交,除非create table与TEMPORARY关键字一起使用.
- TEMPORARY表仅在当前会话中可见(其他会话不可见),会话结束后自动删除,TEMPORARY表与数据库的关系非常松散。删除数据库不会自动删除该库中创建的任何TEMPORARY表,

#### 13.1.17.4 CREATE TABLE ... LIKE Statement    
- 使用CREATE TABLE ... LIKE语句根据另外一个表的定义(包含原表中定义的任何列属性和索引)来创建一个空表.like仅使用于基表(base),不合适视图表(views).不会保留原表的DATA DIRECTORY,INDEX DIRECTORY,外键选项.
- 如果原表是TEMPORARY表,该语句不会存为TEMPORARY表,要保存为TEMPORARY表使用CREATE TEMPORARY TABLE ... LIKE语句.
- 重要提示: 当lock table有效时,不能执行CREATE TABLE或CREATE TABLE ... LIKE. CREATE TABLE ... LIKE.不仅仅是复制.frm文件,这意味着如果当前的sql mode和创建原表的有效模式不同时,则该表定义可能被认为对当前模式无效,并且该语句可能失效,

#### 13.1.17.5 CREATE TABLE ... SELECT Statement
- 根据另一个表创建一个表(包含了原表的数据),在CREATE TABLE后面可以指定增加新列.如果在复制数据到表中时出现错误,则会将其自动删除而不会创建.select语句可以是复杂语句如联表
- CREATE TABLE ... SELECT Statement不会自动创建索引,需要自行指定.(这是故意为之,以便更灵活的设置)
- 某些数据类型可能会发生转变.例如不保留auto_increment属性,varchar可能会变为char.

#### 13.1.17.6 FOREIGN KEY Constraints
- 放空先

#### 13.1.17.7 Silent Column Specification Changes
- 在某些情况下,create table或alert table语句中指定的列规范可能会被静默的修改,这些可能是数据类型,与数据类型关联的属性或索规范.所有更改都受内部的行大小(row-size)65535bytes的限制,这可能会导致某些尝试修改数据类型失败.
  - 构成主键的列都被设置not null,即使没有明确声明.
  - 如果指定的index type不被指定存储引擎支持,如果存储引擎有另外一个不会影响查询结果的index type可用,那么就会使用该存储引擎.
  - **如果strict mode没有启用,VARCHAR列长度大于65535则转换为TEXT,VARBINARY列长度大于65535则转换为BLOB;如果严格模式开启了则产生一个错误.**
  - 如果为字符数据类型(character data type)定义了CHARACTER SET为二进制属性,则CHAR变为BINARY,VARCHAR变为VARBINARY,TEXT变为BLOB;但对enum和set数据类型,不会发生转换,它们按照声明时的创建.
  - 当你使用myisampack压缩表时,对于某些其他数据类型可能会发生更改.
#### 13.1.19 CREATE TRIGGER Statement
- 触发器只能用于永久表,不能用于TEMPORARY表或视图表.
- 如果使用LOCK TABLES锁包含触发器的表,那么在触发器被用到的表也会被锁.

#### 13.1.20 CREATE VIEW Statement    
- 在创建时视图的定义就被"冻结"(frozen)并且不受后续基础表的定义更改的影响.(比如视图定义为select * from a,此后a表新增列不会体现在视图中,如果删除了a表的列则会产生错误)

#### 13.1.21 DROP DATABASE Statement
- DROP SCHEMA的DROP DATABASE同义词.如果对使用符号链接的数据库使用DROP DATABASE,则链接和原数据库都将被删除.该语句返回被删除的表数.
- DROP DATABASE不会删除任何在该数据库下创建的TEMPORARY表,创建的TEMPORARY表在会话后自动删除.
- 注意:授权给表的权限并没有自动删除需要手动删除.

#### 13.1.24 DROP INDEX Statement
- DROP INDEX映射到alert table语句以删除索引.如果要删除主键,则index name始终都是`primary`(因为primary是关键,必须用引号标识符引起来). ONLINE and OFFLINE keywords仅适用于NDB Cluster.

##### 13.1.27 DROP SERVER Statement
- 删除服务器定义(该定义用于FEDERATED表的连接信息),会删除mysql.servers表中相应的行.会导致一个隐式的提交.
    
#### 13.1.28 DROP TABLE Statement
- drop table将删除表定义和所有表数据。如果表已经分区,则将删除表定义,以及他所有分区,还有存储在这些分区中的所有数据以及与表关联的所有分区定义.还会删除所有的触发器.drop table还会导致隐式的提交(除非drop table与temporary关键字一起使用).
  - 注意:授权给表的权限并没有被自动删除,需要手动删除.
- 加了TEMPORARY关键字的影响
  - 只是删除TEMPORARY表
  - 不会导致隐式的提交(commit)  
  - 不用检查访问权限,TEMPORARY表仅在创建他的会话中可见,因此无需检查.
    
#### 13.1.32 RENAME TABLE Statement    
- RENAME TABLE能够重名一个或多个表名(alter table rename也能重命名表名),对于视图的重命名也有效(但无法重命名到不同的数据库中)
- 重命名操作是从左到右执行的,如果你要交换两个表名可按如下: 
  `RENAME TABLE old_table TO tmp_table,
                new_table TO old_table,
                tmp_table TO new_table;`
- 表的元数据(Metadata)锁按名字顺序获取,在某些情况下,当多个事务同时执行时,操作结果可能会有所不同.要执行rename table时,必须没有活动的事务或用lock tables锁定表,重命名过程中没有其他会话能访问表.
- 如果重命名过程中有错误发生则将什么都不更改
- rename table语句可以将表移动到指定的数据库中.`RENAME TABLE current_db.tbl_name TO other_db.tbl_name;`;将一个数据库中所有的表都移动到另一个数据库中实际就相当于重名数据名(mysql中没有一个语句就能完成数据库重命名的操作).如果表有触发器,则尝试重命名表到另一个数据库将会失败(产生Trigger in wrong schema)
- rename table不适用于temporary表,使用alter table语句代替. 
- 任何为旧表或旧视图授权的任何特权都不会迁移到新的当中,这需要手动更改.

#### 13.1.33 TRUNCATE TABLE Statement
- TRUNCATE TABLE语句将完全的清空表,需要drop权限.逻辑上,TRUNCATE TABLE操作类似于删除了所有行的delete操作,或drop table然后再create table的操作.但是为了更好的性能,它绕过了删除数据的DML方法,所有它无法被回滚,也不会触发on delete触发器,也不能用于具有父子外键关系的innoDB表.
- TRUNCATE TABLE虽类似于delete,但被归类于DDL,而不是DML;它与delete有如下不同:
  - TRUNCATE TABLE语句drop再re-create表,这比一行行的删除表更快,特别是大表
  - TRUNCATE TABLE导致隐私的提交,且无法回滚
  - 如果有会话持有活动表锁时,则无法执行TRUNCATE TABLE
  - 对于innoDB和NDB表如果存在来自其他表的外键约束引用了该表,则执行TRUNCATE TABLE语句失败.允许在同一表的列之间使用外键约束.
  - **只要表格式文件(table_name.frm)是有效的,TRUNCATE TABLE语句就可以将表重建为一个空表即使数据文件和索引文件被损坏了.** 
  - AUTO_INCREMENT重为开始值,即使是innoDB和myisam表也是. 
  - 对于分区表,TRUNCATE TABLE语句会保留分区;也就是说数据和索引文件会被删除并重新创建,而分区定义文件(.par)不受影响.
  - TRUNCATE TABLE不会触发on delete触发器
- TRUNCATE TABLE可以与 Performance Schema summary tables一起使用,但结果还是将summary columns置位null或0,而不是移除行.

### 13.2 Data Manipulation Statements  
- CALL语句调用一个存储过程( stored procedure),没有参数call p和call p()是相同的.               

#### 13.2.2 DELETE Statement    
- order by指定按照指定顺序删除行, limit关键字限制删除的行数.如果要清空一个表使用truncate table语句会更快,不过不想delete,truncate table不能用在事务中或者表被锁定了.
- 如果删除了包含auto_increment列最大的值,则对于innoDB和myisam表该值不会被重复使用.如果是删除了表的所有行在autocommit模式下,则序列重新开始(除了innoDB和myisam引擎,不过对于innoDB会有些例外,具体见Section 14.6.1.6).对于myisam表,在多列键中可以指定第二列为自增,则在此情况下会重复使用从顶部删除序列.
- Modifiers(修饰符)
  - LOW_PRIORITY:则服务器会延迟删除行直到没有客户端读取表.这仅对使用表锁的存储引擎有效(如MyISAM,MEMORY,MERGE)
  - QUICK:在删除时存储引擎不会索引叶,这可能会加快某些删除操作.
  - IGNORE:删除时会忽略遇到错误而继续删除.
- InnoDB Tables
  - 如果你要从一个大表中删除许多行,可能会超出一个innoDB表的锁定表大小(lock table size).为了避免这个问题或最小化表锁定是时间,以下策略可能会帮助
     1. insert into ...select语句将不要删除的行导入到一个相同结构的空表中
     2. 使用`RENAME TABLE t TO t_old, t_copy TO t;`语句改变表名.    
     3. 删除不要的表
     - rename table其他会话都不能访问该语句中涉及的表,所以不会有并发的问题.
- MyISAM Tables
  - 在MyISAM表,已删除的行保留在链接列表中(linked list),随后的insert操作将重用这些旧行的位置.如果要回收未使用的空间并减小文件大小,可以使用optimize table语句或myisamchk程序,前者optimize table更易于使用,而myisamchk更快      
     
#### 13.2.3 DO Statement     
- DO执行表达式但不返回任何结果.在许多方面,DO是select expr方式的语句(只能是表达式,如涉及到表是不允许)的简写;所以DO会略微更快些(当你不关心结果时).

#### 13.2.4 HANDLER Statement
- HANDLER语句提供直接访问表存储引擎的接口,它适用于innoDB和myisam表.HANDLER ... OPEN打开一个表以供后续语句访问,打开的表对象不与其他会话共享,如果没有被关闭则会话结束后会被关闭.如果没有加limit修饰则都会只返回一行.
- 使用HANDLER代替普通的select有几个理由:
  - HANDLER比select更快
    - 指定的存储引擎处理程序对象分配HANDLER ...OPEN.该对象可被后续的HANDLER语句重复使用,不需要再初始化.
    - 涉及的解析(parsing)更少
    - 没有优化器或查询检查(query-checking)开销
- HANDLER是较低级别的语句.比如它不提供数据一致性,也就是HANDLER ... OPEN语句后,如果数据被修改了,这些修改对于HANDLER ... NEXT or HANDLER ... PREV扫描仅有部分可见.
- 一个打开的handler能被关闭再被标记为重新打开(reopen).发生在以下情况:
  - 任何会话执行了flush tables或者对于该表的DDL操作.
  - 打开handler的会话执行了使用该表非handler语句.
- TRUNCATE TABLE会关闭用handler OPEN语句打开该表的所有HANDLER  
- 如果使用FLUSH TABLES tbl_name WITH READ LOCK刷新表,则使用HANDLER打开了该表
- HANDLER不支持分区表

#### 13.2.5 INSERT Statement
- ON DUPLICATE KEY UPDATE从句表示要插入的新行导致唯一索引或主键重复时,则会更新表中存在的行.
- default关键为列值明确指定使用默认值(如 set col_name = default),表达式default(col_name)可以获取col_name列的默认值.
- value关键词是values关键字同义词
- INSERT影响的行数可以使用ROW_COUNT()函数获取
- INSERT支持一下修饰词:
  - LOW_PRIORITY: INSERT的执行将延迟,直到没有读取表为止.该选项只适合于使用表锁级别的存储引擎(如MyISAM,MEMORY,MERGE)  
    - 通常不要对myisam表怎么做因为会禁止并行插入.
- HIGH_PRIORITY会覆盖--low-priority-updates的值(如果服务器以该选项启动的话),同样也会导致并发插入无法使用.该选项只适合于使用表锁级别的存储引擎(如MyISAM,MEMORY,MERGE) 
- IGNORE会忽略insert执行过程中发生的错误.比如插入的行与主键或唯一索引的重复,如果加了IGNORE则该行会被丢弃而产生一个警告而不是错误,如果没有IGNORE则产生一个错误并中止;插入时会发生错误数据转换在没有IGNORE时会产生错误并中止,而有IGNORE则会将无效值调整到最接近的值并插入,只会产生一个警告但不会退出;等
- 向使用表级锁的存储引擎(如myisam)的分区表插入时,只会锁定(lock)那些实际插入的分区(对于使用行锁的存储引擎则不会发生分区锁)

#### 13.2.5.1 INSERT ... SELECT Statement
- 对于INSERT ... SELECT Statement语句中select语句部分没有order by从句则可能导致取出结果是不确定的,这意味着,主从复制中主机和从机会变得不一致,所以为了防止这种情况在有主从复制的情况下,总是加上order by从句以保证主从一致性.

#### 13.2.5.2 INSERT ... ON DUPLICATE KEY UPDATE Statement
- 通常你应该避免在有多个唯一索引表上使用该语句,因为要插入的行与现有的多行在唯一索引上冲突时,只有一行会被更新.


#### 13.2.8 REPLACE Statement
- REPLACE的工作方式和insert完全相同,不同之处在于如果要插入的行与表中的旧行在主键或唯一索引上重复时,则在插入新行前先删除旧行.
- 不能引用当前行中的值用在新行中.例如set col_name = col_name +1,在右侧对列名的引用视为DEFAULT(col_name),因此上述赋值等效于SET col_name = DEFAULT（col_name）+ 1.
- REPLACE语句返回一个计数(插入或删除的行数),对于单行的replace,如果计数为1表示有一行插入没有行被删除;如果计数大于1则表示一个或多个旧行被删除在插入新行前,这是有可能的在有多个唯一索引的表,新行与多个旧行在唯一索引上有重复,那么就会有多个旧行被删除.
- 影响的行数指示着replace语句是增加新行(count=1)还是replace行(count>1).
- mysql对replace(load data ...replace)使用以下算法
  1. 先尝试插入新行
  2. 当因为发生主键或唯一索引重复错误时
     1. 删除表中重复的旧行
     2. 再次尝试插入新行
     
#### 13.2.9 SELECT Statement     
- where从句:可以使用任何mysql支持的函数和运算符,除了集合函数(having从句可以使用集合函数)
- select语句中也可以不引用任何表(select 1+1)或引用假表(select 1+1 from DUAL) 
- DUAL单纯就是为了方便哪些要求select应具有from从句或其他子句的情况.
- select_exp:表示要取出哪些列,为了列使用别名(为了好习惯建议加as):select_exp [AS] alias,该别名可以用于GROUP BY,ORDER BY,HAVING从句中,但不能用于where从句中(因为这时列值可能还没确定)
- order by:没有指定默认是asc排序.order by也可以用于子查询中,但是外部查询的order by优先与内部.
- group by: **使用group by时,输出的行将根据group by的列进行排序,就像你对该列使用order by一样,所以为了避免group by产生的排序开销,请添加order by null语句.如果有需要产生特定的顺序那么还是要指定(group by ... [asc|desc] 或order by ... [asc|desc], 两种效果是一样的)**     
- limit: 语法limit [offset,] row_count, 两个参数都必须是非负数.如果要取得一个给定开头都最后所有行,那么给第二个参数指定一个非常大的数.    
- FOR UPDATE:如果在使用页锁或行锁的存储引擎上使用,则查询语句检查的行将被写锁(write-lock)直到当前事务结束为止.使用LOCK IN SHARE MODE设置共享锁,允许其他事务读取检查的行,但不能更新或删除它们.
- 仅接SELECT关键字后,你可使用许多修饰词:HIGH_PRIORITY, STRAIGHT_JOIN,还有SQL_开头的修饰词为mysql对标准SQL的扩展.
  - ALL和DISTINCT表示是否返回相同的行.ALL(默认值)为全部返回,DISTINCT则表示从结果集中去除重复的行.DISTINCTROW为DISTINCT的同义词.
  - STRAIGHT_JOIN:强制优化器以from从句给定表的顺序进行联表,这在mysql优化器以非最佳顺序联表时,你可以这样强制指定来加快查询速度.
    - 一些较深的细节,此处先略过.要看原文.
  - SQL_BIG_RESULT或SQL_SMALL_RESULT:和GROUP BY或DISTINCT一起使用,该修饰符告诉优化器结果会是大还是小.对于SQL_BIG_RESULT,mysql会直接使用磁盘临时表(如果需要);对于SQL_SMALL_RESULT,mysql使用内存临时表.
  - SQL_BUFFER_RESULT:这会将结果强制放到临时表上,以便可以更早的释放表锁定,这对于需要较长的时间将结果集发送到客户端尤为有用.该修饰词只能用于顶级的select语句,不能用于子查询语句或UNION后 
  - SQL_CALC_FOUND_ROWS:告诉mysql计算结果集会有多少行,而不管limit从句,该数值可使用SELECT FOUND_ROWS()获取.
  - SQL_CACHE and SQL_NO_CACHE:表示是否缓存查询结果.
  
##### 13.2.9.1 SELECT ... INTO Statement  
- SELECT ... INTO语句可以将查询结果保存到变量或文件中
  - `SELECT ... INTO var_list`:保存到变量中
  - `SELECT ... INTO OUTFILE`: 将选择行写入到文件中,可指定列和行的终止符来达到特地给格式的输出.file必须为一个不存在的文件(这是为了防止对如/etc/passwd文件或数据库表文件的更改)
  - `SELECT ... INTO DUMPFILE`: 向文件写入单行,没有任何格式. 

##### 13.2.9.2 JOIN Clause
- 在mysql中,JOIN，CROSS JOIN和INNER JOIN是等效的,它们可以互相替换.
- 单个连接(join)中最多引用61个表  
- 在没有连接的条件下, 逗号(,)和INNER JOIN语义上是等效的,虽然逗号(,)运算级别比inner join低.
- 通常on从句是指示表如何连接,where从句则限制要在结果集中包含哪些行.
- USING(join_column_list)从句:join_column_list列出的列名必须存在两个联表中(如`a LEFT JOIN b USING (c1, c2)`)
- 为了移植性建议将right join替换为left join
- { OJ ... }语法仅于为了与ODBC兼容而存在.
- NATURAL [LEFT] JOIN语义等效为使用了using从句的inner join或left join,using中列出两个表都共有的所有列名.
- NATURAL [LEFT] JOIN和带有using从句的join对冗余列的消除和列排序规则
  1. 首先为两表都有的公共列(而这些公共列顺序则按在第一表总出现的顺序)
  2. 其次为第一个表的唯一列
  3. 最后为第二个表的唯一列
- STRAIGHT_JOIN与join类似,不同在于左边的表总是先于右边表被读取.这可用于优化器使用的联表顺序不是最优的情况(不过这种情况很少),以指示优化器使用最优的联表顺序.
- USING从句能被重写为指定了比较相应列的ON子句.但尽管USING和ON相似,但它们并不完全相等(在查询哪行满足条件时是相等;但是选取列可能会有不同,因为using语句是会去除重复列的)

##### 13.2.9.3 UNION Clause  
- union将来至多个select语句的结果组合成为单个结果集中.结果集的列名取至第一个select语句的列名.
- 每个select语句的相应位置列出的所选择的列应该具有相同的数据类型.
- UNION语句中的select和通常的没什么区别,但有以下限制:
  - 不能使用HIGH_PRIORITY,如果在第一个出现则没有效果,但是如果在第一个select语句后的语句出现则会报错.
  - 只有最后一个select语句可以使用`INTO`修饰词,但整个union结果都将写入到目的文件中.
- 默认地,重复行会被移除,这和显示指定`DISTINCT`修饰词效果一样,如果指定`ALL`则包含所有行不会移除重复行.
  
#### 13.2.10 Subqueries  
- 子查询(subquery)是在另外一个语句中的select语句.一个子查询必须由括号括起来.
- 

##### 13.2.10.3 Subqueries with ANY, IN, or SOME
- 语法:
  `operand comparison_operator [ANY|SOME] (subquery)
   operand IN (subquery)` 
- SOME关键字为ANY的别名
- IN等效于 = ANY 
- NOT IN等效与<> ALL,而不是<> ANY

##### 13.2.10.4 Subqueries with ALL
- `operand comparison_operator ALL (subquery)`

##### 13.2.10.5 Row Subqueries   
- 表达式(1,2)和ROW(1,2)是等效的.

##### 13.2.10.6 Subqueries with EXISTS or NOT EXISTS        

##### 13.2.10.7 Correlated Subqueries
-  correlated subquery就是子查询语句中引用外部的表(在子查询引用一个from从句没有指定的表,则mysql会从子查询语句向外部开始查找该表.)

##### 13.2.10.8 Derived Tables
- 派生表(derived table): 查询语句的from从句中的子查询是派生表,如`SELECT ... FROM (subquery) [AS] tbl_name ...` AS关键字是强制要有的.

##### 13.2.10.9 Subquery Errors
- 事务型存储引擎子查询失败会导致整个语句失败;而非事务型存储引擎保留了在遇到错误之前所做的数据修改
   
##### 13.2.10.10 Optimizing Subqueries
- 使用x = ANY (table containing (1,2))代替 x=1 OR x=2.
- 使用= ANY代替EXISTS.
- mysql本身做的一些优化
  - 

##### 13.2.10.12 Restrictions on Subqueries
- 通常地,你不能在一个语句中修改的表和子查询中表是同一个表.但是有个例外是子查询被实现为临时表,而不是将子查询结果合并到外部查询. 

#### 13.2.11 UPDATE Statement
- 有单表更新,多表更新
- UPDATE语句的修饰词:
  - ignore:加了之后当有更新过程中有错误时产生也不会中止,由于唯一索引导致的键重复的不会被更新;对于转换数据会发生错误的会将值更新为最接近的有效值.
  - limit:限制更新范围,当找到满足的where条件的n个行数后即停下,不管该些行实际是否被更新.
- 如果将一行设置为它当前的值,则mysql不会更新它的值.

### 13.3 Transactional and Locking Statements
- XA事务支持是mysql也可以参加分布式事务.

#### 13.3.1 START TRANSACTION, COMMIT, and ROLLBACK Statements
- 默认地, autocommit模式是开启,这意味如果没有在事务内,每个语句都是原子的,你不能使用ROLLBACK撤销操作,但是如果语句执行时发生错误则该语句会回滚.要隐式的禁用单个语句系列的autocommit,请使用START TRANSACTION语句:START TRANSACTION开头的,autocommit会一直被禁止直到用COMMIT或ROLLBACK结束事务时,autocommit的值自动恢复到之前的值.
- START TRANSACTION允许多个修饰词才控制事务特征,多个修饰词用逗号分隔.
  - READ WRITE,READ ONLY:在事务内允许或禁止对表的更改.READ ONLY防止事务中修改或锁定其他事务中可见的事务表或非事务表,但是事务中仍能修改或锁定临时表.这些修饰词5.6.5起可用.如果没有指定访问模式,则使用默认的模式:读/写(除非被改变).
  - BEGIN和BEGIN WORK为START TRANSACTION的别名,作用是初始化事务.START TRANSACTION是标准的sql语法,所以推荐.
  - 开始一个事务会导致任何未决事务(pendin transaction)被提交.开始一个事务同样也会由LOCK TABLE语句获取的表锁被释放,就像执行了UNLOCK TABLES一样.但是开始一个事务不会无法释放由FLUSH TABLES WITH READ LOCK语句全局读锁.
- 为了最好的结果,事务中应该只使用一种事务安全型的存储引擎,否则会有以下可能发生:
  - 如果你在事务中使用的不是事务安全的存储引擎表,那么对于非事务安全表的更改会被马上存储而不管autocommit模式.事务中在对非事务表更改后发出ROLLBACK语句将会有一个警告产生,对于事务安全表的更改会被回滚,但对于非事务安全表的更改则无法回滚.
- commit后,每个事务都以一个块的形式存储在二进制日志中(binary log).回滚的事务不会被记录.(除了:回滚的事务中包含了对非事务表的更改,那么整个事务都将在末尾使用ROLLBACK语句记录下来,以确保后续复制也复制了对非事务表的修改)
- 可以使用SET TRANSACTION语句更改事务的隔离级别和访问模式.

#### 13.3.2 Statements That Cannot Be Rolled Back
- 有些语句无法被回滚.通常,这些包含数据定义语句(DDL),如表的create或drop,创建,删除或更改表或存储例程(procedures and functions)的语句.你应该设计你的事务不能包含这些语句.

#### 13.3.3 Statements That Cause an Implicit Commit
- 这些语句大多数会在语句执行后导致隐式提交,目的是在其自己的特殊事务中处理每个这样的语句,因为他无论如何都不能回滚.
  - 定义或修改了数据库对象的数据定义语言(DDL)
  - 隐式的使用或修改`mysql`数据库的表
  - Transaction-control和locking statements:
    - 仅在当前有任何表被用LOCK TABLES语句锁住时,使用UNLOCK TABLES获取非事务表锁时,UNLOCK TABLES才会提交事务.但在FLUSH TABLES WITH READ LOCK后使用UNLOCK TABLES语句时不会导致提交因为UNLOCK TABLES语句无法获取到表锁.
    - 事务不能嵌套.结果就是START TRANSACTION语句或其他同义词语句后会隐式提交当前事务.
  - Data loading statements
  - Administrative statements
  - Replication control statements

#### 13.3.4 SAVEPOINT, ROLLBACK TO SAVEPOINT, and RELEASE SAVEPOINT Statements
- InnoDB支持SAVEPOINT, ROLLBACK TO SAVEPOINT, RELEASE SAVEPOINT语句.
- RELEASE SAVEPOINT:从当前事务的savepoints集中删除指定的savepoint.
- 在执行commit或没有指定具体savepoint的rollback语句时,当前事务中所有savepoint都将被删除.

#### 13.3.5 LOCK TABLES and UNLOCK TABLES Statements
- mysql允许会话中可以显式的获取表锁.会话只能为其自身获取或释放锁,无法获取或释放另一个会话的锁.
- 对于视图锁定,lock tables会将视图中使用的所有基本表都添加到要锁定的表集中并自动锁定它们.使用lock tables显示锁定表时,则表中触发器中使用的任何表也会被隐式锁定.
- `UNLOCK TABLES`语句(语句没有其他修饰词就是单独的一句UNLOCK TABLES)显式的释放当前会话中持有的任何表锁.LOCK TABLES是在获取新锁之前隐式的释放当前会话持有所有表锁.
- UNLOCK TABLES的另一个使用时释放全局读锁(由FLUSH TABLES WITH READ LOCK语句获取,该语句可以锁定所有数据库中的所有表).
- 对于临时表,LOCK TABLES是允许的但会被忽略.临时表可以被由创建它的会话自由的访问,而不必考虑可能会生效的锁.因为其他会话无法看到该表.
- Table Lock Acquisition
  - 要在当前会话中获取表锁,使用LOCK TABLES,该语句会获取元数据锁.以下为允许的锁类型:
	  - READ [LOCAL] lock:
	    - 持有该锁的会话只能读表(不能写)
	    - 多个会话能获取同时获取同一个表锁.
	    - 其他会话不用明确获取一个读锁(READ LOCK)就可以读取表
	    - LOCAL修饰词使得持有该锁时,其他会话能够执行无冲突的插入(insert)语句,即并发插入(concurrent inserts).如果你想要在持有锁的同时使用外部处理程序操作数据库则不能使用READ LOCAL.对于innodb表,READ LOCAL和READ是一样的.
	  - [LOW_PRIORITY] WRITE lock:
	    - 持有该锁的会话可以读表和写表
	    - 只有持有该锁的会话才能访问表,其他会话只能在锁被释放后才能访问.当表的WRITE锁被持有时,其他会话对于该表的锁请求将被阻塞.
	    - LOW_PRIORITY修饰词已经没有效果了,在较早的版本会影响锁行为.但之后都不赞成使用该修饰词并且使用了产生一个警告.
  - 读锁优先权通常比写锁高以确保更新操作能马上完成.即当有一个会话持有READ锁时,然后另一个会话请求WRITE锁,则随后的READ锁请求将等待直到请求WRITE锁的会话持有并释放了该锁.(不过对于该策略有个例外就是max_write_lock_count系统变量较小时就不是这样的).
  - 需要锁定的会话必须在单个LOCK TABLES语句中获取去它需要的所有锁.
  - 你不能在单个查询语句中使用相同的名称引用锁定的表,需要改用别名,并为表和每个别名字获取单独的锁.(如`LOCK TABLE t WRITE, t AS t1 READ; INSERT INTO t SELECT * FROM t AS t1;`).如果查询语句通过别名引用表,则必须使用相同的别名锁定表.相反,使用别名锁定表时,在查询语句必须使用该别名引用表.
  - 注意:当LOCK tables和unlock TABLES语句应用在分区上时,总是lock和unlock整个表.
- Table Lock Release  
  - 释放会话持有的表锁时,它们将同时释放.会话可以显式释放其锁,也可在某些条件下隐式释放锁.
    - 一个会话使用UNLOCK TABLES语句显式的释放锁
    - 会话中发出LOCK TABLES语句获取新锁前已经持有的锁会被隐式的释放在新锁被授予之前.
    - 如果一个会话由一个事务开始(如START TRANSACTION),一个隐式的UNLOCK TABLES语句会被执行,这会导致当前持有的锁被释放.
  - 一个客户端会话的连接中止(不管是正常或异常),mysql服务器都会隐式的释放该会话(事务或非事务的)持有的所有的锁.如果客户端重新连接,锁不会再有作用,如果就客户端有一个活动的事务,则mysql服务器回滚事务在断开连接后,如果一个重连发生,则新会话开始时autocommit选项是开启的.由于这个原因客户端可能不想要auto-reconnect,因为auto-reconnect会在不通知客户端情况下重新连接,但是表锁和当前事务都将丢失.而当禁用auto_reconnect时,如果连接断开,则下一条发出的语句将发生错误,以便客户端可采取蛇胆的操作,如重新获取锁或重做事务.
  - 注意: 如果对一个加了锁的表使用alert table语句,则表锁可能会被释放.比如你想第二次执行alert table时,则会报错(该表没有被锁定).对此,你需要在执行第二个alert table前先再次锁定表.
- Interaction of Table Locking and Transactions  
  - lock table和unlock table对事务的使用有以下的相互影响
    - lock table不是事务安全的,会对任何活动着的事务进行隐式提交在尝试锁定表前.
    - UNLOCK TABLES隐式提交任何活动的事务(但是仅限于用lock tables语句获取表锁.)
    - 开始一个事务(例如 START TRANSACTION)隐式的提交任何当前活动的事务并释放持有的表锁.
    - FLUSH TABLES WITH READ LOCK语句获取一个全局读锁但表没有锁定,所以它与lock tables和unlock tables语句在表锁定和隐式提交方方面不具有相同的行为.例如之后执行start transaction不会释放全局读锁.
    - 在事务表中(如innoDB)正确使用lock tables和unlock tables:set autocommi = 0, 然后使用lock table语句锁定需要使用的表(全程START TRANSACTION语句都不用到),最好做完相应操作并提交后才最终执行unlock tables.
    - ROLLBACK不会释放表锁
- LOCK TABLES and Triggers
  - 使用lock tables显式的对表锁定,则任何该表的触发器所涉及的所有的表都将被隐式的锁定.
  - 触发器中使用到的表所需要的锁取决当表仅用于读时,则读锁就足够;否则需要写锁.
  - 如果lock tables语句显式的对一个表执行读锁,但需要锁定才能写入因为可能会在触发器中对其进行修改,所以会获取写锁而不是读锁.(也就是,由于触发器中出现的隐式写锁将表的显式读锁请求转换为写锁定请求.)
- Table-Locking Restrictions and Conditions  
  - 使用kill语句可以安全的终指一个回话
  - LOCK TABLES和UNLOCK TABLES不用在存储程序中
  - performance_schema数据库不能lock tables语句锁定,除了setup_xxx表
  - 通常的,你不需要表锁,因为所有单个UPDATE语句都是原子性的,不会受到其他会话并行执行sql语句的影响.但是以下有一些情况是锁定表能带来的好处:
    - 如果你要对myisam表执行许多操作,则锁定后操作会更快.锁定myisam表会加快插入,更新或者删除因为mysql不用flush key cache直到执行unblock tables.通常地key cache在每个sql语句后都会被flush.锁表的坏处是:没有会话可以更新一个加了读锁的表(包括持有该表读锁的会话),除了持有读锁的会话没有其他会话可以会话可以访问加了读锁的表.
    
##### 13.3.6 SET TRANSACTION Statement
- SET TRANSACTION语句为设置事务的特征.隔离级别用于innoDB表,访问模式(access mode)设置事务操作是read/write还是read-only.

#### 13.3.7 XA Transactions    
- 用于分布式事务.传统的事务局限于当前实例不能跨库.
  
#### 13.4.1 SQL Statements for Controlling Master Servers  
- 因为主从自己没有用到暂时放着.

### 13.5 Prepared Statements
- mysql5.6支持服务端预处理语句.对参数值使用带占位符的预处理语句具有以下好处:
  - 减少执行语句时解析语句的开销,通常,应用程序处理大量几乎相同的语句,仅对子语句总的文字或变量值进行更改,例如查询和删除使用的wehre更新使用的set以及insert使用的values.
  - 保护SQL注入.参数值可以包含未转义的sql引号和定界符.
- PREPARE, EXECUTE, and DEALLOCATE PREPARE Statements
  - 预处理语句语法基于以下3个sql语句:
    - PREPARE:准备要执行的语句
    - EXECUTE:执行语句
    - DEALLOCATE PREPARE:释放预处理语句  
  - 准备好的语句用于创建他的会话中,如果会话终断前没有指定DEALLOCATE PREPARE释放预处理语句,则服务端会自动解除解除该预处理语句.预处理语句对于会话也可以是全局的,你可以在存储例程中创建一个预处理语句,在存储例程结束前不会解除(deallocated)预处理语句.
  - 为了保证没有许多预处理语句同时创建,可以设置max_prepared_stmt_count系统变量,设置为0表示禁用.
- SQL Syntax Allowed in Prepared Statements
  - 预处理语句不能嵌套也就是预处理语句中不能包含预处理语句
  - 一个预处理语句只能包含一个语句,不能包含多个语句(语句间用逗号隔开)

#### 13.5.1 PREPARE Statement
- ?字符用于参数标记,以指示稍候的查询将数据值绑定到哪里.只能用于数据值应该显示数据值的位置,而不能用于sql关键子,标识符等.
- 会话中,如果预处理语句中指定的名称已经存在,则在执行新预处理语句前先隐式地将之前的释放.

#### 13.5.2 EXECUTE Statement
- 你可以对给定的预处理语句执行多次,将不同的值传给它. 

### 13.6 Compound Statements

#### 13.6.1 BEGIN ... END Compound Statement
- begin [statement_list] end能够嵌套即可以包含begin [statement_list] end语句; statement_list本身是可选的,所以BEGIN END是合法的,它代表的是为一个或多个sql语句.

#### 13.6.2 Statement Labels
- 标签(LABEL)语句使用在BEGIN ... END块或LOOP,REPEAT,WHILE语句.标签使用有以下规则:
  - begin_label标签后必须要有冒号
  - begin_label后面可以没有end_label,但是end_label前必须要有begin_label;同时begin_label和end_label名必须相同
  - 标签在同个嵌套级别中必须唯一
  - 标签名长度最多16个标签
  
#### 13.6.3 DECLARE Statement  
- DECLARE只能用在begin ... end中,且必须在其他语句之前

#### 13.6.4 Variables in Stored Programs

##### 13.6.4.1 Local Variable DECLARE Statement
- 该语句在存储程序中声明一个或多个局部变量(local variable).可选的default从句指定了默认值(如果没有默认为null).变量的作用范围是在声明它的begin .. end中

##### 13.6.4.2 Local Variable Scope and Resolution
- 局部变量不能使用在存储程序中预处理语句,因为局部变量的作用域在存储程序中而预处理语句的作用域为整个会话.存储程序中所有流程控制块都必须以为分号(;)终止.(如果begin .. end;)

#### 13.6.5 Flow Control Statements
- mysql支持if,case,iterate,leave loop,while,repeat,return构造,以在存储程序中进行流程控制.mysql不支持for循环.

##### 13.6.5.2 IF Statement

### 13.7 Database Administration Statements

### 13.7.2 Table Maintenance Statements

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

### 13.8 Utility Statements
#### 13.8.1 DESCRIBE Statement 
- DESCRIBE和EXPLAIN语句是同义词(mysql对待它们完全相同),通常使用于获取表结构或查询语句的执行计划

#### 13.8.2 EXPLAIN Statement
- EXPLAIN EXTENDED:加了EXTENDED修饰词,则会额外产生用show warnings语句才会生成的执行计划信息.
- EXPLAIN中的FORMAT修饰词指示了结果是以表格还是json格式展示.

#### 13.8.4 USE Statement
- 告知mysql使用给定的数据库作为默认数据库以便手续的语句可以使用.

    
## 14.innoDB storage Engine
### 14.1 Introduction to InnoDB
- innoDB是一个兼顾了高可靠性和高性能的通用存储引擎,在mysql5.6中为默认存储引擎.
- Key Advantages of InnoDB(主要优势)
  - 它的DML操作遵循ACID模型,并具有commit,rollback,crash-recovery功能的事务,以保护用户数据.
  - 行锁和Oracle-style的读一致可提高多用户并发性和性能
  - innoDB表将数据安排在磁盘上,以基于主键优化查询.每个innoDB表都有一个主键索引称为聚簇索引的(ps:clustered index(中文聚簇索引)术语表示innoDB的主键索引),该索引组织书以最小化主键查找的I/O.
  - 为了维护数据的一致性,innoDB支持外键(FOREIGN KEY)限制,以确保不同表间的一致性.

### 14.1.2 Best Practices for InnoDB Tables
- 不要使用lock tables语句.innoDB能处理多个会话的对于同个表的同时读和写.如果要获取一组行的排他性写访问权限,请使用select ... for update语法锁定要更新的行.
- 启动innodb_file_per_table,这可将单个表的数据和索引放入单独的文件中而不是系统表空间.

### 14.2 InnoDB and the ACID Model

### 14.3 InnoDB Multi-Versioning
- innoDB是一个多版本控制的存储引擎,它保存保存了被更改行的旧版本信息,以便支持如并发和回滚的事务功能.该信息以称为回滚段(rollback segment)数据结构存储在表空间中.innoDB使用这些信息来在回滚事务中执行撤销操作,同时也被用于构建行的早期版本以实现读一致.
- 内部的,innoDB向存储在数据库中每行添加三个字段.6字节的DB_TRX_ID字段指示插入或更新该行的最后一个事务标识符,此外删除在内部被视为更新,在该更新中,行中的特殊位(bit)被置为将其标记为已删除行;每行还包含一个7字节的DB_ROLL_PTR字段,称为滚动指针,该滚动指针指向一个写入在回滚片段中撤销日志记录(undo log record),如果行被更新,撤销日志记录包含了重建更新前的行的内容所必要的信息;6字节的DB_ROW_ID字段包含行ID,该行ID随着插入新行而单调增加,如果innoDB自动生成聚集索引,则该索引包含ID值,否则DB_ROW_ID列不会出现在任何索引中.
- 回滚段中的撤销日志分为插入和更新撤销日志.插入撤销日志仅在事务回滚时需要,并且在事务一提交后就立即丢弃.更新撤销日志也用于一致读,但只有当不存在事务中有需要更新撤销日志信息去创建早期的数据库行版本的innoDB分配的事务,才可丢弃该更新撤销日志.
- 回滚段中的撤销日志记录的物理大小通常小于相应的插入或更新的行,你可以用此信息来计算回滚段所需要的大小.
- 在innoDB多版本方案中,当你删除语句时,并不会立即从数据库中物理删除该行,innoDB只会在丢弃了为删除而编写的更新撤销日志记录时,才会物理地删除相应的行以及索引.此清除(removal)操作称为清除(purge),它非常快,通常和执行删除操作的sql语句顺序相同.
- Multi-Versioning and Secondary Indexes
 - InnoDB multiversion concurrency control(MVCC)对二级索引的处理不同于聚簇索引( clustered indexes).聚簇索引中的记录是就地更新,它隐藏着系统列指向了撤销日志条目,该条目可用于重建行的早期版本.而二级索引(secondary index)则没有包含隐藏的系统列,也就无法就地更新.当一个二级索引更新时,旧的索引记录会被标记为删除,插入新记录,并最终清除(purge)带有删除标记的记录

### 14.5 InnoDB In-Memory Structures
#### 14.5.1 Buffer Pool
- 缓冲池(buffer pool)是一个内存中一个区域,访问innoDB表和索引数据时会缓存在该内存中.缓冲池允许直接冲内存中处理经常使用的数据,从而加快处理速度.在专用的服务器上,通常将多达80%的物理内存分配给缓冲池.为了提高大容量读取操作的效率,缓冲池分为多页面,这些页面可以潜在的容纳多行.为了高效的管理缓存,缓冲池被实现为页面的链接列表,使用LRU算法的变体将很少使用的数据老化掉.
- Buffer Pool LRU Algorithm
  - 缓冲池被作为列表进行管理,使用最近最少使用算法(LRU)的变体.当需要添加新的页面到缓冲池中,则最少使用的页面被驱逐,然后新页面加入到列表的中间.中间点插入策略将列表视为两个子列表对待: 一个是新子列表包含最近访问的页面,另一个是旧子列表包含了最近最少访问的页面,作为驱逐的候选对象.
  - 默认地,该算法运行方式如下:
    - 缓冲池的3/8分配给旧页子列表
    - 当innoDB读取一个页面到缓冲池时,它首先如插入到列表中间点(旧子列表的头部).一个页面会被读取到缓冲池是在用户启动的操作(如sql查询),或innoDB自动执行的预读操作的一部分.
    - 访问旧子列表的页面,该页面会被标记为新的并被移到新子列表的头部.如果页面的读取是由于用户发起的操作,则第一次访问会马上将页面标记为新的;如果页面的读是由于预先读(read-ahead)操作,则第一次访问不会马上发生(标记为新的),甚至该页面被驱逐了都不会.
  - 通常,由查询语句读取的页面会别马上被移动到新子列表中.表扫描,比如一个mysqldump操作或没有加where的select语句,会将大量数据写入到缓冲池中并驱逐同等量的旧数据,即使新数据从不会被使用.相同地,由后台预读取线程加载的页面并只被访问一次而被移到新子列表的头部.在这些情况中会将频繁访问页面推到旧页中.对此优化可参照14.8.3.2“Making the Buffer Pool Scan Resistant”和Section 14.8.3.3“Configuring InnoDB Buffer Pool Prefetching (Read-Ahead)”.
- Buffer Pool Configuration
  - 在有足够内存的64位系统上,可将缓冲池分为多个以最小化并发操作之间的内存结构的争用.
  - 可控值在后台flush时是否根据工作负载动态调整flush速率.
  - 可控制innoDB如何保存当前缓存池状态来避免在服务器启动后需要长时间的预热.
- Monitoring the Buffer Pool Using the InnoDB Standard Monitor
  - 可使用SHOW ENGINE INNODB STATUS语句来查看innoDB标准监视输出,缓冲池指标位于该输出中 BUFFER POOL AND MEMORY部分.
- Monitoring the Buffer Pool Using the InnoDB Standard Monitor
  - 使用SHOW ENGINE InnoDB STATUS语句查看innoDB的标准监视输出.
  - 注意:
    - 在没有进行大扫描时,如果youngs/s很低,则可能要减少延时间或增加用于旧子列表的缓冲池百分比.增加百分会使旧子列表的缓冲池变大,因此该子列表中的页面需要更长的时间才能移到尾部,这增加了再次使用它们并是它们变新的可能性.
    - non-youngs/s指标只应用在旧页面.如果在执行大表扫描时该值没有较高(和较高的youngs/s)则请增加延迟值.

### 14.5.2 Change Buffer    
- change buffer是一种特殊的数据结构,它是缓存(cache)对二级索引页面的更改并且这些页面没有存在缓冲池中.更改的缓冲(buffered changes)是由insert,update,delete操作结果引起,更改的缓冲会(buffered changes)与相关的页面被以后其他读的操作加载到缓冲池时而合并然后再放入到缓冲池中.不像聚簇索引,二级索引值通常不是唯一的,插入到二级索引通常是随机的顺序,同样地,删除和更新二级索引页面在索引树上可能不是相邻的.缓存的更改(cached changes)会在之后合并,即当其他读操作将受影响的页面读取到缓冲池中才会合并,这避免了从磁盘中将二级索引读取到缓冲池所需要的大量随机I/O访问. 定期地,purge操作会在系统大部分空闲时或者缓慢关机时将已更新了的索引页面写入到磁盘上,这比一有数据更新就写入磁盘高效.change buffer的合并在受影响行数很多和被更新的二级索引很多时有可能需要花费几个小时.在内存上,change buffer占据一部分缓冲池(buffer pool).在磁盘上,change buffer是系统表的一部分,当数据库服务器关闭时缓冲索引的更改.change buffer由 innodb_change_buffering系统变量控制.当索引列中包含降序列或主键包含降序索引列则Change buffering不支持secondary index.
  - 自己理解总结:change buffer就是缓存那些对二级索引页面的更改且这些页面没有在缓冲池中(因为这些页面没有在缓冲池中所以没办法直接合并),当后面有读操作将相关的页面读取到缓冲池时才合并.更新的页面会后面刷新(flush)到磁盘中,
- Configuring Change Buffering
  - change buffer能减少磁盘的读和写,特别是受限于I/O的负载最有价值(例如具有大量DML操作(如批量插入)的应用),但是如果change buffer占了缓冲池太多的内存或表的二级索引相对较少,那么禁止change buffer可能会更有帮助.为此可通过innodb_change_buffering设置change buffer缓冲程度:可以开启或禁止插入,删除操作(索引记录最初被标记为删除)和purge操作(索引记录被物理删除).更新操作即为插入和删除的组合.具体取值如下:
    - all: 默认值,缓冲insert,delete-marking和purge操作.
    - none: 不缓冲任何操作
    - inserts: 缓冲插入操作
    - deletes: 缓冲标记删除(delete-marking)操作
    - changes: insert和delete-making操作
    - purges: 缓冲后台执行物理删除操作. 
- Configuring the Change Buffer Maximum Size
  - innodb_change_buffer_max_size系统变量为设置change buffer占总缓冲池的最大百分比值,默认为25,最大为50(即50%).在有大量插入,更新和删除的服务器上,change buffer的合并可能会跟不上新增的change buffer条目,从而达到change buffer的最大上限所以要增大innodb_change_buffer_max_size值; 如果change buffer占据太多缓冲池的空间而导致页面比期望的更快逐出缓冲池.使用一个代表性工作负载下测试不同的设置以确定最佳配置.
- Monitoring the Change Buffer
  - 使用`SHOW ENGINE INNODB STATUS\G`语句查看innoDB标准监视输出,change buffer信息位于该输出中的INSERT BUFFER AND ADAPTIVE HASH INDEX部分中.

### 14.5.3 Adaptive Hash Index  
- adaptive hash index特性使innoDB在具有适当工作负载组合和足够的缓冲池内存系统上更像一个内存数据库而不用牺牲事务功能特性和可靠性.innodb_adaptive_hash_index变量控制是否开启.基于对搜索的模式,使用索引前缀构建哈希索引,前缀可以是任意长度.哈希索引是根据经常访问的索引页面的需要而自动建立的.但在有些负载下,adaptive hash index反而没有帮助,如繁重的工作负载(例如多个并发连接).使用like和%通配符的查询也往往不受益,为此在这个负载下应关闭以减少开销.由于很难事先预测开启是否会受益所以要事先在开启和关闭下都进行基准测试下.
- `SHOW ENGINE INNODB STATUS`语句输出结果的SEMAPHORES部分可以对adaptive hash index的使用和争用进行监视.

#### 14.5.4 Log Buffer
- log buffer是一个内存区域,它保存着要写入磁盘上的日志文件的数据.大小由innodb_log_buffer_size变量控制,默认16MB.log buffer的内容定期的flush到磁盘中.较大的log buffer可以使大型事务无需在commit前将redo日志写入到磁盘,因此对于有更新,插入或删除许多行的事务,需要加大log buffer以节省磁盘I/O.
- innodb_flush_log_at_trx_commit变量控制log buffer内容怎么写入磁盘. innodb_flush_log_at_timeout变量控制定期flush到磁盘的频率.

### 14.6 innoDB On-Disk Structures
#### 14.6.1 Tables
##### 14.6.1.1 Creating InnoDB Tables
- 当你创建一个innoDB表时,mysql会在mysql的数据目录下的数据库目录中创建一个.frm文件,对于在 file-per-table选项下创建的,mysql会在数据库目录下创建一个.ibd表空间文件,如果该选择没有开启,则表会创建在innoDB系统表空间中,即在mysql数据目录下在已存在的ibdata文件中创建该表
- InnoDB Tables and .frm Files
  - mysql将表的数据字典信息存储在数据库目录下的.frm文件中,不像其他存储引擎,innoDB还会在系统表空间内的自己内部数据词典中存储编码(encode)了的有关表的信息.所以当mysql删除一个表或者数据库时,它会删除.frm文件同时还会删除innoDB数据字典中相应的条目.为此你不能通过简单的移动.frm来完成innoDB表的移动.
- InnoDB Tables and Primary Keys  
  - 虽然一个表没有主键可以正确运行,但是主键经常被使用到并且与涉及到许多方面的性能,所以强烈推荐指定一个主键.
  
#### 14.6.1.4 AUTO_INCREMENT Handling in InnoDB
 - InnoDB AUTO_INCREMENT Lock Modes
   1. innodb_autoinc_lock_mode = 0 ("traditional" lock mode)
      会产生表锁
   2. innodb_autoinc_lock_mode = 1 ("consecutive" lock mode)
   3. innodb_autoinc_lock_mode = 2 ("interleaved" lock mode)
      速度最快(有些情况也会产生表级锁), 但是it is not safe when using statement-based replication or recovery scenarios when SQL statements are replayed from the binary log
 - InnoDB AUTO_INCREMENT Lock Mode Usage Implications
   - Using auto-increment with replication
     - 使用statement-based replication: 设置innodb_autoinc_lock_mode为0或1同时master和slaves必须同一个值, 这样是安全的
     - row-based or mixed-format replication: innodb_autoinc_lock_mode的所有模式都安全
     - "Lost" auto-increment values and sequence gaps
        所有模式中, 当一个值已经分配给自增键, 这个值都不会再被使用, 无论事务是否回滚
     - 自增值超过定义类型的最大值: 会报错duplicate entry ...
     
 - InnoDB AUTO_INCREMENT Counter Initialization
   在InnoDB中, 自增计数器存储内存中; 空表默认1(auto_increment_offset可以设置)开始; 当服务器重启了, 自增计数器会在第一次插入操作或show table status时初始化(做类似的操作: SELECT MAX(ai_col) FROM table_name FOR UPDATE;)

##### 14.6.1.6 AUTO_INCREMENT Handling in InnoDB
- InnoDB AUTO_INCREMENT Lock Mode Usage Implications
  - 主从复制AUTO_INCREMENT的使用
    - 对于使用基于语句(statement-based)复制,那么主服务器和从服务器innodb_autoinc_lock_mode的值相同且为0或1,这样的复制是安全的.而对于使用innodb_autoinc_lock_mode=2,或者主机和从机使用不同的innodb_autoinc_lock_mode值的情况则无法保证主机从机的Auto-increment值是相同. 
    - 对于使用row-based的mixed-format复制,则所有的innodb_autoinc_lock_mode值(共有0,1,2)都是安全
  - auto-increment的丢失和序列的缺口
    - 在innodb_autoinc_lock_mode所有的值下,如果生成auto-increment值的事务回滚,则这些auto-increment值会"丢失",即一旦一个值分配给自动增加列,即使事务回滚了这些值还是无法复用的(除了重启服务器以重新计算计数器值或者更改自增值计数器值),因此自增列上可能会有间隙.
  - 为自增列指定NULL或者0
    -  在innodb_autoinc_lock_mode所有的值下,为自增列指定NULL或者0,那么innoDB当作它仿佛没有被指定并自动生成一个新值给它.
  - 如果一个自增列值超过该列定义的整数类型
    - 则会报重复键(duplicate-key)的错误(如最大值为127那么报错提示会是:为主键值插入重复值127.(ps:innoDB表只能有一个自增列且必须是主键))  
  - 批量插入下的自增值的间隙  
    - innodb_autoinc_lock_mode为0或者1下,自增(auto-increment)值是连续的不会有间隙 
  - 修改自增列值可能会导致的问题
    - **如果修改自增列的值大于当前自增值的最大值,后续的insert语句可能会在自增列上产生重复值的错误.** 演示:比如a为自增列,当前一行数据,a列为1,现更改为2,然后插入一行(a列不指定值使用自增值),则结果会报2重复.
- InnoDB AUTO_INCREMENT Counter Initialization    
  - 如果为innoDB表指定自增列,则innoDB数据字典中的表句柄将包含了一个称为自增值计数器,该计数器用于为该自增列分配新增.该计数器仅存于主内存中,而不是在磁盘上.当对包含自增列的表第一次插入时初始化该计数器值.默认地,自增值增量为1,可通过设置auto_increment_increment更改,如果表示空的,则从1开始,也设置auto_increment_offset自定义起始值.重启会取消CREATE TABLE和ALTER TABLE语句中AUTO_INCREMENT = N选项的影响,即重启后AUTO_INCREMENT会重新计算可能不是你指定的N了.
  - notes: 当重启服务器后,innoDB可能会重用哪些分配的自增值因事务回滚而没有使用的自增值

#### 14.6.2 Indexes    
##### 14.6.2.1 Clustered and Secondary Indexes
- 每个innoDB表都有一个特殊的索引称为聚簇索引(clustered index),用于存储行数据.通常地,聚簇索引与主键是同义的.
  - 当你为表定义一个主键时,innoDB使用它作为聚簇索引.
  - 如果你没有为表定义一个主键,则mysql会定位第一个所有键列都为not null的唯一索引(unique index)并且innoDB将该唯一索引作为聚簇索引.
  - 如果一个表没有主键和合适的唯一索引(所有键列都为not null的唯一索引),innoDB内部会在包含行ID的合成列上产生一个隐藏的聚簇索引名为GEN_CLUST_INDEX.这些行由innoDB分配给此表中的行ID排序.行ID是一个6字节的字段,随着插入新行而单调增加.因此,按行ID排序实际上是为插入的顺序.
- How the Clustered Index Speeds Up Queries
  - 通过聚簇索引访问行会更快,因为索引搜索将直接指向包含所有行数据的页面.     
- How Secondary Indexes Relate to the Clustered Index    
  - 除了聚簇索引外的所有索引都是二级索引(secondary indexs).二级索引中每个记录都包含该行的主键列以及二级索引指定的列.innoDB使用该主键值在聚簇索引中搜索行.

##### 14.6.2.2 The Physical Structure of an InnoDB Index    
- 所有的innoDB索引都是B-trees,索引记录存储在树的叶子页中.索引页默认大小为16KB.当新记录插入到innoDB聚簇索引中,innoDB会尝试让的页面的1/16空闲,以供将来插入和更新索引记录.如果索引记录的插入是按顺序的(升序或降序),则索引页面大约15/16满.如果索引页下降到1/2以下,则innoDB会尝试收缩索引树以释放页面.
- 可在初始化mysql实例前通过innodb_page_size设置索引页大小,而之后如果要该值需要重新初始化mysql实例.该值支持16KB,8KB,4KB.
- 页面大小(InnoDB page size)不同的两个mysql实例,数据文件和日志文件(data files and log file
s)不能相互使用. 

#### 14.6.3 Tablespaces
##### 14.6.3.1 The System Tablespace
- 系统表空间(system tablespaces)是一个存储innoDB数据字典(data dictionary),双写缓冲区(doublewrite buffer),更改缓冲区(change buffer),撤消日志(undo log).此外,它还可能包含包表和索引数据(即该表是在file-per-table选项关闭情况下创建的,所有表和索引数据都包含在系统表空间内).系统表空间位于mysql的data目录下,名称类似ibdata1,ibdata2(系统表空间可以有多个文件).系统表空间数据文件的数量和大小由innodb_data_file_path在mysql启动时定义的.
- Resizing the System Tablespace    
  - 增加系统表空间大小
    - 最简单的方法就是在配置文件中设置innodb_data_file_path选项为最后一个系统表空间文件为autoextend(自动扩展),每次自动扩展大小由innodb_autoextend_increment设置,然后重启mysql服务器生效.(ps:表空间有个大小最大64TB的限制)
    - 此外,你也可以增加新的系统表空间数据文件来扩展系统表空间大小.
      - 停止mysql
      - 修改配置文件中的innodb_data_file_path值.在innodb_data_file_path定义中如果最后一个系统空间数据文件(文件名类似ibdata1)有autoextend属性则移除,然后将文件大小设置为当前该文件大小转化为M单位并四舍五入后的值
      - innodb_data_file_path值后附上新的系统表空间数据文件名称,以及新数据文件的大小,autoextend属性为可选,与前一个数据文件用;间隔.(修改类似长这样innodb_data_file_path = /ibdata/ibdata1:900M;/disk2/ibdata2:50M:autoextend,这个例子就是增加新的文件名为ibdata2,初始大小为50M,会只能扩展.具体语法innodb_data_file_path=file_name:file_size[:autoextend[:max:max_file_size]])
      - 重启mysql以生效配置
  - Decreasing the Size of the InnoDB System Tablespace     
    - 对于减小系统表空间的值不能采用移除文件的做法,应使用如下方法:
      - 使用mysqldump导出所有innoDB表,包括位于mysql数据下的
      - 停止mysql服务器
      - 移除所有存在的表空间文件(*.ibd),包含ibdata和ib_log文件.不要忘了也移除mysql数据库下*.ibd文件.
      - 移除所有innoDB表的.frm文件
      - 在mysql配置文件中配置新的系统表空间数据文件.(方法类似本节的Resizing the System Tablespace)
      - 重启mysql服务器
      - 导入导出的文件
      - note:如果数据仅使用innoDB存储引擎那么可以直接简单的导出所有表(dump all databases),停止mysql,移除所有数据库和innoDB日志文件,然后重启导入文件
      - 为了避免系统表空间太大,考虑开启file-per-table配置,对于表空间类型为file-per-table的表,当截断(truncate)或删除(drop)该表后,磁盘空间会返还给操作系统.

##### 14.6.3.3 Undo Tablespaces    
- 撤消表空间(undo tablespaces)包含着撤消日志(undo logs).撤消日志是撤消日志记录的集合,撤消日志记录包含了有关如何撤消事务对聚簇索引记录的最新更改的信息.撤消日志(undo logs)存在于撤消日志段(undo log segments)中,撤消日志段包含在回滚段(rollback segments)中.innodb_rollback_segments系统变量定义了为每个撤消表空间(undo tablespaces)分配多少个回滚段.撤消日志能被存储在一个或者多个撤消表空间而不是系统表空间中,此布局与默认配置不同,默认地撤消日志位于系统表空间中. innodb_undo_tablespaces变量设置了innoDB使用的撤消表空间的数量,该选项只能在mysql实例化时配置,之后便不能再更改.
- Configuring Undo Tablespaces
  - 为了找到最佳值你需要事先在测试实例上测试(该测试实例应与实际生产环境相同,数据量相似). 对于innodb_undo_tablespaces数量,如果不确定可以估值高点,然后是确定innodb_rollback_segments:先赋个比较小的值,然后定期增加该值(最大128)并查看I/O性能是否提升,一直重复直到I/O性能没有再提升.

##### 14.6.4 InnoDB Data Dictionary
- InnoDB数据字典由内部系统表组成，这些内部系统表包含了用于跟踪对象（例如表，索引和表列）的元数据。元数据位于InnoDB系统表空间中(数据字典位于系统表空间中)。由于历史原因，数据字典元数据在某种程度上与InnoDB表元数据文件（.frm文件）中存储的信息重叠。

#### 14.6.5 Doublewrite Buffer
- doublewrite缓冲区是系统表空间中的存储区域，InnoDB会在其中写入从缓冲池中刷新的页面，然后再将它们写入数据文件中的适当位置。仅在刷新页面并将其写入doublewrite缓冲区后，InnoDB才会将页面写入其适当位置。如果在页面写入过程中发生操作系统，存储子系统或mysqld进程崩溃，则InnoDB可以在崩溃恢复期间从doublewrite缓冲区中找到该页面的良好副本。
- 尽管数据总是被写入两次，但是双写缓冲区不需要两倍的I / O开销或两倍的I / O操作。通过对操作系统的单个fsync（）调用，数据将作为一个大的顺序块写入doublewrite缓冲区。
- 默认情况下，双写缓冲区处于启用状态。要禁用双写缓冲区，请将innodb_doublewrite设置为0。

#### 14.6.6 Redo Log
- 重做日志(redo log)是一种基于磁盘的数据结构,在崩溃恢复期间用于纠正不完整事务写入的数据.在正常操作期间，重做日志对更改表数据的请求进行编码，这些请求是由SQL语句或低级别的API调用引起的。在初始化过程中以及接受用户连接之前，将自动重播在意外关闭之前未完成更新数据文件的修改.
- 默认地,重做日志物理上由名为ib_logfile0和ib_logfile1两个在磁盘上的文件表示.mysql以循环的方式写入重做日志.
- Changing the Number or Size of Redo Log Files
- Group Commit for Redo Log Flushing

#### 14.6.7 Undo Logs    
- 与单个读写事务关联的撤消日志记录的集合是撤消日志.一个撤消日志记录包含着怎么撤消一个事务对聚簇索引的最新更改的信息,如果另一个事务需要查看原始数据,则将从该撤消日志记录中检索未修改的数据.撤消日志存在与撤消日志段(undo log segments)中,而撤消日志段存在于回滚段(rollback segments)中.默认地,回滚段存放与系统表空间中,但同样也可以存放在撤消表空间中(undo tablespaces).
- 回滚段支持的事务数量取决于回滚段上的撤消插槽(undo slot)的数量和每个事务需要的撤消日志数量.一个事务最多分配2个撤消日志:一个为插入操作,另一个为更新或删除操作.
- 基于以上的讨论我们可以估算出innoDB支持多少个并发读写事务.
  - 假设每个事物都是只有插入操作或者更新,删除操作(即这种情况只要分配一个撤消日志),则并发数公式如下:(innodb_page_size单位byte)
    `(innodb_page_size / 16) * innodb_rollback_segments`
  - 假设每个事务都有插入操作和更新或删除操作,公式如下:(innodb_page_size单位byte)
    `(innodb_page_size / 16 / 2) * innodb_rollback_segments`

### 14.17 InnoDB Monitors
#### 14.17.2 Enabling InnoDB Monitors  
- 当innoDB监视器被开启时,innoDB大约每15秒会将结果写入mysql服务器的标准错误输出(stderr)中.开启的方式如下2中
  - 创建一个名为innodb_monitor的innoDB表.
  - 开启innodb_status_output或innodb_status_output_locks系统变量,前者变量为InnoDB Standard Monitor out,后者为Lock Monitor Output,区别就是后者比前者多了关于lock的信息
- Obtaining Standard InnoDB Monitor Output On Demand
  - 作为启动innoDB Standard Monitor定期输出的替代方法,可以使用`SHOW ENGINE INNODB STATUS`语句按照需要查询
      
#### 14.17.3 InnoDB Standard Monitor and Lock Monitor Output      
- Lock Monitor与Standard Monitor的输出是相同,除了多了锁(lock)信息.
      
# mysql术语
- adaptive hash index(自适应哈希索引)
  - 一种能加速在innoDB表中=或in运算符的查找,它通过在内存中构建一个哈希索引(hash index).mysql监视innoDB表的索引查询,如果能够从哈希索引中获益,则mysql会自动为经常被访问的index pages创建一个.该特性由于innodb_adaptive_hash_index系统变量控制,因为该特性对于有些负载能从中获益而有些不能,而用于哈希索引的内存保留在buffer pool中,所以你应该在该功能开启和关闭下进行基测比较下.
- buffer pool:  
  - 存有innoDB表数据和索引数据缓存的内存区域.为了高效的读取,该缓冲池被分为多个页面(pages),这些页面可能包含多个行.为了提高缓存管理效率,缓冲池被使实现为页面的链接列表(a linked list of pages).使用的是LRU算法的变体.在有大内存的系统上,可以将缓存池划分为多个缓冲池实例来提高并发性. 
  - 从5.6起,可通过在mysql服务器关闭时间保存缓存池状态并在启动时恢复到相同的状态来避免重启mysql后漫长的预热.
- clustered index  
  - 聚簇索引(clustered index)是对innoDB主键的术语.
- data dictionary 
  - innoDB数据字典(data dictionary)由内部系统表组成,这些系统表包含了跟踪与innoDB相关的对象(例如表,索引和表列)的元数据.元数据位于innoDB系统表空间中.由于历史原因,词典元数据在某种程度上与innoDB表元数据文件(.frm文件)中存储的信息重叠.
- data files 
  - data files是物理上包含表和索引数据的文件.
  - innoDB系统表空间,保存着innoDB数据字典(data dictionary)并且能够保存多个innoDB表数据,系统表空间用一个或多个.ibdata数据文件表示.
  - file-per-table表空间保存着单个innoDB表的数据,用一个.ibd数据文件表示.
  - 通用表空间(在mysql5.7.6引入),它能保存多个的innoDB表数据,同样使用一个.ibd数据文件表示.
- .ibd file
  - .ibd是file-per-table表空间(tablespaces)和通用表空间(general tablespaces)的数据文件. file-per-table表空间.ibd文件包含单个表和相关的数据文件.常规表空间.ibd文件可能包含多个表的表和索引数据,常规表空间(general tablespaces)在mysql5.7.6引入. .ibd不同于系统表空间(system tablespaces),系统表空间是由一个或多个ibdate文件组成的.
- ibdata file  
  - ibdata file是一系列名字如ibdata1,ibdata2等的文件,这一系列文件组成了innoDB的系统表空间(system tablespace).这些文件包含了innoDB表的元数据,(innoDB data dictionary(数据词典))和一个或多个的undo logs(撤消日志)、change buffer、doublewrite buffer(双写缓冲)的存储区域.这些文件包含了部分或全部表的数据(部分还是全部这取决于所有表创建时innodb_file_per_table选项是否关闭),启用innodb_file_per_table时,新建表的数据和索引将单独存储在.ibd文件中,而不是系统表空间中.ibdata文件的增长受innodb_autoextend_increment配置影响.
- ib_logfile
  - 形成redo log(重做日志)的一组文件,通常命名为ib_logfile0和ib_logfile1.有时也被称为log group(日志组).这些文件记录着尝试更改innoDB表中数据的语句.这些语句会在系统崩溃之后的启动时自动重播(replay)以更正由不完整事务写入的数据.当然ib_logfile文件是不能被用于手动恢复的,若需要手动恢复请使用binary log.
- LSN
  - log sequence numberde首字母缩写,这个不断增加的值表示着与重做日志(redo log)中操作记录对应的时间点.(此时间点不受事务边界限制,它可以落在一个或多个事务的中间).在崩溃恢复期间,innoDB在内部使用它来管理缓冲池.
  
- rollback segment
  - 一个包含撤消日志(undo logs)的存储区域.回滚段(rollback segment)传统上位于系统表空间中.从mysql5.6起回滚段可以驻留在撤消表空间(undo tablespaces)中,mysql5.7开始,回滚段也分配给全局临时表空间.  
- secondary index
  - 一种innoDB索引,表示着表列的子集.一个innoDB表可以有零个,一个或多个secondary index(不像聚簇索引(clustered index),每个innoDB表都要有聚簇索引).secondary index能被用在仅查询索引列就能满足查询条件;或更复杂的,能被用于定位表中相关行,然后再用聚簇索引来获取要查询的行信息.
- tablespace
  - 一个数据文件,可以保存一个或多个innoDB表及关联的索引.系统表空间(system tablespace)包含了innoDB的数据字典(data dictionary)


# 一些外部辅助理解mysql的文章
- 索引结构
  - https://www.kancloud.cn/kancloud/theory-of-mysql-index/41850
  - https://zhuanlan.zhihu.com/p/35811482
- 好的优化文章
  - https://www.jianshu.com/p/d7665192aaaf 
 
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

- Linux安装多个mysql [二进制包安装方法](https://dev.mysql.com/doc/refman/5.6/en/binary-installation.html#binary-installation-layout)
  
  下载mysql二进制包[下载地址](https://dev.mysql.com/downloads/mysql/), 然后初始化, 初始化时务必使指定basedir和database格式, 这样就能避免与已安装的冲突
  `bin/mysqld --initialize --user=mysql --basedir=/opt/mysql/mysql --datadir=/opt/mysql/mysql/data`

- 指定配置文件启动(Linux)
  
  `mysql_path/bin/mysqld --defaults-file=customize_config_path/my.cnf`
  
- 查看mysqld会以什么参数启动或初始化
  
  `bin/mysqld [--defaults-file=path/my.cnf] --print-defaults`
  

【数据库迁移,导出及其导入】

- 导出(备份)： mysqldump -u root -p --all-databases > $destDir/all_databases_20180314.bak   直接在linux命令行中输入

- 导入： mysql -u root -p < $destDir/all_databases_20180314.bak
    导入sql脚本:
       1. mysqldump -uroot -p database_name < import.sql   //Linux命令行下导入import.sql文件到库名为database_name的数据库中
       2. 先进入mysql
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
  
- mysql5.6和mysql5.7区别
  - 5.7以前使用mysql_install_d初始化数据目录, 5.7起使用mysqld的initialize
  