- 使用内网或外网ip访问访问接口都很快, 在本地使用域名访问也不慢, 但是部署到服务器时, 使用域名访问变得非常慢, 要几十秒?

- mysql -user=root 不用输入密码可以直接登录mysql, 为什么?
  >done. mysql不加任何参数可匿名登录, mysql.user中存在一行user名为空的数值, 而如上写法登录的用户即是空的, 可以select current_user查看当前用户

- tp的hook的作用及使用?
  >done.
  
- phpstudy的php7.1版本在nginx下无法加载curl扩展， 其他php版本能正常加载
  > done 重新安装新的phpstudy后解决
  
  
- Linux中, nginx配置静态文件, 目录没有执行权限时则出现不能访问的问题?
  > done [参考](https://blog.csdn.net/caomiao2006/article/details/21701791) [参考](https://blog.csdn.net/li_101357/article/details/78391589) [参考](https://blog.csdn.net/yangcs2009/article/details/39998309)
         [参考](https://unix.stackexchange.com/questions/21251/execute-vs-read-bit-how-do-directory-permissions-in-linux-work)[参考](https://blog.csdn.net/cdu09/article/details/10310103)
         
- ajax中的success函数中怎么使用到外部变量, 又怎么将结果赋值给外部变量?    
  > 藐视没有问题中的问题
  
- 访问页面时, nginx超时, php还会继续执行吗?
  >php进程还会继续执行直到任务完成
  
- 从官网拉取的easyswoole框架无法使用路由访问?
  > 引入psr4, 没有composer dump, 具体见自己blog

- tp5数据库操作的find()方法传入参数具体怎么使用?
  > 例如find(1)即是直接查找主键为1的数据
  
- window上连接mysql很慢? 
  默认的, mysql会进行反向解析域名(ip -> 域名), 解析不到时要等待1s的超时.解决办法:
  1. 在host上加上127.0.0.1 localhost
  2. 在mysql的配置文件中加上如下内容, 表示禁用dns解析, 但是不推荐, 这样之后就无法使用域名, 只能用ip替换之
      [mysqld]
      skip-name-resolve
      
- git版本发布流程, 怎么发布版本和二进制?

- window下nginx+php无法并发,一次只能处理一个请求?
  因为用phpstudy,php-cgi.exe进程他只有一个,所以他同时只能同时处理一个请求.解决如下:
  nginx上 
  fastcgi_pass = 127.0.0.1:9000
  fastcgi_pass  = 127.0.0.1:9001
  php上,进入php目录,打开cmd,自己手动开启php-cgi进程监听不同端口
  path/to/php-cgi.exe -b 127.0.0.1:90001 -c path/to/php.ini

- php存储session的格式是长什么样的,和cookie是怎么配合运行流程? 怎么具体实现session共享? session是怎么回收的?  
session的文件名字为一个md5串,内容为经过序列化的。cookie上的存着session id其实也就是对应服务端上session的文件名。