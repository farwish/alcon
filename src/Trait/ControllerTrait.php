<?php

namespace Alcon\Trait;

/**
 * Trait for controller.
 *
 * 供控制器使用Trait.
 *
 * @farwish
 */
Trait ControllerTrait
{
    protected static $p;

    protected static $offset;

    protected static $limit = 10;
    
    /**
     * Can be used in ControllerBase::initialize().
     *
     * 可在 ControllerBase::initialize() 中调用作初始化.
     * 
     * <code>
     *  self::init();
     * </code>
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
     * Response json.
     *
     * <code>
     *  $this->respond();
     * </code>
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
