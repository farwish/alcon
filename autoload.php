<?php
/**
 * autoload.php
 *
 * Use it without composer, cant in cli.
 *
 * <code>
 * include "/your_path/farwish/alcon/autoload.php";
 * </code>
 *
 * @farwish.
 */

const ALCON_PSR4 = '{"Alcon\\\": "src/"}';
const ALCON_DS = DIRECTORY_SEPARATOR;
const ALCON_EXT = '.php';

spl_autoload_register(function($name) {
    $auto = json_decode(ALCON_PSR4, true);
    $name = str_replace([key($auto), '\\'], [current($auto), ALCON_DS], $name);
    $file = __DIR__ . ALCON_DS . $name . ALCON_EXT;
    if (! file_exists($file) ) die("File not exists : {$file}\n");
    include_once $file;
});
