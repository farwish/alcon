<?php

namespace Alcon\Traits;

/**
 * Trait for Model.
 *
 * 在模型中使用.
 *
 * @farwish
 */
trait ModelTrait
{

    /**
     * Get DB Instance.
     * 
     * @param string $key db
     *
     * @return object
     *
     * @farwish
     */
    public static function getDb($key = 'db')
    {
        $db = \Phalcon\Di::getDefault()->getShared($key);
        
        return $db;
    }

    /**
     * 查询结果数组.
     *
     * @parameters mixed
     *
     * @return array
     *
     * @farwish
     */
    public static function findArray($parameters = null)
    {
        $obj = static::find($parameters);    

        return $obj ? $obj->toArray() : [];
    }

    /**
     * 增加一条数据.
     *
     * @param array $data
     *
     * @return int | bool
     *
     * @farwish
     */
    public static function insertOne(array $data)
    {
        $db = static::getDb();
    
        $db->insert(
            (new self())->getSource(),
            array_values($data),
            array_keys($data)
        );

        return $db->lastInsertId();
    }

    /**
     * 更新一条数据.
     *
     * @param string $conditions
     * @param array $data
     *
     * @return boolean
     *
     * @farwish
     */
    public static function updateOne($conditions, array $data)
    {
        $db = static::getDb();
    
        $bool = $db->update(
            (new self())->getSource(),
            array_keys($data),
            array_values($data),
            $conditions
        );

        return $bool;
    }

    /**
     * 删除一条数据.
     *
     * @param string $conditions
     *
     * @return boolean
     *
     * @farwish
     */
    public static function deleteOne($conditions)
    {
        $obj = static::findFirst($conditions);

        // Deletes a model instance.
        return $obj ? $obj->delete() : false;
    }
}
