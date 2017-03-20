<?php

namespace Alcon\Design;

use Alcon\Design\Exception;

/**
 * Register tree for global use.
 *
 * <code>
 *  $con = new Container();
 *  $con->set('std', new \StdClass() );
 *  class Demo{};
 *  $con->set('demo', new Demo() );
 *  echo $con->count() . "\n";
 *  print_r($con->get('demo'));
 *  print_r($con);
 *  $con->del('demo');
 *  print_r($con);
 * </code>
 *
 * @farwish
 */
class Container implements \Countable
{
    const ITEM_EXISTS = ' same object has registed! ';

    /**
     * Objects collection.
     *
     * @var array
     */
    private $_container = [];

    public function __construct()
    {
    }

    /**
     * Pre regist.
     *
     * Name can not cover.
     *
     * @param $name mixed
     * @param $value mixed
     *
     * @return void
     */
    private function preSet($name, $value) {
        if ( array_search($value, $this->_container) !== false ) {
            throw new Exception(__CLASS__ . "::" . __FUNCTION__ . 
                "('$name', value)" . self::ITEM_EXISTS);    
        }
    }
   
    /**
     * Regist.
     *
     * Name can not cover.
     *
     * @param $name mixed
     * @param $value mixed
     *
     * @return void
     */
    public function set($name, $value)
    {
        self::preSet($name, $value);

        $this->_container[$name] = $value;
    }

    /**
     * Get registed.(php7 syntax)
     *
     * @param $name mixed
     *
     * @return object | null
     */
    public function get($name)
    {
        return $this->_container[$name] ?? null;
    }

    /**
     * Del registed.
     *
     * @param $name string
     *
     * @return void
     */
    public function del($name)
    {
        unset($this->_container[$name]);
    }

    /**
     * Registed count.
     *
     * @param void
     *
     * @return integer
     *
     * @farwish
     */
    public function count()
    {
        return count($this->_container);
    }
}

