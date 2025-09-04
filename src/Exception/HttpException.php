<?php

namespace Lizundao\K3CloudSDK\Exception;

/**
 * HTTP异常类
 */
class HttpException extends \RuntimeException
{
    /**
     * @var int HTTP状态码
     */
    private $statusCode;

    /**
     * 构造函数
     *
     * @param string $message 异常消息
     * @param int $statusCode HTTP状态码
     * @param int $code 异常代码
     * @param \Throwable|null $previous 前一个异常
     */
    public function __construct(string $message = '', int $statusCode = 0, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->statusCode = $statusCode;
    }

    /**
     * 获取HTTP状态码
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
