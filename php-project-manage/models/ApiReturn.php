<?php
namespace app\models;


use Yii;

/**
 * Class ApiReturn 所有api请求的通用返回
 * @package app\models
 */
class ApiReturn extends BaseModel {
    
    /** 处理结果：成功 */
    const SUCC_SUCC = 1;
    
    /** 处理结果：失败 */
    const FAIL_FAIL = -1;
    /** 处理结果：失败 空参数 */
    const FAIL_EMPTY_DATA = -2;
    /** 处理结果：失败 非法参数 */
    const FAIL_ILLEGAL_DATA = -3;
    /** 处理结果：失败 已经初始化 */
    const FAIL_ALREADY_INIT = -4;
    /** 处理结果：失败 需要重新登录 */
    const FAIL_RE_LOGIN = -100;
    
    /** @var int 返回代码 */
    public $code;
    /** @var string|array 返回数据 */
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
     * 模型验证规则
     * @see BaseModel::setAttributes()  设置属性方法使用到 规则
     * @see BaseModel::validate()   验证模型方法使用到 规则
     * @return array
     */
    public function rules() {
        return [
            [["code", "data"], "safe"]  // 允许写入的参数
        ];
    }
    
    /**
     * @param string|null $message 返回的消息
     * @return string json字符串
     */
    public function toJsonStr($message = null) {
        $array = $this->toArray();
        if ($message === null) {
            $message = $this->getMessage($this->code);
        }
        $array["msg"] = $message;
        
        return json_encode($array);
    }
    
    /**
     * @param int $code 获取返回的消息内容
     * @return string
     */
    private function getMessage($code) {
        $messageArray = [
            self::SUCC_SUCC => "success",
            
            self::FAIL_FAIL => "failed",
            self::FAIL_EMPTY_DATA => "empty data",
            self::FAIL_ILLEGAL_DATA => "illegal data",
            self::FAIL_ALREADY_INIT => "already init",
            
            self::FAIL_RE_LOGIN => "re login",
        ];
        
        $message = isset($messageArray[$code]) ? $messageArray["$code"] : "unknown message";
        
        return Yii::t("app", $message);
    }
    
    /**
     * 通用静态返回
     * @param int $code 使用类中 SUCC_ 或 FAIL_ 开头的常量
     * @param string|array $data 返回数据
     * @return string
     */
    public static function ret($code, $data = "") {
        return (new ApiReturn($code, $data))->toJsonStr();
    }
    
    /**
     * 返回处理失败的结果 消息给客户端
     * @param string $message
     * @param string|array $data
     * @return string
     */
    public static function retFailMessage($message, $data = "") {
        return (new ApiReturn(-10000, $data))->toJsonStr($message);
    }
    
    /**
     * 快捷成功返回
     * @param string|array $data 数据
     * @return string
     */
    public static function retSucc($data = "") {
        return self::ret(self::SUCC_SUCC, $data);
    }
    
    /**
     * 快捷失败返回
     * @param string|array $data 数据
     * @return string
     */
    public static function retFail($data = "") {
        return self::ret(self::FAIL_FAIL, $data);
    }
    
    /**
     * 快捷失败空参数返回
     * @param string|array $data 数据
     * @return string
     */
    public static function retFailEmptyData($data = "") {
        return self::ret(self::FAIL_EMPTY_DATA, $data);
    }
}