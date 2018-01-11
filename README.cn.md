# Alcon

<p>
<img src="https://api.travis-ci.org/farwish/alcon.svg?branch=master">
<img src="https://poser.pugx.org/farwish/alcon/v/stable">
<img src="https://poser.pugx.org/farwish/alcon/downloads">
<img src="https://poser.pugx.org/farwish/alcon/v/unstable">
<img src="https://poser.pugx.org/farwish/alcon/license">
</p>

## 簡介

Alcon 是一个PHP项目开发支持库。  

一个应用开发中可以使用的公用结构，目的是拆分出来便于随时组装。  

## 使用

1. 使用 Composer 的情況  

```
composer require farwish/alcon -v  
```

或者編輯你的 composer.json 如:  

```
{  
    "require": {   
        "farwish/alcon": "4.1.0"  
    },  
    "repositories": [   
        {
            "type": "vcs",  
            "url": "https://github.com/farwish/alcon"  
        }
    ]   
}  
```

2. 不使用 Composer 的情況:  

```
$ git clone https://github.com/farwish/alcon.git    

include "/your_path/farwish/alcon/autoload.php";  
```

## 建议

直接查看目录结构及源码, 按需使用.  

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

## 结构   

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

## 应用   

[alconSeek](https://github.com/farwish/alconSeek "alconSeek")  


## 单元测试    

```
$ composer update  
$ phpunit    
```

## 维护  

```
Join Qq Ggroup: 377154148  

If you do use this package, please let me know; welcome to give pull request.  
```