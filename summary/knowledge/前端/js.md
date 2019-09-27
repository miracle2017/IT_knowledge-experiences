##字符串属性:

- length 	返回字符串的长度

- indexOf() / lastIndexOf() 返回字符串中检索指定字符第一次出现的位置,不存时则返回空,数组也可以使用. 查找最后一次的位置: lastIndexOf()

- serach(RegExp或字符串)  返回第一个匹配的位置,没有则返回-1

- match('字符串' | /正则/)   找到一个或多个(正则有g时)正则表达式的匹配 (val | RegExp) 存在则返回具体的值,不存在时则返回空

- replace(sercValue: string｜RegExp , replaceValue)  替换与正则表达式匹配的子串

- slice(star[包含], end[不包含,省略则是截取到末尾] ) 提取字符串的片断，并在新的字符串中返回被提取的部分.

- substr(start [, length]);   截取字符串,从下标start开始的length长的字符

- substring(start, stop);     返回一个下标从start到stop-1的字符串

- Array.prototype.slice.call(obj [,start[,end]])  将具有长度的对象转换为数组

- split(separator,limit[可选,限制返回结果的长度])  把字符串分割为子字符串数组

- newstr = str.concat(str1,str2...);     连接多个字符串返回新字符串


##数组

- join(separator)：将数组的元素组起一个字符串，以separator为分隔符，省略的话则用默认用逗号为分隔符

- arr.splice(index[开始位置,包含],  deleteCount[删除几个,没填则从包含index删到尾], new1,new2..[可选,如果是数组那么,这项就是数组])  返回被删除的元素,会改变数组

- arr.slice(start, end);   返回一个从arr下标start到end-1的新数组

- **newarr = arr.concat(arr1,arr2, 数字, 字符串)**   将多个两个或多个数组连接起来,返回新数组
newstr = str.concat(str1,str2...)            连接多个字符串返回新字符串

- array.forEach(function(currentValue, index, arr[本身]), thisValue[this指向哪,没有写则undefined传给this])   用于遍历数组,for in用于遍历对象,数组也可以 ;值返回undefined

- array.map(function(currentValue, index, arr), thisValue) 同上 区别:map返回新数组

- arr.reverse(); 颠倒数组中元素的顺序

##基础

- js数据类型: String, Number, Boolean, Array, Object, Null, Undefined
        
      js中一切皆对象.除了Null, Undefined,其他都是对象
    
   >原始类型: Undefined, Null, Boolean, Number, String, symbol  (可以直接改变数值)
      
   >引用类型: Object: Array, Date, Function (对象作为参数传入到函数是引用参数,而原始类型是传值参数,函数内部的改变数值不会影响到外部;此外如果是全局变量在函数内部是会被改变)

- 相等号==中,如果有一边不是数字,会先转化为数字    例子: true == 1 , null == undefined  返回 true  null与undefined 在和其他判断相等时都不会转化为数字,所以都是false,不过两者是相等

*逻辑与（a && b）, 如果其中一个参数不是boolean,则a转为布尔后true则返回 b的值,false时,则返回a(没有经过布尔转换的值)  2个变量中有 null, undefined, NaN都会返回相应的 null,undefined,NaN
* a || b  其中一个不是布尔时,a转化为布尔为false时则返回b,反之返回a.

*typeof(变量) 返回的是字符串形式,typeof 1 == "number" 返回的名称都是小写
 
*debugger  停止执行JavaScript,如果没有调试可用,debugger 语句将无法工作。

* **对象没有length,使用则返回为null,无法用length判断对象个数**

*var fun = function ff(){};  此句是一条语句,ff()函数是不存在,不被被调用. = 后面的函数都是或类似匿名函数

*DNS（Domain Name System，域名系统），因特网上作为域名和IP地址相互映射的一个分布式数据库,可以通过域名访问,而不用记ip地址

*AMD : (Asynchronous Module Definition 异步模块定义)     
 推崇依赖前置，在定义模块的时候就要声明其依赖的模块 (Require.js)
 CMD : (Common Module Definition通用模块定义) 推崇就近依赖，只有在用到某个模块的时候再去require (Sea.js)

*常见的js全局函数,不是window函数: isNaN(), Number(), parseFloat(),String(), eavl(), escape()

*大小写转换: string.toUpperCase()    string.tolowerCase(); 返回字符串中全部转换为大写或小写,不改变原值

*hasOwnProperty()
obj.hasOwnProperty("val");  返回true或false


