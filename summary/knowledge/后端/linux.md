##【基本指令】:

- man 命令: 查看某个命令的在线文档

- pwd -LP: 显示出当前文件路径(完整的) 后面不加参数时是有些会是不完整的。

- sync : 关机或者重启,首先要执行此命令将内存的数据存储到磁盘中

- cd:
   cd ..返回前一个目录
   cd ~ 主目录
   cd - 上次工作的目录
   
- tar: 
    -c: 建立压缩档案
    -x：解压
    -t：查看内容
    -r：向压缩归档文件末尾追加文件
    -u：更新原压缩包中的文件
    
   这五个是独立的命令，压缩解压都要用到其中一个，可以和别的命令连用但只能用其中一个。下面的参数是根据需要在压缩或解压档案时可选的。
    
    -z：有gzip属性的
    -j：有bz2属性的
    -Z：有compress属性的
    -v：显示所有过程
    -O：将文件解开到标准输出
    
    下面的参数-f是必须的
    -f: 使用档案名字，切记，这个参数是最后一个参数，后面只能接档案名。
    
    示例: 
    
    tar -czf jpg.tar.gz *.jpg    //压缩为.gz文件,首先将所有的jpg打包成jpg.tar文件, 在用gzip压缩成jpg.tar.gz文件
    tar -xf file.tar.gz //解压 >=1.15版本中解压就会自动识别, 无需像之前tar -xzf file.tar.gz明确指定解压那种

- cp [-r] /home/a/目标文件  /home/b   带-r为复制目录; 递归合并目录只有目标目录没有才添加: cp -rui /source_dir /target_dir

- scp 安全复制,可以跨服务器
    - 本地上传到服务器: scp ./本地文件 root@服务器ip:/path
    - 服务端文件传到本地: scp root@服务器ip:/path ./本地接收路径
    - 指定服务器端口(使用-P): scp -P 20000 ./本地文件 root@服务器ip:/path
    - 使用你预定的好别名也可(myServer名称可以用 ssh myServer直接登录服务器): scp myServer:/path ./本地接收路径

- mv ./a.txt ../b/    复制文件也用于重命名

- rm 删除文件

- chmod -R 777 文件名    修改文件权限

- chown -R git:git    修改文件的所属者

- date "+%Y-%m-%d %H:%M:%S": 输出时间,还有更多用法

- mysql -uroot -p  登录mysql数据库

- service nginx restart  重启nginx

- service php-fpm restart  重启php

- systemctl: 是系统服务管理器指令，它实际上将 service 和 chkconfig 这两个命令组合到一起。

- crontab    定时任务
  > 注意: %有特殊作用, 所以\%才是表达%. 如使用$(date +"\%Y.\%m.\%d")

- free [-h|-m|-g] 查看运行内存，-h方便人阅读自动调整单位, -m以M为单位, -g以G为单位

- top [-b|显示全部进程] [-n number|显示数据刷新次数] 查看进程 （按下1看cpu情况， 默认以cpu列排序,shift + < > 左右切换排序的列
- iostat: 查看I/O状态
- vmstat: 查看服务器状态包括cpu,内存,I/O等的使用情况
- du -sh [指定目录]: 当前文件夹的大小(指定目录), -h为自动调整人便于阅读的单位
- df -h: 列举各个文件大小, -h为自动调整人便于阅读的单位
- chatter [-R] (+|-|=)(A|S|a|c|D|d|I|i|j|s|T|t|u): 对文件属性的更改
- lscpu: 查看系统的一些信息
    
    >CPUs = Threads per core X cores per socket X sockets
    
    >Cores = Cores per socket X Sockets  
    - sockets: 插槽, 即实际物理cpu数
    - cores per socket: 每个cpu包含的核数
    - Threads per core: 每个核有几个线程(超线程)
    
- ll /proc/进程id : 查看进程具体信息

- netstat [参数]:  如netstat -ap | grep 9501
    -a: 全部
    -p: 建立相关链接的程序名及进程号
    
- find [path]  (-name pattern(文件名查找)| -iname pattern(文件名不区分大小写)|-regex pattern(正则表达式)|-exec 命令(对找到的内容执行命令))
  例子 find . -name ".c"   找出当前目录下的.c文件
  只对目录下所有文件修改权限为644,而子目录不动: `find /home/wwwroot -type f -exec chmod 644 {} \;` {}表示匹配到的内容,旁边一定要有空格,\;表示结束.
    
- mkdir: 创建文件夹

- ln: 设置链接
  ln -s target link_name
  ln -s /usr/local/php /home/local(设置软链接, 将/usr/local(实际目录或文件)链接到/home/local，即是/home/local下会多出个php软连接)

