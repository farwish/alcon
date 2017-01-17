<?php

namespace Alcon\Traits;

/**
 * Trait for Model advanced setting.
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
