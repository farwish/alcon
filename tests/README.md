# tests

Install Command-Line Test Runner

```
$ wget https://phar.phpunit.de/phpunit-6.2.phar  
$ chmod +x phpunit-6.2.phar  
$ sudo mv phpunit-6.2.phar /usr/local/bin/phpunit  
$ phpunit --version  
```

Install Composer Package:  

```
composer require --dev phpunit/phpunit ^6.2  
```

or  

```
composer install  
```

Run all tests in this directory:  

```
phpunit --bootstrap ../autoload.php ./   
```

Run the test case in this directory:   

```
phpunit --bootstrap ../autoload.php Supports/HelperTest   
```

Run all tests in root directory (depend on XML Configuration):  

```
phpunit   
```
