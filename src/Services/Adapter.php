<?php

namespace Alcon\Services;

/**
 * Base class for Alcon\Services adapters.
 * Keep methods name same.
 *
 * <code>
 *  class Yours extends Adapter {
 *  }
 * </code>
 *
 * TODO
 *
 * @farwish
 */
abstract class Adapter implements AdapterInterface
{
    public function get($addr)
    {
    }  
}
