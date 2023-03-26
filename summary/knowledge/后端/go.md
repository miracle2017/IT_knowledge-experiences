## 语法
- go文件命令规范? [answer](https://medium.com/@kdnotes/golang-naming-rules-and-conventions-8efeecd23b68)

- (*Book)(nil)语法作用? [answer](https://stackoverflow.com/questions/60443193/what-does-a-pair-of-round-brackets-syntax-expression-mean-in-go)

- 结构体标签的使用(Struct tags). [引用](https://www.digitalocean.com/community/tutorials/how-to-use-struct-tags-in-go)
 [参考2](https://stackoverflow.com/a/30889373/8714749)

- 单引号,双引号和反引号用法? [参考](https://golangbyexample.com/double-single-back-quotes-go/)

- 重复代码的一种优化方式? [参考](https://go.dev/doc/articles/wiki/#tmp_12)
通过闭包,该闭包包含重复代码 + 非重复代码.

- 为什么Go声明变量语法是这样的?[answer](https://go.dev/blog/declaration-syntax)

- go语言泛型详细介绍入门? [比较详细入门介绍answer](https://segmentfault.com/a/1190000041634906) ;[官方介绍](https://go.dev/blog/intro-generics)

- nil slice和empty slice,两者的length都为0,他们具体有什么区别?[answer](https://stackoverflow.com/questions/29164375/correct-way-to-initialize-empty-slice)
所有指向零长度(zero-length)的指针,都指向内存中同一块地址.

- 什么nil? [answer](https://stackoverflow.com/questions/35983118/what-does-nil-mean-in-golang#:~:text=nil%20in%20Go%20means%20a,means%20the%20value%20is%20uninitialized)
nil is the zero value for pointers, interfaces, maps, slices, channels and function types, representing an uninitialized value.

- slice用法, 怎么赋值? [answer](https://stackoverflow.com/questions/48700907/how-to-assign-a-value-to-the-empty-slice-after-the-declaration)
对于一个空slice,其实如果要赋值只能append, 像数组一样赋值a[0] = val是不行的.

- 计算函数执行时间比较好的实现?[answer](https://stackoverflow.com/a/45766707/8714749)

- 结构体中嵌入字段是什么?[answer](https://go.dev/ref/spec#Struct_types)
EmbeddedField即是在结构体没有明确指定字段名的.

- json.marshal怎么保持本身map的结构?[answer](https://stackoverflow.com/a/48301733/8714749)

- 并发的用法?
  - 怎么等所有并发线程处理完,在继续?[answer](https://stackoverflow.com/questions/18207772/how-to-wait-for-all-goroutines-to-finish-without-using-time-sleep)
  - 最佳并发数? [answer](https://stackoverflow.com/questions/25306073/always-have-x-number-of-goroutines-running-at-any-time)
      [answer待验证](https://stackoverflow.com/questions/44771078/most-efficient-number-of-goroutines-on-this-machine)
  - 实现并发读写map的方式[answer](https://gobyexample.com/mutexes)
  - 并发append不安全?[answer](https://stackoverflow.com/questions/44152988/append-not-thread-safe)
  
- init()函数? [answer](https://stackoverflow.com/a/24790378/8714749) [answer](https://stackoverflow.com/a/49831018/8714749)

- 怎么并发安全的读写一个变量?[answer](https://stackoverflow.com/a/52882045/8714749)

- 用Channel实现广播模式?[answer](https://stackoverflow.com/a/49877632/8714749)

- 

### 经验trick
- 结构体中,一个bool值属性变量foo, 想做成getFoo


### 笔记
- json的omitempt对于json.Unmarshal和json.Marshal都起作用,即是转成接口转成json或者json转成接口,字段为空时该字段都会省略掉.

- json.Unmarshal(str, &v)执行多次, 如果都用同个v去接收, 结果会有问题, 不会变化!维持第一次的赋值.(bool类型会这样,但是string字段好像能正常改变)