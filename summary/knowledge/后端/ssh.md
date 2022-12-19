- 配置登录服务器快捷命令?
```shell
#编辑~/.ssh/config
#跳板
Host j
    HostName 跳板机ip
    Port 端口
    User 用户名

#需要经过跳板机才能登录的机器
Host my_server
    HostName 66.66.66.66
    Port 36000
    User 用户名
    ProxyCommand ssh j -W 66.66.66.66:36000
#配置好后,就可以用以下命令快捷登录了
ssh my_server
```

- 使用指定密钥ssh登录?
  - [参考](https://help.aliyun.com/document_detail/51798.htm?spm=a2c4g.11186623.0.0.294a5192J4jwKu#concept-ucj-wrx-wdb)
```ssh -i ./.ssh/指定的密钥地址 username@ip```
也可以配置快捷方式
```shell
#编辑~/.ssh/config
Host my
    HostName 服务器ip
    Port 端口
    User 用户名
    IdentityFile ~/.ssh/指定的私钥
#之后你就你这样登录
ssh my
```