<?php

namespace ModelTrait\Traits;

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
        $res = static::find($parameters);    

        return $res ? $res->toArray() : [];
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
        $db = \Phalcon\Di::getDefault()->getShared('db');
    
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
        $res = static::findFirst($conditions);

        // Updates a model instance. Using save() anyways.
        return $res->update($data);
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
        $res = static::findFirst($conditions);

        // Deletes a model instance.
        return $res->delete();
    }
}