*parseInt("str")         将字符串解析成整数(如果开头不是数字则返回NaN,后面只解析到是数字,第一个非数字后全舍弃)
parseFloat("str")       将字符串解析成实数

- 变量名命名规则: **字母,数字,下划线,$组成, 不能以数字开头.**

  var arr = new Array(数组长度)  或  var arr = new Array("Saab","Volvo","BMW")

- *typeof(val) 使用中,但是 null 数组 对象 都会返回 object 要具体知道则使用[如: val instanceof Array 是返回true反之返回false ]或则使用 constructor ,而null类型使用 [ val == null ] 判断是不是undefined类型 也可以 使用 val == undefined 

*不论var声明的变量处于当前作用域的第几行,都会被提升到作用域的顶部并初始化为undefined，但是如果有赋值要等到执行到才能赋值，不然在赋值语句前都是undefined. 譬如var i =6；语句var i 会被提前,而i = 6 要等到语句执行

*未定义的变量直接赋值,直接变成为全局变量 [ 如: val = 66; ]

*清空对象:
val = undefined;//推荐
val = null;

*判断一个变量是否存在undefined还是不存在的undefined(用typeof判断),如果不存在变量console或者使用会是 val is not defined
'val' in window (存在则返回true反之则返回false)


- data函数的一些方法: 使用前一定要使用new不能直接赋值 var d = Date() 

        getDate()    从 Date 对象返回一个月中的某一天 (1 ~ 31)。
        getDay()     从 Date 对象返回一周中的某一天 (0 ~ 6,周日-周六)。
        getHours()   返回 Date 对象的小时 (0 ~ 23)。
        getTime()    返回毫秒数
        getMonth()   返回月份(0-11)

JSON语法：

    大括号保存对象
    方括号保存数组
    数据为 键/值 对
    数据由逗号分隔

>JSON.parse(txt) 用于将一个 JSON 字符串转换为 JavaScript对象。

>JSON.stringify(obj)    用于将 JavaScript 值[通常数组或对象]转换为 JSON 字符串。

Math方法:

    Math.random()         返回0到1之间的随机数
    Math.round()          返回四舍五入的值, 只返回整数
    Math.sqrt( val )      返回val的开方值,有小数位则精确到10多位

HTML文档选择器: 
 
 >除了id选择器外,其他的都要Elements都有加s注意,所以出来的都是数组,一定要记得选第几个数组,即便是选出来只有1个那么也要用[0]不然后续无法使用.
 
    document.getElementById()   
    document.getElementsByClassName()     
    document.getElementsByTagName()
    document.getElementsByName()
    document.querySelectorAll("css selecter")  返回所有的  document.querySelectorAll("#add *") 全部子元素,返回数组形式
    document.querySelector("css selecter")  返回所有选择元素的第一个

##前端面试题

代码规范:

**变量名和函数名推荐使用驼峰法来命名**;(例如:firstName);

通常运算符 ( = + - * / ) 前后需要添加空格;

html事件:

    onmouseover(在元素内移动都会一直触发)  与onmouseout配对使用
    onmouseenter 鼠标进入只会触发一次 和onmouseleave 一对
    onblur
    onfocus
    onchange
    onmouseup
    onmousedown

BOM:浏览器对象模型(BrowserObjectModel)

DOM:文档对象模型(Document Object Model)

BFC:块级格式化上下文(Block Formatting Contexts):即是元素内的子元素的布局不会影响到外部.

在JavaScript中，有三种常用的绑定事件的方法：

- 在DOM元素中直接绑定； 例如: <div onclick="alert('哈哈')"></div>
	
- 在JavaScript代码中绑定；onclick = function(){}  (定义多个click时,前者会被后者覆盖)   btn.onclick = null; // 删除事件处理程序；

- 绑定事件监听函数。
	
事件流: 捕获阶段  目标阶段  冒泡阶段 (如果一个元素) 

添加事件句柄:(此方法不会覆盖之前的事件,比如可以定义多个click,其他方法
则会)

