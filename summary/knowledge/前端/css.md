- position:
  static　无定位,元素出现在正常的流中.所有元素定位的默认值,所以可用于还原元素定位的默认值。
  absolute　生成绝对定位的元素，相对于 static 定位以外的第一个祖先元素进行定位。
  fixed　相对于窗口的固定定位,窗口滚动时不会移动

- 内核: -moz-、-ms-、-webkit- 
Trident: IE  -moz-
Gecko: Firefox  -ms-
WebKit: Safari, Google Chrome -webkit-

- css盒子模型:  (在开头 使用 DOCTYPE 就可以使用W3C盒子)
    有两种，IE盒子模型、W3C盒子模型
    盒模型:content、padding、margin、border
    区  别:IE的content部分把 border 和 padding计算了进去

- box-sizing属性:
content-box:(默认)  width不包含padding 和 border
padding-box:padding包含在width
border-box(怪异模式):border 和padding 包含在width中

- css选择器:
    选择第n个子元素: :nth-child(odd[奇偶数]/event/3n+b[n从0开始,b为偏移数量])   
    
    第n个指定子元素类型:   :nth-child(p)

    E[attr]   只使用属性名，但没有确定任何属性值；
    
    E[attr="value"]：指定属性名，并指定了该属性的属性值
    
    E[attr~="value"]：指定属性名，并且具有属性值，此属性值是一个词列表，并且以空格隔开，其中词列表中包含了一个value词。
    
    E[attr^="value"]：指定了属性名，并且有属性值，属性值是以value开头的；
    
    E[attr$="value"]：指定了属性名，并且有属性值，而且属性值是以value结束的;
    
    E[attr*="value"]：指定了属性名，并且有属性值，而且属值中包含了value;
    
    E[attr|="value"]：属性值是value或者以“value-”开头的值(value后有-);

    :是伪类 ::是伪元素  ( 如 ::after )


- *transform属性  

    translate(x,y)  定义2d的转换x,y轴偏移多少(使用百分比是根据元素本身的尺寸的)
    
    rotate( 几度 )  定义以几何中心逆时针旋转  transform: rotate(60deg)
    
    rotateX( 几deg ) 定义以x旋转轴  [还有Y/Z轴的]
    
    scale(x,y)     定义 2D 缩放转换。 scaleX(1.5)平均向两边扩大.
    
    例子(多个属性用空格隔开): transform: rotate(45deg) translate(50%, 50%);    

- *transition: 

    transition-property(css属性中的name), 
    
    transition-duration(过渡时间),
    
    transition-timing-function(效果的转速曲线 liner,ease..), 
    
    transition-delay(开始的时间)
    
    例子(多个属性过渡示例): transition: width 1s linear 2s, height 1s;

- *animation:

    animation-name  
    animation-duration  动画时间,单位s或ms, 例如2ms
    animation-timing-function  
    animation-delay  
    animation-iteration-count(播放次数,n次/infinite)  
    animation-direction( normal|reverse|alternate(1,3,5正向偶数反向)|alternate-reverse(偶数正向,奇数反向););
    
    动画的定义: 关键词 "from" 和 "to", 等同于 0% 和 100%, 为了得到最佳的浏览器支持，您应该始终定义 0% 和 100% 选择器。
    
    @-webkit-keyframes mymove{
      from { left:0px;}
      to {left: 20px;}
      0% {}
      50% {}
    }
    
    例子: animation: mymove 5s

- *flex弹性盒子

 flex-direction: row | row-reverse | column | column-reverse
 
 justify-content: flex-start | flex-end | center | space-between | space-around (弹性盒子元素在主轴（横轴）方向上的对齐方式。)
 
 align-items: flex-start | flex-end | center | baseline | stretch (弹性盒子元素在侧轴（纵轴）方向上的对齐方式) 
 
 flex-flow:  nowrap | wrap
 
 align-content：flex-start | flex-end | center | space-between | space-around | stretch （修改 flex-wrap 属性的行为，设置各个行的对齐。）
 
 align-self: auto | flex-start | flex-end | center | baseline | stretch(自身元素在纵轴上的对齐方式) [子元素上使用,覆盖父级align-items 属性 ]
 
 flex: 数字 在子项目中可以定义占的比例  [子项目中设]
 
 order: 数字(可为负数)   在子弹盒子中定义,数字小排前  [子项目中设]
 

- *letter-spacing:增加或减少字符间的空白（字符间距）允许使用负值

- *white-space : (规定段落中的文本不进行换行)

        normal	默认。空白会被浏览器忽略。 
        pre	空白会被浏览器保留。其行为方式类似 HTML 中的 <pre> 标签。
        nowrap	文本不会换行，文本会在在同一行上继续，直到遇到 <br> 标签为止。
        pre-wrap    保留空白符序列(几个空格就几个)，但是正常地进行换行。
        pre-line    合并空白符序列(多个空格合为一个)，但是保留换行符。

