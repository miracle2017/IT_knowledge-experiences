## 基础
- HEAD: 表示指向当前分支最新的一次提交.
- origin, master: 通常的我们会将远端仓库命名为origin(通过git remote 自定义名 地址);而新仓库第一次提交时git就会自动为你创建个master分支,通常人们会将master作为主分支.

#git 工作流程：
[教程参考](https://backlog.com/git-tutorial/cn/)
![](../../../images/git/git_flow.jpg)

##git裸仓:
>就是没有工作目录的仓库; 即是没有实际源文件,只是包含版本历史记录的仓库.
git init --bare myproject mybare.git    //获取myproject项目的版本历史记录即不包含实际源码生成一个mybare.git裸仓.(该命令
的整体效果如执行 cp -Rf my_project/.git my_project.git ,即是复制一份myproject项目下的.git文件.

#git clone --bare myproject mybare.git    
>获取myproject项目的版本历史记录即不包含实际源码生成一个mybare.git裸仓.(该命令
的整体效果如执行`-Rf my_project/.git my_project.git,即是复制一份myproject项目下的.git文件.

##对项目快速添加git版本管理: 在项目根目录中输入 git init, 在此命令之前最好有.gitignore, 这样初始化时就能把要忽略的文件忽略

##git rm --cached [-r] 文件名 
删除已经追踪的文件,然后在进行 git commit,git push 操作后就可以将文件忽略

##将本地密钥推送到服务器上：
    ssh-copy-id -i ~/.ssh/id_rsa.pub git@111.22.180.99

##添加远端地址并推送：
    git remote add origin https://github.com/miracle2017/test.git
    git push -u origin master（由于第一仓库是空的，所以要加- u，之后就不用）

##删除远端origin关联：
git remote rm origin

##自动化部署~
在裸仓目录下/hooks/post-receive 文件写入如下代码
#!/bin/bash
git --work-tree=/home/wwwroot/your_project_path checkout -f

#git撤销
- 只是提交了commit, 但是还未push.
  git reset --soft HEAD^ : 
      --soft只会撤销commit, 更改的内容不会撤销. 
      --hard会撤销commit,并丢弃修改的内容
      HEAD^的意思是上一个版本，也可以写成HEAD~1,如果进行了2次commit，想都撤回，可以使用HEAD~2.
  
# git切换分支时强制丢弃所有更改?
git checkout -f newBranchName

# git怎么在一个文件的所有历史中搜索某个字符串?[answer](https://stackoverflow.com/questions/10215197/git-search-for-string-in-a-single-files-history)
[answer](https://stackoverflow.com/questions/4468361/search-all-of-git-history-for-a-string/4472267#4472267)

# 什么是pull request(PR)?提PR流程是怎么样的?
你对一个开源项目提交代码,希望项目作者能采纳你的代码,这个动作就叫你提了PR,即请求项目作者能拉取(pull)和合并你提交的代码.
一般地想对一个开源项目AA做出代码贡献,流程大致如下: fork一份AA项目代码 -> 起个分支 -> 实现些功能 -> 向项目作者提交一个pull request -> PR通过,作者pull你的代码并合入主分支


## 常用的操作
- 怎么丢弃本地所有变更?
git reset --hard //有时候,执行这个命令后还没法清除所有变动,那么就下面的命令了
git clean -fxd