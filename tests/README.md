# tests

Install PHPUnit with composer:  

`composer require --dev phpunit/phpunit ^6.1`  

Run all tests in this directory:  

`phpunit --bootstrap ../autoload.php ./`  

Run the test case in this directory:   

`phpunit --bootstrap ../autoload.php Supports/HelperTest`  

Run all tests in root directory (depend on XML Configuration):  

`phpunit`  