- **sed: (stream editor)**
  sed -i "s/oldstring/newstring/g" `grep oldstring -rl path`: -i为直接修改内容; 在path中找出所有存在oldstring的文件, 然后将oldstring替换成newstring; g为全局匹配; /为分界符, 如有冲突可选用| 
  sed -i 's/user.*=.*nobody/user = www/g;s/group.*=.*nobody/group = www/g' w.cnf : 多个匹配替换
  sed -n 's/old/new/p': n和p组合表示打印出匹配的内容不会修改内容

- wget url地址: 下载文件, 支持http(s),ftp协议
  wget: 强大的下载工具, 可以用其递归扒站

- split: 分割大文件为小文件
  - -a: 指定后缀的长度
  - -b: 指定输出文件片段大小. 单位KB, K, M, G
  - -d：输出文件片段后缀为数字而不是默认的字母形式
  - -l：每个输出文件片段的行数
  
  例子:
     - a.按照输入文件行数分割 
       - split -l 300 test.sql -d -a 3 new_file_name 每300行拆分成一个文件, 使用数字作为后缀, 后缀长度3, 文件名为new_file_name  
     - b.按照输出大小文件大小分割 
       - split -b 2G mysql-slow.log -d -a 1 new.log 每2G拆分成一个文件, 使用数字为后缀, 后缀长度1, 文件名new.log
      
- nohup
  不挂断运行命令, 一般与&一起使用, 即关闭当前终端窗口也能在后台运行; 
  而如果只用&, 只能在后台运行, ctrl + c不会退出进程, 但是当前终端关闭了就会结束后台进程
  
  `nohup php cmd.php &`
  
  `nohup ./myprogram.sh > result.log 2>&1 & echo $! > run.pid  //将输入和输出结果记录到result.log中, 将pid号记录到run.pid中`
  `nohup node server.js 1>log.out 2>err.out > & echo $! > run.pid` //将正常信息和错误信息分别对应输出到log.out和err.out文件, pid记录到run.pid文件中
   &>file:将标准输出和标准错误输出都重定向到file中
   2>&1: 将标准错误重定向到标准输出
  
- HASH-TYPE名字+'sum'后缀 filename :(如sha1sum,sha512sum,md5sum等)计算文件(不能是文件夹, 要是单一文件, 文件夹可以先打包压缩)哈希值(sha1, sha512, md5等)  
 
- shell命令之间分号`;`, `&&`, `&`, `||`, `|` 的作用?
  - 分号(`;`) : 顺序独立执行各条命令, 彼此不关系是否失败, 所有命令都会执行
  - `&&` : 顺序执行, 只有当前一条执行成功才会执行后面的
  - `&` : 多个命令同时执行, 不关心彼此是否执行成功
  - `||` : 顺序执行, 只有当前一条执行失败才会执行后面的
  - `|`: 管道命令符, 将前面命令执行的结果做后面命令的输入

- linux常规操作
    - ctrl + z： 挂起
    - ctrl + c： 终止
    - ctrl + \: 退出
    - **ctrl + r: 历史命令搜索, 再按ctrl+r查找上一个** 
    - ctrl + p/n: 快速向前/向后查找历史命令
    - ctrl + u: 当前位置删除到行首
    - ctrl + w: 删除光标前的单词
    - ctrl + a/e : 光标移到行首/行尾
    - tab: 自动补全

