## [php单元测试文档](phpunit.readthedocs.io)
一个名为class对应的测试类为classTest,即是在类名后加Test
classTest一般都继承PHPUnit\Framework\TestCase
classTest类内以test*开头的公开方法即为测试方法.(或者也可以在方法上用@test标注为测试方法)