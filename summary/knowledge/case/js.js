//获取checkbox选中值的数组,都没选中返回空数组 [answer](https://stackoverflow.com/a/16171197/8714749) [map常用方法](https://api.jquery.com/map/)
    $('.js-platform:checked').map(function () {
        return $(this).val();
    }).get().join().toArray() //获取.toArray()也可

//判断元素是否在数组中(类似inArray)
    arr = [1, 2, 3]
    arr.includes(3); //return true
    arr.indexOf(3)//return 3