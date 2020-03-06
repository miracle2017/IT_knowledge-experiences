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
