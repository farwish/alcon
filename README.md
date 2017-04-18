# Alcon

[中文文档](https://github.com/farwish/alcon/blob/master/README.cn "alcon中文文档")  

> Synopsis:  
`Alcon is a pure communal library for your program, if you are developing in phalcon framework.`    

> Usage:  
1. With Composer, your composer.json like:  
```
{  
    "require": {  
        "farwish/alcon": "dev-master"  
    },  
    "repositories": [  
        {  
            "type": "vcs",  
            "url": "https://github.com/farwish/alcon"  
        }  
    ]  
}  
```

or  

`composer require farwish/alcon --no-dev`  

2. Without Composer:  
`git clone https://github.com/farwish/alcon.git`  
`include "/your_path/farwish/alcon/autoload.php";`  

> Suggest:  
`You are encouraged to read it by yourself, its few and simple.`  

> Classes:  

```
Design/   
    |_ Container.php  
    |_ Decorator.php  
    |_ Event.php  
    |_ Singleton.php  
    |_ Strategy.php  

Projects/  
    |_ Alconseek/  

Scripts/   
    |_ model_header.php   
    |_ produce_all_models.php  

Services/  
    |_ ServiceBase.php  

Supports/  
    |_ Codes.php  
    |_ Helper.php  
    |_ STBase.php  

Traits/  
    |_ ControllerTrait.php   
    |_ ModelTrait.php  
    |_ ModelAdvanceTrait.php  

```

> Unit test  
`composer update`  
`phpunit`  

> Maintain or Join  
`Join Qq Group: 377154148`  
`If you do use this package, please let me know; welcome to give pull request.`  

> A&Q  
`How to install phalcon?`  
`1. https://docs.phalconphp.com/en/latest/reference/install.html`  
`2. https://github.com/farwish/delicateShell/tree/master/lnmp`  