- Linux下的vi编辑器基本操作:
  - i 进入插入,模式
  - esc + :(冒号) 进入命令行模式
  - wq保存并退出
  - **u： 撤销**
  - **ctrl + r： 反撤销**
  - 搜索与替换:(https://docs.oracle.com/cd/E19253-01/806-7612/editorvi-62/index.html)
    - `/`向前搜, `?`向后搜. 
    - `n`下一个, `N`上一个.(当然在向后搜时,方向刚好相反)

- su root:服务器上切换用户, su(switch user)
  su - username: 加-,表示环境变量进行切换. 
  显示的时候看到命令行前的#表示超级用户, $表示普通用户

- useradd 用户名  ：Linux下添加一个用户同时会在home下生成一个用户名的目录, -s /sbin/nologin 选项为禁止远程登录

- userdel -r 用户名  ：删除Linux用户，包含home下的用户目录， 不加-r 则只是删除用户名不会删除home下的用户目录
  
- linux参数前 - 和 -- 区别: - 后接单字符
路径之间的 : 冒号做分隔符,分隔多个路径   
    
- 显示环境变量命令
  env: 查看所有环境变量
  set: 查看所有本地定义的环境变量
  export: 查看所有导出的环境变量

- 多个文件合并成一个
  方法1: `cat data* > merge.sql`  #将所有data开头的文件合并成名为merge.txt的文件 
    
- 【防火墙】
    firewall-cmd --zone=public --add-port=3306/tcp --permanent  //永久开放某个端口
    firewall-cmd --zone=public --remove-port=3306/tcp --permanent  //永久关闭某个端口
    firewall-cmd --list-all     //查看所有开放的端口
    firewall-cmd --reload   //重载
    systemctl status/restart/stop firewalld.service   // 状态/重启/停止防火墙服务
    
- 【linux命令行快捷键，或叫配置环境变量】
>全局的环境变量在/etc/profile, 但是非常不推荐改这个文件, 而推荐在/etc/profile.d/下新建一个.sh后缀的自定义文件(比如bash_profile.sh)然后加入环境变量, 该配置也是全局; 而其他每个linux用户根目录下也会有一个.bash_profile环境变量配置文件仅对相应的用户有效

    方一(配置环境变量): vi ~/.bash_profile 可以看到 PATH=$PATH:$HOME/bin, 这个就是配置环境变量,在后面新增即可, 路径间用 : 冒号
    方二(使用别名):  vi ~/.bashrc    增加例如 alias mv='mv -i' 这样的格式,不重启立即生效方法 source ~/.bashrc 或者 \. ~/.bashrc
    
- 【linux修改配置文件不重启立即生效】如修改 ~/.bash_profile文件, 那么 .  /~/.bash_profile  或者 source ~/.bash_profile 即可 (source 又称点命令) 
      可以使用 alias 列出所有的别名

- 【误删数据恢复】参考:https://blog.csdn.net/zonghua521/article/details/78200239

- [CentOS7下swap分区创建(添加),删除以及相关配置](https://www.jianshu.com/p/5acd4cdb34e7)      
      
##【nginx】
>- 重新nginx配置文件(不停服)
>- /usr/local/nginx/sbin/nginx -t  :检测配置文件的语法正确性(很重要)
>- /usr/local/nginx/sbin/nginx -s reload  :重新加加载配置文件(-s有stop的意思)

##【网站压力测试】
>- Apache自带强大网站测试工具：ab
    常用用法： 进入Apache的ab.exe(用于请求http,而abs.exe用于请求https)文件所在目录  打开命令行 ab -n 1000 -c 200 http://www.baidu.com
    (-n 请求总数量, -c并发数)

##【PHP-FPM】
- 参考:线程和进程的区别:https://blog.csdn.net/kuangsonghan/article/details/80674777, https://blog.csdn.net/mxsgoden/article/details/8821936
>- Nginx 是非阻塞IO & IO复用模型，通过操作系统提供的类似 epoll 的功能，可以在一个线程里处理多个客户端的请求。
>- Nginx 的进程就是线程，即每个进程里只有一个线程，但这一个线程可以服务多个客户端。

>- PHP-FPM 是阻塞的单线程模型，pm.max_children 指定的是最大的进程数量，pm.max_requests 指定的是每个进程处理多少个请求后重启(因为 PHP 偶尔会有内存泄漏，所以需要重启).
>- PHP-FPM 的每个进程也只有一个线程，但是一个进程同时只能服务一个客户端。

>- mysql是单进程多线程的架构.每个客户端连接(会话)都会在服务器进程中拥有一个线程,这个连接的查询只会在这个单独的线程中执行.一个mysql实例会有一个管理线程的线程池.

##shell并发执行

    for ((i=0; i<3; i++))
    do
    {
         sleep `expr 10 - $i \* 2` 
        echo $(curl www.baidu.com &)
        echo "\nNO" $i
    }& 
    #这个&是重点 
    done
    
    wait  
    echo 'finish'
  
### **linux的编译安装程序**
 - ./configure: 检测安装平台的目标特征的, 生成Makefile  
 - make: 编译,从Makefile中读取指令,然后编译。
 - make install: 也是从Makefile中读取指令, 将程序安装到指定目录
 - make clean: 清除编译时产生的文件
  
## Linux下独立编译安装搭建LNMP(nginx + php + mysql)
[总指南](https://blog.csdn.net/faith306/article/details/78541974)

  - 添加需要的用户
    - 添加www用户: useradd -r -g www -s /bin/false www
    - 添加mysql用户: useradd -r -g mysql -s /bin/false mysql
    
  - nginx
    1. [下载地址](https://nginx.org/en/download.html)
    2. 安装前准备: 下载pcre, zlib, openssl
    3. [编译安装-官方指南](https://nginx.org/en/docs/configure.html) 
        ./configure --prefix=/usr/local/nginx-1.17.5 --user=www --group=www --with-http_ssl_module --with-http_flv_module --with-http_mp4_module --with-http_stub_status_module --with-select_module --with-poll_module --with-pcre=/usr/local/lib64/pcre-8.43 --with-zlib=/usr/local/lib --with-openssl=/usr/local/lib64/openssl-1.1.0b然后make && make install
    4. 加入系统服务: nginx包中没有提供相关脚本程序
    
  - php
    1. [下载](https://www.php.net/downloads.php)
    2. 编译安装
    ./configure --prefix=/usr/local/php-7.1.11 --with-config-file-path=/alidata/server/php-7.1.11/etc --enable-fpm --with-mcrypt --enable-mbstring --enable-pdo --with-curl --disable-debug --disable-rpath --enable-inline-optimization --with-bz2 --with-zlib --enable-sockets --enable-sysvsem --enable-sysvshm --enable-pcntl --enable-mbregex --with-mhash --enable-zip --with-pcre-regex --with-mysqli --with-gd --with-jpeg-dir --with-freetype-dir --enable-calendar然后make && make install
    3. 复制源码中的php.ini和php-fpm.cnf文件并做自行调整作为配置
    4. 加入系统服务: 复制sapi/fpm/php-fpm.service到/etc.init.d/下
    
  - mysql
    1. [社区下载地址](https://dev.mysql.com/downloads/mysql)
    2. [初始化数据目录-官方手册](https://dev.mysql.com/doc/refman/5.6/en/binary-installation.html) mysql-path/script/mysql_install_db -user=` --basedir=customize-path --datadir=customize-path (5.7开始就使用mysqld -initialize程序参数一样)
    3. 配置my.cnf
    4. 加入系统服务, 复制/support/mysql.server到/etc/init.d/下 

## LAMP的独立安装
- Apache与php的通讯方式
  - fast-cgi: 即安装好Apache(yum install httpd)后,然后将请求转发给php-fpm监听的端口.httpd.conf的配置例子:
     `<FilesMatch \.php$>
        SetHandler "proxy:fcgi://127.0.0.1:9000"
      </FilesMatch>`
   - php作为Apache模块运行,简单理解就是每个Apache线程中都内置php解析器.
     [安装参考](https://www.php.net/manual/zh/install.unix.apache2.php)
     yum install httpd // 安装Apache
     yum install httpd-devel  //安装Apache的apxs工具,apxs能让你不用重新编译httpd而能安装扩展模块.  
     ./configure --with-apxs2=/usr/local/apache2/bin/apxs --with-mysql //下载php,并进入到下载目录中, 如果php需要安装其他扩展需自己加上,这个编译配置是最简的只为走通Apache和php通讯
     make && make install //安装完后,会生成libphp7.so,就是这个作为Apache模块
     在Apache的httpd.conf配置如下
     LoadModule php7_module modules/libphp7.so
     <FilesMatch \.php$>
         SetHandler application/x-httpd-php
     </FilesMatch>
     搞定
   - cgi模式:   
      
- Apache与php几种通讯方式?
  [参考比较易懂的解释](9https://blog.csdn.net/c67_dongxue/article/details/83588787)
- Apache的几种运行方式?
 一共有三种稳定的MPM（Multi -Processing Modules，多进程理模块）
  - prefork MPM:预先fork一些进程,多进程,单线程
  - worker MPM:多进程多线程,一个进程可以处理多个请求
  - event: 更worker差不多,只不过由于长连接(keep-alive)会一直占用资源,会有专门线程来处理这些长连接,允许释放这些长连接,以提高并发. 

- nginx与Apache运行方式的区别?
  - nginx是多进程单线程,他是异步I/O非阻塞的,采用epoll    
  - Apache是多进程单线程,每个连接都要一个进程,所有很难有大的并发

## nginx和php-fpm动态状态实时监视
[参考](https://blog.csdn.net/keyunq/article/details/53410569?depth_1-utm_source=distribute.pc_relevant.none-task&utm_source=distribute.pc_relevant.none-task)

## ab(http)和abs(https)性能压测工具
[参考](https://www.cnblogs.com/weizhxa/p/8427708.html)
    
## **linux上php不需要重新编译php添加扩展?**
 0. 如果你之前编译安装php的源码还在则忽略; 否则从官网下载当前安装php版本的源码
 1. 在源码的/ext下, 找到你要安装的扩展并进入, 运行phpize, 生成configure文件
 2. ./configure --with-php-config=你的php-config文件路径 
 3. make && make install
 4. php.ini引入刚生成的.so扩展文件
    
## Linux上进程崩溃或被杀退出了,能自动重启(崩溃自启动)?
使用systemd.[参考](https://www.zybuluo.com/xtccc/note/1070028)
    
## curl
- curl获取请求响应各个阶段耗时?[answer](https://stackoverflow.com/a/22625150/8714749)
`
  time_namelookup:  %{time_namelookup}s\n
  time_connect:  %{time_connect}s\n
  time_appconnect:  %{time_appconnect}s\n
  time_pretransfer:  %{time_pretransfer}s\n
  time_redirect:  %{time_redirect}s\n
  time_starttransfer:  %{time_starttransfer}s\n
  ----------\n
  time_total:  %{time_total}s\n
`
建个文件curl-format.txt, 并输入以上内容;
curl -w "@curl-format.txt" -o /dev/null -s "http://wordpress.com/"