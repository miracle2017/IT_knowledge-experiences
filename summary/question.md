- 使用内网或外网ip访问访问接口都很快, 在本地使用域名访问也不慢, 但是部署到服务器时, 使用域名访问变得非常慢, 要几十秒?

- mysql -user=root 不用输入密码可以直接登录mysql, 为什么?

  >done. 匿名登录, mysql.user中存在一行user名为空的数值, 而如上写法登录的用户即是空的吗, 可以select current_user查看当前用户

- tp的hook的作用及使用?
  >done.
  
- phpstudy的php7.1版本在nginx下无法加载curl扩展， 其他php版本能正常加载
  > donw 重新安装新的phpstudy后解决
  
  
- Linux中, nginx配置静态文件, 目录没有执行权限时则出现不能访问的问题?
  > done [参考](https://blog.csdn.net/caomiao2006/article/details/21701791) [参考](https://blog.csdn.net/li_101357/article/details/78391589) [参考](https://blog.csdn.net/yangcs2009/article/details/39998309)
         [参考](https://unix.stackexchange.com/questions/21251/execute-vs-read-bit-how-do-directory-permissions-in-linux-work)[参考](https://blog.csdn.net/cdu09/article/details/10310103)
         
- ajax中的success函数中怎么使用到外部变量, 又怎么将结果赋值给外部变量?    
  > 藐视没有问题中问题
  
- 访问页面时, nginx超时, php还会继续执行吗?
  >php进程还会继续执行直到任务完成
  
- 从官网拉取的easyswoole框架无法使用路由访问?
