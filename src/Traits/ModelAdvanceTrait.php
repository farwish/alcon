<?php

namespace Alcon\Traits;

/**
 * Trait for Model advanced setting.
 *
 * For Phalcon framework.
 *
 * @farwish
 */
trait ModelAdvanceTrait
{

    public function initialize()
    {   
        $this->setReadConnectionService('dbslave');
        $this->setWriteConnectionService('dbmaster');
    }   
}
