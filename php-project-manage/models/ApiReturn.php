<?php
namespace app\models;


/**
 * Class ApiReturn 所有api请求的通用返回
 * @package app\models
 */
class ApiReturn extends BaseModel {
    
    /**
     * 处理结果：成功
     */
    const SUCC_SUCC = 1;
    
    /**
     * 处理结果：失败
     */
    const FAIL_FAIL = -1;
    
    /**
     * @var int 返回代码
     */
    public $code;
    /**
     * @var string|array 返回数据
     */
    public $data;
    
    
    /**
     * ApiReturn constructor.
     * @param int $code
     * @param string|array $data
     */
    public function __construct($code, $data = "") {
        parent::__construct(["code" => $code, "data" => $data]);
    }
    
    /**
     * toArray 默认的返回字段
     * @see BaseModel::toArray()
     * @return array
     */
    public function fields() {
        return ["code", "data"];
    }
    
    /**
     * @return string json字符串
     */
    public function toJsonStr() {
        $array = $this->toArray();
        $array["msg"] = $this->getMessage($this->code);
        
        return json_encode($array);
    }
    
    /**
     * @param int $code 获取返回的消息内容
     * @return string
     */
    private function getMessage($code) {
        $messageArray = [
            self::SUCC_SUCC => "success",
            
            self::FAIL_FAIL => "failed"
        ];
        
        return isset($messageArray[$code]) ? $messageArray["$code"] : "unknown message";
    }
    
    /**
     * 快捷返回方法
     * @param string|array $data 数据
     * @return string
     */
    public static function retSucc($data = "") {
        return (new ApiReturn(ApiReturn::SUCC_SUCC, $data))->toJsonStr();
    }
}