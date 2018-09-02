<?php
namespace app\exceptions;


use Throwable;
use yii\base\UserException;

/**
 * Class ProcessException 流程处理异常
 * @package app\exceptions
 */
class ProcessException extends UserException {
    
    /**
     * ProcessException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}