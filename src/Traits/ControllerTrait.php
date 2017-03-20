<?php

namespace Alcon\Traits;

use Alcon\Traits\JsonRespondTrait;

/**
 * Trait for Controller.
 *
 * 供控制器使用Trait.
 *
 * @farwish
 */
trait ControllerTrait
{
    /** 
     * Response json.
     *
     * <code>
     *  $this->respond();
     * </code>
     *
     * @farwish
     */
    use JsonRespondTrait;

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
}
