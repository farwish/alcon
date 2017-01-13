<?php

namespace YkCommon\Traits;

/**
 * used in model for advanced setting.
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
