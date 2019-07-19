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

- array_merge($array1, ...$array2); 合并数组,相同键值后面的覆盖前面的,包含数字的索引不会覆盖而是会附上

- array_combine(array $keys, array $values);	将一数组作为一个键,另一数组作值返回新数组

- array_column($array, $column_key  [, $index_key]);	 从多维数组中取出指定的一列值

- array_replace($array, ...$array1);   后面的数组有和第一数组key名一样的,value则被后面的替换,后面有前面没有的key,则在第一数组中创建. 后一个数组会覆盖前面的. 返回替换后的数组

- array_keys($array [, $search_value [, bool $strict]]);		返回数组的键值

- array_values($array);	返回数组所有的值

- array_search($needle, $haystack [, $strict]); 查找给定值返回**首个匹配**键名

- array_push(&$array, ...$var);		向数组末尾压入一个或多个值, 增加一个元素更推荐 $array[] = $var, 这个更快

- array_pop(&$array);		数组弹出最后一个值

- array_shift(&$array);		移除数组开头第一个值

- array_unshift(&$array, ...$var);	向数组开头压入一个或多个值

- array_fill($start_index, $num, $value);	用给定值填充数组value至给定长度

- array_fill_key(array $keys, $value);	用给定的数组填充key, 而对应的value值都是一致的

- asort(&$array [, $sort_flags]);   保留索引对数组从低到高排序

- arsort(&$array [, $sort_flags]):     保留索引对数组从高到低排序

- ksort(&$array [, $sort_flags]);    按照键值从低到高排序   

- krsort(&$array [, $sort_flags]);   按照键值从高到低排序

- array_filter($array, $callback, $flag);	遍历数组中每个值,用回调函数过滤值(回调函数true的该值留下)

- array_walk(&$array, $funcname [, $userdata]); 	对数组每个成员递归应用函数,如果有设置$userdata则作为第三个参数传入

- array_map(callback, ...$array1);		对数组每个数组的元素都应用到回调函数, 函数的形参必须是 $array1, $array2

- array_flip($array);    反转数组键值,即返回一个键和值对换的数组,  array_flip(array_flip($array)); 翻翻法数组去重, 时间和内存
都比 array_unique($array) 少

- array_sum($array); 对数组中所有值求和

- array_product($array);  对数组中所有值求乘积

- array_count_value($input:array);  返回一个输入数组的值为键名,总的出现次数为值的数组

- range($start, $end, float $step);		根据范围产生一个数组值从$start开始至于$end,步进为$step

- var_export($var, true);  返回变量的字符串表示

- extract($var_array, $extract_type, $prefix);	提取数组中变量

- count(array|object $array [, $mode]); 计算数组(或可计算var)长度, $mode=1时则为递归计算

>##时间:

- date(string $format [, int $timestamp | time()]);   返回时间格式
 
- **strtotime($time [, $now = time()])**;  将英文时间字符串转换为时间戳, $now为计算相对时间的基准时间
           
       支持的英文:  
       
           this, last, previous, next,
           
           first, second, third ... twelfth
           
           sunday, monday, ... saturday
           
           week(s), weekday(s) ...
       
       例子:
       
            strtotime('+1 week 2 days 4 hours 2 seconds')
            
            strtotime('this week Monday') 
            
            strtotime('last week Monday')
            
            strtotime('third Sunday 2018-6')

            

- time(); 返回当前的UNIX时间戳

- getdate();			获取一个日期信息数组

>##文件:

- file_get_content(); 将文件读入一个字符串

- file_put_content();	写入数据到文件中

- unlink('path/name'): 删除文件

- glob('/*.txt'): 查找出所有与模式匹配的路径名, 返回一个数组

>##错误处理:

- error_get_last();	返回最近一次的错误

>##错误追踪

    todo
    
>##魔术常量:

    __DIR__ : 文件所在目录的绝对路径
    
    __FILE__ : 文件绝对路径, 文件完整路径加文件名
    
    __LINE__ : 所在行数
    
    __FUNCTION__ : 函数名

>##其他:

- rand($min, $max); 产生一个在[$min, $max]闭区间随机数

- eval();				将字符串code作为php代码执行

- PHP_EOF				换行,依据不同平台换行

- goto: 可以用来跳转到程序中的另一位置

- get_defined_vars(); 获取所有已经定义的变量

- get_declared_classes(); 获取已经定义的类

- 反单引号作用: 直接执行服务器的系统命令 ` echo "<pre>". `ipconfig` . "</pre>";` 前提shell_exec()函数被允许

##类与对象
>###访问控制(可见性)

public的权限最大，既可以让子类使用，也可以支持实例化之后的调用，

protected表示的是受保护的，访问的权限是只有在子类和本类中才可以被访问到

private 表示的是私有，只能够是在当前的类中可以被访问到

trait关键字: 同class相似, 一种代码复用的方法,但不用像class要继承.

>###重载:

- 属性重载: __set(), __get(), __isset(), __unset()

- 方法重载: __call(), __callStatic()

