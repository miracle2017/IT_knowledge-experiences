[完善的纯中文版手册](https://php.golaravel.com/)

#变量类型(共9中原始数据类型)

- 四种标量类型
  1. boolean(布尔型)
  2. integer(整型)
  3. float(浮点型, 也称为double, 实际上float和double是相同的, 由于历史两个名称同时存在) 
  4. string(字符串)

- 三种复合类型
  5. array(数组)
  6. object(对象)
  7. callable(可调用)
  
- 两种特殊类型
  8. resource(资源)
  9. NULL(无类型)

#常用核心函数

>##变量处理

- isset($var, [...$_]); 检测变量是否已设置并且非 NULL

- empty($var); 判断一个变量是否被认为是空的(false, 0, "0", null, "", 0.0, array(), 没有被赋值的变量); 当变量不存在, 不会产生警告

- is_null($var); 检测变量是否为 NULL, 变量不存在时会产生一个notice

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

- mkdir(); 第三个参数为true可创建多级目录

>##错误处理:

- error_get_last();	返回最近一次的错误

>##错误追踪

    todo
    
    debug_print_backtrace(); 打印一条回溯。
    debug_backtrace();  产生一条回溯跟踪(backtrace)
    
>##魔术常量:

    __DIR__ : 文件所在目录的绝对路径
    
    __FILE__ : 文件绝对路径, 文件完整路径加文件名
    
    __LINE__ : 所在行数
    
    __FUNCTION__ : 函数名
    
>##正则 PCRE
   [官方文档](https://www.php.net/manual/zh/reference.pcre.pattern.syntax.php)

>##其他:

- rand($min, $max); 产生一个在[$min, $max]闭区间随机数

- eval();				将字符串code作为php代码执行

- PHP_EOF				换行,依据不同平台换行

- goto: 可以用来跳转到程序中的另一位置

- get_defined_vars(); 获取所有已经定义的变量

- get_declared_classes(); 获取已经定义的类

- 反单引号作用: 直接执行服务器的系统命令 ` echo "<pre>". `ipconfig` . "</pre>";` 前提shell_exec()函数被允许

- socket函数(用php监听ip+端口)
  
  - 应用demo
  [用php实现一个动态web服务器](https://segmentfault.com/a/1190000003029173)
  
- streams

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

  1. [超快速简单详细的安装指导](https://xdebug.org/wizard.php)
  
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
         
- linux上

  1. [超快速简单详细的安装指导](https://xdebug.org/wizard.php)
  
  2. 配置
  
         zend_extension=xdebug.so
         xdebug.remote_enable=1
         ;如果remote_connect_back(推荐开启这个)没有开启,就要开启remote_host=(你phpstorm端电脑的ip地址), 这个只能指定一个触发, 多人用时还是推荐前者, 比较智能
         xdebug.remote_connect_back=1
         ;Linux机器上的端口注意不要和Linux上的程序端口冲突了, phpstorm的端口需要和这一样
         xdebug.remote_port=9100
         ;在每次请求带上?XDEBUG_SESSION_START=PHPSTORM即可触发, 或者使用谷歌xdebug插件(他做的就是在每次请求时cookie带上XDEBUG_SESSION_START参数,比较省事), 又或者开启remote_autostart=1(每次请求都会触发)
         xdebug.idekey="PHPSTORM"
         xdebug.remote_log="/usr/local/php/var/log/xdebug_remote.log"
 
    
 ##【Composer】
  
 - ###安装
 
    - Linux
        //安装composer
        php -r "copy('https://install.phpcomposer.com/installer', 'composer-setup.php');"
        php composer-setup.php
        //移动到/usr/local/bin/下并命令为composer, 之后就在全局中使用composer命令
        mv composer.phar /usr/local/bin/composer
        //使用阿里云镜像
        composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/
        //更新composer
        composer selfupdate


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

- 附录:好文
  - [php多进程模型](https://easyswoole.oss-cn-shenzhen.aliyuncs.com/入门教程1/php多进程模型.pdf)

##php缓存技术
[参考https://www.cnblogs.com/godok/p/6341300.html](https://www.cnblogs.com/godok/p/6341300.html)
[参考https://juejin.im/entry/5c871001e51d4539a756f734](https://juejin.im/entry/5c871001e51d4539a756f734)

- ###内置缓存
  >缓存函数
  - ob_flush(): 把当前缓存写入到上级缓存, 如果用了一个ob_start(), 那么上级就是Apache, 或者nginx
  - flush(): 将Apache缓存写入到浏览器中, nginx要做些参数配置才能实现相应的效果

- ###opcache使用
  >[参考https://blog.csdn.net/u011250882/article/details/49431053](https://blog.csdn.net/u011250882/article/details/49431053)
  >
  - window上
    [参考https://blog.csdn.net/xgocn/article/details/86669091](https://blog.csdn.net/xgocn/article/details/86669091)

- ###nginx配置静态缓存
  
  例如: 
  location ~ \.(img|jpg)$ {
      expires 1d;   //比如缓存1天, 但是如果文件有更改时, 浏览器则会重新下载
  } 
  

- tp5使用消息队列
[参考](https://www.kancloud.cn/yangweijie/learn_thinkphp5_with_yang/367645)


##php性能分析
[参考](https://segmentfault.com/a/1190000003895734)

- webgrind(Xdebug分析的前端, 即是将Xdebug产生的cache.out文件显示出来)

  [参考](https://github.com/jokkedk/webgrind)

- XHProf(分析`PHP`性能工具)
  
  >介绍:　xhprof是一个开源的,但是不兼容php7以上, 且不再维护. tideway的xhprof_extension分析器可以使用php7及以上, 结合xhgui开源免费的图形界面进行分析(tideway也提供了图形界面但是收费, 故我们用xhgui代替) 
  
    
  [参考](https://learnku.com/laravel/t/3142/php-performance-tracking-and-analysis-tool-xhprof-installation-and-use)
  [参考](http://www.voidcn.com/article/p-zdxrjwwb-bou.html)
  
- wnidow上

  1. 下载及安装[tideway-xhprof-extension的window版本下载](https://ci.appveyor.com/project/tideways/php-profiler-extension)
      [项目github地址](https://github.com/tideways/php-xhprof-extension)
  2. 从github上拉取xhgui项目
  3. - 安装mongodb(xhgui基于它实现的)
     - 安装php mongodb扩展
     
- linux上     
     
    //todo
    
##MongoDB

- window上
  [mongodbzaiwindow安装参考](https://www.mongodb.org.cn/tutorial/55.html)
  [phpmongodb驱动参考](https://www.php.net/manual/zh/mongodb.installation.windows.php)
  
- linux上

  //todo    

##实现session分布式

- php.ini中设置session.handler将session存在redis， mysql等上面


##php.ini文件配置

[完善的纯中文版手册](https://php.golaravel.com/)
[核心配置官网](https://www.php.net/manual/zh/ini.core.php)
[配置选项列表官网](https://www.php.net/manual/zh/ini.list.php)

##php爬虫

- 使用curl模拟登录后获取cookie进行爬去其他页面 

[参考](http://www.voidcn.com/article/p-rcxgdvsy-xe.html)
[参考](https://www.cnblogs.com/wangluochong/p/9849647.html)

- Guzzle(php http client)

   [中文文档](https://guzzle-cn.readthedocs.io/zh_CN/latest/overview.html)
   [git文档](https://github.com/guzzle/guzzle)

- php异步执行的几种方法(不阻塞后续执行)?

[参考:PHP非阻塞模式](http://www.4wei.cn/archives/1002336) 

  - 1.提前结束会话
    - FastCGI模式下, 使用fastcgi_finish_request()函数能马上结束会话
    
      - 注意: fastcgi_finish_request官方介绍页面下的评论提出需要注意的点[链接](https://www.php.net/manual/zh/function.fastcgi-finish-request.php)
        正常脚本结束时php会自动调用session_write_close()函数, 而脚本在处理中的时候占用者session锁,对于后续请求来说是阻塞的.所以要尽快手动调用session_write_close()结束并保存session数据. 这对于其他有竞争锁情况同样适用,没有用了要尽快释放
        
    - 一般模式下(如Apache, Nginx, FastCGI(直接使用fastcgi_finish_request()更方便等), 提前输出内容, 结束会话
      
      <?php
      //适用于大多数运行模式(不包括命令行模式)
      set_time_limit(0);  //设置不限执行时间
      ignore_user_abort(true);  //忽略客户端中断
      //nginx等可能需要达到4k才会输出buffer,所有先输出一些空字符串
      $str = str_repeat(' ', 65536);
      $str .= '立即输出' . date('Y-m-d H:i:s');
      #header('X-Accel-Buffering: no');   // 关闭加速缓冲, 在nginx模式需要开启此行
      header("Content-Type: text/html;charset=utf-8");
      header("Connection: close");//告诉浏览器不需要保持长连接
      header('Content-Length: '. strlen($str));//告诉浏览器本次响应的数据大小只有上面的echo那么多
      ob_end_flush();
      ob_start();
      echo $str;
      ob_flush();
      flush();
      //至此,连接已经关闭. 但是进程还不会结束, 以下程序还能运行但不会输出
      sleep(10);
      file_put_contents('./log.txt', '10s后我写入log文本: 时间' . date('Y-m-d H:i:s'));
      
      - 注意: 在以下情况中,该方法失效:无论那个模式,gzip一定要关闭; 是window32下web服务不行;   [官方说明](https://www.php.net/manual/zh/function.flush.php)
      
        个别web服务器程序，特别是Win32下的web服务器程序，在发送结果到浏览器之前，仍然会缓存脚本的输出，直到程序结束为止。
        
        有些Apache的模块，比如mod_gzip，可能自己进行输出缓存，这将导致flush()函数产生的结果不会立即被发送到客户端浏览器。
      
      
  - 2.请求子进程网址, 不等待返回结果
    - fsockopen打开一个网络连接或者一个Unix套接字连接, 忽略返回结果(不等待返回结果)
    - curl 设置超时时间为1s, 忽略返回结果(不等待返回结果,直接超时,但最短要1s)
  
  - 3.开启子进程(确保以下函开启异步子进程数没有被禁用)
    - popen 
      >[官方介绍链接](https://www.php.net/manual/zh/function.popen.php): 打开一个指向进程的管道，该进程由派生给定的command命令执行而产生。他是单向的(只能用于写或读)
      
      - 例子1 (不等待子进程返回结果直接结束父脚本)
      <?php
      ini_set('date.timezone', 'Asia/shanghai');
      echo "父脚本开始\n";
      echo date('Y-m-d H:i:s') . "\n";
      //&: 转入后台运行; nohup:不挂断地运行命令, 防止当前的终端窗口被关闭后导致进程结束
      $cmd = 'nohup php cmd.php &';
      pclose(popen($cmd, 'r'));//开启一个子进程后马上关闭, 子进程进入后台处理耗时的处理
      echo "父脚本结束";
       
      - 例子2 (等待子进程返回结果在结束父脚本)
      <?php
      ini_set('date.timezone', 'Asia/shanghai');
      echo "父进程开始\n";
      echo date('Y-m-d H:i:s') . "\n";
      $cmd1 = 'nohup php cmd.php &';
      $cmd2 = 'nohup php cmd1.php &';     
      //执行耗时异步任务1
      $p1 = popen($cmd1, 'r');
      //执行耗时异步任务2, 与任务1是并行运行的
      $p2 = popen($cmd2, 'r');
      register_shutdown_function(function () use ($p1, $p2) {
          $res1 = stream_get_contents($p1);
          echo $res1;
          $res2 = stream_get_contents($p2);
          echo $res2;
          pclose($p1);
          pclose($p2);
          echo "父脚本结束" . date('Y-m-d H:i:s') . "\n";
      });
      
    - proc_open 开启异步子进程
      >与popen()一样, 只是该函数有更强的控制程序执行的能力, 可以双向(读又写)
      >参考例子(https://my.oschina.net/eechen/blog/745504)
      
    - pcntl_fork 需要扩展支持较麻烦
      
  - 4.借助框架如swoole等
  
#**收藏问题整理**

###PHP7下的协程实现 
   
[参考](https://segmentfault.com/a/1190000012457145)

