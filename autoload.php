<?php
/**
 * autoload.php
 *
 * Use it without composer.
 *
 * <code>
 * include "/your_path/farwish/alcon/autoload.php";
 * </code>
 *
 * @license Apache-2.0
 * @author farwish <farwish@foxmail.com>
 */

class AlconAutoload
{
    const ALCON_NAMESPACE = 'Alcon\\';
    const ALCON_BASEDIR = 'src/';
    const ALCON_EXT = '.php';

    public static function psr4($name)
    {
        // Be sure of include once.
        static $namespace_map = [];

        // Be sure of this library.
        if ( (strpos($name, self::ALCON_NAMESPACE) === 0)
            && ! array_key_exists($name, $namespace_map) ) 
        {
            $realname = str_replace([self::ALCON_NAMESPACE, '\\'], [self::ALCON_BASEDIR, DIRECTORY_SEPARATOR], $name);
            $file = __DIR__ . DIRECTORY_SEPARATOR . $realname . self::ALCON_EXT;

            if ( file_exists($file) ) {
                include $file;
                $namespace_map[$name] = $file;
            }
        }
    }
}

spl_autoload_register('AlconAutoload::psr4');
