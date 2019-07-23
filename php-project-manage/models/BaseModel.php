<?php
namespace app\models;

use yii\base\Model;

/**
 * Class BaseModel 所有非数据库模型的基类
 * @package app\models
 */
abstract class BaseModel extends Model {
    /**
     * 使用数组初始化对象
     * @deprecated 未经测试
     * @param array $array 数据
     * @return BaseModel
     */
    public static function initByArray($array) {
        $model = new static();
        $model->setAttributes($array);
        return $model;
    }
}