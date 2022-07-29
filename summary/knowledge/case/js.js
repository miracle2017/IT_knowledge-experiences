//获取checkbox选中值的数组,都没选中返回空数组 [answer](https://stackoverflow.com/a/16171197/8714749)
    $('.js-platform:checked').map(function () {
        return $(this).val();
    }).get().join()

//判断元素是否在数组中(类似inArray)
    arr = [1, 2, 3]
    arr.includes(3); //return true
    arr.indexOf(3)//return 3