addEventListener("event"[不加on前缀], function[不加括号], useCapture[true|false会使用冒泡) 

如addEventListener("click", f1, false)  传函数使用匿名,addEventListener("click", function(){ f1(i,j)}, false)   如果是冒泡是一直向上到DOM节点传递动作(click),而捕捉是DOM向下一直传递动作.在传递过程有相同的事件(click)就会被触发.

阻止冒泡: 在该元素定义event.stopPropagation();
 
removeEventListener(evernt, function)   
(attachEvent(type, listener); [事件需要加on]
detachEvent(event,function); )

###添加属性：

e.attributes  返回所有属性, 然后遍历出你要的. e.attributes.name (例如 href) / e.attributes.href  (例如www.baidu.com)

**e.setAttribute("type","button")**       如果e没有该属性则添加,有则覆盖
e.removeAttribute("属性")          移除属性 e.removeAttribute("style")

attr = document.createAttribute("class")
attr.value = "classname"
p.setAttributeNode(attr)

###html中class的操作
element.className.replace(目标值[正则], "") 

e.classList  只读属性, e.classList.add("class1","class2..")  e.classList.remove("calss1", "class2")
(移除不存在的class不会报错)


创建HTML元素:  var p = document.createElement("p")   p.innerHTML = "内容"
添加HTML元素:  element.appendChild(element)
移除HTML元素:  parent.removeChild(child)  成功返回删除节点,失败返回NULL  例list.removerChlid( list[0].childNodes[0])   list.childNodes[0].nodeType==1时才是元素节点，2是属性节点，3是文本节点。  所以说这个还是使用  e.children 只会返回元素节点.(同时几乎所有浏览器都支持)


##node节点

	e.parentNode 返回父节点
	e.previousElementSibling上个兄弟元素节点
	e.nextElementSibling 下个兄弟元素节点
	e.children  返回属性节点 (同时几乎所有浏览器都支持)
	parent.insertBefore(newItem,existingItem)  例子  list.insertBefore(newItem,list.childNodes[0]);

##BOM:

window.history.back();      返回

window.history.forward();   前进

window.history.go(-2);      后退两页,为0会刷新

setInterval("function",milliseconds， ...参数)    间隔一定时间不断执行
clearInterval( val )                               停止不间断执行 

setTimeout(function[不加括号],milliseconds,参数1,参数2..)                计时到后执行
clearTimeout( val )                                停止计时到执行操作

- location方法及属性:

location.assign("http://www.baidu.com")  整个页面载入新网址

location.reload(forceGet[true|false])    重新载入当前文档相当于刷新整个页面,true时都会绕过缓存,重新下载

location.host           返回主机

location.href           返回完整的URL; location.href = "网址" 跳转到新网址 
		 
*navigator.appName      浏览器名称

*window.innerWidth / Height 当前窗口的大小不含滚动条,窗口不全屏也会变小

 window.outerWidth / Height 当前窗口的大小包含滚动条和工具栏, 窗口不全屏也会变小  
 
 window.scrollTo(x, y);    例子 window.scrollTo(100,500);
 
var w = window.open(URL, name["_blank" / "_self"],  specs['width=100px,height=100px']);

w.resizeTo(x, y)  例如:w.resizeTo(500, 500)   

w.moveTo(x, y)    例如:w.moveTo(20, 20)

*cookie 

document.cookie   属性返回当前文档所有的cookies,以键=值形式

var d = new Date(); d.setTime(d.getTime() + 1000 * 60 * 60);
document.cookie = "name=vlaue; expires="+d.toUTCString();

函数的call（）与 apply（）用法 如果第一个参数写成 null 或传入 null 那么this指向window. 最主要区别如下例子

myObj = function.apply(myObj[, argArray])        函数的参数以数组传入

myObj = function.call(myObj[, arg1[, arg2[, [,...argN]]]]) 函数的参数一个个传入

- **跨域:**
    
    >只要协议、域名、端口有任何一个不同都是跨域
    
    解决跨域:jsonp、 iframe、window.name、window.postMessage、服务器上设置代理页面
    
    后端加上这句就可以实现跨域,*表示任何地址,也可以是自己的地址: header("Access-Control-Allow-Origin: *"); 
    
    jsonp就是使用标签实现跨域  详解自己博客
    前端: 
    
        $.ajax({
             type:"get",
             async:"false",
             url: "",
             Datatype:"jsonp",
             jsonp:"cc", //给服务端做索引,服务端拿到是handler()名字
             jsonpCallback:"handler",  客户端处理返回数据的函数
             success:function(data){
                这里的data就是后台返回, 在外面函数名为handler的也会接收到数据
                console.log(data)
             }
        })
    
    服务器端php:

        <?php
        $arr = 返回给前端数据;
        echo $_REQUEST['cc'] . "(" . json_encode($arr) . ")";
    
    
- *js的字符串正则:

    >search(正则或字符串都可做检索) [返回开始的位置,没有则返回-1] 和  match()[没有返回null,有返回数组] 和 replace()[返回新String不会改变原String] 
        
        
        修饰符: i(大小写不敏感) g(全局匹配,不会匹配到第一个就结束) 
        
        .   单个字符，除了换行和行结束符; 
        \w  单词字符。        \W: 不是单词的字符
        \d  查找数字。	      \D
        \s  查找空白符(指包括\n,\r,\f,\t,\v)    \S
        \b  匹配单词边界      \B
        string?=n   匹配任何其后紧接指定字符串 n 的字符串,返回?前的string
        string?!=n  匹配任何其后没有紧接指定字符串 n 的字符串
        [A-z]  匹配大写A到小写z
        [abc]  []中任意字符
        [^abc] 不包含[]中任意一个字符
        (red|blue|yellow) 查找任何指定的选项。
        n{x,}
        n{x,y}
        n+ 至少一个n  
        n*  零个或多个n 
        n? 零个或1个n 
 
*结果是什么

    var a = 6;
    setTimeout(function () {
            alert(a);
            var a = 666;   //有这句和没这句的区别, 会是undefined,声明提升.如果没有则是66
    }, 1000);
    a = 66;
    //先在自己作用域中找, 没有则一直往上一个一个作用域寻找

*let和const的区别

let声明的变量可以改变，值和类型都可以改变，没有限制。
const声明的变量不得改变值

*js内存泄漏:

全局变量不会被回收
闭包的变量不会被回收.

*介绍一下闭包和闭包常用场景

 [参考](http://www.ruanyifeng.com/blog/2009/08/learning_javascript_closures.html)

闭包是指能够访问另一个函数作用域中的变量的**函数**. 创建闭包常见方式,就是在一个函数内部创建子函数(这个子函数就是闭包).

应用场景：读取函数内部变量; 让变量常驻内存
不适合场景：返回闭包的函数是个非常大的函数
闭包的缺点就是常驻内存，会增大内存使用量，使用不当很容易造成内存泄露。

*介绍一下你所了解的作用域链,作用域链的尽头是什么，为什么

每一个函数都有一个作用域，比如我们创建了一个函数，函数里面又包含了一个函数，那么现在 就有三个作用域，这样就形成了一个作用域链。
作用域的特点就是，先在自己的变量范围中查找，如果找不到，就会沿着作用域链 **往上找。**



**常用HTTP消息状态码 (HyperText Transfer Protocol)超文本传输协议**

    1xx   服务器收到请求，需要请求者继续执行操作
    2xx   被成功的接受并处理
    200 一切正常(ok)
    3xx 重定向
    301 永久性转移
    302 暂时转移,客户端应继续使用原有的url
    304 没有被修改(not modified)(服务器返回304状态，表示源文件没有被修改,不会返回资源,继续使用缓存）
    4xx   客户端错误
    400 客户端请求的语法错误(Bad Request)
    401 Unauthorized  合法请求,因为被请求的页面需要身份验证，客户端没有提供或者身份验证失败。
    403 禁止访问(forbidden)
    404 没找到页面(not found)
    5xx   服务端错误
    500 内部服务器出错(internal service error)
    503 服务器超时(通常,这只是暂时状态)

特点: HTTP是无连接, HTTP是无状态

客户端请求消息: 请求行（request line）、请求头部（header）、空行和请求数据

服务器响应消息: 状态行、消息报头、空行和响应正文。

TCP协议:(Transmission Control Protocol)传输控制协议
3次握手,4次挥手

TCP协议对应于传输层(面向接协议),而HTTP协议对应于应用层,Http协议是建立在TCP协议基础之上的.

UDP [User Datagram Protocol-用户数据报协议] 结构简单.速度快,没有握手

HTTP请求方法:8种

* iframe有那些缺点?
	会阻塞主页面的onload事件,等iframe加载完后再触发onload()
	影响页面的并行加载。 
	动态给iframe添加src属性值，解决以上的问题.

*undefined 不是关键字会被赋值  void 表达式  返回的都是undefined

* & |  ~ (取反) ^(异或,二进负数转为正数,先反码加1在加上负号)  <<   >>    

*jq中的ready()和onload的区别:ready表示文档加载完成(不包含图片和非文字媒体文件);  onload表示包含图片在内的所有的元素都已经加载完成

*前端性能优化方法: 

	1.减少http请求次数:CSS Sprites,JS、CSS源码压缩
	2.将样式表放在顶部(head中)，将脚本放在底部(body后)(css放在js前面) 
	3.缓存DOM节点查找结果, 用变量保存AJAX请求结果
	4.使用CDN加速,即就近资源

*从输入url到得到html详细过程?

    1.浏览器根据dns服务器得到域名对应的ip地址;
    2.向这个IP的机器发送http请求
    3.服务器收到处理并返回http请求
    4.浏览器得到返回结果
 
*浏览器渲染页面的过程

    1.根据HTML生成DOM树
    2.根据CSS生成CSSOM(CSS Object Model)树
    3.将DOM和CSSOM整合成Render Tree(渲染树) 
    4.**遇到script时会执行并阻塞渲染**
    5.根据渲染树在屏幕上画出

    所以有: css样式放在head中(因为这样可以在加载页面时一次渲染完成)script放在body后(不会阻塞渲染,让页面展现更快)

*link 和@import 的区别是?

页面被加载的时，link会同时被加载，而@import等到页面被加载完再加载;
link方式的样式的权重高于@import的权重.

*new操作符号做了什么?

var fn = function () { };
var fnObj = new fn();
1.var obj = new object();创建了一个空对象
2.obj._proto_ = fn.prototype;设置原型链
3.var result = fn.call(obj)让fn的this指向obj，并执行fn的函数体
4.判断fn的返回值，如果是一个对象,直接返回。如果是引用类型，就返回这个引用类型的对象。
if (typeof(result) == "object"){  
	fnObj = result;  
} else {  
	fnObj = obj;
}

*算法:冒泡,直插法 ??(需要练习下)


##////////////////////AjAX////////////////////

setRequestHeader(header,value);
open("method"[只有GET和POST],url,async[true/false]);
send();
XMLHttpRequest五个重要属性:
onreadystatechange 事件是当状态改变  例子: xmlhttp.onreadystatechange = function(){}
readyState的值  0: 请求未初始化(未调用open()) 1: 服务器连接已建立 2: 请求已接收  3: 请求处理中 4: 请求已完成，且响应已就绪 
status: 200为ok
responseText  获取内容形式为字符串
responseXML   获取内容形式为XML   xml.respondxml.documentElement.getElementsByTagName(tagname)[]
方法:
xml.getAllRespondHead()   获取整个响应头
xml.getResponseHeader('Last-Modified')   获取指定的响应头

##JQ 部分

- 基础语法： $("selector").action(); selector为css选择器  $("")

$(document).ready( function(){})

callback 函数有**加()则立马执行,不是等到隐藏/显示完后才执行**; speed有内设 "fast" ,"slow"(使用加引号)

- *显示/隐藏  (效果是整个元素变小然后消失)

    $(selector).hide(speed,callback); 
    $(selector).show(speed,callback); 
    $(selector).toggle(speed,callback);

- *淡入/淡出   (效果是整个元素变淡然后消失)

    $(selector).fadeToggle(speed,callback);
    
    $(selector).fadeIn(speed,callback);
    
    $(selector).fadeOut(speed,callback);
    
    $(selector).fadeTo(speed,opacity,callback);  定义到透明度到哪里

- *滑动

     $(selector).slideToggle(speed,callback);
     
     $(selector).slideDown(speed,callback);
     
     $(selector).slideUP(speed,callback);

- *动画
    
        $(selector).animate({params},speed,callback); 
        
        例子:$("div").animate({
            left:'250px',    
            height:'+=150px',
            width:'+=150px'
        });

- *停止动画

       $(selector).stop(stopAll(没填默认false,是否停止队列所有动画),goToEnd(没填默认false,true时立刻完成当前的动作,队列中下一个不影响)); 

- *css之class

     $("h1,h2,p").toggleClass("blue");       
     
     $("#div1").addClass("class1 class2");
     
     $("h1,h2,p").removeClass("class1 class2");
     
     想获取某个元素所有的class, 可用 $("p").attr("class")
 
- css方法:

     $("p").css("background-color");    //返回首个指定CSS 属性的值
     
     $("p").css("background-color","yellow");  //设置指定值
     
     $("p").css({"background-color":"yellow","font-size":"200%"});   //设置多个 CSS 属性

- 设置属性

    $("#w3s").attr("href"); 返回属性值
    
    $("#w3s").attr("href","//www.w3cschool.cn/jquery");设置属性
     
- *text(),html(),val()的获取及设置(回调函数两个参数:被选元素列表中当前元素的下标，以及原始值)

		$("#test2").html(function(i,origText){ 
			return "Old html: " + origText + " New html: Hello <b>world!</b> 
			(index: " + i + ")"; 
		});

     
- *祖先
        
        $("selector").parent()  直接上级父节点,自己本身不包含
        $("selector").parents("ul"[可选,祖先ul的.])  一直向上到html标签,遍历出该元素的所有祖先. 
        $("span").parentsUntil("div");     <span> (不包含)与 <div>(不包含) 元素之间的所有祖先元素：

- *后代

        $("div").children();   返回div的所有直接子元素。
        $("div").children("p.1");    返回div的直接子元素并且class是 .1的p元素。
        $("div").find("span");     返回 <div> 后代的所有 <span> 元素(一直向下到最后一代的遍历)
        $("div").find("*");       返回所有后代(一直向下到最后一代的遍历)

- *同胞(sibling)

        $("h2").siblings();     返回所有同胞元素,不包含自己
        $("h2").next();         下一个同胞元素
        $("h2").nextAll();       h2元素(不包含)后的所有同胞
        $("h2").nextUntil("h6");  h2(不含)到h6(不含)之间的所有同胞元素
        prev(), prevAll(), prevUntil()  同上
        
- *添加元素

       append() - 在被选元素的内部结尾插入内容 
       prepend() - 在被选元素的内部开头插入内容
       after() - 在被选元素之后插入内容
       before() - 在被选元素之前插入内容

       例子:
       $("p").append("<b>Appended text</b>"); 


- *删除元素
    
       $("selector").remove() **删除被选元素及其子元素。**
       $("selector").empty()  只删除子元素

- *过滤

    .first()    $("div p").first();  第一个div内部中的第一个p元素
    
    .last()     $("div p").last();  最后一个div内部中的最后一个p
    
    .eq(index)  $("p").eq(5);     选取第6个元素p元素,索引从0开始.   eq和数组下标索引区别: [参考](https://blog.csdn.net/weixin_37281289/article/details/82669966)
    
    .filter()   $("p").filter(".intro");   返回所有p元素同时是 .intro 的class元素
    
    .not()      $("p").not(".intro");      返回所有p元素不是 .intro class的元素

- *on / off  为现在或未来元素添加事件, off为移除on绑定的事件

	$(selector).on("event",childSelector,data,function)
        
        例子: 
        $(".right-col").on("click", "li", function(){
            $(".right-col>li").removeClass("right-selected");
            $(this).addClass("right-selected");
        })
        
- *chaining  一条语句中运行多个 jQuery 方法（在相同的元素上）
    
       例子: $("#p1").css("color","red").slideUp(2000).slideDown(2000);

- *杂项

    $(selector).index()  相对于同一级元素的位置,0开始计算,没有返回-1
    
    $(selector).index(element)  返回元素的索引位置, 例 $(".hot").index( $("#favorite") ) 

- *尺寸
    
     width(内容的宽) / innerWidth(包含padding) / outWidht(包含padding和border)  / outWidth(true) (包含padding和border和margin)
     
     height 同上
     
     $("#div1").width() 返回宽的     $("#div1").width("设定值")  设定宽度, 设定值没有单位默认使用px
	
- *AJAX

         $("selector").load(URL,data,callback);  从服务器加载数据，并把返回的数据放入被选元素中。
            callback(responseTxt, status, xhr) 参数:
                 responseTxt - 包含调用成功时的结果内容
                 statusTXT - 包含调用的状态
                 xhr - 包含 XMLHttpRequest 对象   
        
         $.get(URL,callback);  callback(data, status)  data为数据, status是状态(success为成功)
        
         $.post(URL,data,callback);    data用json形式,callback参数同get方法.
        jsonp跨域请求: $.getJSON("url?cc=?", function(data){})  cc后端获取到的是function()回调  详解自己博客
    
         $.ajax({
            "method": "post"|"get",
            "url": "",
            "data": {},
            success: function(){
            },
            error: function(){
            }
         })

##React

组件的生命周期:
Mounting：已插入真实 DOM
Updating：正在被重新渲染
Unmounting：已移出真实 DOM

React 为每个状态都提供了两种处理函数，will 函数在进入状态之前调用，did 函数在进入状态之后调用
(例如: componentWillMount)


##node.js

node.js 是单进程单线程应用程序，但是通过事件和回调支持并发，所以性能非常高。

##

- 光标, 选区处理(Range接口)
[参考](https://www.jianshu.com/p/ad2f818cc3b0)

- node开启守护进程方法
  - [forever](https://www.npmjs.com/package/forever) 实现程序的永久运行