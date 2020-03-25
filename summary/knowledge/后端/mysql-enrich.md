## 4.MySQL Programs 

### mysqlcheck — A Table Maintenance Program
- mysqlcheck必须在运行时使用同时处理期间每个表都会被锁其他会话无法访问.myisamchk在停机使用,虽在运行时也可以,但必须自己锁表,所以最推荐的方式为停机下使用.这两个程序功能是差不多的.
- 选项:
  - fast:仅检查未正确关闭的表
  - check:检查表错误
  - repair: 修复几乎所有问题除了唯一键不唯一
  - analyse: 分析表,更新索引的基数
  - optimize: 优化表,优化表的碎片
#### 4.5.4 mysqldump — A Database Backup Program
#### 4.5.7 mysqlslap — Load Emulation Client
#### 4.6.5 myisampack — Generate Compressed, Read-Only MyISAM Tables
#### 4.6.6 mysql_config_editor — MySQL Configuration Utility    
>管理名为`.mylogin.cnf`(默认在用户home目录下,名字最前面是有点的)的模糊登录路径文件, 当如mysql. mysqladmin等客户端工具使用--login-path=.mylogin.cnf启动时, 这些客户端会读取其中的[client], [mysql], [mypath]块配置(优先权高于其他配置文件但低于命令行的), 这样就能知道要连接那个mysql server, 同时记录在.mylogin.cnf的密码不是明文的有一定安全性(但是不要认为它是牢不可破,因为无法阻挡有决心的攻击者), 有多个mysql服务器时方便连接切换

#### 4.6.8 mysqlbinlog — Utility for Processing Binary Log Files
- 使用mysqldump + mysqlbinlog for Backup and Restore
  事先使用mysqldump导出备份文件作为快照, 使用 mysqlbinlog备份bin log二进制文件(可以永不断开的持续实时备份). 在万一数据丢失了,先导入备份文件, 然后执行二进制备份,可执行类似如下命令 `mysqlbinlog --start-position=27284 binlog.001002 binlog.001003 binlog.001004 | mysql --host=host_name -u root -p`

## 5.1 The MySQL Server  
- 在调优mysql服务器时,最重要的配置变量:key_buffer_size和table_open_cache,你首先应该确信自己已经对这两个值设置适当值在修改参数前.
    - table_open_cache: 所有线程的能打开表数量,增大该值将增加mysql所需的文件描述符的数量.可通过opened_tables状态变量查看是否修改增加table_open_cache值,如果你没用经常执行flush tables(flush tables会强制将所有的表关闭重新打开)而opened_tables值很大时你就需要增加table_open_cache值了.
    - key_buffer_size: 缓冲MyISAM表的索引块(这些缓冲是并被所有线程共享的).(只缓冲MyISAM表,同时他是只缓冲索引不缓冲数据的,对于innoDB表缓冲的是索引和数据是一起的)

