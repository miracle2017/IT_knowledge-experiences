- 解析json字符串,怎么知道json格式具体错哪里? [answer](https://github.com/Seldaek/jsonlint)
该库可提供格式化好的具体哪个地方错了的信息以直接展示给用户.但是速度是比不上json_decode()的,只有在json_decode错误时才用该库获取错误信息.