- *word-wrap    自动换行的处理方法

        normal   使用浏览器默认的换行规则。
        break-all	允许在单词内换行。
        keep-all	只能在半角空格或连字符处换行。

- *box-shadow: h-shadow v-shadow blur[模糊距离/可选] spread[阴影尺寸/可选] color[颜色/可选];

- *background: bg-color bg-image bg-repeat bg-attachment bg-position;(建议顺序)

background-positon (图片左上角从父元素那个坐标开始)
background-size 需另外设置。
background-origin [content-box / border-box / padding-box ] 指定从哪开始显示, 即定义基准点
background-clip  值同origin, 显示的区域, clip裁剪
background-attachment ( fixed / scroll) 背景图是否固定或会滚动

- 本地离线存储 localStorage 长期存储数据，浏览器关闭后数据不丢失;
sessionStorage 的数据在浏览器关闭后自动删除;
cookie数据始终在同源的http请求中携带（即使不需要），即会在浏览器和服务器间来回传递。
sessionStorage和localStorage不会自动把数据发给服务器，仅在本地保存。
localStorage    存储持久数据，浏览器关闭后数据不丢失除非主动删除数据,除非主动删除.
sessionStorage  数据在当前浏览器窗口关闭后自动删除。
cookie          设置的cookie过期时间之前一直有效，即使窗口或浏览器关闭,没设置默认浏览器关闭失效

- *任意浏览器的默认字体高都是16px。1em = 16px. em为相对于当前对象内文本的字体尺寸。（相对于body的font-size）  rem相对html的font-size的大小。 即是 1rem = html的font-size


- *title与h1的区别、b与strong的区别、i与em的区别？
strong是标明重点内容，有语气加强的含义，使用阅读设备阅读网络时：<strong>会重读，而<B>是展示强调内容,为加粗而加粗。
i内容展示为斜体，em表示强调的文本；

- *如何居中div？
4种

- *a标签4个状态写的顺序:  L-V-H-A (这个顺序的原因是相同css样式后面会覆盖前面的)

- *外边距合并怎么解决？  
 
  当两个垂直外边距相遇时，它们将形成一个外边距。边距为较大的那个，小的一个嵌入到大的中。 
  如果2个元素（内外关系或相邻关系都会）为以下一种就不会发生外边距合并
  inline-block （内外关系的，内设置即可；相邻的都要设）
  float不为none  （内外关系的，外设置；相邻的都设）
  position为（absolute、fixed)  
以上任一种也会触发BFC，BFC块级格式化上下文，即是元素内子元素布局不会影响到外边。
 
- *margin和padding分别适合什么场景使用？

- *position:fixed;在android下无效怎么处理？
fixed的元素不是相对手机屏幕固定的。加入以下
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no"/>

- *<a>标签中taget的值:_blank(新窗口) / _self(相同窗口下,默认) / _parent(在父框架集打开) / 
_top (整个窗口中打开被链接文档。) / framename (指定iframe框中打开,与name有关) 

- *css标签的优先级别
 !important > 内联样式(1000) > id(100) > class,伪类(10) > tag(标签)(1) >  ( > + ~ )(0)

- *float会导致父元素高度坍塌, 在该元素后加入clearfix就会撑开父元素; 或者父元素使用 overflow:hidden.

- *::after 和 ::before 注意是在元素内子元素开头或结尾添加伪元素

- *onload  在页面加载完触发

- *html中 帧(frameset)元素优先级最高,表单(包含文本/密码输入框,单选框,复选框,)比非表单高;
从窗口分:窗口(select, frame, object)和非窗口(大部分html标签). 有窗口标签总是显示在无窗口前

- h1效果为加粗大号字体

- 常见的行块级元素(不换行,可以设置宽高)

         button,input，textarea,select,img
         ul,li是块级元素

- *常见的行内元素(无自动换行,但不能设置宽高)      
   
         a,span，i（斜体）,em（强调）,sub(下标)，sup（上标）等

- *常见置换元素  (不受CSS视觉格式化模型控制，CSS渲染模型并不考虑对此内容的渲染，且元素本身一般拥有固有尺寸,浏览器根据元素的标签和属性，来决定元素的具体显示内容。)
  `<img>、<input>、<textarea>、<select>、<object>` 这些本身是一个空元素

- *disable 和 readonly  : 都能被脚本修改值,而disable input指元素加载时禁用此元素。input内容不会随着表单提交

- *link引入css,都是同时加载不按写的顺序,先加载完的先解析

- *margin和padding设为 **百分比是根据块级父元素的宽度**

- *自闭合标签:<input/><img/><br/><link/><hr/>

