#常用核心函数

>##字符串:
- explode($delimiter, $string);       按照某个字符分割字符成数组

- str_split($strin, $split_length:int):	按照固定长度将字串分割成数组

- preg_split():   按照正则作为分割符分割字串成数组

- implode()/别名:join();

- strlen();			获取字符串长度

- mb_strlen();		获取字符串长度(可将中文字符按照一个算)

- pre_match('/正则/', $string [,$match]) / pre_match_all() ; $match[0]为完整模式的所有匹配(pre_match_all会是一个二维数组), $match[1]为第一个子组的所有匹配(pre_match_all也是一个二维数组)   

- preg_replace('/正则/', $replacement, $subject)		替换字串  $0表示全部的匹配字串,$n?表示第n个匹配的字串

- str_replace()		子字串替换	str_ireplace()	/忽略大小写

- strtr()		    替换字串的字

- substr_replace()	子字串替换

- htmlspecialchars(); *

- htmlspecialchars_decode(); *

- strip_tags($string [, $allow_tags]);       删除html和php的标签符号, 标签符号中的内容还在,始终会脱离html的注释     

- strpos()			查找字串首次出现的位置.    stripos()	忽略大小写	strrpos() / strripos()

- strstr($haystack, $needle [, $before_needle:bool]):   返回子字符第一在住字符串中匹配到的位置到字符串结束的所有字符, $before_needle为true时则返回前面一部分. stristr()大小写不敏感

- substr($string, $start, $length);     截取字符串

- strrev()			反转字符串

- strtoupper() / strtolower()

- substr_count();		计算字符串出现的次数

- count_char()		计算字串出现

- str_pad()			补齐字串长度

字符串编码转换：

- mb_convert_encoding($string, $to_encoding [, $from_encoding]) : 例如 mb_convert_encoding($string, 'UTF-8', 'GBK');

- iconv($in_charset, $out_charset, $string):  例如iconv('UTF-8', 'GBK', $string);


>##数组:

- array_slice($array, $offset  [, $length, $prserve_keys]);       获取数组的某一部分

- array_splice(&$input, $offset, [$length, $replacement]);  去除数组某一部分并用其他代替,变种出$replacement为空就是**删除某部分元素**, $length为空就是**单纯的向数组中增加元素**

- array_combine(array $keys, array $values);	将一数组作为一个键,另一数组作值返回新数组

- array_count_value($input:array);  返回一个输入数组的值为键名,总的出现次数为值的数组

- array_column($array, $column_key  [, $index_key]);	 从多维数组中取出指定的一列值

- array_replace($array, ...$array1);   后面的数组有和第一数组key名一样的,value则被后面的替换,后面有前面没有的key,则在第一数组中创建. 后一个数组会覆盖前面的. 返回替换后的数组

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

array_walk();		对数组每个成员递归应用函数

array_map();		对数组每个元素都应用到回调函数

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
    

###新特性

标量类型声明之可为空（Nullable）类 

    传入参数或返回值类型前加上`?` 表示要么是给定类型或者null(如果没有设置`?` 传入null会报错); 即是可以为传入和传出null . 例如  function test(?int param): ?array  { //todo}

函数传入不确定的参数(使用`...`)

    function demo(...$params){
        var_dump($params); //会是一个传入参数的数组
    }

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