>###抽象类和接口类
- [参考地址1](https://blog.csdn.net/sunlylorn/article/details/6124319),
- [参考地址2](https://www.jianshu.com/p/4a05c55872c3)

- 抽象类 abstract class

    - 定义为抽象的类不能被实例化(子类必须实现全部的抽象后才能实例化,不然还是抽象类)。任何一个类，如果它里面至少有一个方法是被声明为抽象的，那么这个类就必须被声明为抽象的。被定义为抽象的方法只是声明了其调用方式（参数），不能定义其具体的功能实现。
    
    - 继承一个抽象类的时候，**子类必须定义父类中的所有抽象方法**；另外，**这些方法的访问控制必须和父类中一样（或者更为宽松）**。例如抽象方法被声明为protest, 那么子类不能是更加严厉的private的, 而必须是声明为同样的protest或更为宽松的public。        
    

- 接口类 interface class

    - 使用接口（interface），可以指定某个类必须实现哪些方法，但不需要定义这些方法的具体内容。
    
    - 接口是通过 interface 关键字来定义的，就像定义一个标准的类一样，但其中定义所有的方法都是空的。
    
    - **接口中定义的所有方法都必须是公有，这是接口的特性。**
    
    - 要实现一个接口，使用 implements 操作符。**类中必须实现接口中定义的所有方法**，否则会报一个致命错误。**类可以实现多个接口，用逗号来分隔多个接口的名称**。(实现多个接口时，接口中的方法不能有重名。)
     
    - 接口也可以继承，通过使用 extends 操作符
    
    - 接口中也可以定义常量。接口常量和类常量的使用完全相同，但是不能被子类或子接口所覆盖。(将常量变量放在 interface 中违背了其作为接口的作用而存在的宗旨，也混淆了 interface 与类的不同价值)
    
>###新特性

- 标量类型声明之可为空（Nullable）类 

    传入参数或返回值类型前加上`?` 表示要么是给定类型或者null(如果没有设置`?` 传入null会报错); 即是可以为传入和传出null . 例如  function test(?int param): ?array  { //todo}

- 函数传入不确定个数的参数(使用`...`)

    function demo(...$params){
        var_dump($params); //会是一个传入参数的数组
    }

- className::class 获取一个字符串，包含了类 ClassName 的完全限定名称.(`php>5.5`新特性)

##【xdebug】

- window上

  1. [超快速简单安装指导](https://xdebug.org/wizard.php)
  
  2. 常规配置
              
         xdebug.profiler_append = 0
         xdebug.profiler_enable = 1
         xdebug.profiler_enable_trigger = 0
         xdebug.profiler_output_name = "cache.out.%t-%s"
         xdebug.remote_enable = 1
         xdebug.remote_mode = "req"
         xdebug.remote_handler = "dbgp"
         xdebug.remote_host = "127.0.0.1"
         xdebug.remote_port = 9100
         xdebug.idekey="PHPSTORM"
         xdebug.remote_autostart = no
         xdebug.auto_trace = 0
    


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

##【swoole扩展】
 
    学习前最好看 《linux高性能服务器编程》


>ThinkPHP使用(`version>5.1`) 

[入手好文](https://www.kancloud.cn/thinkphp/think-swoole/722895)


##【easyswoole】

[文档](https://www.easyswoole.com/Manual/3.x/Cn/_book/noobCourse/Introduction.html)

WebSocket协议是基于TCP的一种新的网络协议。它实现了浏览器与服务器全双工(full-duplex)通信——允许服务器主动发送信息给客户端。


##php缓存技术
[参考https://www.cnblogs.com/godok/p/6341300.html](https://www.cnblogs.com/godok/p/6341300.html)
[参考https://juejin.im/entry/5c871001e51d4539a756f734](https://juejin.im/entry/5c871001e51d4539a756f734)

>缓存函数
 - ob_flush(): 把当前缓存写入到上级缓存, 如果用了一个ob_start(), 那么上级就是Apache, 或者nginx
 - flush(): 将Apache缓存写入到浏览器中, nginx要做些参数配置才能实现相应的效果

- ###opcache使用
  >[参考https://blog.csdn.net/u011250882/article/details/49431053](https://blog.csdn.net/u011250882/article/details/49431053)
  >
  - window上
    [参考https://blog.csdn.net/xgocn/article/details/86669091](https://blog.csdn.net/xgocn/article/details/86669091)

##php性能分析
[参考](https://segmentfault.com/a/1190000003895734)

- webgrind(Xdebug分析的前端, 即是将Xdebug产生的cache.out文件显示出来)

  [参考](https://github.com/jokkedk/webgrind)

- XHProf(分析`PHP`性能工具)

  [参考](https://learnku.com/laravel/t/3142/php-performance-tracking-and-analysis-tool-xhprof-installation-and-use)
  [参考](http://www.voidcn.com/article/p-zdxrjwwb-bou.html)
  
- wnidow上

  [tideway-xhprof-extension下载](https://ci.appveyor.com/project/tideways/php-profiler-extension)
  
    //todo
    
##MongoDB

- window上
  [mongodbzaiwindow安装参考](https://www.mongodb.org.cn/tutorial/55.html)
  [phpmongodb驱动参考](https://www.php.net/manual/zh/mongodb.installation.windows.php)
  
- linux上

  //todo  
  

##实现session分布式

- php.ini中设置session.handler将session存在redis， mysql等上面

#**收藏问题整理**

###PHP7下的协程实现
   
[参考](https://segmentfault.com/a/1190000012457145)
