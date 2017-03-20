<?php

namespace Alcon\Traits;

/**
 * Json Respond Strategy.
 * Only used in Phalcon Framework!
 *
 * <code>
 *  $this->respond();
 * </code>
 *
 * @farwish
 */
trait JsonRespondTrait
{
    public function respond($data = null, $status = 0, $msg = 'Ok')
    {   
        $this->response->setJsonContent([
            'data' => $data,
            'status' => $status,
            'msg' => $msg,
        ])->send();
    }     
}
