<?php

namespace Alcon;

/**
 * 控制器trait.
 *
 * @farwish
 */
Trait ControlTrait
{
    protected static $p;

    protected static $offset;

    protected static $limit = 10;
    
    /**
     * Initialize.
     *
     * @farwish
     */
    public function init()
    {
        $this->view->setRenderLevel(
            \Phalcon\Mvc\View::LEVEL_NO_RENDER
        );

        if ( $this->request->isGet() ) { 
            static::$p = max(1, $this->request->get('p', 'int'));
            static::$offset = (static::$p - 1) * static::$limit;
        }
    }

    /** 
     * Respond json.
     *
     * @farwish
     */
    public function respond($data = null, $status = 0, $msg = 'Ok')
    {   
        $this->response->setJsonContent([
            'data' => $data,
            'status' => $status,
            'msg' => $msg,
        ])->send();
    }
}
