##【基本指令】:

    man 命令: 查看某个命令的在线文档
    
    pwd -LP: 显示出当前文件路径(完整的) 后面不加参数时是有些会是不完整的。
    
    sync : 关机或者重启,首先要执行此命令将内存的数据存储到磁盘中
    
    cd:
       cd ..返回前一个目录
       cd ~ 主目录
       cd - 上次工作的目录
       
    tar: 
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
        tar -xzf file.tar.gz //解压tar.gz
    
    cp [-r] /home/a/目标文件  /home/b   带-r为复制目录
    
    scp 安全复制,可以跨服务器
    
    mv ./a.txt ../b/    复制文件也用于重命名
    
    rm 删除文件
    
    chmod -R 777 文件名    修改文件权限
    
    chown -R git:git    修改文件的所属者
    
    mysql -uroot -p  登录mysql数据库
    
    service nginx restart  重启nginx
    
    service php-fpm restart  重启php
    
    crontab    定时任务
    
    free [-h|-m|-g] 查看运行内存，-h方便人阅读自动调整单位, -m以M为单位, -g以G为单位
    
    top [-b|显示全部进程] [-n number|显示数据刷新次数] 查看进程 （按下1看cpu情况， 默认以cpu列排序,shift + < > 左右切换排序的列
    
    du -sh: 当前文件夹的大小, -h为自动调整人便于阅读的单位
    
    chatter [-R] (+|-|=)(A|S|a|c|D|d|I|i|j|s|T|t|u): 对文件属性的更改
    
    lscpu: 查看系统的一些信息
    
    ll /proc/进程id : 查看进程具体信息
    
    netstat [参数]:  如netstat -ap | grep 9501
        -a: 全部
        -p: 建立相关链接的程序名及进程号
        

    ctrl + z： 挂起
    
    ctrl + c： 终止
    
    ctrl + \: 退出
    
    ctrl + r: 历史命令搜索
    
    ctrl + u: 当前位置删除到行首
    
    strl + a/e : 光标移到行首/行尾
    
    tab: 自动补全
    
    mkdir: 创建文件夹
    
    wget url地址: 下载文件, 支付http(s),ftp协议

    Linux下的vi编辑器基本操作:
    
    i 进入插入,模式
    
    esc + :(冒号) 进入命令行模式
    
    wq保存并退出
    
    u： 撤销
    ctrl + r： 反撤销
   
   
    su root:服务器上切换用户, su(switch user)

    useradd 用户名  ：Linux下添加一个用户同时会在home下生成一个用户名的目录
    userdel -r 用户名  ：删除Linux用户，包含home下的用户目录， 不加-r 则只是删除用户名不会删除home下的用户目录

    linux参数前 - 和 -- 区别: - 后接单字符
    路径之间的 : 冒号做分隔符,分隔多个路径   
    
    【防火墙】
        firewall-cmd --zone=public --add-port=3306/tcp --permanent  //永久开放某个端口
        firewall-cmd --list-all     //查看所有开放的端口
        firewall-cmd --reload   //重载
        systemctl status/restart/stop firewalld.service   // 状态/重启/停止防火墙服务
        
    【linux命令行快捷键，或叫配置环境变量】
        方一(配置环境变量): vi ~/.bash_profile 可以看到 PATH=$PATH:$HOME/bin, 这个就是配置环境变量,在后面新增即可, 路径间用 : 冒号
        方二(使用别名):  vi ~/.bashrc    增加例如 alias mv='mv -i' 这样的格式,不重启立即生效 source ~/.bashrc
        
    【linux修改配置文件不重启立即生效】如修改 ~/.bash_profile文件, 那么 .  /~/.bash_profile  或者 source ~/.bash_profile 即可 (source 又称点命令) 
          可以使用 alias 列出所有的别名
      

##【nginx】

    
    重新nginx配置文件(不停服)
    
    /usr/local/nginx/sbin/nginx -t  :检测配置文件的语法正确性(很总要)
    
    /usr/local/nginx/sbin/nginx -s reload  :重新加加载配置文件(-s有stop的意思)

##【网站压力测试】
    Apache自带强大网站测试工具：ab
        常用用法： 进入Apache的ab.exe(用于请求http,而abs.exe用于请求https)文件所在目录  打开命令行 ab -n 1000 -c 200 http://www.baidu.com
        (-n 请求总数量, -c并发数)

##【PHP-FPM】
    Nginx 是非阻塞IO & IO复用模型，通过操作系统提供的类似 epoll 的功能，可以在一个线程里处理多个客户端的请求。
    Nginx 的进程就是线程，即每个进程里只有一个线程，但这一个线程可以服务多个客户端。

    PHP-FPM 是阻塞的单线程模型，pm.max_children 指定的是最大的进程数量，pm.max_requests 指定的是每个进程处理多少个请求后重启(因为 PHP 偶尔会有内存泄漏，所以需要重启).
    PHP-FPM 的每个进程也只有一个线程，但是一个进程同时只能服务一个客户端。

