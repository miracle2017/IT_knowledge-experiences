## redis在命令行中设值,value太大命令行粘贴不了复制的全部内容? value从文件读取! [answer](https://stackoverflow.com/a/47368673/8714749)
cat file | redis-cli -h host -p port -x SET key