## Chapter 8 Optimization
 ### 8.1 Optimization Overview
  
 ### 8.2 Optimizing SQL Statements
  ##### 8.2.1.1 WHERE Clause Optimization
   - **通过尝试所有的可能来找到最佳的联表联结组合.ORDER BY或GROUP BY从句中的所有列都来自同一个表,那么join时首先将他放前面**
   - **如果一个ORDER BY从句和一个不同的GROUP BY从句,或者ORDER BY or GROUP BY从句中的列不是来自联表(join)顺序中第一个表的列, 都会创建临时表**
  #### 8.2.1.9 Outer Join Simplification
   - **在解析阶段(parse stage), 带有right join的查询会被等效转换成只带有left join的语句**
  #### 8.2.1.13 ORDER BY Optimization
   - Use of Indexes to Satisfy ORDER BY
     - 默认的, mysql会对group by col1, col2, ...语句进行排序操作,所以你在语句后显式的指定相同列的order by col1, col2, ...语句, mysql会对于进行优化不会任何的速度损失,不管他是否排序(**使用索引就不用排序(filesort), 因为索引本身就是顺序的**). **如果想让包含group by的语句避免排序的开销, 加上order by null可以抑制排序,但是仅仅是抑制对结果的排序.**
   - Influencing ORDER BY Optimization
      - **如果想要提高order by速度,先检查下能否使用索引而不是需要额外的排序阶段(用索引不用排序),** 如果不可能,可尝试一下策略:
        - **增加sort_buffer_size系统变量值**.理想的该值应该足够大以装下整个结果集在sort buffer中(避免写入到磁盘和合并过程), 监视合并的次数(合并临时文件),**可以查看Sort_merge_passes状态变量, 如果该值很大则应考虑增加sort_buffer_size的值**
 ### 8.3 Optimization and Indexes
  #### 8.3.4 Column Indexes 
   - Index Prefixes
     当有一个字符串列col_name(N),你可以只索引前N个字符,这样会使索引更小.当你对BLOB或TEXT列作索引时, 你必须指定索引前缀长度.**索引最长可达到1000字节(bytes)(innoDB最大767bytes,但系统变量innodb_large_prefix被设置后可以更大).** **前缀限制的长度以字节为单位, 而create table, alter table和create index语句的前缀长度被解释为非二进制字符串类型的字符数和二进制字符串类型.所以在为多字节集的非二进制字符串列指定前缀长度时,需要考虑到这点.**
   - FULLTEXT Indexes
     **只有MyISAM和innoDB存储引擎支持全文索引,而且只有char,varchar和text列支持.全文索引只会对整列索引,不支持前缀索引**  
   - Indexes in the MEMORY Storage Engine
     **MEMORY存储引擎默认使用hash索引, 但也支持B-tree**  
  #### 8.3.5 Multiple-Column Indexes
   - **mysql可以创建复合索引(即在多列上建索引).一个索引最多可以包含16列**.**对于复合索引的替代方法,在表上多建一列基于其他列组合的值的hash列, 如果此列较短,合理唯一并且已经建立索引则可能比复合索引快.**  
  #### 8.3.7 InnoDB and MyISAM Index Statistics Collection
   - **平均值组的大小与表基数有关,表基数就是值数的数目.show index语句显示的基数值字段(cardinality)基于N/S, N为表的所有行数, S为值组的平均大小, 该比率指示着表中大约多少个值组.**
   - 对于基于<=>的join, null与其他任何值都一样: null<=>null(为true), 就像N<=>N(为true)一样.(**`<=>`操作符为比较两个变量,相同返回1不同返回0,其中对于null:只有当两个都是null才返回1,只有一个为null时返回0,而平常的`=`操作符null于其它任何值相比都是返回null**)
   
   
 ### 8.4 Optimizing Database Structure
  #### **8.4.1 Optimizing Data Size**
   - Table Columns
     - **如果可能声明列不为null,通过更好的使用索引并消除测试每个值是否为null的开销可加快sql的操作.如果确实需要使用null值,就使用但是避免设置默认值为null.**
   - Row Format
      - **在mysql 5.6中,innoDB表默认使用COMPACT row存储格式(ROW_FORMAT=COMPACT)**.紧凑的行格式系列包括了COMPACT, DYNAMIC, COMPRESSED,(innoDB支持的行格式:COMPACT,DYNAMIC,COMPRESSED,REDUNDANT)减少了行存储空间但增加某些操作的cpu使用率.**如果你的工作负载是典型的受缓存命中率和磁盘速度,则会更快;如果仅仅只是受限于cpu速度, 那么反而会更慢.**
        - **紧凑的行格式还可以优化使用了可变长度字符集(如utf8mb3或utf8mb4时)的char列存储.如果ROW_FORMAT=REDUNDANT,则char(N)占用N x 字符集最大字节长度.许多语言主要可使用单字节utf8字符集编写, 所以一个固定的存储长度往往是浪费空间的.使用紧凑的行格式系列,InnoDB通过剥离尾部的空格, 在N到N x 该列字符集的最大字节长度的范围内分配存储长度.在典型情况下, 最小的存储长度为N字节以方便就地更新.**
        - **要通过压缩的形式存储表数据来进一步减少空间,可在创建innoDB表时指定ROW_FORMAT=COMPRESSED,或对已存在的myisam表执行myisampack命令(myisam采用compressed的行格式只能有myisampack工具产生).(innoDB压缩表是可读写的,而myisam压缩表只能读)**  
  ##### 8.4.2.1 Optimizing for Numeric Data
   - **对于唯一id或其他可以被表示为数字或字符串的值,数字列好于字符串列.因为大数值可以比相应的字符串存储使用更少的字节,因此使用更少内存的来传输和比较(比如存储ip使用无符号的int就够了,存取时要做个转换.php的ip2long()可将ip转为数字,long2ip()则为逆向操作)**     
  ##### 8.4.2.3 Optimizing for BLOB Types
   - **而不是针对一个非常长的文本字符串测试是否相等, 你可以将列值的hash值存储在一个列中并建立索引,然后在查询使用hash查找.由于hash函数可能会由不同输入值产生重复的结果,为此你仍然可以再加上and blob_colname=long_string_value来保证不会将错误结果也包含进来.** 
  #### 8.4.3 Optimizing for Many Tables  
   #### 8.4.3.1 How MySQL Opens and Closes Tables 
   - **检查你的table_open_cache是否太小,检查opened_tables状态变量,这指示着自服务器启动以来表打开操作的数量.如果该值很大或增加迅速,即使你没有执行许多flash table语句,那么在服务器启动时要增加table_open_cache值(table_open_cache是所有线程能打开的表数)**
  #### 8.4.5 **Limits on Number of Databases and Tables**
   - mysql对于数据库的数量没有限制,基础文件系可能对目录数量有所限制.
   - mysql对表的数量没有限制,基础文件系统可能对文件数量有所限制;各个存储引擎可能会强加特定于引擎的约束,**innodb最多40亿张表** 
  #### 8.4.7 **Limits on Table Column Count and Row Size**  
   - Column Count Limits
     - **mysql硬性限制表最大4096列,但实际有效列可能比这小, 具体取决如下情况:**
       - 最大行大小限制了列的数量(也可能是大小)
       - 存储引擎可能施加其他的限制,**比如innoDB限制每个表最大1017列**
     - 自己扩展:
       - 一个表可以建多少个索引取`决存储引擎.,mysiam最多64个索引,innoDB最多64个二级索引  
       - **innoDB: 最多创建1017列,最多64个二级索引,单个索引最多16列,索引长度767字节,行大小最大65536字节**
       - **mysiam: 最多4096列,最多64个二级索引,单个索引最多16列,索引长度1000字节,行大小最大65536字节**      
   - Row Size Limits
     - **mysql表内部表示形式最大行大小限制为65536字节(bytes),即使是存储引擎能提供更大的值也是如此.BLOB和TEXT列仅对行大小贡献9-12字节,因为它们的内容与行的其余部分分开存储**
   - Row Size Limit Examples    
    - **对于myisam表, null列在行中需要占用额外的空间以记录其值是否为null,每个null列都要多加1bit,四舍五入到最近的字节.(比如一行有3个null列那么就是占用3bit舍入为1byte)**  
    
 ### 8.5 Optimizing for InnoDB Tables
  - **一旦你的数据达到稳定大小或者增长了几十或几百兆字节,考虑使用OPTIMIZE TABLE语句重组表并压缩所有浪费的空间.重组后的表需要更少的磁盘I/O执行全表扫描.这是直接的技术**(如改善索引使用或调整程序代码)在其他技术不可行时提高性能.   
  #### 8.5.4 Optimizing InnoDB Redo Logging  
   - 可以从以下方面考虑优化redo logging
     - 使你的redo log文件变大,甚至和缓冲池(buffer pool一样大.当redo files被innoDB写满时,它必须在检查点(checkpoint)将缓冲池的已修改内存写入磁盘.小的redo log files导致许多不必要的磁盘写入.因此你应该有自信使用大的redo log file.
       - **可通过innoDB_log_file_size和innoDB_log_file_in_group系统变量分别控制redo log fiels的大小和数量.**
     - 考虑增加log buffer的大小.一个大的log buffer能够允许大事务的执行在commit前不需要将log写入到磁盘中.因此有更新,插入或删除许多行的事务增大log buffer能够节省磁盘I/O, 可通过innodb_log_buffer_size系统变量来控制log buffer大小.
  ##### 8.5.8 Optimizing InnoDB Disk I/O    
   - 增加buffer pool大小
      - **通过innodb_buffer_pool_size设置,此内存区域非常重要,因此建议配置为系统的50%-75%.**
 ### 8.6 Optimizing for MyISAM Tables
 >**由于表锁定限制了同时更新的能力,因此myisam存储引擎在以只读数据为主要或低并发操作方面表现最佳.**   
  #### 8.6.1 **Optimizing MyISAM Queries**
  - **在加载数据后使用ANALYZE TABLE或myisamchk --analyze,这将为每个索引部分更新上一个值**,该值指示着具有相同值的平均行数.在不是恒定表达式(nonconstant express)的表join中优化器使用该值决定使用哪个索引.
  - **根据某个索引对数据和索引进行排序这会使得如果有一个唯一索引要从中按顺序读取所有的行的查询更快;** myisamchk --sort-index --sort-records=1(sort-index为将索引树按高低顺序排序,sort-records则是将表行记录按索引号排序.假设你要对索引号为1的索引进行排序,索引号可从show index语句获得)
  - mysql支持并发插入数据,如果表的数据文件中间没有空闲块(free block),则可以在其他线程正在读取数据的同时,向其中插入新行.如果能够做到这一点对于你很重要,那么请考虑避免删除表行,**另一个可能就是当你删除许多行后使用OPTIMIZE TABLE语句整理碎片.通过设置concurrent_insert系统变量可以控制并发插入行的行为,该变量可采用如下的值:**
  - **使用alter table table_name order by expr1, expr2,...对表进行按照索引的顺序将数据进行排序,这样会有利于后续你查询数据时以expr1,expr2..的顺序查询**(expr格式字段名加上可选的顺序(asc,desc)默认asc,比如alter table a order by c desc就是将表的数据行按照表的c字段降序,但之后的插入和更新的数据不一定还按这个顺序的)
  - **定期的执行OPTIMIZE TABLE语句避免动态格式的myisam表碎片化.**
  - **使用DELAY_KEY_WRITE=1选项声明在建myisam表时(该选项有仅适用于myisam),可以加快是索引更新更快因为在关闭表时才会将索引的更新刷新到磁盘**. 
  
 ### 8.8 Understanding the Query Execution Plan 
  #### 8.8.1 Optimizing Queries with EXPLAIN
   - **explain可以运用在select,insert,delete,update,replace语句(对于相同操作的预处理语句不支持)**
  #### **8.9.3 Index Hints** 
   - **在查询处理期间,index hint(索引提示)为优化器提供了如何选择索引的信息,索引提示仅对select,update语句有效.index hints跟在表后面**
     - USE INDEX (index_list)告诉优化器仅使用index_list其中一个索引去寻找行;相反的,ignore index (index_list)告诉优化器不使用index_list的索引;
     - force index提示与use index类似
     
 ### 8.10 Buffering and Caching   
  #### 8.10.2 The MyISAM Key Cache
   - **为了最小化磁盘I/O,myisam存储引擎,它使用了缓存机制将最常访问的表块数据保留在内存中.**
     - **对于index block(索引块),由于一种叫key 
     (or key buffer)的特殊结构维护**
     - **对于数据块(data block),myslq没使用特殊的缓存.相反,它们依赖于本机操作系统文件系统缓存.**
   - **通常的mysql服务器遵循LRU(Least Recently Used)策略(最近最少
   使用),当选择一块作为替换对象时,它选择最近最少使用的索引块.为了使选择变得简单, key cache module维护着所有使用过的块在一个由使用的次数排序的特殊列表(LRU chain).当一个块访问时,它是最近访问所以放置到列表底部;当需要一个块被替换时,最经常使用的块置于该列表的底部,而该列表的开头成为第一个驱逐的候选者.**

  ##### **8.10.2.2 Multiple Key Caches**
   - **对于key cache的共享访问并不能消除会话间的竞争关系.为了减少这种key cache访问的竞争,mysql提供了多个key caches,即允许将不同的表索引分配到不同的key caches.默认的,所有myisam表的indexs都被缓存(cache)在同一个key cache上.你可以使用cache index table_name[,table_name] in key_cache_name语句为表索引分配到指定名字的key cache上,同时还可以设置其大小.(ps:load index into cache tab_index_list则是将表索引预先加载到刚cache index语句指定的key_cache_name上).当有一个key cache被销毁时,所有分配到这上的所有索引都将被重新分配到默认的key cache上.**
   - 对于一个繁忙的服务器,**可以使用以下的三个key caches策略:**
     - **'hot' key cache:占所有为key cache分配空间的20%,该部分用经常搜索但是不更新的表.**
     - **'cold' key cache:20%,该部分用于中等大小,密集修改的表,如临时表**
     - **'warm' key cache:60%,该部分最为默认的key cache,上述情况外都使用此区域**
  ##### 8.10.2.3 Midpoint Insertion Strategy
   - 默认的,mysql使用简单的LRU策略来选择需要驱逐的key cache block.而中点插入策略会将LRU链分为hot子列表和warm子列表两部分.**使用中点插入策略能够使得更有价值的blocks总是保留在cache中**.如果仅想使用普通LRU,则将key_cache_division_limit设置它的默认值100.   
  #### 8.10.3 The MySQL Query Cache
   - **查询缓存将select语句和对应的发送到客户端的结果存储起来.以便后续有相同查询语句时可以直接从查询缓存获取而不必再解析执行.这对于表没有经常改而又经常用相同语句取数据的环境很有帮助.查询缓存不会返回陈旧的数据,当表被更改时,则对应的查询缓存条目都将被刷新.** **分区表不支持查询缓存,涉及分区表的查询将自动禁止查询缓存.**
  #### **8.10.3.2 Query Cache SELECT Options**
   - **查询语句中可以指定两个与查询缓存相关的选项** query_cache_type控制缓冲语句是否开启 
     - SQL_CACHE
     - SQL_NO_CACHE 
 ### 8.11 Optimizing Locking Operations   
  #### 8.11.1 Internal Locking Methods
   - 表锁
     - 表锁的优点
       - **所需要的内存相对较少**(行锁需要锁定每行或行组的内存)
     - 表的更新权限比读高,因此当一个锁释放时,该锁先可用于写锁队列中请求,然后才是读锁队列中的请求.如果有许多更新则等到更新结束才能读取.SHOW STATUS LIKE 'Table%';可以查看表锁争用的信息.(**ps:自己理解,表级锁的表读锁和写锁是互斥的,读与写操作是串行的,即读锁会阻塞写,而不会阻塞读,写锁会把其他写和读都阻塞.不过在设置Concurrent Insert>0时,允许有一个会话执行插入的同时其他会话可以读表(同一时间只能有一个插入),就是我们说的并行插入**)  
      
 ### 8.12 Optimizing the MySQL Server    
  #### 8.12.3 Using Symbolic Links 
   - 你可以将数据库或表从数据库目录移动到其他位置(如空间更大,更快的磁盘),推荐软链接整个数据库目录.软链接myisam表为最后的手段.
  #### 8.12.3.2 Using Symbolic Links for MyISAM Tables on Unix   
   - **仅有myisam表完全支持符号链接.对于其他引擎使用的表文件,如果使用软链接可能会有奇怪的问题.innoDB表如果想要将表放置不同磁盘位置可以用create table的DATA DIRECTORY从句代替软链接而达到这个目的. `SHOW VARIABLES LIKE 'have_symlink';` 查看是否支持或开启软链接**
 ### 8.13 Measuring Performance (Benchmarking)
  #### 8.13.1 Measuring the Speed of Expressions and Functions
  
   - **测试mysql执行一个表达或函数的速度, 可以使用 select BENCHMARK(count,expr);表示expr重复执行count次.**  
  #### **8.13.2 The MySQL Benchmark Suite**
   - 免费的开源数据库基准测试工具:http://osdb.sourceforge.net/
   - 基准测试
     - **mysqlslap(mysql自带的)**
     - 其他如SysBench或DBT2; 
     
## Chapter 13 SQL Statements
### 13.1.13 CREATE INDEX Statement 
- Index Options
  - **每个存储引擎支持的索引类型**
    - innoDB: BTREE
    - MYISAM：BTREE
    - MEMORY/HEAP:HASH,BTREE
    - NDB: HASH/BTREE
- Table Options
  - **ENGINE**
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

#### 13.1.16 CREATE SERVER Statement    
- Indexes and Foreign Keys
  - PRIMARY KEY
    - **主键是not null的唯一索引,如果没有显示指定not null则mysql会静默的设置为not null.一个表只能有一个主键,主键的名称始终为primary,所以primary不能用作其他索引的名称.主键可以是多列的**.    
  - FOREIGN KEY
    - **仅innoDB存储引擎支持外键,innoDB的分区表不支持外键**  
    
##### 13.1.17.1 CREATE TABLE Statement Retention
- **由于是保存的是原始语句的文本.但是由于某些值或选项可以被静默的重新配置(如row_format),所以活动表的定义(通过describe或show table status获取)和表创建的字符串(通过SHOW CREATE TABLE获取)得到的值可能会有所不同**.
    
#### 13.1.33 TRUNCATE TABLE Statement
- **TRUNCATE TABLE语句将完全的清空表,需要drop权限.逻辑上,TRUNCATE TABLE操作类似于删除了所有行的delete操作,或drop table然后再create table的操作.但是为了更好的性能,它绕过了删除数据的DML方法,所有它无法被回滚,也不会触发on delete触发器,也不能用于具有父子外键关系的innoDB表.**
- **TRUNCATE TABLE虽类似于delete,但被归类于DDL,而不是DML;它与delete有如下不同:**
  - **TRUNCATE TABLE语句drop再re-create表,这比一行行的删除表更快,特别是大表**
  - **TRUNCATE TABLE导致隐私的提交,且无法回滚**
  - **AUTO_INCREMENT重为开始值,即使是innoDB和myisam表也是.** 
  - **对于分区表,TRUNCATE TABLE语句会保留分区;也就是说数据和索引文件会被删除并重新创建,而分区定义文件(.par)不受影响.**   
  
#### 13.3.2 Statements That Cannot Be Rolled Back
- **有些语句无法被回滚.通常,这些包含数据定义语句(DDL),如表的create或drop,创建,删除或更改表或存储例程(procedures and functions)的语句.你应该设计你的事务不能包含这些语句.**

##### 13.7.2.4 OPTIMIZE TABLE Syntax
>reorganizes the physical storage of table data and associated index date, to reduce storage space and improve I/O efficiency
- **支持的存储引擎: InnoDB,MyISAM,ARCHIVE**     

### 14.1.2 Best Practices for InnoDB Tables
- **不要使用lock tables语句.innoDB能处理多个会话的对于同个表的同时读和写.如果要获取一组行的排他性写访问权限,请使用select ... for update语法锁定要更新的行.**

#### 14.5.1 Buffer Pool
- **可使用SHOW ENGINE INNODB STATUS语句来查看innoDB标准监视输出**

### 14.5.2 Change Buffer    
- 自己理解总结:**change buffer就是缓存那些对二级索引页面的更改且这些页面没有在缓冲池中(因为这些页面没有在缓冲池中所以没办法直接合并),当后面有读操作将相关的页面读取到缓冲池时才合并.更新的页面会后面刷新(flush)到磁盘中**

##### 14.6.2.1 Clustered and Secondary Indexes
- 每个innoDB表都有一个特殊的索引称为聚簇索引(clustered index),用于存储行数据.通常地,**聚簇索引与主键是同义的.**
  - 当你为表定义一个主键时,innoDB使用它作为聚簇索引.
  - 如果你没有为表定义一个主键,则mysql会定位第一个所有键列都为not null的唯一索引(unique index)并且innoDB将该唯一索引作为聚簇索引.
  - 如果一个表没有主键和合适的唯一索引(所有键列都为not null的唯一索引),innoDB内部会在包含行ID的合成列上产生一个隐藏的聚簇索引名为GEN_CLUST_INDEX.这些行由innoDB分配给此表中的行ID排序.行ID是一个6字节的字段,随着插入新行而单调增加.因此,按行ID排序实际上是为插入的顺序.
  
##### 14.6.3.1 The System Tablespace
- **系统表空间(system tablespaces)是一个存储innoDB数据字典(data dictionary),双写缓冲区(doublewrite buffer),更改缓冲区(change buffer),撤消日志(undo log).此外,它还可能包含包表和索引数据(即该表是在file-per-table选项关闭情况下创建的,所有表和索引数据都包含在系统表空间内).系统表空间位于mysql的data目录下,名称类似ibdata1,ibdata2(系统表空间可以有多个文件).系统表空间数据文件的数量和大小由innodb_data_file_path在mysql启动时定义的.**

#### 14.17.2 Enabling InnoDB Monitors  
- **当innoDB监视器被开启时,innoDB大约每15秒会将结果写入mysql服务器的标准错误输出(stderr)中.开启的方式如下2种**
  - 创建一个名为innodb_monitor的innoDB表.
  - **开启innodb_status_output或innodb_status_output_locks系统变量,前者变量为InnoDB Standard Monitor out,后者为Lock Monitor Output,区别就是后者比前者多了关于lock的信息**