- 使用内网或外网ip访问访问接口都很快, 在本地使用域名访问也不慢, 但是部署到服务器时, 使用域名访问变得非常慢, 要几十秒?

- mysql -user=root 不用输入密码可以直接登录mysql, 为什么?

  >done. 匿名登录, mysql.user中存在一行user名为空的数值, 而如上写法登录的用户即是空的吗, 可以select current_user查看当前用户

- tp的hook的作用及使用?
  >done.
  
- phpstudy的php7.1版本在nginx下无法加载curl扩展， 其他php版本能正常加载
  重新安装新的phpstudy后解决