- mysql怎么批量更新某个字段,从某个值开始并加一的递增? [answer](https://blog.nice100.net/mysql/172.html)
```
set @var = 100;
update table_name set num = (@var := @var + 1) where id > 100;//更新每行数据时会先运算@var := $var + 1,然后更新字段.
此方式,还可以在查询数据用来标记排名,或者第几行, 如下
set @var = 0;
select (@var := @var + 1) as num, name where id > 100;
```

- mysql怎么复制表中某些行到同张中或其他表? 其中只更改几个字段, 最省事的方法,不用写出所有字段? [answer](https://blog.nice100.net/mysql/171.html)
```
CREATE TEMPORARY table temporary_table AS SELECT * FROM original_table WHERE Event_ID="155";
UPDATE temporary_table SET Event_ID="120";
ALTER TABLE temporary_table MODIFY <auto_inc_not_null_field> INT;//更改主键为普通int类型
UPDATE temporary_table SET ID=NULL;
INSERT INTO original_table SELECT * FROM temporary_table;
```