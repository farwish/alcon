# Alcon

<p>
<img src="https://api.travis-ci.org/farwish/alcon.svg?branch=master">
<img src="https://poser.pugx.org/farwish/alcon/v/stable">
<img src="https://poser.pugx.org/farwish/alcon/downloads">
<img src="https://poser.pugx.org/farwish/alcon/v/unstable">
<img src="https://poser.pugx.org/farwish/alcon/license">
</p>

[中文文档](https://github.com/farwish/alcon/blob/master/README.cn.md "alcon中文文档")  

## Synopsis  

Alcon is a light communal lib for your program.    

## Usage   

1. With Composer  

```
$ composer require farwish/alcon -v   
```

or custom your composer.json like:  

```
{  
    "require": {  
        "farwish/alcon": "4.1.x-dev"  
    },  
    "repositories": [  
        {  
            "type": "vcs",  
            "url": "https://github.com/farwish/alcon"  
        }  
    ]  
}  
```

2. Without Composer:  

```
$ git clone https://github.com/farwish/alcon.git  

include "/your_path/farwish/alcon/autoload.php";    
```

## Suggest:  

You are encouraged to read it by yourself, its few and simple.    

```php
Status Code:
$status = \Alcon\Supports\Codes::ACTION_SUC;         // 0
$messag = \Alcon\Supports\Codes::get($status);       // 操作成功
$messag = \Alcon\Supports\Codes::map('ACTION_SUC');  // 操作成功
```

```php
Helper Class:
\Alcon\Supports\Helper::isInWechat();
\Alcon\Supports\Helper::arrayColumnCombine($array, $column);
\Alcon\Supports\Helper::buildInsertSql($table, $column, array $data);
...
```

```php
Design Pattern:
\Alcon\Design\Event
\Alcon\Design\Container
\Alcon\Design\Singleton
...
```

```php
Thirdparty Wechat sdk:
\Alcon\Thirdparty\Wx::get_sns_token($token);
\Alcon\Thirdparty\Wx::get_userinfo($access_token, $openid);
...
```

```php
Thirdparty Alipay sdk:
------ Create order
$trade = new \Alcon\Thirdparty\Alipay\AlipayTrade();
$trade->setPid('xx');
$trade->setAppid('xx');
$trade->setAlipayPublicKeyPath('xx');
$trade->setAlipayAppPrivateKeyPath('xx');
$trade->setNotifyUrl('http://xx');
$trade->precreateSet('xx', 'xx', 'xx', 'xx');
$trade->precreate();

------ Refund order
$trade = new \Alcon\Thirdparty\Alipay\AlipayTrade();
$trade->setPid('xx');
$trade->setAppid('xx');
$trade->setAlipayPublicKeyPath('xx');
$trade->setAlipayAppPrivateKeyPath('xx');
$trade->refundSet('xx', 'xx');
$trade->refund();

------ Signature can use standalone
self::signature($decoded_query_string);
```


## Structure:  

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
    |_ StatusTrait.php   

Thirdparty/
    |_ Alipay/
        |_ AlipayHelperTrait.php
        |_ AlipayTrade.php
    |_ Wechat/
        |_ Wx.php
        |_ WxAbstract.php

Traits/  
    |_ ControllerTrait.php   
    |_ JsonRespondTrait.php  
    |_ ModelTrait.php  
    |_ ModelAdvanceTrait.php  
    |_ SentryClientClass.php  
    |_ SentryClientTrait.php  
```

## Unit test  

```
$ composer update   
$ phpunit  
```

## Maintain or Join  

```
Join Qq Group: 377154148  

If you do use this package, please let me know; welcome to give pull request.  
```
