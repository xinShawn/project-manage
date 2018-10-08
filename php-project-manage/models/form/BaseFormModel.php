<?php
namespace app\models\form;


use app\models\BaseModel;
use Yii;

abstract class BaseFormModel extends BaseModel {
    /**
     * 从 请求 参数导入数据
     * @param string $formParamName post\get 参数名称（值可以是 json对象 或 json字符串）
     * @return static|null
     */
    public static function initByForm($formParamName) {
        $params = Yii::$app->request->post($formParamName, null);
        if ($params === null) {
            $params = Yii::$app->request->get($formParamName, null);
            if ($params === null) {
                return null;
            }
        }
        
        if (is_object($params)) {
            $params = get_object_vars($params);
        }
        
        if (is_string($params)) {
            $params = json_decode($params, true);
        }
        
        $baseFromModel = new static();
        $baseFromModel->setAttributes($params);
        
        return $baseFromModel;
    }
}