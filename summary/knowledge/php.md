#常用核心函数

>##字符串:
explode();

implode()/别名:join();

strlen();			获取字符串长度

mb_strlen();		获取字符串长度(可将中文字符按照一个算)

pre_replace()		替换字串  $0表示全部的匹配字串,$n?表示第n个匹配的字串

pre_match();

str_replace()		子字串替换	str_ireplace()	/忽略大小写

htmlspecialchars(); *

htmlspecialchars_decode(); *

strip_tags();

substr_count();		计算字符串出现的次数

strpos()			查找字串首次出现的位置.    stripos()	忽略大小写	strrpos() / strripos()

strrev()			反转字符串

strtr()				替换字串的字

str_split()			将字串转换为数组

substr_replace()	子字串替换

strtoupper() / strtolower()

count_char()		计算字串出现

str_pad()			补齐字串长度

字符串编码转换：

mb_convert_encoding()

iconv()

>##数组:

array_slice();		获取数组的某一部分

array_splice();		去除数组某一部分并用其他代替

array_walk();		对数组每个成员递归应用函数

array_map();		对数组每个元素都应用到回调函数

array_combine();	将一数组作为一个键,另一数组作值返回新数组

array_count_value();计算值所出现的次数

array_replace();	前面传入的数组参数如和后面的数组参数有相同则被替换

array_column();		取出数组的某一类值

array_keys();		返回数组的键值

array_values();		返回数组所有的值

array_search();		查找给定值返回首个键名

array_push();		向数组末尾压入一个或多个值

array_pop();		数组弹出最后一个值

array_shift();		移除数组开头第一个值

array_unshift();	向数组开头压入一个或多个值

array_fill();		用给定值填充数组value至给定长度

array_fill_key();	用给定的数组填充key(value值一致)

array_filter();		用回调函数过滤值

asort();

arsort():

ksort();

krsort();

range();			根据范围产生数组

extract();			提取数组中变量

>>时间:

strtotime();		将给定时间转换为时间戳

getdate();			获取一个日期信息数组

date();

time();

>>文件:

file_get_content(); 将文件读入一个字符串

file_put_content();	写入数据到文件中

>>错误处理:

error_get_last();	返回最近一次的错误

>>错误追踪

>>魔术常量:

__DIR__: 文件所在目录的绝对路径

__FILE__: 文件绝对路径

__LINE__: 所在行数

>>其他:

eval();				将字符串code作为php代码执行

PHP_EOF				换行,依据不同平台换行

goto: 可以用来跳转到程序中的另一位置

##类与对象
>###访问控制(可见性)


public的权限最大，既可以让子类使用，也可以支持实例化之后的调用，

protected表示的是受保护的，访问的权限是只有在子类和本类中才可以被访问到

private 表示的是私有，只能够是在当前的类中可以被访问到

trait关键字: 同class相似, 一种代码复用的方法,但不用像class要继承.

>###重载:

属性重载: __set(), __get(), __isset(), __unset()

方法重载: __call(), __callStatic()

>###抽象类和接口类
[参考地址1](https://blog.csdn.net/sunlylorn/article/details/6124319),
[参考地址2](https://www.jianshu.com/p/4a05c55872c3)

    //todo
    
className::class 获取一个字符串，包含了类 ClassName 的完全限定名称.(`php>5.5`新特性)

##【memcache】
    简介:
    Memcached是一种基于内存的key-value存储，用来存储小块的任意数据（字符串、对象）。这些数据可以是数据库调用、API调用或者是页面渲染的结果。
    一般的使用目的是，通过缓存数据库查询结果，减少数据库访问次数，以提高动态Web应用的速度、提高可扩展性。

>###window下安装memcache服务

下载安装包

路径\memcache.exe -d start [-p 端口号 -m 分配的内存(兆)] 开启服务(默认11211端口)

连接上服务 telnet 127.0.0.1 11211

>###window下php安装memcache扩展:

php7.0以上版本memcache的dll文件下载地址: https://github.com/nono303/PHP7-memcache-dll.git

将dll文件放入php的ext扩展目录中

在php.ini中加入类似语句 extension=php_memcache.dll引入dll文件

重启Apache并检查确认phpinfo()有无存在memcache模块

>###php连接的简单实例:
    
    $memcache = new Memcache;
    
    $memcache->connect('localhost', 11211);
    
    $memcache->set("foo", 123);


##【XHProf】(分析`PHP`性能工具)

    //todo

##【swoole扩展】
 
    学习前最好看 《linux高性能服务器编程》


>ThinkPHP使用(`version>5.1`) 

[入手好文](https://www.kancloud.cn/thinkphp/think-swoole/722895)


##【easyswoole】

[文档](https://www.easyswoole.com/Manual/3.x/Cn/_book/noobCourse/Introduction.html)

WebSocket协议是基于TCP的一种新的网络协议。它实现了浏览器与服务器全双工(full-duplex)通信——允许服务器主动发送信息给客户端。



#**收藏问题整理**

###PHP7下的协程实现
   
[参考](https://segmentfault.com/a/1190000012457145)



