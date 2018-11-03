<?php
namespace app\exceptions;


use Throwable;
use yii\base\UserException;

/**
 * Class ReLoginException 重新登录异常。抛出这个异常后前端需要重新登录
 * @package app\exceptions
 */
class ReLoginException extends UserException {
    
    /**
     * ReLoginException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}